<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use App\Models\farm as Farm;
use App\Models\Order;
use App\Services\OracleService;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FarmerOrderController extends Controller
{
    protected $oracleService;

    public function __construct(OracleService $oracleService)
    {
        $this->oracleService = $oracleService;
    }

    public function index()
    {
        $userId = Session::get('user_id');
        $farmer = Farmer::where('USER_ID', $userId)->first();

        if (!$farmer) {
            $orders = collect();
        } else {
            $farmIds = Farm::where('FARMER_ID', $farmer->FARMER_ID)->get()->pluck('FARM_ID')->map(fn($id) => (int)$id)->toArray();

            $orders = count($farmIds) > 0 ? Order::with(['customer', 'farm'])->whereIn('FARM_ID', $farmIds)->orderBy('ORDER_DATE', 'desc')->get() : collect();
        }

        ActivityLogger::log(Session::get('user_id'), 'FARMER', 'VIEW_LIST', 'ORDERS', 'Farmer viewed orders list');

        return view('farmer.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $userId = Session::get('user_id');
        $farmer = Farmer::where('USER_ID', $userId)->firstOrFail();

        $order = Order::where('ORDER_ID', $id)->firstOrFail();

        $farmIds = Farm::where('FARMER_ID', $farmer->FARMER_ID)->get()->pluck('FARM_ID')->map(fn($fid) => (int)$fid)->toArray();

        if (!in_array((int)$order->FARM_ID, $farmIds)) {
            abort(403, 'Unauthorized access: Order does not belong to your farm.');
        }

        $newStatus = strtoupper($request->input('status', 'COMPLETED'));

        try {
            if ($newStatus === 'COMPLETED') {
                $this->oracleService->completeOrder((int)$id);
            } elseif ($newStatus === 'CANCELLED') {
                $this->oracleService->cancelOrder((int)$id);
            } else {
                $order->STATUS = $newStatus;
                $order->save();
            }

            ActivityLogger::log($userId, 'FARMER', 'UPDATE_STATUS', 'ORDERS', 'Farmer updated order ID ' . $id . ' status to ' . $newStatus . ' via Oracle Stored Procedure', $id);

            return redirect()->back()->with('success', 'Order #' . $id . ' status updated to ' . $newStatus . ' successfully via Oracle Stored Procedure.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Failed to update order status: ' . $e->getMessage());
        }
    }
}

