<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Create stored procedures for database operations.
     */
    public function up(): void
    {
        // Procedure 1: Add item to cart safely
        DB::unprepared("
            CREATE PROCEDURE IF NOT EXISTS sp_add_to_cart(
                IN p_cart_id BIGINT,
                IN p_medicine_id BIGINT,
                IN p_quantity INT,
                OUT p_success BOOLEAN,
                OUT p_message VARCHAR(255)
            )
            proc_label: BEGIN
                DECLARE v_available_stock INT;
                DECLARE v_current_price DECIMAL(8,2);
                DECLARE v_existing_quantity INT DEFAULT 0;
                DECLARE v_new_quantity INT;
                
                -- Check medicine exists and get stock
                SELECT stock, price INTO v_available_stock, v_current_price
                FROM medicines
                WHERE id = p_medicine_id;
                
                -- If medicine not found
                IF v_available_stock IS NULL THEN
                    SET p_success = FALSE;
                    SET p_message = 'Medicine not found';
                    LEAVE proc_label;
                END IF;
                
                -- Check if enough stock
                IF v_available_stock < p_quantity THEN
                    SET p_success = FALSE;
                    SET p_message = CONCAT('Only ', v_available_stock, ' units available');
                    LEAVE proc_label;
                END IF;
                
                -- Check if item already in cart
                SELECT quantity INTO v_existing_quantity
                FROM cart_items
                WHERE cart_id = p_cart_id AND medicine_id = p_medicine_id;
                
                -- If exists, update quantity
                IF v_existing_quantity > 0 THEN
                    SET v_new_quantity = v_existing_quantity + p_quantity;
                    IF v_new_quantity > v_available_stock THEN
                        SET p_success = FALSE;
                        SET p_message = 'Cannot add - total would exceed available stock';
                        LEAVE proc_label;
                    END IF;
                    UPDATE cart_items
                    SET quantity = v_new_quantity
                    WHERE cart_id = p_cart_id AND medicine_id = p_medicine_id;
                ELSE
                    -- Insert new cart item
                    INSERT INTO cart_items (cart_id, medicine_id, quantity, price, created_at, updated_at)
                    VALUES (p_cart_id, p_medicine_id, p_quantity, v_current_price, NOW(), NOW());
                END IF;
                
                SET p_success = TRUE;
                SET p_message = 'Item added to cart successfully';
            END
        ");

        // Procedure 2: Get medicine details with stock status
        DB::unprepared("
            CREATE PROCEDURE IF NOT EXISTS sp_get_medicine_details(
                IN p_medicine_id BIGINT
            )
            BEGIN
                SELECT 
                    id,
                    name,
                    brand,
                    stock,
                    reorder_level,
                    price,
                    expiry_date,
                    category,
                    description,
                    supplier,
                    image,
                    CASE 
                        WHEN stock = 0 THEN 'OUT_OF_STOCK'
                        WHEN stock <= reorder_level THEN 'LOW_STOCK'
                        ELSE 'IN_STOCK'
                    END as stock_status,
                    DATEDIFF(expiry_date, CURDATE()) as days_to_expiry,
                    CASE 
                        WHEN DATEDIFF(expiry_date, CURDATE()) <= 0 THEN 'EXPIRED'
                        WHEN DATEDIFF(expiry_date, CURDATE()) <= 30 THEN 'NEAR_EXPIRY'
                        ELSE 'OK'
                    END as expiry_status,
                    created_at,
                    updated_at
                FROM medicines
                WHERE id = p_medicine_id;
            END
        ");

        // Procedure 3: Get inventory statistics
        DB::unprepared("
            CREATE PROCEDURE IF NOT EXISTS sp_get_inventory_stats()
            BEGIN
                SELECT 
                    COUNT(*) as total_medicines,
                    SUM(stock) as total_units,
                    ROUND(SUM(stock * price), 2) as total_value,
                    COUNT(CASE WHEN stock = 0 THEN 1 END) as out_of_stock,
                    COUNT(CASE WHEN stock <= reorder_level THEN 1 END) as low_stock,
                    COUNT(CASE WHEN DATEDIFF(expiry_date, CURDATE()) <= 30 AND DATEDIFF(expiry_date, CURDATE()) > 0 THEN 1 END) as near_expiry,
                    COUNT(CASE WHEN DATEDIFF(expiry_date, CURDATE()) <= 0 THEN 1 END) as expired
                FROM medicines;
            END
        ");

        // Procedure 4: Reduce medicine stock when order is placed
        DB::unprepared("
            CREATE PROCEDURE IF NOT EXISTS sp_reduce_stock(
                IN p_medicine_id BIGINT,
                IN p_quantity INT,
                OUT p_success BOOLEAN,
                OUT p_message VARCHAR(255)
            )
            proc_label: BEGIN
                DECLARE v_current_stock INT;
                
                -- Get current stock
                SELECT stock INTO v_current_stock
                FROM medicines
                WHERE id = p_medicine_id
                FOR UPDATE;
                
                -- Check if stock is available
                IF v_current_stock IS NULL THEN
                    SET p_success = FALSE;
                    SET p_message = 'Medicine not found';
                    LEAVE proc_label;
                END IF;
                
                IF v_current_stock < p_quantity THEN
                    SET p_success = FALSE;
                    SET p_message = 'Insufficient stock';
                    LEAVE proc_label;
                END IF;
                
                -- Reduce stock
                UPDATE medicines
                SET stock = stock - p_quantity,
                    updated_at = NOW()
                WHERE id = p_medicine_id;
                
                SET p_success = TRUE;
                SET p_message = 'Stock reduced successfully';
            END
        ");

        // Procedure 5: Search medicines by name, brand, or category
        DB::unprepared("
            CREATE PROCEDURE IF NOT EXISTS sp_search_medicines(
                IN p_search_term VARCHAR(255)
            )
            BEGIN
                SELECT 
                    id,
                    name,
                    brand,
                    stock,
                    price,
                    category,
                    image,
                    CASE 
                        WHEN stock = 0 THEN 'OUT_OF_STOCK'
                        WHEN stock <= reorder_level THEN 'LOW_STOCK'
                        ELSE 'IN_STOCK'
                    END as stock_status
                FROM medicines
                WHERE 
                    name LIKE CONCAT('%', p_search_term, '%') OR
                    brand LIKE CONCAT('%', p_search_term, '%') OR
                    category LIKE CONCAT('%', p_search_term, '%')
                ORDER BY name ASC;
            END
        ");
    }

    /**
     * Drop stored procedures.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_add_to_cart");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_get_medicine_details");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_get_inventory_stats");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_reduce_stock");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_search_medicines");
    }
};
