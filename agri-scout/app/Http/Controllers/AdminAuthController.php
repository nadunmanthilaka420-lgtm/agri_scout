<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\farmers;
use App\Models\farm;
use App\Models\Crop;
use App\Models\FieldOfficer;
use App\Models\Customer;
use App\Models\Order;
use App\Models\VisitReport;
use App\Models\DiseaseReport;
use App\Models\ActivityLog;
class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (Session::has('admin_id')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $admin = User::whereRaw('LOWER(EMAIL) = ?', [strtolower($request->email)])
            ->whereIn('ROLE', ['ADMIN', 'admin'])
            ->whereIn('STATUS', ['ACTIVE', 'active'])
            ->first();

        if ($admin && Hash::check($request->password, $admin->password)) {

            Session::put('admin_id', $admin->user_id);
            Session::put('admin_name', $admin->name);
            Session::put('admin_role', $admin->role);

            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Invalid administrator credentials.');
    }

    public function dashboard()
    {
        if (!Session::has('admin_id')) {
            return redirect()->route('admin.login')->with('error', 'Please log in first.');
        }

        try {
            $farmersCount = farmers::count();
            $farmsCount = farm::count();
            $officersCount = FieldOfficer::count();
            $customersCount = Customer::count();
            if ($customersCount === 0) {
                $customersCount = User::whereIn('ROLE', ['CUSTOMER', 'customer'])->count();
            }
        } catch (\Throwable $e) {
            $farmersCount = 0;
            $farmsCount = 0;
            $officersCount = 0;
            $customersCount = 0;
        }

        return view('admin.dashboard', compact('farmersCount', 'farmsCount', 'officersCount', 'customersCount'));
    }

    public function logout()
    {
        Session::forget([
            'admin_id',
            'admin_name',
            'admin_role'
        ]);

        return redirect()->route('admin.login');
    }
    //ADD FARMER
    public function add_farmer()
    {


        return view('admin.add_farmer');
    }
    public function new_farmer(request $request){
    $data = new farmers;
    $data->setAttribute('NAME', $request->name);
    $data->setAttribute('PHONE', $request->phone);
    $data->setAttribute('EMAIL', $request->email);
    $data->setAttribute('ADDRESS', $request->address);

    $data->save();
    return redirect()->back()->with('success', '🌱 Farmer added successfully!');
    }
    //ADD FARM
     public function add_farm()
    {
        try {
            $farmers = farmers::all();
        } catch (\Throwable $e) {
            $farmers = collect();
        }

        return view('admin.add_farm', compact('farmers'));
    }
     public function new_farm(request $request){
    $data = new farm();
    $data->setAttribute('FARMER_ID', $request->farmer_id);
    $data->setAttribute('FARMNAME', $request->farmname);
    $data->setAttribute('LOCATION', $request->location);
    $data->setAttribute('DISTRICT', $request->district);
    $data->setAttribute('AREA', $request->area);

    $data->save();
    return redirect()->back()->with('success', '🌱 Farm added successfully!');
    }
    public function view_farmers(){
        try {
            $farmers = farmers::with(['farms'])->get();
            if ($farmers->isEmpty()) {
                $farmers = farmers::all();
            }
        } catch (\Throwable $e) {
            $farmers = collect();
        }

        return view('admin.view_farmers', compact('farmers'));
    }

    public function update_farmer(Request $request, $id)
    {
        try {
            $farmer = farmers::findOrFail($id);
            $farmer->setAttribute('NAME', $request->input('name'));
            $farmer->setAttribute('PHONE', $request->input('phone'));
            $farmer->setAttribute('EMAIL', $request->input('email'));
            $farmer->setAttribute('ADDRESS', $request->input('address'));
            $farmer->save();

            return redirect()->back()->with('success', '👨‍🌾 Farmer details updated successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Failed to update farmer: ' . $e->getMessage());
        }
    }

    public function delete_farmer($id)
    {
        try {
            $farmer = farmers::findOrFail($id);
            if ($farmer->user) {
                $farmer->user->delete();
            }
            $farmer->delete();

            return redirect()->back()->with('success', '🗑️ Farmer record deleted successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Failed to delete farmer: ' . $e->getMessage());
        }
    }
    public function view_farms(){
        try {
            $farms = farm::with(['farmer', 'visits', 'orders'])->get();
        } catch (\Throwable $e) {
            $farms = collect();
        }

        return view('admin.view_farms', compact('farms'));
    }

    public function update_farm(Request $request, $id)
    {
        try {
            $farm = farm::findOrFail($id);
            $farmName = $request->input('farmname');
            $farm->setAttribute('FARM_NAME', $farmName);
            $farm->setAttribute('FARMNAME', $farmName);
            $farm->setAttribute('LOCATION', $request->input('location'));
            $farm->setAttribute('DISTRICT', $request->input('district'));
            $farm->setAttribute('AREA', $request->input('area'));
            $farm->save();

            return redirect()->back()->with('success', '🌱 Farm details updated successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Failed to update farm: ' . $e->getMessage());
        }
    }

    public function delete_farm($id)
    {
        try {
            $farm = farm::findOrFail($id);
            $farm->delete();

            return redirect()->back()->with('success', '🗑️ Farm record deleted successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Failed to delete farm: ' . $e->getMessage());
        }
    }
    public function add_officer()
    {
        return view('admin.add_officer');
    }
    public function new_officer(Request $request){
        $data = new FieldOfficer;
        $data->setAttribute('EMPLOYEE_NO', $request->employee_no);
        $data->setAttribute('FULL_NAME', $request->name);
        $data->setAttribute('PHONE', $request->phone);
        $data->setAttribute('EMAIL', $request->email);
        $data->setAttribute('ASSIGNED_AREA', $request->area);

        $data->save();
        return redirect()->back()->with('success', '🌱 Officer added successfully!');
    }
    public function view_officers(){
        try {
            $officers = FieldOfficer::with(['user', 'visits'])->get();
            if ($officers->isEmpty()) {
                $officers = FieldOfficer::all();
            }
        } catch (\Throwable $e) {
            $officers = collect();
        }

        return view('admin.view_officers', compact('officers'));
    }

    public function update_officer(Request $request, $id)
    {
        try {
            $officer = FieldOfficer::findOrFail($id);
            $officer->setAttribute('EMPLOYEE_NO', $request->input('employee_no'));
            $officer->setAttribute('FULL_NAME', $request->input('name'));
            $officer->setAttribute('PHONE', $request->input('phone'));
            $officer->setAttribute('EMAIL', $request->input('email'));
            $officer->setAttribute('ASSIGNED_AREA', $request->input('area'));
            if ($request->has('status')) {
                $officer->setAttribute('STATUS', strtoupper($request->input('status')));
            }
            $officer->save();

            return redirect()->back()->with('success', '👮 Field officer updated successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Failed to update field officer: ' . $e->getMessage());
        }
    }

    public function delete_officer($id)
    {
        try {
            $officer = FieldOfficer::findOrFail($id);
            if ($officer->user) {
                $officer->user->delete();
            }
            $officer->delete();

            return redirect()->back()->with('success', '🗑️ Field officer record deleted successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Failed to delete field officer: ' . $e->getMessage());
        }
    }
    public function view_customers(){
        try {
            $customers = Customer::with(['user', 'orders'])->get();
            if ($customers->isEmpty()) {
                $customers = User::whereIn('ROLE', ['CUSTOMER', 'customer'])->get();
            }
        } catch (\Throwable $e) {
            $customers = collect();
        }

        return view('admin.view_customers', compact('customers'));
    }

    public function update_customer_status(Request $request, $id)
    {
        try {
            $customer = Customer::find($id);
            $newStatus = strtoupper($request->input('status', 'ACTIVE'));

            if ($customer) {
                $customer->STATUS = $newStatus;
                $customer->save();
                if ($customer->user) {
                    $customer->user->STATUS = $newStatus;
                    $customer->user->save();
                }
            } else {
                $user = User::findOrFail($id);
                $user->STATUS = $newStatus;
                $user->save();
            }

            return redirect()->back()->with('success', '👥 Customer status updated successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Failed to update customer: ' . $e->getMessage());
        }
    }

    public function delete_customer($id)
    {
        try {
            $customer = Customer::find($id);
            if ($customer) {
                if ($customer->user) {
                    $customer->user->delete();
                }
                $customer->delete();
            } else {
                $user = User::findOrFail($id);
                $user->delete();
            }

            return redirect()->back()->with('success', '🗑️ Customer account deleted successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Failed to delete customer: ' . $e->getMessage());
        }
    }
    public function view_orders(){
        try {
            $orders = Order::all();
        } catch (\Throwable $e) {
            $orders = collect();
        }

        return view('admin.view_orders', compact('orders'));
    }
    public function view_crops(){
        try {
            $crops = Crop::all();
        } catch (\Throwable $e) {
            $crops = collect();
        }

        return view('admin.view_crops', compact('crops'));
    }
    public function view_visit_reports(){
        try {
            $visitReports = VisitReport::whereNotNull('visit_id')->get();
            if ($visitReports->isEmpty()) {
                $visitReports = VisitReport::all();
            }
        } catch (\Throwable $e) {
            $visitReports = collect();
        }

        return view('admin.view_visit_reports', compact('visitReports'));
    }
    public function view_disease_reports(){
        try {
            $diseaseReports = DiseaseReport::all();
        } catch (\Throwable $e) {
            $diseaseReports = collect();
        }

        return view('admin.view_disease_reports', compact('diseaseReports'));
    }

    public function update_disease_status(Request $request, $id)
    {
        try {
            $report = DiseaseReport::findOrFail($id);
            $report->status = strtoupper($request->input('status', 'OPEN'));

            if ($request->filled('remarks')) {
                $followUps = $report->follow_ups ?? [];
                if (!is_array($followUps)) {
                    $followUps = [];
                }
                $followUps[] = [
                    'date' => date('Y-m-d'),
                    'status' => strtoupper($request->input('status', 'OPEN')),
                    'remarks' => $request->input('remarks') . ' (Updated by Admin)',
                    'by' => 'ADMIN'
                ];
                $report->follow_ups = $followUps;
            }

            $report->save();

            return redirect()->back()->with('success', '🌱 Disease report status updated successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Failed to update disease report: ' . $e->getMessage());
        }
    }

    public function delete_disease_report($id)
    {
        try {
            $report = DiseaseReport::findOrFail($id);
            $report->delete();

            return redirect()->back()->with('success', '🗑️ Disease report deleted successfully!');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Failed to delete disease report: ' . $e->getMessage());
        }
    }
    public function view_activity_logs()
    {
        try {
            $activityLogs = ActivityLog::all();
        } catch (\Throwable $e) {
            $activityLogs = collect();
        }

        return view('admin.view_activity_logs', compact('activityLogs'));
    }

}
