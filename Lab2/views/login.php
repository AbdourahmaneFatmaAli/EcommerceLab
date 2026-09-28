<?php

require_once "../core/core.php";

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log In</title>

    <link rel="stylesheet" href="/ecomlab/css/style.css">
</head>

<body>

<?php require_once __DIR__ . "/layout/header.php"; ?>

<main>

    <h1>Log In</h1>

    <?php
    if (!empty($_SESSION['error'])) {
        echo '<p class="error-message">'
            . htmlspecialchars($_SESSION['error'])
            . '</p>';

        unset($_SESSION['error']);
    }
    ?>

    <form action="../actions/login_action.php" method="POST">

        <div>
            <label for="customer_email">Email</label>
            <input
                type="email"
                name="customer_email"
                id="customer_email"
                required
            >
        </div>

        <div>
            <label for="customer_pass">Password</label>
            <input
                type="password"
                name="customer_pass"
                id="customer_pass"
                required
            >
        </div>

        <div>
            <button type="submit">Log In</button>
        </div>

    </form>

    <p>
        Don't have an account?
        <a href="register.php">Register here</a>.
    </p>

</main>

<?php require_once __DIR__ . "/layout/footer.php"; ?>

</body>
</html>