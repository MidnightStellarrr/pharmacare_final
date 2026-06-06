<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Add optimization indexes for query performance.
     */
    public function up(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            // Only add indexes if they don't already exist
            if (!$this->indexExists('medicines', 'medicines_brand_index')) {
                $table->index('brand');
            }
            if (!$this->indexExists('medicines', 'medicines_category_index')) {
                $table->index('category');
            }
            if (!$this->indexExists('medicines', 'medicines_stock_index')) {
                $table->index('stock');
            }
            if (!$this->indexExists('medicines', 'medicines_expiry_date_index')) {
                $table->index('expiry_date');
            }
            if (!$this->indexExists('medicines', 'medicines_reorder_level_index')) {
                $table->index('reorder_level');
            }
        });

        // Composite indexes via raw SQL to ensure they're created
        if (!$this->indexExists('medicines', 'medicines_category_stock_index')) {
            DB::statement('ALTER TABLE medicines ADD INDEX medicines_category_stock_index (category, stock)');
        }

        Schema::table('users', function (Blueprint $table) {
            if (!$this->indexExists('users', 'users_user_type_index')) {
                $table->index('user_type');
            }
        });

        Schema::table('carts', function (Blueprint $table) {
            if (!$this->indexExists('carts', 'carts_user_id_updated_at_index')) {
                $table->index(['user_id', 'updated_at']);
            }
            if (Schema::hasColumn('carts', 'session_id') && !$this->indexExists('carts', 'carts_session_id_index')) {
                $table->index('session_id');
            }
        });

        Schema::table('cart_items', function (Blueprint $table) {
            if (!$this->indexExists('cart_items', 'cart_items_cart_id_medicine_id_index')) {
                $table->index(['cart_id', 'medicine_id']);
            }
        });
    }

    /**
     * Drop optimization indexes.
     */
    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            if ($this->indexExists('medicines', 'medicines_brand_index')) {
                $table->dropIndex(['brand']);
            }
            if ($this->indexExists('medicines', 'medicines_category_index')) {
                $table->dropIndex(['category']);
            }
            if ($this->indexExists('medicines', 'medicines_stock_index')) {
                $table->dropIndex(['stock']);
            }
            if ($this->indexExists('medicines', 'medicines_expiry_date_index')) {
                $table->dropIndex(['expiry_date']);
            }
            if ($this->indexExists('medicines', 'medicines_reorder_level_index')) {
                $table->dropIndex(['reorder_level']);
            }
            if ($this->indexExists('medicines', 'medicines_category_stock_index')) {
                DB::statement('ALTER TABLE medicines DROP INDEX medicines_category_stock_index');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if ($this->indexExists('users', 'users_user_type_index')) {
                $table->dropIndex(['user_type']);
            }
        });

        Schema::table('carts', function (Blueprint $table) {
            if ($this->indexExists('carts', 'carts_user_id_updated_at_index')) {
                $table->dropIndex(['user_id', 'updated_at']);
            }
            if ($this->indexExists('carts', 'carts_session_id_index')) {
                $table->dropIndex(['session_id']);
            }
        });

        Schema::table('cart_items', function (Blueprint $table) {
            if ($this->indexExists('cart_items', 'cart_items_cart_id_medicine_id_index')) {
                $table->dropIndex(['cart_id', 'medicine_id']);
            }
        });
    }

    /**
     * Check if an index exists on a table.
     */
    private function indexExists($table, $index): bool
    {
        $result = DB::select("
            SELECT 1 FROM INFORMATION_SCHEMA.STATISTICS 
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND INDEX_NAME = ?
        ", [env('DB_DATABASE'), $table, $index]);

        return !empty($result);
    }
};
