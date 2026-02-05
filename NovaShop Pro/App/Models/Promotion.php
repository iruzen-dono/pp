<?php
namespace App\Models;

use App\Core\Model;

class Promotion extends Model
{
    /**
     * Get all promotions
     */
    public function getAll()
    {
        return $this->run(
            "SELECT p.*, u.name as created_by_name, pr.name as product_name, c.name as category_name 
             FROM promotions p
             LEFT JOIN users u ON p.created_by = u.id
             LEFT JOIN products pr ON p.product_id = pr.id
             LEFT JOIN categories c ON p.category_id = c.id
             ORDER BY p.created_at DESC"
        );
    }

    /**
     * Get active promotions for a product
     */
    public function getActiveForProduct(int $productId)
    {
        return $this->run(
            "SELECT * FROM promotions 
             WHERE (product_id = ? OR category_id = (SELECT category_id FROM products WHERE id = ?))
             AND is_active = TRUE
             AND NOW() BETWEEN start_date AND end_date
             ORDER BY discount_value DESC LIMIT 1",
            [$productId, $productId],
            true
        );
    }

    /**
     * Get active promotions by category
     */
    public function getActiveByCategory(int $categoryId)
    {
        return $this->run(
            "SELECT * FROM promotions 
             WHERE category_id = ?
             AND is_active = TRUE
             AND NOW() BETWEEN start_date AND end_date",
            [$categoryId]
        );
    }

    /**
     * Create a new promotion
     */
    public function create(array $data)
    {
        return $this->run(
            "INSERT INTO promotions (name, description, discount_type, discount_value, product_id, category_id, is_active, start_date, end_date, created_by)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $data['name'] ?? '',
                $data['description'] ?? '',
                $data['discount_type'] ?? 'percentage',
                $data['discount_value'] ?? 0,
                $data['product_id'] ?? null,
                $data['category_id'] ?? null,
                $data['is_active'] ?? true,
                $data['start_date'] ?? date('Y-m-d H:i:s'),
                $data['end_date'] ?? date('Y-m-d H:i:s', strtotime('+30 days')),
                $data['created_by'] ?? $_SESSION['user']['id'] ?? 1
            ]
        );
    }

    /**
     * Update a promotion
     */
    public function update(int $id, array $data)
    {
        return $this->run(
            "UPDATE promotions 
             SET name = ?, description = ?, discount_type = ?, discount_value = ?, 
                 product_id = ?, category_id = ?, is_active = ?, start_date = ?, end_date = ?
             WHERE id = ?",
            [
                $data['name'] ?? '',
                $data['description'] ?? '',
                $data['discount_type'] ?? 'percentage',
                $data['discount_value'] ?? 0,
                $data['product_id'] ?? null,
                $data['category_id'] ?? null,
                $data['is_active'] ?? true,
                $data['start_date'] ?? date('Y-m-d H:i:s'),
                $data['end_date'] ?? date('Y-m-d H:i:s', strtotime('+30 days')),
                $id
            ]
        );
    }

    /**
     * Delete a promotion
     */
    public function delete(int $id)
    {
        return $this->run("DELETE FROM promotions WHERE id = ?", [$id]);
    }

    /**
     * Get promotion by ID
     */
    public function getById(int $id)
    {
        return $this->run(
            "SELECT * FROM promotions WHERE id = ? LIMIT 1",
            [$id],
            true
        );
    }

    /**
     * Calculate discounted price
     */
    public static function calculateDiscountedPrice(float $originalPrice, array $promotion): float
    {
        if (!$promotion) {
            return $originalPrice;
        }

        if ($promotion['discount_type'] === 'percentage') {
            $discount = ($originalPrice * $promotion['discount_value']) / 100;
        } else {
            $discount = $promotion['discount_value'];
        }

        $discountedPrice = $originalPrice - $discount;
        return max(0, $discountedPrice); // Ensure price doesn't go below 0
    }
}
?>
