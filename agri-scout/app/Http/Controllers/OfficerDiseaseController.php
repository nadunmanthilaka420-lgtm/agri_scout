<?php

namespace App\Http\Controllers;

use App\Models\FieldOfficer;
use App\Models\farm as Farm;
use App\Models\DiseaseReport;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OfficerDiseaseController extends Controller
{
    private function getAuthenticatedOfficer()
    {
        $userId = Session::get('user_id');
        return FieldOfficer::where('USER_ID', $userId)->firstOrFail();
    }

    public function index()
    {
        $officer = $this->getAuthenticatedOfficer();
        $diseaseReports = DiseaseReport::all();
        $farms = Farm::all()->keyBy('FARM_ID');

        ActivityLogger::log(Session::get('user_id'), 'FIELD_OFFICER', 'VIEW_LIST', 'DISEASES', 'Officer viewed disease reports list');

        return view('officer.diseases.index', compact('diseaseReports', 'farms'));
    }

    public function create()
    {
        $farms = Farm::all();
        return view('officer.diseases.create', compact('farms'));
    }

    public function store(Request $request)
    {
        $userId = Session::get('user_id');

        $request->validate([
            'farm_id' => 'required|numeric',
            'crop_name' => 'required|string',
            'disease_name' => 'required|string',
            'severity' => 'required|in:LOW,MEDIUM,HIGH,CRITICAL',
            'description' => 'required|string',
            'treatment' => 'nullable|string',
        ]);

        $symptomsList = array_filter(array_map('trim', explode("\n", $request->symptoms ?? '')));

        $report = DiseaseReport::create([
            'farm_id' => (int)$request->farm_id,
            'crop_name' => $request->crop_name,
            'reported_by' => [
                'user_id' => (int)$userId,
                'role' => 'FIELD_OFFICER',
            ],
            'disease' => [
                'name' => $request->disease_name,
                'severity' => strtoupper($request->severity),
                'symptoms' => array_values($symptomsList),
            ],
            'reported_date' => date('Y-m-d'),
            'description' => $request->description,
            'images' => [],
            'treatment' => [
                'recommended' => $request->treatment ?? 'Standard crop protection recommended.',
            ],
            'follow_ups' => [],
            'status' => 'OPEN',
            'created_at' => now()->toIso8601String(),
            'updated_at' => now()->toIso8601String(),
        ]);

        ActivityLogger::log($userId, 'FIELD_OFFICER', 'CREATE', 'DISEASES', 'Officer created disease report for crop ' . $request->crop_name, $report->_id);

        return redirect()->route('officer.diseases.index')->with('success', 'Disease report registered in MongoDB.');
    }

    public function show($id)
    {
        $report = DiseaseReport::findOrFail($id);
        $farm = Farm::where('FARM_ID', $report->farm_id)->first();

        ActivityLogger::log(Session::get('user_id'), 'FIELD_OFFICER', 'VIEW_DETAILS', 'DISEASES', 'Officer viewed disease report ' . $id, $id);

        return view('officer.diseases.show', compact('report', 'farm'));
    }

    public function addFollowUp(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:OPEN,IMPROVING,RESOLVED,MONITORING',
            'remarks' => 'required|string',
        ]);

        $report = DiseaseReport::findOrFail($id);

        $followUps = $report->follow_ups ?? [];
        $followUps[] = [
            'date' => date('Y-m-d'),
            'status' => strtoupper($request->status),
            'remarks' => $request->remarks,
        ];

        $report->follow_ups = $followUps;
        $report->status = strtoupper($request->status);
        $report->updated_at = now()->toIso8601String();
        $report->save();

        ActivityLogger::log(Session::get('user_id'), 'FIELD_OFFICER', 'ADD_FOLLOWUP', 'DISEASES', 'Officer added follow-up to disease report ' . $id, $id);

        return back()->with('success', 'Follow-up observation added successfully.');
    }
}
