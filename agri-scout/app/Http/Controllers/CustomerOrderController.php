<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Crop;
use App\Models\farm as Farm;
use App\Services\OracleService;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerOrderController extends Controller
{
    protected $oracleService;

    public function __construct(OracleService $oracleService)
    {
        $this->oracleService = $oracleService;
    }

    private function getAuthenticatedCustomer()
    {
        $userId = Session::get('user_id');
        return Customer::where('USER_ID', $userId)->firstOrFail();
    }

    public function index()
    {
        $customer = $this->getAuthenticatedCustomer();
        $orders = Order::with('farm')->where('CUSTOMER_ID', $customer->CUSTOMER_ID)->orderBy('ORDER_DATE', 'desc')->get();

        ActivityLogger::log(Session::get('user_id'), 'CUSTOMER', 'VIEW_LIST', 'ORDERS', 'Customer viewed orders list');

        return view('customer.orders.index', compact('orders'));
    }

    public function create(Request $request)
    {
        $cropId = $request->query('crop_id');
        $selectedCrop = $cropId ? Crop::find($cropId) : null;
        $crops = Crop::all();
        $farms = Farm::all();

        return view('customer.orders.create', compact('crops', 'farms', 'selectedCrop'));
    }

    public function store(Request $request)
    {
        $customer = $this->getAuthenticatedCustomer();

        $request->validate([
            'crop_name' => 'required|string|max:255',
            'farm_id' => 'required|numeric',
            'quantity' => 'required|numeric|min:1',
            'unit_price' => 'required|numeric|min:0.01',
        ]);

        $farm = Farm::where('FARM_ID', $request->farm_id)->first();
        if (!$farm) {
            return back()->withInput()->with('error', 'Selected farm does not exist.');
        }

        try {
            // Invoke Oracle CREATE_ORDER Stored Procedure
            $orderId = $this->oracleService->createOrder(
                (int)$customer->CUSTOMER_ID,
                (int)$farm->FARM_ID,
                (string)$request->crop_name,
                (float)$request->quantity,
                (float)$request->unit_price,
                (string)($request->unit ?? 'KG')
            );

            ActivityLogger::log(Session::get('user_id'), 'CUSTOMER', 'CREATE', 'ORDERS', 'Customer created order ID ' . $orderId . ' via Oracle CREATE_ORDER procedure', $orderId);

            return redirect()->route('customer.orders.show', $orderId)->with('success', 'Order #' . $orderId . ' created successfully via Oracle CREATE_ORDER procedure.');
        } catch (\Throwable $e) {
            $msg = $e->getMessage();
            if (str_contains($msg, 'ORA-20001')) {
                $msg = 'Oracle Validation Error: Order quantity must be greater than 0.';
            } elseif (str_contains($msg, 'ORA-20002')) {
                $msg = 'Oracle Validation Error: Unit price cannot be negative.';
            } else {
                $msg = 'Failed to create order in Oracle Database: ' . $msg;
            }
            return back()->withInput()->with('error', $msg);
        }
    }

    public function cancel($id)
    {
        $customer = $this->getAuthenticatedCustomer();
        $order = Order::where('ORDER_ID', $id)->firstOrFail();

        if ((int)$order->CUSTOMER_ID !== (int)$customer->CUSTOMER_ID) {
            abort(403, 'Unauthorized access: Order does not belong to you.');
        }

        if (strtoupper($order->STATUS) === 'CANCELLED') {
            return back()->with('error', 'Order is already cancelled.');
        }

        if (strtoupper($order->STATUS) === 'COMPLETED') {
            return back()->with('error', 'Completed orders cannot be cancelled.');
        }

        try {
            // Invoke Oracle CANCEL_ORDER Stored Procedure
            $this->oracleService->cancelOrder((int)$id);

            ActivityLogger::log(Session::get('user_id'), 'CUSTOMER', 'CANCEL', 'ORDERS', 'Customer cancelled order ID ' . $id . ' via Oracle CANCEL_ORDER procedure', $id);

            return redirect()->back()->with('success', 'Order #' . $id . ' cancelled successfully via Oracle CANCEL_ORDER procedure.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Failed to cancel order: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $customer = $this->getAuthenticatedCustomer();
        $order = Order::with(['customer', 'farm.farmer'])->where('ORDER_ID', $id)->firstOrFail();

        // Security ownership check
        if ((int)$order->CUSTOMER_ID !== (int)$customer->CUSTOMER_ID) {
            abort(403, 'Unauthorized access: Order does not belong to you.');
        }

        // Calculate official total via Oracle CALCULATE_ORDER_TOTAL stored function
        $officialTotal = $this->oracleService->calculateOrderTotal((float)$order->QUANTITY, (float)$order->UNIT_PRICE);

        // Get matching crop from MongoDB for additional details
        $crop = Crop::where('farm_id', (int)$order->FARM_ID)->where('crop_name', $order->CROP_NAME)->first();

        ActivityLogger::log(Session::get('user_id'), 'CUSTOMER', 'VIEW_DETAILS', 'ORDERS', 'Customer viewed order ' . $id, $id);

        return view('customer.orders.show', compact('order', 'crop', 'officialTotal'));
    }
}

