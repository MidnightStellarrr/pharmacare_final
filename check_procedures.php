<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Check if procedures were created
$sql = "SHOW PROCEDURE STATUS WHERE Db = ?";
try {
    $procedures = DB::select($sql, [env('DB_DATABASE')]);
    echo "Stored Procedures:\n";
    if (empty($procedures)) {
        echo "  (None found in SHOW PROCEDURE STATUS)\n\n";
        echo "Checking migration...\n";
        $migrationStatus = DB::select("SELECT * FROM migrations WHERE migration LIKE ?", ['%create_stored_procedures%']);
        echo "Migration Status:\n";
        foreach ($migrationStatus as $m) {
            echo "  Batch: {$m->batch}, Migration: {$m->migration}\n";
        }
    } else {
        foreach ($procedures as $p) {
            echo "  ✓ {$p->Name}\n";
        }
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
