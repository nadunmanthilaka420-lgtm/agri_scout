<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerProfileController extends Controller
{
    public function index()
    {
        $userId = Session::get('user_id');
        $user = User::findOrFail($userId);
        $customer = Customer::where('USER_ID', $userId)->first();

        ActivityLogger::log($userId, 'CUSTOMER', 'VIEW_PROFILE', 'PROFILE', 'Customer viewed profile');

        return view('customer.profile.index', compact('user', 'customer'));
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

        $customer = Customer::where('USER_ID', $userId)->first();
        if ($customer) {
            $customer->FULL_NAME = $request->name;
            $customer->PHONE = $request->phone;
            $customer->ADDRESS = $request->address;
            $customer->save();
        }

        ActivityLogger::log($userId, 'CUSTOMER', 'UPDATE_PROFILE', 'PROFILE', 'Customer updated profile information');

        return back()->with('success', 'Customer profile updated successfully.');
    }
}
