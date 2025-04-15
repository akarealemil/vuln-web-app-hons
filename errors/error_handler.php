<?php
function file_exists_and_accessible($file) {
    return file_exists($file) && is_readable($file);
}

function check_page_permission($page) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    $restricted_pages = [
        'loggedin.php',
        'admin.php',
    ];
    
    $admin_only_pages = [
        'admin.php',
        'createNewUser.php',
        'logs.php',
        'directories.php',
    ];
    
    if (in_array($page, $restricted_pages) && !isset($_SESSION['user_id'])) {
        return false;
    }
    
    if (in_array($page, $admin_only_pages) && 
        (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin')) {
        return false;
    }
    
    return true;
}

function handle_page_request($requested_page) {    
    $page = trim($requested_page, '/');
    
    if (empty($page)) {
        $page = 'index.php';
    }
    
    $file_path = $page;
    
    if (!file_exists_and_accessible($file_path)) {
        include_once('/errors/404.php');
        exit();
    }
    
    // Check if the user has permission to access the page
    if (!check_page_permission($page)) {
        include_once('/errors/403.php');
        exit();
    }
    
    // Page exists and user has permission, include the file
    include_once($file_path);
    exit();
}