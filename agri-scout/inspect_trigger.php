<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$res = DB::select("SELECT trigger_name, trigger_body FROM all_triggers WHERE owner = 'C##AGRI'");
foreach ($res as $trig) {
    $trig = (array)$trig;
    echo "=== TRIGGER: {$trig['trigger_name']} ===\n";
    echo $trig['trigger_body'] . "\n\n";
}
