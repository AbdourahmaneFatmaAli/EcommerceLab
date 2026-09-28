<?php

// Start the session if it has not already been started.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Check if a customer is logged in.
function is_logged_in()
{
    return isset($_SESSION['customer_id']);
}


// Check if the logged-in customer is an admin.
// user_role 1 = admin.
function is_admin()
{
    return isset($_SESSION['user_role'])
        && (int) $_SESSION['user_role'] === 1;
}


// Protect pages that require a logged-in customer.
function require_login()
{
    if (!is_logged_in()) {
        header("Location: ../views/login.php");
        exit;
    }
}


// Protect pages that require an admin.
function require_admin()
{
    if (!is_admin()) {
        $_SESSION['error'] = "You do not have permission to access this page.";

        header("Location: ../index.php");
        exit;
    }
}