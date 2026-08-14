<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use App\Models\farm as Farm;
use App\Models\OfficerVisit;
use App\Models\VisitReport;
use App\Helpers\ActivityLogger;
use Illuminate\Support\Facades\Session;

class FarmerVisitController extends Controller
{
    public function index()
    {
        $userId = Session::get('user_id');
        $farmer = Farmer::where('USER_ID', $userId)->first();

        if (!$farmer) {
            $visits = collect();
            $visitReportsMap = [];
        } else {
            $farmIds = Farm::where('FARMER_ID', $farmer->FARMER_ID)->get()->pluck('FARM_ID')->toArray();

            $visits = count($farmIds) > 0 ? OfficerVisit::with(['officer', 'farm'])->whereIn('FARM_ID', $farmIds)->orderBy('VISIT_DATE', 'desc')->get() : collect();

            $visitIds = $visits->pluck('VISIT_ID')->map(fn($id) => (int)$id)->toArray();
            $reports = count($visitIds) > 0 ? VisitReport::whereIn('visit_id', $visitIds)->get() : collect();
            $visitReportsMap = $reports->keyBy('visit_id');
        }

        ActivityLogger::log(Session::get('user_id'), 'FARMER', 'VIEW_LIST', 'VISITS', 'Farmer viewed officer visits list');

        return view('farmer.visits.index', compact('visits', 'visitReportsMap'));
    }
}
