<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function is_authenticated() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function require_auth() {
    if (!is_authenticated()) {
        header("Location: /errors/403.php");
        exit();
    }
}

function require_admin() {
    require_auth();
    
    if (!is_admin()) {
        header("Location: /errors/403.php");
        exit();
    }
}