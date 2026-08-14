<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Crop;
use App\Models\farm as Farm;
use App\Services\OracleService;
use Illuminate\Support\Facades\Session;

class CustomerDashboardController extends Controller
{
    protected $oracleService;

    public function __construct(OracleService $oracleService)
    {
        $this->oracleService = $oracleService;
    }

    public function index()
    {
        $userId = Session::get('user_id');
        $customer = Customer::where('USER_ID', $userId)->first();

        $availableCropsCount = Crop::whereIn('status', ['GROWING', 'HARVESTED', 'PLANNED'])->count();

        if (!$customer) {
            $myOrdersCount = 0;
            $pendingOrdersCount = 0;
            $completedOrdersCount = 0;
            $recentOrders = collect();
        } else {
            $cid = (int)$customer->CUSTOMER_ID;

            // Fetch order counts from Oracle PL/SQL Function GET_CUSTOMER_ORDER_COUNT
            $myOrdersCount = $this->oracleService->getCustomerOrderCount($cid);
            $pendingOrdersCount = $this->oracleService->getCustomerOrderCount($cid, 'PENDING');
            $completedOrdersCount = $this->oracleService->getCustomerOrderCount($cid, 'COMPLETED');

            $recentOrders = Order::with('farm')->where('CUSTOMER_ID', $customer->CUSTOMER_ID)->orderBy('ORDER_DATE', 'desc')->take(5)->get();
        }

        $featuredCrops = Crop::take(6)->get();
        $farmsMap = Farm::all()->keyBy('FARM_ID');

        return view('customer.dashboard', compact(
            'availableCropsCount',
            'myOrdersCount',
            'pendingOrdersCount',
            'completedOrdersCount',
            'recentOrders',
            'featuredCrops',
            'farmsMap'
        ));
    }
}

