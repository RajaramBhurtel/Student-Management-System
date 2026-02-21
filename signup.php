<?php
session_start();
include 'function/helper.php';
if(is_logged_in()) {
    header('Location: index.php');
    exit();
}
include 'templates/head.php';
?>
<div class="register-page">
<?php
include 'templates/register.php';
?>
</div>
// require_once 'config/db.php';
   
