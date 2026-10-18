<?php

require_once __DIR__ . "/../core/db_class.php";

class CartClass extends Database
{
    // Check whether this product is already in the visitor's cart.
    public function isInCart($product_id, $ip)
    {
        $sql = "SELECT p_id
                FROM cart
                WHERE p_id = ? AND ip_add = ?
                LIMIT 1";

        $result = $this->fetchOne($sql, [$product_id, $ip]);

        return $result !== false && $result !== null;
    }

    // Add a product to the cart.
    public function addToCart($product_id, $qty, $ip, $customer_id = null)
    {
        if ((int) $product_id <= 0 || (int) $qty <= 0 || empty($ip)) {
            return false;
        }

        $sql = "INSERT INTO cart (p_id, ip_add, qty)
                VALUES (?, ?, ?)";

        return $this->execute($sql, [
            (int) $product_id,
            $ip,
            (int) $qty
        ]);
    }

    // Retrieve cart items and their product details.
    public function getCartItems($ip)
    {
        $sql = "SELECT cart.*,
                       products.product_title,
                       products.product_price,
                       products.product_image
                FROM cart
                INNER JOIN products
                    ON cart.p_id = products.product_id
                WHERE cart.ip_add = ?";

        $items = $this->fetchAll($sql, [$ip]);

        return is_array($items) ? $items : [];
    }

    // Count the number of cart rows.
    public function getCartCount($ip)
    {
        $sql = "SELECT COUNT(*) AS total_items
                FROM cart
                WHERE ip_add = ?";

        $result = $this->fetchOne($sql, [$ip]);

        return (int) ($result['total_items'] ?? 0);
    }

    // Calculate the total price of all quantities in the cart.
    public function getCartTotal($ip)
    {
        $items = $this->getCartItems($ip);
        $total = 0.0;

        foreach ($items as $item) {
            $qty = (int) ($item['qty'] ?? 0);
            $price = (float) ($item['product_price'] ?? 0);

            $total += $qty * $price;
        }

        return (float) $total;
    }

    // Remove a product from the visitor's cart.
    public function removeFromCart($product_id, $ip)
    {
        $product_id = filter_var($product_id, FILTER_VALIDATE_INT);

        if ($product_id === false || $product_id < 1 || empty($ip)) {
            return false;
        }

        $sql = "DELETE FROM cart
                WHERE p_id = ? AND ip_add = ?";

        return $this->execute($sql, [$product_id, $ip]);
    }

    // Update a product's quantity in the visitor's cart.
    public function updateQty($product_id, $new_qty, $ip)
    {
        $product_id = filter_var($product_id, FILTER_VALIDATE_INT);
        $new_qty = filter_var($new_qty, FILTER_VALIDATE_INT);

        if (
            $product_id === false || $product_id < 1 ||
            $new_qty === false || $new_qty < 1 ||
            empty($ip)
        ) {
            return false;
        }

        $sql = "UPDATE cart
                SET qty = ?
                WHERE p_id = ? AND ip_add = ?";

        return $this->execute($sql, [
            $new_qty,
            $product_id,
            $ip
        ]);
    }
}
