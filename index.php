<?php
session_start();
include 'function/helper.php';
if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}
if(is_user()){

    $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
    if (file_exists("student/{$page}.php")) {
        render_default_template("student/{$page}.php");
    } 
    exit();
} elseif (is_admin()) {
    $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
    if (file_exists("admin/{$page}.php")) {
        render_default_template("admin/{$page}.php");
    }
    exit();
}
