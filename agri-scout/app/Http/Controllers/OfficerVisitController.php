<?php

namespace App\Http\Controllers;

use App\Models\FieldOfficer;
use App\Models\OfficerVisit;
use App\Models\farm as Farm;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OfficerVisitController extends Controller
{
    private function getAuthenticatedOfficer()
    {
        $userId = Session::get('user_id');
        return FieldOfficer::where('USER_ID', $userId)->firstOrFail();
    }

    public function index()
    {
        $officer = $this->getAuthenticatedOfficer();
        $visits = OfficerVisit::with(['farm.farmer'])->where('OFFICER_ID', $officer->OFFICER_ID)->orderBy('VISIT_DATE', 'desc')->get();

        ActivityLogger::log(Session::get('user_id'), 'FIELD_OFFICER', 'VIEW_LIST', 'VISITS', 'Officer viewed visits list');

        return view('officer.visits.index', compact('visits'));
    }

    public function create()
    {
        $farms = Farm::with('farmer')->get();
        return view('officer.visits.create', compact('farms'));
    }

    public function store(Request $request)
    {
        $officer = $this->getAuthenticatedOfficer();

        $request->validate([
            'farm_id' => 'required|numeric',
            'visit_date' => 'required|date',
            'visit_type' => 'required|string',
            'purpose' => 'required|string|max:500',
        ]);

        $visit = OfficerVisit::create([
            'OFFICER_ID' => $officer->OFFICER_ID,
            'FARM_ID' => $request->farm_id,
            'VISIT_DATE' => $request->visit_date,
            'VISIT_TYPE' => strtoupper($request->visit_type),
            'STATUS' => 'PENDING',
            'PURPOSE' => $request->purpose,
            'CREATED_AT' => date('Y-m-d H:i:s'),
        ]);

        ActivityLogger::log(Session::get('user_id'), 'FIELD_OFFICER', 'CREATE', 'VISITS', 'Officer created visit ID ' . $visit->VISIT_ID, $visit->VISIT_ID);

        return redirect()->route('officer.visits.index')->with('success', 'Visit scheduled successfully.');
    }

    public function show($id)
    {
        $officer = $this->getAuthenticatedOfficer();
        $visit = OfficerVisit::with(['farm.farmer', 'officer'])->where('VISIT_ID', $id)->firstOrFail();

        if ((int)$visit->OFFICER_ID !== (int)$officer->OFFICER_ID) {
            abort(403, 'Unauthorized access: Visit does not belong to you.');
        }

        ActivityLogger::log(Session::get('user_id'), 'FIELD_OFFICER', 'VIEW_DETAILS', 'VISITS', 'Officer viewed visit details ' . $id, $id);

        return view('officer.visits.show', compact('visit'));
    }

    public function edit($id)
    {
        $officer = $this->getAuthenticatedOfficer();
        $visit = OfficerVisit::where('VISIT_ID', $id)->firstOrFail();

        if ((int)$visit->OFFICER_ID !== (int)$officer->OFFICER_ID) {
            abort(403, 'Unauthorized access: Visit does not belong to you.');
        }

        $farms = Farm::all();
        return view('officer.visits.edit', compact('visit', 'farms'));
    }

    public function update(Request $request, $id)
    {
        $officer = $this->getAuthenticatedOfficer();
        $visit = OfficerVisit::where('VISIT_ID', $id)->firstOrFail();

        if ((int)$visit->OFFICER_ID !== (int)$officer->OFFICER_ID) {
            abort(403, 'Unauthorized access: Visit does not belong to you.');
        }

        $request->validate([
            'visit_date' => 'required|date',
            'visit_type' => 'required|string',
            'status' => 'required|in:PENDING,IN_PROGRESS,COMPLETED,CANCELLED',
            'purpose' => 'required|string|max:500',
        ]);

        $visit->VISIT_DATE = $request->visit_date;
        $visit->VISIT_TYPE = strtoupper($request->visit_type);
        $visit->STATUS = strtoupper($request->status);
        $visit->PURPOSE = $request->purpose;
        $visit->save();

        ActivityLogger::log(Session::get('user_id'), 'FIELD_OFFICER', 'UPDATE', 'VISITS', 'Officer updated visit ID ' . $id, $id);

        return redirect()->route('officer.visits.show', $id)->with('success', 'Visit updated successfully.');
    }
}
