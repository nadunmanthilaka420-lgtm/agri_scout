<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$db = DB::connection('mongodb')->getMongoDB();
$cols = $db->listCollections();
foreach ($cols as $col) {
    echo "=== COLLECTION: " . $col->getName() . " ===\n";
    $options = $col->getOptions();
    echo json_encode($options, JSON_PRETTY_PRINT) . "\n\n";
}
