// database/migrations/xxxx_xx_xx_xxxxxx_create_medicines_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand')->nullable();
            $table->integer('stock')->default(0);
            $table->decimal('price', 8, 2);
            $table->date('expiry_date');
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->string('supplier')->nullable();
            $table->integer('reorder_level')->default(10);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};