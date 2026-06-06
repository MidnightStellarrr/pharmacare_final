<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Create database triggers for business logic enforcement.
     */
    public function up(): void
    {
        // Trigger 1: Prevent adding expired medicines to cart
        DB::unprepared("
            CREATE TRIGGER IF NOT EXISTS prevent_expired_medicine_cart
            BEFORE INSERT ON cart_items
            FOR EACH ROW
            BEGIN
                DECLARE v_expiry_date DATE;
                
                SELECT expiry_date INTO v_expiry_date
                FROM medicines
                WHERE id = NEW.medicine_id;
                
                IF v_expiry_date < CURDATE() THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Cannot add expired medicine to cart';
                END IF;
            END
        ");

        // Trigger 2: Update medicine stock when cart item is deleted
        DB::unprepared("
            CREATE TRIGGER IF NOT EXISTS update_stock_on_cart_delete
            AFTER DELETE ON cart_items
            FOR EACH ROW
            BEGIN
                -- Log this action (optional - can be extended to an audit table)
                UPDATE medicines
                SET updated_at = NOW()
                WHERE id = OLD.medicine_id;
            END
        ");

        // Trigger 3: Prevent out-of-stock medicines from being added to cart
        DB::unprepared("
            CREATE TRIGGER IF NOT EXISTS prevent_out_of_stock_cart
            BEFORE INSERT ON cart_items
            FOR EACH ROW
            BEGIN
                DECLARE v_stock INT;
                
                SELECT stock INTO v_stock
                FROM medicines
                WHERE id = NEW.medicine_id;
                
                IF v_stock <= 0 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Medicine is out of stock';
                END IF;
                
                IF v_stock < NEW.quantity THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Insufficient stock for requested quantity';
                END IF;
            END
        ");

        // Trigger 4: Validate price in cart items
        DB::unprepared("
            CREATE TRIGGER IF NOT EXISTS validate_cart_item_price
            BEFORE INSERT ON cart_items
            FOR EACH ROW
            BEGIN
                DECLARE v_actual_price DECIMAL(8,2);
                
                SELECT price INTO v_actual_price
                FROM medicines
                WHERE id = NEW.medicine_id;
                
                -- Auto-correct price to current medicine price if it differs
                IF v_actual_price > 0 THEN
                    SET NEW.price = v_actual_price;
                END IF;
            END
        ");

        // Trigger 5: Prevent medicine updates that would violate reorder level
        DB::unprepared("
            CREATE TRIGGER IF NOT EXISTS validate_reorder_level
            BEFORE UPDATE ON medicines
            FOR EACH ROW
            BEGIN
                -- Reorder level should not be greater than max reasonable stock
                IF NEW.reorder_level < 0 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Reorder level cannot be negative';
                END IF;
                
                -- Warn if reorder level is too high (set to max 1000)
                IF NEW.reorder_level > 1000 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Reorder level too high (max 1000)';
                END IF;
            END
        ");

        // Trigger 6: Prevent adding medicines with invalid expiry date
        DB::unprepared("
            CREATE TRIGGER IF NOT EXISTS validate_medicine_expiry
            BEFORE INSERT ON medicines
            FOR EACH ROW
            BEGIN
                IF NEW.expiry_date <= CURDATE() THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Cannot add medicine with expiry date in the past';
                END IF;
            END
        ");

        // Trigger 7: Update medicine timestamp on stock change
        DB::unprepared("
            CREATE TRIGGER IF NOT EXISTS update_medicine_on_stock_change
            BEFORE UPDATE ON medicines
            FOR EACH ROW
            BEGIN
                IF NEW.stock != OLD.stock THEN
                    SET NEW.updated_at = NOW();
                END IF;
            END
        ");

        // Trigger 8: Prevent negative prices
        DB::unprepared("
            CREATE TRIGGER IF NOT EXISTS validate_medicine_price
            BEFORE INSERT ON medicines
            FOR EACH ROW
            BEGIN
                IF NEW.price < 0 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Medicine price cannot be negative';
                END IF;
                
                IF NEW.price = 0 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Medicine price must be greater than 0';
                END IF;
            END
        ");

        // Trigger 9: Prevent invalid stock values
        DB::unprepared("
            CREATE TRIGGER IF NOT EXISTS validate_medicine_stock
            BEFORE INSERT ON medicines
            FOR EACH ROW
            BEGIN
                IF NEW.stock < 0 THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Stock quantity cannot be negative';
                END IF;
            END
        ");
    }

    /**
     * Drop triggers.
     */
    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS prevent_expired_medicine_cart");
        DB::unprepared("DROP TRIGGER IF EXISTS update_stock_on_cart_delete");
        DB::unprepared("DROP TRIGGER IF EXISTS prevent_out_of_stock_cart");
        DB::unprepared("DROP TRIGGER IF EXISTS validate_cart_item_price");
        DB::unprepared("DROP TRIGGER IF EXISTS validate_reorder_level");
        DB::unprepared("DROP TRIGGER IF EXISTS validate_medicine_expiry");
        DB::unprepared("DROP TRIGGER IF EXISTS update_medicine_on_stock_change");
        DB::unprepared("DROP TRIGGER IF EXISTS validate_medicine_price");
        DB::unprepared("DROP TRIGGER IF EXISTS validate_medicine_stock");
    }
};
