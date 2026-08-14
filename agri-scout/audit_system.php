<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use MongoDB\Client as MongoClient;

echo "=========================================================\n";
echo "           AGRI SCOUT COMPLETE AUDIT REPORT              \n";
echo "=========================================================\n\n";

// 1. AUDIT ORACLE TABLES
echo "--- 1. ORACLE TABLES ---\n";
try {
    $tables = DB::connection('oracle')->select("SELECT table_name FROM user_tables ORDER BY table_name");
    foreach ($tables as $t) {
        echo "Table: " . $t->table_name . "\n";
    }
} catch (\Throwable $e) {
    echo "Oracle Error: " . $e->getMessage() . "\n";
}

// 2. AUDIT ORACLE PROCEDURES, FUNCTIONS, TRIGGERS
echo "\n--- 2. ORACLE PROCEDURES, FUNCTIONS & OBJECTS ---\n";
try {
    $objects = DB::connection('oracle')->select("SELECT object_name, object_type, status FROM user_objects WHERE object_type IN ('PROCEDURE', 'FUNCTION', 'TRIGGER', 'PACKAGE') ORDER BY object_type, object_name");
    if (empty($objects)) {
        echo "No PL/SQL procedures, functions, or triggers found in Oracle user_objects!\n";
    } else {
        foreach ($objects as $obj) {
            echo "[{$obj->object_type}] {$obj->object_name} (Status: {$obj->status})\n";
        }
    }
} catch (\Throwable $e) {
    echo "Oracle Objects Error: " . $e->getMessage() . "\n";
}

// 3. AUDIT ORACLE TRIGGERS DETAILS
echo "\n--- 3. ORACLE TRIGGERS DETAILS ---\n";
try {
    $triggers = DB::connection('oracle')->select("SELECT trigger_name, table_name, triggering_event, status FROM user_triggers ORDER BY trigger_name");
    if (empty($triggers)) {
        echo "No PL/SQL triggers found!\n";
    } else {
        foreach ($triggers as $trg) {
            echo "Trigger: {$trg->trigger_name} on {$trg->table_name} ({$trg->triggering_event}) - Status: {$trg->status}\n";
        }
    }
} catch (\Throwable $e) {
    echo "Triggers Error: " . $e->getMessage() . "\n";
}

// 4. AUDIT PL/SQL SOURCE CODE FOR CURSORS
echo "\n--- 4. ORACLE PL/SQL SOURCE (CURSOR AUDIT) ---\n";
try {
    $cursors = DB::connection('oracle')->select("SELECT name, type, text FROM user_source WHERE LOWER(text) LIKE '%cursor%' OR LOWER(text) LIKE '%for % in %' ORDER BY name, line");
    if (empty($cursors)) {
        echo "No PL/SQL CURSOR declarations found in user_source!\n";
    } else {
        foreach ($cursors as $c) {
            echo "[{$c->type} {$c->name}] " . trim($c->text) . "\n";
        }
    }
} catch (\Throwable $e) {
    echo "Source Error: " . $e->getMessage() . "\n";
}

// 5. AUDIT MONGODB VALIDATORS & INDEXES
echo "\n--- 5. MONGODB VALIDATION & INDEXES ---\n";
try {
    $mongoUri = config('database.connections.mongodb.dsn') ?? 'mongodb://127.0.0.1:27017';
    $mongoClient = new MongoClient("mongodb://127.0.0.1:27017");
    $mongoDb = $mongoClient->selectDatabase('agri_scout');

    $collections = $mongoDb->listCollections();
    foreach ($collections as $colInfo) {
        $name = $colInfo->getName();
        $options = $colInfo->getOptions();
        echo "Collection: {$name}\n";
        
        // Validator check
        if (isset($options['validator'])) {
            echo "  - Validator: PRESENT (" . json_encode($options['validator']) . ")\n";
        } else {
            echo "  - Validator: MISSING (No schema validation attached)\n";
        }

        // Indexes check
        $col = $mongoDb->selectCollection($name);
        $indexes = iterator_to_array($col->listIndexes());
        echo "  - Indexes:\n";
        foreach ($indexes as $idx) {
            echo "    * " . $idx->getName() . " : " . json_encode($idx->getKey()) . "\n";
        }
        echo "\n";
    }
} catch (\Throwable $e) {
    echo "MongoDB Error: " . $e->getMessage() . "\n";
}
