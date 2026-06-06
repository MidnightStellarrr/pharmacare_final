<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Check stored procedures
$procedures = DB::select("SELECT ROUTINE_NAME FROM INFORMATION_SCHEMA.ROUTINES WHERE ROUTINE_SCHEMA = ? AND ROUTINE_TYPE = 'PROCEDURE'", [env('DB_DATABASE')]);
echo "=== STORED PROCEDURES ===\n";
foreach ($procedures as $p) {
    echo "✓ {$p->ROUTINE_NAME}\n";
}

// Check views
$views = DB::select("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'VIEW' AND TABLE_SCHEMA = ?", [env('DB_DATABASE')]);
echo "\n=== DATABASE VIEWS ===\n";
foreach ($views as $v) {
    echo "✓ {$v->TABLE_NAME}\n";
}

// Check triggers
$triggers = DB::select("SHOW TRIGGERS");
echo "\n=== TRIGGERS (" . count($triggers) . " total) ===\n";
foreach ($triggers as $t) {
    echo "✓ {$t->Trigger} ({$t->Timing} {$t->Event})\n";
}

// Check foreign keys
$fks = DB::select("SELECT CONSTRAINT_NAME, TABLE_NAME, COLUMN_NAME, REFERENCED_TABLE_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = ? AND REFERENCED_TABLE_NAME IS NOT NULL", [env('DB_DATABASE')]);
echo "\n=== FOREIGN KEY CONSTRAINTS ===\n";
foreach ($fks as $fk) {
    echo "✓ {$fk->TABLE_NAME}.{$fk->COLUMN_NAME} → {$fk->REFERENCED_TABLE_NAME}\n";
}

// Check indexes (excluding primary keys)
$indexes = DB::select("SELECT TABLE_NAME, INDEX_NAME, COLUMN_NAME FROM INFORMATION_SCHEMA.STATISTICS WHERE TABLE_SCHEMA = ? AND INDEX_NAME != 'PRIMARY' ORDER BY TABLE_NAME, INDEX_NAME", [env('DB_DATABASE')]);
echo "\n=== OPTIMIZATION INDEXES ===\n";
$currentTable = '';
$indexCount = 0;
foreach ($indexes as $idx) {
    if ($idx->TABLE_NAME !== $currentTable) {
        echo "\n{$idx->TABLE_NAME}:\n";
        $currentTable = $idx->TABLE_NAME;
    }
    echo "  ✓ {$idx->INDEX_NAME} ({$idx->COLUMN_NAME})\n";
    $indexCount++;
}

// Check migrations
$migrations = DB::select("SELECT migration FROM migrations WHERE migration LIKE '%2026_05_28%' ORDER BY migration");
echo "\n=== DATABASE FEATURE MIGRATIONS ===\n";
foreach ($migrations as $m) {
    echo "✓ {$m->migration}\n";
}

echo "\n=== SUMMARY ===\n";
echo "✓ Stored Procedures: " . count($procedures) . "\n";
echo "✓ Views: " . count($views) . "\n";
echo "✓ Triggers: " . count($triggers) . "\n";
echo "✓ Foreign Keys: " . count($fks) . "\n";
echo "✓ Indexes: " . $indexCount . "\n";
echo "✓ Feature Migrations: " . count($migrations) . "\n";
