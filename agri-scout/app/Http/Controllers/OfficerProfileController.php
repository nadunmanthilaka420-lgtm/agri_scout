<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FieldOfficer;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OfficerProfileController extends Controller
{
    public function index()
    {
        $userId = Session::get('user_id');
        $user = User::findOrFail($userId);
        $officer = FieldOfficer::where('USER_ID', $userId)->first();

        ActivityLogger::log($userId, 'FIELD_OFFICER', 'VIEW_PROFILE', 'PROFILE', 'Officer viewed profile');

        return view('officer.profile.index', compact('user', 'officer'));
    }

    public function update(Request $request)
    {
        $userId = Session::get('user_id');
        $user = User::findOrFail($userId);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'assigned_area' => 'required|string|max:255',
        ]);

        $user->NAME = $request->name;
        $user->save();

        Session::put('user_name', $user->NAME);

        $officer = FieldOfficer::where('USER_ID', $userId)->first();
        if ($officer) {
            $officer->FULL_NAME = $request->name;
            $officer->PHONE = $request->phone;
            $officer->ASSIGNED_AREA = $request->assigned_area;
            $officer->save();
        }

        ActivityLogger::log($userId, 'FIELD_OFFICER', 'UPDATE_PROFILE', 'PROFILE', 'Officer updated profile information');

        return back()->with('success', 'Field Officer profile updated successfully.');
    }
}
