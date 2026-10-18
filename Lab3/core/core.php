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
        header("Location: /~fatma.abdourahmane/Ecommerce-class/Lab3/views/login.php");
        exit;
    }
}

function require_admin()
{
    if (!is_admin()) {
        $_SESSION['error'] = "You do not have permission to access this page.";
        header("Location: /~fatma.abdourahmane/Ecommerce-class/Lab3/index.php");
        exit;
    }
}

function get_ip()
{
    if (!empty($_SERVER['REMOTE_ADDR'])) {
        return $_SERVER['REMOTE_ADDR'];
    }

    return '0.0.0.0';
}
