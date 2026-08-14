<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Farmer;
use App\Models\farm as Farm;
use App\Models\FieldOfficer;
use App\Models\OfficerVisit;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Crop;
use App\Models\VisitReport;
use App\Models\DiseaseReport;
use Illuminate\Support\Facades\Hash;

echo "=== SEEDING ORACLE & MONGODB DATA ===\n";

try {
    // 1. Ensure USERS & Profiles exist
    $farmerUser = User::whereRaw("LOWER(EMAIL) = 'farmer@agriscout.com'")->first();
    if (!$farmerUser) {
        $farmerUser = User::create([
            'NAME' => 'John Farmer',
            'EMAIL' => 'farmer@agriscout.com',
            'PASSWORD' => Hash::make('Farmer@123'),
            'ROLE' => 'farmer',
            'STATUS' => 'ACTIVE',
        ]);
    }

    $farmer = Farmer::where('USER_ID', $farmerUser->USER_ID)->orWhereRaw("LOWER(EMAIL) = 'farmer@agriscout.com'")->first();
    if (!$farmer) {
        $farmer = Farmer::create([
            'USER_ID' => $farmerUser->USER_ID,
            'NAME' => $farmerUser->NAME,
            'PHONE' => '0771234567',
            'EMAIL' => 'farmer@agriscout.com',
            'ADDRESS' => 'Hillwood Estate, Kandy',
            'CREATED_AT' => date('Y-m-d H:i:s'),
            'UPDATED_AT' => date('Y-m-d H:i:s'),
        ]);
    } else {
        $farmer->USER_ID = $farmerUser->USER_ID;
        $farmer->save();
    }
    echo "Farmer ID: {$farmer->FARMER_ID}, User ID: {$farmerUser->USER_ID}\n";

    $officerUser = User::whereRaw("LOWER(EMAIL) = 'officer@agriscout.com'")->first();
    if (!$officerUser) {
        $officerUser = User::create([
            'NAME' => 'Sarah Field Officer',
            'EMAIL' => 'officer@agriscout.com',
            'PASSWORD' => Hash::make('Officer@123'),
            'ROLE' => 'field_officer',
            'STATUS' => 'ACTIVE',
        ]);
    }

    $officer = FieldOfficer::where('USER_ID', $officerUser->USER_ID)->orWhereRaw("LOWER(EMAIL) = 'officer@agriscout.com'")->first();
    if (!$officer) {
        $officer = FieldOfficer::create([
            'USER_ID' => $officerUser->USER_ID,
            'EMPLOYEE_NO' => 'OFF-0004',
            'FULL_NAME' => $officerUser->NAME,
            'PHONE' => '0719876543',
            'EMAIL' => 'officer@agriscout.com',
            'ASSIGNED_AREA' => 'Kandy District',
            'JOINED_DATE' => date('Y-m-d'),
            'STATUS' => 'ACTIVE',
        ]);
    } else {
        $officer->USER_ID = $officerUser->USER_ID;
        $officer->save();
    }
    echo "Field Officer ID: {$officer->OFFICER_ID}, User ID: {$officerUser->USER_ID}\n";

    $customerUser = User::whereRaw("LOWER(EMAIL) = 'customer@agriscout.com'")->first();
    if (!$customerUser) {
        $customerUser = User::create([
            'NAME' => 'David Customer',
            'EMAIL' => 'customer@agriscout.com',
            'PASSWORD' => Hash::make('Customer@123'),
            'ROLE' => 'customer',
            'STATUS' => 'ACTIVE',
        ]);
    }

    $customer = Customer::where('USER_ID', $customerUser->USER_ID)->orWhereRaw("LOWER(EMAIL) = 'customer@agriscout.com'")->first();
    if (!$customer) {
        $customer = Customer::create([
            'USER_ID' => $customerUser->USER_ID,
            'FULL_NAME' => $customerUser->NAME,
            'PHONE' => '0755554433',
            'EMAIL' => 'customer@agriscout.com',
            'ADDRESS' => 'No. 45, Main Street, Colombo',
            'REGISTERED_DATE' => date('Y-m-d'),
            'STATUS' => 'ACTIVE',
        ]);
    } else {
        $customer->USER_ID = $customerUser->USER_ID;
        $customer->save();
    }
    echo "Customer ID: {$customer->CUSTOMER_ID}, User ID: {$customerUser->USER_ID}\n";

    // 2. Link or create Farms
    $farms = Farm::all();
    if ($farms->count() > 0) {
        foreach ($farms as $f) {
            $f->FARMER_ID = $farmer->FARMER_ID;
            $f->save();
        }
        echo "Linked {$farms->count()} farms to Farmer ID: {$farmer->FARMER_ID}\n";
    } else {
        $f1 = Farm::create([
            'FARMER_ID' => $farmer->FARMER_ID,
            'FARM_NAME' => 'Hillwood Organic Farm',
            'LOCATION' => 'Peradeniya Road',
            'DISTRICT' => 'Kandy',
            'AREA' => '12.5',
        ]);
        $farms = collect([$f1]);
        echo "Created farm ID: {$f1->FARM_ID}\n";
    }

    $farm1 = Farm::first();

    // 3. Officer Visit
    if ($farm1 && $officer) {
        $v1 = OfficerVisit::where('OFFICER_ID', $officer->OFFICER_ID)->where('FARM_ID', $farm1->FARM_ID)->first();
        if (!$v1) {
            $v1 = OfficerVisit::create([
                'OFFICER_ID' => $officer->OFFICER_ID,
                'FARM_ID' => $farm1->FARM_ID,
                'VISIT_DATE' => date('Y-m-d'),
                'VISIT_TYPE' => 'ROUTINE_INSPECTION',
                'STATUS' => 'COMPLETED',
                'PURPOSE' => 'Seasonal crop growth & pest check',
                'CREATED_AT' => date('Y-m-d H:i:s'),
            ]);
        }
        echo "Officer Visit ID: {$v1->VISIT_ID}\n";
    }

    // 4. Order
    if ($farm1 && $customer) {
        $o1 = Order::where('CUSTOMER_ID', $customer->CUSTOMER_ID)->first();
        if (!$o1) {
            $o1 = Order::create([
                'CUSTOMER_ID' => $customer->CUSTOMER_ID,
                'FARM_ID' => $farm1->FARM_ID,
                'ORDER_DATE' => date('Y-m-d'),
                'CROP_NAME' => 'Mango (Karutha Colomban)',
                'QUANTITY' => 150,
                'UNIT' => 'KG',
                'UNIT_PRICE' => 450.00,
                'TOTAL_AMOUNT' => 67500.00,
                'STATUS' => 'PENDING',
            ]);
        }
        echo "Order ID: {$o1->ORDER_ID}\n";
    }

    // 5. MongoDB Collections
    if ($farm1) {
        $farmId = (int)$farm1->FARM_ID;

        Crop::updateOrCreate(
            ['farm_id' => $farmId, 'crop_name' => 'Mango'],
            [
                'variety' => 'Karutha Colomban',
                'category' => 'Fruit',
                'planting_date' => '2025-10-15',
                'expected_harvest_date' => '2026-09-20',
                'current_stage' => 'Fruiting',
                'area_acres' => 4.5,
                'estimated_yield' => 3200,
                'yield_unit' => 'KG',
                'status' => 'GROWING',
                'created_at' => now()->toIso8601String(),
                'updated_at' => now()->toIso8601String(),
            ]
        );

        Crop::updateOrCreate(
            ['farm_id' => $farmId, 'crop_name' => 'Cinnamon'],
            [
                'variety' => 'Ceylon Alba',
                'category' => 'Other',
                'planting_date' => '2024-05-10',
                'expected_harvest_date' => '2026-11-30',
                'current_stage' => 'Maturing',
                'area_acres' => 3.0,
                'estimated_yield' => 800,
                'yield_unit' => 'KG',
                'status' => 'GROWING',
                'created_at' => now()->toIso8601String(),
                'updated_at' => now()->toIso8601String(),
            ]
        );

        if (isset($v1) && $officer) {
            VisitReport::updateOrCreate(
                ['visit_id' => (int)$v1->VISIT_ID],
                [
                    'farm_id' => $farmId,
                    'officer_id' => (int)$officer->OFFICER_ID,
                    'report_date' => date('Y-m-d'),
                    'weather' => [
                        'condition' => 'Partly Cloudy',
                        'temperature' => 29,
                        'humidity' => 68,
                    ],
                    'crop_condition' => 'Healthy & Vigorous',
                    'soil_condition' => 'Optimal Moisture',
                    'irrigation_status' => 'Drip Irrigation Functioning',
                    'fertilizer_applied' => true,
                    'pest_detected' => false,
                    'remarks' => 'Mango fruit set looks excellent this season. No sign of fungal infestation.',
                    'recommendations' => [
                        'Apply organic potash in 2 weeks',
                        'Maintain drip irrigation frequency',
                        'Monitor for leafhopper activity',
                    ],
                    'photos' => [],
                    'created_at' => now()->toIso8601String(),
                ]
            );
        }

        DiseaseReport::updateOrCreate(
            ['farm_id' => $farmId, 'crop_name' => 'Mango'],
            [
                'reported_by' => [
                    'user_id' => (int)$officerUser->USER_ID,
                    'role' => 'FIELD_OFFICER',
                ],
                'disease' => [
                    'name' => 'Anthracnose',
                    'severity' => 'LOW',
                    'symptoms' => [
                        'Minor dark spots on lower leaves',
                    ],
                ],
                'reported_date' => '2026-08-01',
                'description' => 'Early stage symptoms detected on lower canopy during field inspection.',
                'images' => [],
                'treatment' => [
                    'recommended' => 'Apply organic neem spray & prune lower branches',
                ],
                'follow_ups' => [
                    [
                        'date' => '2026-08-08',
                        'status' => 'RESOLVED',
                        'remarks' => 'Spots dried up after pruning and spray treatment.',
                    ]
                ],
                'status' => 'RESOLVED',
                'created_at' => now()->toIso8601String(),
            ]
        );

        echo "MongoDB seeded successfully!\n";
    }

} catch (Exception $e) {
    echo "SEEDING ERROR: " . $e->getMessage() . "\n" . $e->getTraceAsString();
}
