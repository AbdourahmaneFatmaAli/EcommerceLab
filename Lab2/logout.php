<?php
// Destroys the session and sends the browser back to the homepage.
// Linked from index.php's nav when a customer is logged in.
require_once "core/core.php";

// Clear every value stored in the session...
$_SESSION = [];

// ...then destroy the session itself.
session_destroy();

header("Location: index.php");
exit;
