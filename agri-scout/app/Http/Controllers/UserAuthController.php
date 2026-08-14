<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Farmer;
use App\Models\FieldOfficer;
use App\Models\Customer;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserAuthController extends Controller
{
    public function showLogin()
    {
        if (Session::has('user_id') || Session::has('admin_id')) {
            $role = Session::get('user_role') ?? Session::get('admin_role');
            return $this->redirectByRole($role);
        }
        return view('auth.login');
    }

    public function showRegister()
    {
        if (Session::has('user_id') || Session::has('admin_id')) {
            $role = Session::get('user_role') ?? Session::get('admin_role');
            return $this->redirectByRole($role);
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'role' => 'required|in:farmer,field_officer,customer',
            'password' => 'required|min:6|confirmed',
        ]);

        $existing = User::whereRaw('LOWER(EMAIL) = ?', [strtolower($request->email)])->first();
        if ($existing) {
            return back()->withInput()->with('error', 'An account with this email address already exists.');
        }

        $userRole = strtolower($request->role);

        $user = User::create([
            'NAME' => $request->name,
            'EMAIL' => strtolower($request->email),
            'PASSWORD' => Hash::make($request->password),
            'ROLE' => $userRole,
            'STATUS' => 'ACTIVE',
        ]);

        $this->ensureRoleProfileExists($user);

        Session::put('user_id', $user->user_id);
        Session::put('user_name', $user->name);
        Session::put('user_role', $user->role);

        ActivityLogger::log($user->user_id, $user->role, 'REGISTER', 'AUTH', 'User registered new account');

        return $this->redirectByRole($user->role);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::whereRaw('LOWER(EMAIL) = ?', [strtolower($request->email)])
            ->whereIn('ROLE', [
                'FIELD_OFFICER', 'field_officer',
                'FARMER', 'farmer',
                'CUSTOMER', 'customer',
                'ADMIN', 'admin'
            ])
            ->whereIn('STATUS', ['ACTIVE', 'active'])
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {

            $userRole = strtolower($user->role);

            if ($userRole === 'admin') {
                Session::put('admin_id', $user->user_id);
                Session::put('admin_name', $user->name);
                Session::put('admin_role', $user->role);
            } else {
                Session::put('user_id', $user->user_id);
                Session::put('user_name', $user->name);
                Session::put('user_role', $user->role);
                $this->ensureRoleProfileExists($user);
            }

            ActivityLogger::log($user->user_id, $user->role, 'LOGIN', 'AUTH', 'User logged in');

            return $this->redirectByRole($userRole);
        }

        return back()->with('error', 'Invalid user credentials.');
    }

    public function dashboard()
    {
        $userId = Session::get('user_id') ?? Session::get('admin_id');
        $role = Session::get('user_role') ?? Session::get('admin_role');

        if (!$userId || !$role) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        return $this->redirectByRole($role);
    }

    public function logout()
    {
        $userId = Session::get('user_id') ?? Session::get('admin_id');
        $role = Session::get('user_role') ?? Session::get('admin_role');

        if ($userId && $role) {
            ActivityLogger::log($userId, $role, 'LOGOUT', 'AUTH', 'User logged out');
        }

        Session::forget(['user_id', 'user_name', 'user_role', 'admin_id', 'admin_name', 'admin_role']);

        return redirect()->route('login');
    }

    private function redirectByRole($role)
    {
        $normalized = strtolower($role);

        switch ($normalized) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'farmer':
                return redirect()->route('farmer.dashboard');
            case 'field_officer':
                return redirect()->route('officer.dashboard');
            case 'customer':
                return redirect()->route('customer.dashboard');
            default:
                return redirect()->route('login');
        }
    }

    private function ensureRoleProfileExists($user)
    {
        $role = strtolower($user->role);

        try {
            if ($role === 'farmer') {
                $farmer = Farmer::where('USER_ID', $user->user_id)->orWhereRaw('LOWER(EMAIL) = ?', [strtolower($user->email)])->first();
                if (!$farmer) {
                    Farmer::create([
                        'USER_ID' => $user->user_id,
                        'NAME' => $user->name,
                        'EMAIL' => strtolower($user->email),
                        'PHONE' => '070' . str_pad($user->user_id, 7, '0', STR_PAD_LEFT),
                        'ADDRESS' => 'Not set',
                        'CREATED_AT' => date('Y-m-d H:i:s'),
                        'UPDATED_AT' => date('Y-m-d H:i:s'),
                    ]);
                } elseif (!$farmer->USER_ID) {
                    $farmer->USER_ID = $user->user_id;
                    $farmer->save();
                }
            } elseif ($role === 'field_officer') {
                $officer = FieldOfficer::where('USER_ID', $user->user_id)->orWhereRaw('LOWER(EMAIL) = ?', [strtolower($user->email)])->first();
                if (!$officer) {
                    FieldOfficer::create([
                        'USER_ID' => $user->user_id,
                        'EMPLOYEE_NO' => 'OFF-' . str_pad($user->user_id, 4, '0', STR_PAD_LEFT),
                        'FULL_NAME' => $user->name,
                        'EMAIL' => strtolower($user->email),
                        'PHONE' => '071' . str_pad($user->user_id, 7, '0', STR_PAD_LEFT),
                        'ASSIGNED_AREA' => 'Central Region',
                        'JOINED_DATE' => date('Y-m-d'),
                        'STATUS' => 'ACTIVE',
                    ]);
                } elseif (!$officer->USER_ID) {
                    $officer->USER_ID = $user->user_id;
                    $officer->save();
                }
            } elseif ($role === 'customer') {
                $customer = Customer::where('USER_ID', $user->user_id)->orWhereRaw('LOWER(EMAIL) = ?', [strtolower($user->email)])->first();
                if (!$customer) {
                    Customer::create([
                        'USER_ID' => $user->user_id,
                        'FULL_NAME' => $user->name,
                        'EMAIL' => strtolower($user->email),
                        'PHONE' => '072' . str_pad($user->user_id, 7, '0', STR_PAD_LEFT),
                        'ADDRESS' => 'Not set',
                        'REGISTERED_DATE' => date('Y-m-d'),
                        'STATUS' => 'ACTIVE',
                    ]);
                } elseif (!$customer->USER_ID) {
                    $customer->USER_ID = $user->user_id;
                    $customer->save();
                }
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Profile provision error: ' . $e->getMessage());
        }
    }
}
