<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\farm as Farm;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class AdminCropController extends Controller
{
    public function index()
    {
        try {
            $crops = Crop::all();
            $farmsMap = Farm::all()->keyBy('FARM_ID');
        } catch (\Throwable $e) {
            Log::error('AdminCropController@index error: ' . $e->getMessage());
            $crops = collect();
            $farmsMap = collect();
        }

        return view('admin.crops.index', compact('crops', 'farmsMap'));
    }

    public function create()
    {
        try {
            $farms = Farm::with('farmer')->get();
        } catch (\Throwable $e) {
            Log::error('AdminCropController@create error: ' . $e->getMessage());
            $farms = collect();
        }

        return view('admin.crops.create', compact('farms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'farm_id' => 'required|numeric',
            'crop_name' => 'required|string|max:100',
            'variety' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:100',
            'planting_date' => 'nullable|date',
            'expected_harvest_date' => 'nullable|date|after_or_equal:planting_date',
            'current_stage' => 'nullable|string|max:100',
            'area_acres' => 'nullable|numeric|min:0',
            'estimated_yield' => 'nullable|numeric|min:0',
            'yield_unit' => 'nullable|string|max:20',
            'status' => 'required|string|max:50',
        ], [
            'expected_harvest_date.after_or_equal' => 'The expected harvest date cannot be before the planting date.',
        ]);

        $farmId = (int)$request->farm_id;

        // Oracle Farm Verification Rule: Confirm farm exists in Oracle FARMS table before MongoDB insertion
        $farmExists = Farm::where('FARM_ID', $farmId)->exists();
        if (!$farmExists) {
            return back()->withInput()->withErrors([
                'farm_id' => 'Invalid Farm: Selected farm_id (' . $farmId . ') does not exist in the Oracle FARMS database.'
            ]);
        }

        try {
            $crop = Crop::create([
                'farm_id' => $farmId,
                'crop_name' => $request->crop_name,
                'variety' => $request->variety,
                'category' => $request->category ?? 'Other',
                'planting_date' => $request->planting_date,
                'expected_harvest_date' => $request->expected_harvest_date,
                'current_stage' => $request->current_stage ?? 'PLANNED',
                'area_acres' => $request->area_acres ? (float)$request->area_acres : null,
                'estimated_yield' => $request->estimated_yield ? (float)$request->estimated_yield : null,
                'yield_unit' => $request->yield_unit ?? 'KG',
                'status' => strtoupper($request->status),
                'created_at' => now()->toIso8601String(),
                'updated_at' => now()->toIso8601String(),
            ]);

            $adminId = Session::get('admin_id') ?? 1;
            ActivityLogger::log($adminId, 'ADMIN', 'CREATE', 'CROP', 'Created crop document "' . $crop->crop_name . '" for Oracle Farm #' . $farmId, $crop->_id);

            return redirect()->route('admin.crops.index')->with('success', 'Crop added successfully.');
        } catch (\Throwable $e) {
            Log::error('AdminCropController@store failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to save crop document to MongoDB: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $crop = Crop::findOrFail($id);
            $farms = Farm::with('farmer')->get();
        } catch (\Throwable $e) {
            Log::error('AdminCropController@edit error: ' . $e->getMessage());
            return redirect()->route('admin.crops.index')->with('error', 'Crop not found.');
        }

        return view('admin.crops.edit', compact('crop', 'farms'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'farm_id' => 'required|numeric',
            'crop_name' => 'required|string|max:100',
            'variety' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:100',
            'planting_date' => 'nullable|date',
            'expected_harvest_date' => 'nullable|date|after_or_equal:planting_date',
            'current_stage' => 'nullable|string|max:100',
            'area_acres' => 'nullable|numeric|min:0',
            'estimated_yield' => 'nullable|numeric|min:0',
            'yield_unit' => 'nullable|string|max:20',
            'status' => 'required|string|max:50',
        ], [
            'expected_harvest_date.after_or_equal' => 'The expected harvest date cannot be before the planting date.',
        ]);

        $farmId = (int)$request->farm_id;

        // Oracle Farm Verification
        $farmExists = Farm::where('FARM_ID', $farmId)->exists();
        if (!$farmExists) {
            return back()->withInput()->withErrors([
                'farm_id' => 'Invalid Farm: Selected farm_id (' . $farmId . ') does not exist in the Oracle FARMS database.'
            ]);
        }

        try {
            $crop = Crop::findOrFail($id);
            $crop->update([
                'farm_id' => $farmId,
                'crop_name' => $request->crop_name,
                'variety' => $request->variety,
                'category' => $request->category ?? 'Other',
                'planting_date' => $request->planting_date,
                'expected_harvest_date' => $request->expected_harvest_date,
                'current_stage' => $request->current_stage,
                'area_acres' => $request->area_acres ? (float)$request->area_acres : null,
                'estimated_yield' => $request->estimated_yield ? (float)$request->estimated_yield : null,
                'yield_unit' => $request->yield_unit ?? 'KG',
                'status' => strtoupper($request->status),
                'updated_at' => now()->toIso8601String(),
            ]);

            $adminId = Session::get('admin_id') ?? 1;
            ActivityLogger::log($adminId, 'ADMIN', 'UPDATE', 'CROP', 'Updated crop document "' . $crop->crop_name . '" (ID: ' . $id . ')', $id);

            return redirect()->route('admin.crops.index')->with('success', 'Crop updated successfully.');
        } catch (\Throwable $e) {
            Log::error('AdminCropController@update failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update crop document in MongoDB: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $crop = Crop::findOrFail($id);
            $cropName = $crop->crop_name;
            $crop->delete();

            $adminId = Session::get('admin_id') ?? 1;
            ActivityLogger::log($adminId, 'ADMIN', 'DELETE', 'CROP', 'Deleted crop document "' . $cropName . '" (ID: ' . $id . ')', $id);

            return redirect()->route('admin.crops.index')->with('success', 'Crop deleted successfully.');
        } catch (\Throwable $e) {
            Log::error('AdminCropController@destroy failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete crop document: ' . $e->getMessage());
        }
    }
}
