<?php

namespace App\Http\Controllers;

use App\Models\FieldOfficer;
use App\Models\OfficerVisit;
use App\Models\VisitReport;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OfficerVisitReportController extends Controller
{
    private function getAuthenticatedOfficer()
    {
        $userId = Session::get('user_id');
        return FieldOfficer::where('USER_ID', $userId)->firstOrFail();
    }

    public function create(Request $request)
    {
        $officer = $this->getAuthenticatedOfficer();
        $visitId = $request->query('visit_id');

        $visits = OfficerVisit::with('farm')->where('OFFICER_ID', $officer->OFFICER_ID)->get();
        $selectedVisit = $visitId ? OfficerVisit::with('farm')->where('VISIT_ID', $visitId)->first() : null;

        return view('officer.visit-reports.create', compact('visits', 'selectedVisit'));
    }

    public function store(Request $request)
    {
        $officer = $this->getAuthenticatedOfficer();

        $request->validate([
            'visit_id' => 'required|numeric',
            'crop_condition' => 'required|string',
            'soil_condition' => 'required|string',
            'irrigation_status' => 'required|string',
            'remarks' => 'required|string',
            'recommendations' => 'nullable|string',
        ]);

        $visit = OfficerVisit::where('VISIT_ID', $request->visit_id)->firstOrFail();

        if ((int)$visit->OFFICER_ID !== (int)$officer->OFFICER_ID) {
            abort(403, 'Unauthorized visit access.');
        }

        $recommendationsList = array_filter(array_map('trim', explode("\n", $request->recommendations ?? '')));

        VisitReport::updateOrCreate(
            ['visit_id' => (int)$visit->VISIT_ID],
            [
                'farm_id' => (int)$visit->FARM_ID,
                'officer_id' => (int)$officer->OFFICER_ID,
                'report_date' => date('Y-m-d'),
                'weather' => [
                    'condition' => $request->weather_condition ?? 'Sunny',
                    'temperature' => (int)($request->temperature ?? 30),
                    'humidity' => (int)($request->humidity ?? 65),
                ],
                'crop_condition' => $request->crop_condition,
                'soil_condition' => $request->soil_condition,
                'irrigation_status' => $request->irrigation_status,
                'fertilizer_applied' => $request->has('fertilizer_applied'),
                'pest_detected' => $request->has('pest_detected'),
                'remarks' => $request->remarks,
                'recommendations' => array_values($recommendationsList),
                'photos' => [],
                'created_at' => now()->toIso8601String(),
                'updated_at' => now()->toIso8601String(),
            ]
        );

        // Update Oracle visit status to COMPLETED
        $visit->STATUS = 'COMPLETED';
        $visit->save();

        ActivityLogger::log(Session::get('user_id'), 'FIELD_OFFICER', 'SUBMIT_REPORT', 'VISIT_REPORTS', 'Officer submitted visit report for visit ID ' . $visit->VISIT_ID, $visit->VISIT_ID);

        return redirect()->route('officer.visits.show', $visit->VISIT_ID)->with('success', 'Detailed visit report submitted to MongoDB.');
    }
}
