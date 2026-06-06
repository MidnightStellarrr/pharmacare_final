<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Show database features and statistics.
     */
    public function database()
    {
        $data = [];

        // Get inventory summary from VIEW
        try {
            $data['inventory_summary'] = DB::select("SELECT * FROM inventory_summary")[0] ?? null;
        } catch (\Exception $e) {
            $data['inventory_summary'] = null;
            $data['inventory_error'] = $e->getMessage();
        }

        // Get low stock medicines from VIEW
        try {
            $data['low_stock_medicines'] = DB::select("SELECT * FROM low_stock_medicines");
        } catch (\Exception $e) {
            $data['low_stock_medicines'] = [];
            $data['low_stock_error'] = $e->getMessage();
        }

        // Get near expiry medicines from VIEW
        try {
            $data['near_expiry_medicines'] = DB::select("SELECT * FROM near_expiry_medicines");
        } catch (\Exception $e) {
            $data['near_expiry_medicines'] = [];
            $data['near_expiry_error'] = $e->getMessage();
        }

        // Get category inventory from VIEW
        try {
            $data['category_inventory'] = DB::select("SELECT * FROM category_inventory");
        } catch (\Exception $e) {
            $data['category_inventory'] = [];
            $data['category_error'] = $e->getMessage();
        }

        // Call stored procedure for inventory stats
        try {
            $data['stored_proc_stats'] = DB::select("CALL sp_get_inventory_stats()")[0] ?? null;
        } catch (\Exception $e) {
            $data['stored_proc_stats'] = null;
            $data['proc_error'] = $e->getMessage();
        }

        // Get cart summary from VIEW
        try {
            $data['cart_summary'] = DB::select("SELECT * FROM cart_summary");
        } catch (\Exception $e) {
            $data['cart_summary'] = [];
            $data['cart_summary_error'] = $e->getMessage();
        }

        // Get all indexes
        try {
            $medicines_indexes = DB::select("SHOW INDEX FROM medicines");
            $users_indexes = DB::select("SHOW INDEX FROM users");
            $carts_indexes = DB::select("SHOW INDEX FROM carts");
            $cart_items_indexes = DB::select("SHOW INDEX FROM cart_items");
            
            $data['all_indexes'] = [
                'medicines' => $medicines_indexes,
                'users' => $users_indexes,
                'carts' => $carts_indexes,
                'cart_items' => $cart_items_indexes,
            ];
        } catch (\Exception $e) {
            $data['all_indexes'] = [];
            $data['indexes_error'] = $e->getMessage();
        }

        // Get all triggers
        try {
            $data['triggers'] = DB::select("SHOW TRIGGERS");
        } catch (\Exception $e) {
            $data['triggers'] = [];
            $data['triggers_error'] = $e->getMessage();
        }

        // Get all stored procedures
        try {
            $data['procedures'] = DB::select("SHOW PROCEDURE STATUS WHERE Db = ?", [env('DB_DATABASE')]);
        } catch (\Exception $e) {
            $data['procedures'] = [];
            $data['procedures_error'] = $e->getMessage();
        }

        // Get all views
        try {
            $data['views'] = DB::select("
                SELECT TABLE_NAME, TABLE_SCHEMA 
                FROM INFORMATION_SCHEMA.TABLES 
                WHERE TABLE_TYPE = 'VIEW' AND TABLE_SCHEMA = ?
            ", [env('DB_DATABASE')]);
        } catch (\Exception $e) {
            $data['views'] = [];
            $data['views_error'] = $e->getMessage();
        }

        // Database statistics
        try {
            $data['db_size'] = DB::select("
                SELECT 
                    ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) as size_mb
                FROM information_schema.tables 
                WHERE table_schema = ?
            ", [env('DB_DATABASE')])[0] ?? null;
        } catch (\Exception $e) {
            $data['db_size'] = null;
        }

        return view('reports.database', $data);
    }

    /**
     * Test stored procedures interactively.
     */
    public function testProcedures()
    {
        $data = [];

        // Test sp_search_medicines
        try {
            $data['search_results'] = DB::select("CALL sp_search_medicines(?)", ['medicine']);
        } catch (\Exception $e) {
            $data['search_error'] = $e->getMessage();
        }

        // Test sp_get_medicine_details for first medicine
        try {
            $medicines = DB::select("SELECT id FROM medicines LIMIT 1");
            if (!empty($medicines)) {
                $data['medicine_details'] = DB::select("CALL sp_get_medicine_details(?)", [$medicines[0]->id]);
            }
        } catch (\Exception $e) {
            $data['medicine_details_error'] = $e->getMessage();
        }

        return view('reports.procedures', $data);
    }

    /**
     * Show index performance statistics.
     */
    public function performance()
    {
        $data = [];

        // Check query execution using EXPLAIN
        try {
            // Example: Show execution plan for product search
            $data['explain_search'] = DB::select("EXPLAIN SELECT * FROM medicines WHERE name LIKE '%pain%' OR brand LIKE '%pain%'");
            
            $data['explain_stock'] = DB::select("EXPLAIN SELECT * FROM medicines WHERE stock <= reorder_level");
            
            $data['explain_category'] = DB::select("EXPLAIN SELECT * FROM medicines WHERE category = 'Pain Relief'");
            
            $data['explain_composite'] = DB::select("EXPLAIN SELECT * FROM medicines WHERE category = 'Vitamins' AND stock > 0");
        } catch (\Exception $e) {
            $data['explain_error'] = $e->getMessage();
        }

        // Table statistics
        try {
            $data['table_stats'] = DB::select("
                SELECT 
                    table_name,
                    ROUND(((data_length + index_length) / 1024 / 1024), 2) as size_mb,
                    table_rows,
                    auto_increment
                FROM information_schema.tables 
                WHERE table_schema = ?
                ORDER BY (data_length + index_length) DESC
            ", [env('DB_DATABASE')]);
        } catch (\Exception $e) {
            $data['stats_error'] = $e->getMessage();
        }

        return view('reports.performance', $data);
    }
}
