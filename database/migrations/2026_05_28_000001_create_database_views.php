<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Create database views for reporting and optimization.
     */
    public function up(): void
    {
        // View 1: Low stock medicines
        DB::statement("
            CREATE OR REPLACE VIEW low_stock_medicines AS
            SELECT 
                id,
                name,
                brand,
                stock,
                reorder_level,
                CASE 
                    WHEN stock = 0 THEN 'OUT OF STOCK'
                    WHEN stock <= reorder_level THEN 'LOW STOCK'
                    ELSE 'IN STOCK'
                END as stock_status,
                price,
                supplier,
                created_at
            FROM medicines
            WHERE stock <= reorder_level
        ");

        // View 2: Near expiry medicines
        DB::statement("
            CREATE OR REPLACE VIEW near_expiry_medicines AS
            SELECT 
                id,
                name,
                brand,
                expiry_date,
                DATEDIFF(expiry_date, CURDATE()) as days_until_expiry,
                stock,
                price,
                CASE 
                    WHEN DATEDIFF(expiry_date, CURDATE()) <= 0 THEN 'EXPIRED'
                    WHEN DATEDIFF(expiry_date, CURDATE()) <= 30 THEN 'NEAR EXPIRY'
                    ELSE 'OK'
                END as expiry_status,
                created_at
            FROM medicines
            WHERE DATEDIFF(expiry_date, CURDATE()) <= 30
            ORDER BY expiry_date ASC
        ");

        // View 3: Cart summary with medicine details
        DB::statement("
            CREATE OR REPLACE VIEW cart_summary AS
            SELECT 
                ci.id as cart_item_id,
                c.id as cart_id,
                c.user_id,
                u.name as user_name,
                u.email,
                m.id as medicine_id,
                m.name as medicine_name,
                m.brand,
                ci.quantity,
                ci.price,
                (ci.quantity * ci.price) as item_total,
                c.created_at as cart_created_at,
                c.updated_at as cart_updated_at
            FROM cart_items ci
            INNER JOIN carts c ON ci.cart_id = c.id
            INNER JOIN medicines m ON ci.medicine_id = m.id
            INNER JOIN users u ON c.user_id = u.id
        ");

        // View 4: Inventory summary report
        DB::statement("
            CREATE OR REPLACE VIEW inventory_summary AS
            SELECT 
                COUNT(*) as total_medicines,
                SUM(stock) as total_units,
                SUM(stock * price) as total_value,
                ROUND(AVG(stock), 2) as avg_stock_per_medicine,
                MIN(price) as lowest_price,
                MAX(price) as highest_price,
                COUNT(CASE WHEN stock = 0 THEN 1 END) as out_of_stock_count,
                COUNT(CASE WHEN stock <= reorder_level THEN 1 END) as low_stock_count
            FROM medicines
        ");

        // View 5: Category-wise inventory
        DB::statement("
            CREATE OR REPLACE VIEW category_inventory AS
            SELECT 
                category,
                COUNT(*) as total_medicines,
                SUM(stock) as total_units,
                ROUND(SUM(stock * price), 2) as category_value,
                ROUND(AVG(price), 2) as avg_price,
                COUNT(CASE WHEN stock = 0 THEN 1 END) as out_of_stock,
                COUNT(CASE WHEN stock <= reorder_level THEN 1 END) as low_stock
            FROM medicines
            GROUP BY category
            ORDER BY category_value DESC
        ");
    }

    /**
     * Drop the views.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS low_stock_medicines");
        DB::statement("DROP VIEW IF EXISTS near_expiry_medicines");
        DB::statement("DROP VIEW IF EXISTS cart_summary");
        DB::statement("DROP VIEW IF EXISTS inventory_summary");
        DB::statement("DROP VIEW IF EXISTS category_inventory");
    }
};
