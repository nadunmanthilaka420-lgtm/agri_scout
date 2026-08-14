<?php

namespace App\Http\Controllers;

use App\Models\FieldOfficer;
use App\Models\OfficerVisit;
use App\Models\farm as Farm;
use App\Models\Crop;
use App\Models\DiseaseReport;
use App\Models\VisitReport;
use App\Helpers\ActivityLogger;
use Illuminate\Support\Facades\Session;

class OfficerFarmController extends Controller
{
    private function getAuthenticatedOfficer()
    {
        $userId = Session::get('user_id');
        return FieldOfficer::where('USER_ID', $userId)->first();
    }

    public function index()
    {
        $officer = $this->getAuthenticatedOfficer();

        if (!$officer) {
            $farms = collect();
        } else {
            $farmIds = OfficerVisit::where('OFFICER_ID', $officer->OFFICER_ID)->get()->pluck('FARM_ID')->unique()->toArray();
            $farms = count($farmIds) > 0 ? Farm::with('farmer')->whereIn('FARM_ID', $farmIds)->get() : Farm::with('farmer')->get();
        }

        ActivityLogger::log(Session::get('user_id'), 'FIELD_OFFICER', 'VIEW_LIST', 'FARMS', 'Officer viewed assigned farms list');

        return view('officer.farms.index', compact('farms'));
    }

    public function show($id)
    {
        $farm = Farm::with('farmer')->where('FARM_ID', $id)->firstOrFail();
        $farmId = (int)$farm->FARM_ID;

        $crops = Crop::where('farm_id', $farmId)->get();
        $diseaseReports = DiseaseReport::where('farm_id', $farmId)->get();
        $visitReports = VisitReport::where('farm_id', $farmId)->get();
        $previousVisits = OfficerVisit::with('officer')->where('FARM_ID', $farmId)->orderBy('VISIT_DATE', 'desc')->get();

        ActivityLogger::log(Session::get('user_id'), 'FIELD_OFFICER', 'VIEW_DETAILS', 'FARMS', 'Officer viewed farm details for farm ' . $id, $id);

        return view('officer.farms.show', compact('farm', 'crops', 'diseaseReports', 'visitReports', 'previousVisits'));
    }
}
