<?php
// The homepage / entry point of the app. This is now a .php file (it used
// to be plain .html) because it needs to call core/core.php to find out
// whether someone is logged in, so the nav can show the right links.
require_once "core/core.php";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ecom LAB</title>

    <link rel="stylesheet" href="/ecomlab/css/style.css">
</head>
<body>
	<h1>This is ecom lab started</h1>
	<nav>
		<?php if (is_logged_in()) { ?>
			<!-- Logged in: greet them by name and offer Logout instead of
			     Register/Login -->
			Welcome, <?php echo htmlspecialchars($_SESSION['customer_name']); ?> |
			<a href="logout.php">Logout</a>
		<?php } else { ?>
			<!-- Logged out: offer Register/Login -->
			<a href="views/register.php">Register</a> |
			<a href="views/login.php">Login</a>
		<?php } ?>
		| <a href="views/customers.php">View All Customers</a>
	</nav>
<?php require_once __DIR__ . "/views/layout/footer.php"; ?>