<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\farm as Farm;
use App\Models\Farmer;
use App\Helpers\ActivityLogger;
use Illuminate\Support\Facades\Session;

class CustomerCropController extends Controller
{
    public function index()
    {
        $crops = Crop::all();
        $farmsMap = Farm::all()->keyBy('FARM_ID');

        ActivityLogger::log(Session::get('user_id'), 'CUSTOMER', 'BROWSE', 'CROPS', 'Customer browsed crop marketplace');

        return view('customer.crops.index', compact('crops', 'farmsMap'));
    }

    public function show($id)
    {
        $crop = Crop::findOrFail($id);

        $farm = null;
        $farmer = null;

        if ($crop->farm_id) {
            $farm = Farm::where('FARM_ID', $crop->farm_id)->first();
            if ($farm && $farm->FARMER_ID) {
                $farmer = Farmer::where('FARMER_ID', $farm->FARMER_ID)->first();
            }
        }

        ActivityLogger::log(Session::get('user_id'), 'CUSTOMER', 'VIEW_DETAILS', 'CROPS', 'Customer viewed crop details for ' . $crop->crop_name, $id);

        return view('customer.crops.show', compact('crop', 'farm', 'farmer'));
    }
}
