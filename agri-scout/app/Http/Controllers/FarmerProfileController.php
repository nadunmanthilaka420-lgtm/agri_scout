<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Farmer;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FarmerProfileController extends Controller
{
    public function index()
    {
        $userId = Session::get('user_id');
        $user = User::findOrFail($userId);
        $farmer = Farmer::where('USER_ID', $userId)->first();

        ActivityLogger::log($userId, 'FARMER', 'VIEW_PROFILE', 'PROFILE', 'Farmer viewed profile');

        return view('farmer.profile.index', compact('user', 'farmer'));
    }

    public function update(Request $request)
    {
        $userId = Session::get('user_id');
        $user = User::findOrFail($userId);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        $user->NAME = $request->name;
        $user->save();

        Session::put('user_name', $user->NAME);

        $farmer = Farmer::where('USER_ID', $userId)->first();
        if ($farmer) {
            $farmer->NAME = $request->name;
            $farmer->PHONE = $request->phone;
            $farmer->ADDRESS = $request->address;
            $farmer->UPDATED_AT = date('Y-m-d H:i:s');
            $farmer->save();
        }

        ActivityLogger::log($userId, 'FARMER', 'UPDATE_PROFILE', 'PROFILE', 'Farmer updated profile information');

        return back()->with('success', 'Profile updated successfully.');
    }
}
