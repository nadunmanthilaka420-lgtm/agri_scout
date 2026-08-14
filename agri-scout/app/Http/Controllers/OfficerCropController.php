<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\FieldOfficer;
use App\Models\OfficerVisit;
use App\Models\farm as Farm;
use App\Models\Crop;
use App\Helpers\ActivityLogger;
use Illuminate\Support\Facades\Session;

class OfficerCropController extends Controller
{
    public function index()
    {
        $userId = Session::get('user_id');
        $officer = FieldOfficer::where('USER_ID', $userId)->first();

        if (!$officer) {
            $crops = collect();
            $farmsMap = [];
        } else {
            $farmIds = OfficerVisit::where('OFFICER_ID', $officer->OFFICER_ID)->get()->pluck('FARM_ID')->unique()->map(fn($id) => (int)$id)->toArray();
            $farms = count($farmIds) > 0 ? Farm::whereIn('FARM_ID', $farmIds)->get() : Farm::all();
            $farmsMap = $farms->keyBy('FARM_ID');

            $crops = count($farmIds) > 0 ? Crop::whereIn('farm_id', $farmIds)->get() : Crop::all();
        }

        ActivityLogger::log(Session::get('user_id'), 'FIELD_OFFICER', 'VIEW_LIST', 'CROPS', 'Officer viewed crops list');

        return view('officer.crops.index', compact('crops', 'farmsMap'));
    }
}
