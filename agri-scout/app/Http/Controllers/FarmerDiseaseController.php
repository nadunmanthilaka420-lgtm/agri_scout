<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use App\Models\farm as Farm;
use App\Models\DiseaseReport;
use App\Helpers\ActivityLogger;
use Illuminate\Support\Facades\Session;

class FarmerDiseaseController extends Controller
{
    public function index()
    {
        $userId = Session::get('user_id');
        $farmer = Farmer::where('USER_ID', $userId)->first();

        if (!$farmer) {
            $diseaseReports = collect();
            $farmsMap = [];
        } else {
            $farms = Farm::where('FARMER_ID', $farmer->FARMER_ID)->get();
            $farmsMap = $farms->keyBy('FARM_ID');
            $farmIds = $farms->pluck('FARM_ID')->map(fn($id) => (int)$id)->toArray();

            $diseaseReports = count($farmIds) > 0 ? DiseaseReport::whereIn('farm_id', $farmIds)->get() : collect();
        }

        ActivityLogger::log(Session::get('user_id'), 'FARMER', 'VIEW_LIST', 'DISEASES', 'Farmer viewed disease reports');

        return view('farmer.diseases.index', compact('diseaseReports', 'farmsMap'));
    }
}
