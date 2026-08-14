<?php

namespace App\Http\Controllers;

use App\Models\FieldOfficer;
use App\Models\OfficerVisit;
use App\Models\farm as Farm;
use App\Models\DiseaseReport;
use Illuminate\Support\Facades\Session;

class OfficerDashboardController extends Controller
{
    public function index()
    {
        $userId = Session::get('user_id');
        $officer = FieldOfficer::where('USER_ID', $userId)->first();

        if (!$officer) {
            $officerId = null;
            $assignedFarmsCount = 0;
            $todaysVisitsCount = 0;
            $pendingVisitsCount = 0;
            $completedVisitsCount = 0;
            $diseaseReportsCount = 0;
            $recentVisits = collect();
            $assignedFarms = collect();
        } else {
            $officerId = (int)$officer->OFFICER_ID;

            $visits = OfficerVisit::with(['farm.farmer'])->where('OFFICER_ID', $officerId)->get();
            $farmIds = $visits->pluck('FARM_ID')->unique()->map(fn($id) => (int)$id)->toArray();

            $assignedFarmsCount = count($farmIds);
            $todaysVisitsCount = $visits->where('VISIT_DATE', date('Y-m-d'))->count();
            $pendingVisitsCount = $visits->where('STATUS', 'PENDING')->count();
            $completedVisitsCount = $visits->where('STATUS', 'COMPLETED')->count();

            $diseaseReportsCount = count($farmIds) > 0 ? DiseaseReport::whereIn('farm_id', $farmIds)->count() : 0;

            $recentVisits = OfficerVisit::with(['farm.farmer'])->where('OFFICER_ID', $officerId)->orderBy('VISIT_DATE', 'desc')->take(5)->get();
            $assignedFarms = count($farmIds) > 0 ? Farm::with('farmer')->whereIn('FARM_ID', $farmIds)->take(5)->get() : collect();
        }

        return view('officer.dashboard', compact(
            'officer',
            'assignedFarmsCount',
            'todaysVisitsCount',
            'pendingVisitsCount',
            'completedVisitsCount',
            'diseaseReportsCount',
            'recentVisits',
            'assignedFarms'
        ));
    }
}
