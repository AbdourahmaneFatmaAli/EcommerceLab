<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function is_logged_in()
{
    return isset($_SESSION['customer_id']);
}

function is_admin()
{
    return isset($_SESSION['user_role'])
        && (int) $_SESSION['user_role'] === 1;
}

function require_login()
{
    if (!is_logged_in()) {
        header("Location: ../views/login.php");
        exit;
    }
}

function require_admin()
{
    if (!is_admin()) {
        $_SESSION['error'] = "You do not have permission to access this page.";
        header("Location: ../index.php");
        exit;
    }
}
