<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use App\Models\farm as Farm;
use App\Models\OfficerVisit;
use App\Models\Crop;
use App\Models\DiseaseReport;
use App\Models\VisitReport;
use App\Helpers\ActivityLogger;
use Illuminate\Support\Facades\Session;

class FarmerFarmController extends Controller
{
    private function getAuthenticatedFarmer()
    {
        $userId = Session::get('user_id');
        return Farmer::where('USER_ID', $userId)->first();
    }

    public function index()
    {
        $farmer = $this->getAuthenticatedFarmer();
        $farms = $farmer ? Farm::where('FARMER_ID', $farmer->FARMER_ID)->get() : collect();

        ActivityLogger::log(Session::get('user_id'), 'FARMER', 'VIEW_LIST', 'FARMS', 'Farmer viewed farms list');

        return view('farmer.farms.index', compact('farms'));
    }

    public function show($id)
    {
        $farmer = $this->getAuthenticatedFarmer();

        if (!$farmer) {
            abort(403, 'Farmer profile not found.');
        }

        $farm = Farm::with('farmer')->where('FARM_ID', $id)->firstOrFail();

        // Ownership Security Check
        if ((int)$farm->FARMER_ID !== (int)$farmer->FARMER_ID) {
            abort(403, 'Unauthorized access: You do not own this farm.');
        }

        $farmId = (int)$farm->FARM_ID;

        // MongoDB cross-database integration
        $crops = Crop::where('farm_id', $farmId)->get();
        $diseaseReports = DiseaseReport::where('farm_id', $farmId)->get();
        $visitReports = VisitReport::where('farm_id', $farmId)->get();

        // Oracle visits
        $oracleVisits = OfficerVisit::with('officer')->where('FARM_ID', $farmId)->orderBy('VISIT_DATE', 'desc')->get();

        ActivityLogger::log(Session::get('user_id'), 'FARMER', 'VIEW_DETAILS', 'FARMS', 'Farmer viewed details of farm ' . $id, $id);

        return view('farmer.farms.show', compact('farm', 'crops', 'diseaseReports', 'visitReports', 'oracleVisits'));
    }
}
