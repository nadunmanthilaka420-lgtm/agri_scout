<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== MONGODB CONNECTION TEST ===\n";
try {
    $db = DB::connection('mongodb');
    $collections = $db->getMongoDB()->listCollections();
    echo "Collections:\n";
    foreach($collections as $col) {
        echo "  - " . $col->getName() . "\n";
    }
} catch(Exception $e) {
    echo "MONGODB ERROR: " . $e->getMessage() . "\n";
}

echo "\n=== SAMPLE CROPS ===\n";
try {
    $crops = DB::connection('mongodb')->collection('crops')->get();
    foreach($crops->take(3) as $crop) {
        echo json_encode($crop) . "\n";
    }
} catch(Exception $e) { echo "ERROR: " . $e->getMessage() . "\n"; }

echo "\n=== OFFICER VISITS SAMPLE ===\n";
try {
    $visits = DB::select("SELECT * FROM OFFICER_VISITS WHERE ROWNUM <= 3");
    foreach($visits as $v) { echo json_encode((array)$v) . "\n"; }
} catch(Exception $e) { echo "ERROR: " . $e->getMessage() . "\n"; }

echo "\n=== CUSTOMERS SAMPLE ===\n";
try {
    $rows = DB::select("SELECT * FROM CUSTOMERS WHERE ROWNUM <= 3");
    foreach($rows as $r) { echo json_encode((array)$r) . "\n"; }
} catch(Exception $e) { echo "ERROR: " . $e->getMessage() . "\n"; }

echo "\n=== FIELD_OFFICERS SAMPLE ===\n";
try {
    $rows = DB::select("SELECT * FROM FIELD_OFFICERS WHERE ROWNUM <= 3");
    foreach($rows as $r) { echo json_encode((array)$r) . "\n"; }
} catch(Exception $e) { echo "ERROR: " . $e->getMessage() . "\n"; }

echo "\n=== ORDERS SAMPLE ===\n";
try {
    $rows = DB::select("SELECT * FROM ORDERS WHERE ROWNUM <= 3");
    foreach($rows as $r) { echo json_encode((array)$r) . "\n"; }
} catch(Exception $e) { echo "ERROR: " . $e->getMessage() . "\n"; }
