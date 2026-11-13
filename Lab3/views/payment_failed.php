
<?php

require_once __DIR__ . "/../core/core.php";

$message = $_SESSION['payment_error'] ?? 
    "Your payment could not be completed.";

unset($_SESSION['payment_error']);

require_once __DIR__ . "/layout/header.php";
?>

<style>
.failed-container {
    max-width: 600px;
    margin: 60px auto;
    padding: 35px;
    text-align: center;
    background: #fff;
    border: 1px solid #f0d5e2;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(100, 50, 75, 0.08);
    box-sizing: border-box;
}

.failed-container h1 {
    color: #b42335;
    margin-bottom: 15px;
}

.failed-container p {
    color: #542b42;
    line-height: 1.6;
}

.failed-button {
    display: inline-block;
    margin-top: 20px;
    padding: 12px 22px;
    background: #d63384;
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
}

.failed-button:hover {
    background: #a61e62;
    color: white;
}

@media(max-width: 600px) {
    .failed-container {
        margin: 25px 12px;
        padding: 22px;
    }
}
</style>

<div class="failed-container">

    <h1>Payment Unsuccessful</h1>

    <p>
        <?php
        echo htmlspecialchars(
            $message,
            ENT_QUOTES,
            'UTF-8'
        );
        ?>
    </p>

    <p>
        You can return to your cart and try again.
    </p>

    <a href="cart.php" class="failed-button">
        Return to Cart
    </a>

</div>

<?php require_once __DIR__ . "/layout/footer.php"; ?>
