<?php
session_start();
include 'function/helper.php';
if(is_logged_in()) {
    header('Location: index.php');
    exit();
}
include 'templates/head.php';
?>
<div class="login-page">
<?php
include 'templates/login.php';
?>
</div>
// require_once 'config/db.php';
   
