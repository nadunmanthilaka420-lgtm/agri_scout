<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== ORACLE TABLES ===\n";
$tables = DB::select("SELECT table_name FROM all_tables WHERE owner = 'C##AGRI' ORDER BY table_name");
foreach($tables as $t) {
    $t = (array)$t;
    echo array_values($t)[0] . "\n";
}

echo "\n=== TABLE COLUMNS ===\n";
$tableNames = ['USERS', 'FARMERS', 'FARMS', 'FIELD_OFFICERS', 'OFFICER_VISITS', 'CUSTOMERS', 'ORDERS'];
foreach($tableNames as $tname) {
    echo "\n-- $tname --\n";
    try {
        $cols = DB::select("SELECT column_name, data_type, nullable FROM all_tab_columns WHERE owner = 'C##AGRI' AND table_name = '$tname' ORDER BY column_id");
        foreach($cols as $col) {
            $col = (array)$col;
            $vals = array_values($col);
            echo "  {$vals[0]} ({$vals[1]}) nullable={$vals[2]}\n";
        }
    } catch (Exception $e) {
        echo "  TABLE NOT FOUND or ERROR: " . $e->getMessage() . "\n";
    }
}

echo "\n=== SAMPLE DATA (USERS) ===\n";
try {
    $users = DB::select("SELECT USER_ID, NAME, EMAIL, ROLE, STATUS FROM USERS WHERE ROWNUM <= 10");
    foreach($users as $u) {
        $u = (array)$u;
        echo "  " . json_encode($u) . "\n";
    }
} catch(Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

echo "\n=== SAMPLE DATA (FARMERS) ===\n";
try {
    $rows = DB::select("SELECT * FROM FARMERS WHERE ROWNUM <= 5");
    foreach($rows as $r) { echo "  " . json_encode((array)$r) . "\n"; }
} catch(Exception $e) { echo "ERROR: " . $e->getMessage() . "\n"; }

echo "\n=== SAMPLE DATA (FARMS) ===\n";
try {
    $rows = DB::select("SELECT * FROM FARMS WHERE ROWNUM <= 5");
    foreach($rows as $r) { echo "  " . json_encode((array)$r) . "\n"; }
} catch(Exception $e) { echo "ERROR: " . $e->getMessage() . "\n"; }
