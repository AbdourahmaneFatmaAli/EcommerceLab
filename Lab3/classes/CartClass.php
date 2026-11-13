
<?php

require_once __DIR__ . "/../core/db_class.php";

class CartClass extends Database
{
    // Check whether a product is already in the cart.
    public function isInCart($product_id, $ip)
    {
        $sql = "SELECT p_id FROM cart
                WHERE p_id = ? AND ip_add = ?
                LIMIT 1";

        $result = $this->fetchOne($sql, [$product_id, $ip]);

        return $result !== false && $result !== null;
    }

    // Add a product to the cart.
    public function addToCart($product_id, $qty, $ip, $customer_id = null)
    {
        if ((int)$product_id <= 0 || (int)$qty <= 0 || empty($ip)) {
            return false;
        }

        $sql = "INSERT INTO cart (p_id, ip_add, qty)
                VALUES (?, ?, ?)";

        return $this->execute($sql, [
            (int)$product_id,
            $ip,
            (int)$qty
        ]);
    }

    // Retrieve cart items and product details.
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

    // Count cart rows.
    public function getCartCount($ip)
    {
        $sql = "SELECT COUNT(*) AS total_items
                FROM cart
                WHERE ip_add = ?";

        $result = $this->fetchOne($sql, [$ip]);

        return (int)($result['total_items'] ?? 0);
    }

    // Calculate cart total.
    public function getCartTotal($ip)
    {
        $items = $this->getCartItems($ip);
        $total = 0;

        foreach ($items as $item) {
            $total += (int)$item['qty'] * (float)$item['product_price'];
        }

        return (float)$total;
    }

    // Remove a product from the cart.
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

    // Update product quantity.
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

    // Process a payment that has already been verified by Paystack.
    public function processPayment($customer_id, $ip, $reference, $amount)
    {
        $conn = $this->getConnection();

        try {
            $conn->beginTransaction();

            // Validate required information.
            if (
                (int)$customer_id <= 0 ||
                empty($ip) ||
                empty($reference) ||
                (int)$amount <= 0
            ) {
                throw new Exception("Invalid payment information.");
            }

            // Prevent duplicate payment processing.
            $check = $conn->prepare(
                "SELECT order_id
                 FROM orders
                 WHERE paystack_reference = ?
                 LIMIT 1"
            );

            $check->execute([$reference]);

            if ($check->fetch(PDO::FETCH_ASSOC)) {
                throw new Exception("This payment has already been processed.");
            }

            // Get cart items.
            $items = $this->getCartItems($ip);

            if (empty($items)) {
                throw new Exception("Your cart is empty.");
            }

            // Calculate the actual cart total.
            $total = 0;

            foreach ($items as $item) {
                $total += (int)$item['qty'] * (float)$item['product_price'];
            }

            // Compare cart total with verified Paystack amount.
            $expectedAmount = (int)round($total * 100);

            if ($expectedAmount !== (int)$amount) {
                throw new Exception("Payment amount does not match the cart.");
            }

            // Generate invoice number.
            $invoice_no = mt_rand(100000, 999999);

            // Create the order.
            $sql = "INSERT INTO orders
                    (customer_id, invoice_no, order_date,
                     order_status, paystack_reference)
                    VALUES (?, ?, CURDATE(), 'paid', ?)";

            $stmt = $conn->prepare($sql);

            $stmt->execute([
                (int)$customer_id,
                $invoice_no,
                $reference
            ]);

            $order_id = $conn->lastInsertId();

            // Save purchased products.
            $sql = "INSERT INTO orderdetails
                    (order_id, product_id, qty)
                    VALUES (?, ?, ?)";

            $stmt = $conn->prepare($sql);

            foreach ($items as $item) {
                $stmt->execute([
                    $order_id,
                    $item['p_id'],
                    $item['qty']
                ]);
            }

            // Clear the cart after saving the order.
            $stmt = $conn->prepare(
                "DELETE FROM cart WHERE ip_add = ?"
            );

            $stmt->execute([$ip]);

            $conn->commit();

            return $order_id;

        } catch (Exception $e) {
            if ($conn->inTransaction()) {
                $conn->rollBack();
            }

            throw $e;
        }
    }
    // Retrieve all orders belonging to one customer.
// Retrieve all orders belonging to one customer.
public function getCustomerOrders($customer_id)
{
    $sql = "SELECT
                orders.order_id,
                orders.invoice_no,
                orders.order_date,
                orders.order_status,
                orderdetails.product_id,
                orderdetails.qty,
                products.product_title,
                products.product_price
            FROM orders
            INNER JOIN orderdetails
                ON orders.order_id = orderdetails.order_id
            INNER JOIN products
                ON orderdetails.product_id = products.product_id
            WHERE orders.customer_id = ?
            ORDER BY orders.order_id DESC";

    return $this->fetchAll($sql, [(int)$customer_id]);
}
    // Retrieve an order and its products for the invoice.
   
    public function getOrderById($order_id)
    {
        $sql = "SELECT
                    orders.order_id,
                    orders.customer_id,
                    orders.invoice_no,
                    orders.order_date,
                    orders.order_status,
                    orderdetails.product_id,
                    orderdetails.qty,
                    products.product_title,
                    products.product_price
                FROM orders
                INNER JOIN orderdetails
                    ON orders.order_id = orderdetails.order_id
                INNER JOIN products
                    ON orderdetails.product_id = products.product_id
                WHERE orders.order_id = ?";

        return $this->fetchAll($sql, [(int)$order_id]);
    }
}
