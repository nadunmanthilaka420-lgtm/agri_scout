<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use App\Models\farm as Farm;
use App\Models\OfficerVisit;
use App\Models\Order;
use App\Models\Crop;
use App\Models\DiseaseReport;
use App\Services\OracleService;
use Illuminate\Support\Facades\Session;

class FarmerDashboardController extends Controller
{
    protected $oracleService;

    public function __construct(OracleService $oracleService)
    {
        $this->oracleService = $oracleService;
    }

    public function index()
    {
        $userId = Session::get('user_id');
        $farmer = Farmer::where('USER_ID', $userId)->orWhereRaw('LOWER(EMAIL) = ?', [strtolower(Session::get('user_email', ''))])->first();

        if (!$farmer) {
            $farms = collect();
            $farmIds = [];
            $farmsCount = 0;
        } else {
            $farms = Farm::where('FARMER_ID', $farmer->FARMER_ID)->get();
            $farmIds = $farms->pluck('FARM_ID')->map(fn($id) => (int)$id)->toArray();
            // Fetch farm count from Oracle PL/SQL Function GET_FARM_COUNT
            $farmsCount = $this->oracleService->getFarmCount((int)$farmer->FARMER_ID);
        }

        $cropsCount = count($farmIds) > 0 ? Crop::whereIn('farm_id', $farmIds)->count() : 0;
        $visitsCount = count($farmIds) > 0 ? OfficerVisit::whereIn('FARM_ID', $farmIds)->count() : 0;
        $diseasesCount = count($farmIds) > 0 ? DiseaseReport::whereIn('farm_id', $farmIds)->count() : 0;
        $ordersCount = count($farmIds) > 0 ? Order::whereIn('FARM_ID', $farmIds)->count() : 0;

        $recentVisits = count($farmIds) > 0 ? OfficerVisit::with(['officer', 'farm'])->whereIn('FARM_ID', $farmIds)->orderBy('VISIT_DATE', 'desc')->take(5)->get() : collect();
        $recentOrders = count($farmIds) > 0 ? Order::with(['customer', 'farm'])->whereIn('FARM_ID', $farmIds)->orderBy('ORDER_DATE', 'desc')->take(5)->get() : collect();

        return view('farmer.dashboard', compact(
            'farmsCount',
            'cropsCount',
            'visitsCount',
            'diseasesCount',
            'ordersCount',
            'farms',
            'recentVisits',
            'recentOrders'
        ));
    }
}

