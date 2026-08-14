<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class OracleService
{
    /**
     * Call Oracle CREATE_ORDER stored procedure.
     */
    public function createOrder(int $customerId, int $farmId, string $cropName, float $quantity, float $unitPrice, string $unit = 'KG'): int
    {
        $pdo = DB::connection('oracle')->getPdo();

        $stmt = $pdo->prepare("
            BEGIN
                CREATE_ORDER(
                    :customer_id,
                    :farm_id,
                    :crop_name,
                    :quantity,
                    :unit_price,
                    :unit,
                    :order_id
                );
            END;
        ");

        $orderId = 0;
        $stmt->bindParam(':customer_id', $customerId, \PDO::PARAM_INT);
        $stmt->bindParam(':farm_id', $farmId, \PDO::PARAM_INT);
        $stmt->bindParam(':crop_name', $cropName, \PDO::PARAM_STR);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':unit_price', $unitPrice);
        $stmt->bindParam(':unit', $unit, \PDO::PARAM_STR);
        $stmt->bindParam(':order_id', $orderId, \PDO::PARAM_INT | \PDO::PARAM_INPUT_OUTPUT, 32);

        $stmt->execute();

        return (int) $orderId;
    }

    /**
     * Call Oracle COMPLETE_ORDER stored procedure.
     */
    public function completeOrder(int $orderId): bool
    {
        return DB::connection('oracle')->statement("
            BEGIN
                COMPLETE_ORDER(:order_id);
            END;
        ", ['order_id' => $orderId]);
    }

    /**
     * Call Oracle CANCEL_ORDER stored procedure.
     */
    public function cancelOrder(int $orderId): bool
    {
        return DB::connection('oracle')->statement("
            BEGIN
                CANCEL_ORDER(:order_id);
            END;
        ", ['order_id' => $orderId]);
    }

    /**
     * Call Oracle CALCULATE_ORDER_TOTAL stored function.
     */
    public function calculateOrderTotal(float $quantity, float $unitPrice): float
    {
        $result = DB::connection('oracle')->selectOne("
            SELECT CALCULATE_ORDER_TOTAL(:quantity, :unit_price) AS TOTAL
            FROM DUAL
        ", [
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
        ]);

        return (float) ($result->total ?? $result->TOTAL ?? ($quantity * $unitPrice));
    }

    /**
     * Call Oracle GET_FARM_COUNT stored function.
     */
    public function getFarmCount(int $farmerId): int
    {
        $result = DB::connection('oracle')->selectOne("
            SELECT GET_FARM_COUNT(:farmer_id) AS FARM_COUNT
            FROM DUAL
        ", ['farmer_id' => $farmerId]);

        return (int) ($result->farm_count ?? $result->FARM_COUNT ?? 0);
    }

    /**
     * Call Oracle GET_CUSTOMER_ORDER_COUNT stored function.
     */
    public function getCustomerOrderCount(int $customerId, ?string $status = null): int
    {
        $result = DB::connection('oracle')->selectOne("
            SELECT GET_CUSTOMER_ORDER_COUNT(:customer_id, :status) AS ORDER_COUNT
            FROM DUAL
        ", [
            'customer_id' => $customerId,
            'status' => $status,
        ]);

        return (int) ($result->order_count ?? $result->ORDER_COUNT ?? 0);
    }

    /**
     * Call Oracle GENERATE_ORDER_REPORT stored procedure (Cursor demonstration).
     */
    public function generateOrderReport(?string $status = null): int
    {
        $pdo = DB::connection('oracle')->getPdo();

        $stmt = $pdo->prepare("
            BEGIN
                GENERATE_ORDER_REPORT(:status, :record_count);
            END;
        ");

        $recordCount = 0;
        $stmt->bindParam(':status', $status, \PDO::PARAM_STR);
        $stmt->bindParam(':record_count', $recordCount, \PDO::PARAM_INT | \PDO::PARAM_INPUT_OUTPUT, 32);

        $stmt->execute();

        return (int) $recordCount;
    }
}
