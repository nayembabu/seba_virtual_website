<?php
require '/var/www/website/vendor/autoload.php';
$app = require_once '/var/www/website/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$val = get_settings()->min_d ?? 'NULL';
echo "min_d = " . $val . "\n";

// Also check what keys exist
$settings = \App\Models\Setting::where('name', 'min_d')->first();
if ($settings) {
    echo "DB row: name={$settings->name}, value={$settings->value}\n";
} else {
    echo "No min_d row found in DB\n";
    // List all settings
    $all = \App\Models\Setting::all();
    foreach ($all as $s) {
        echo "  {$s->name} => {$s->value}\n";
    }
}
