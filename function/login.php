<?php 
session_start();
require_once '../config/db.php';

// Initialize variables
$errors = [];
$name = '';
$email = '';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // print_r($_POST);die;
    // Retrieve and sanitize form data
    $email = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '');
    $pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING) ?? '';

    
    // Validate email
    if (empty($email)) {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    } 

    // Validate password
    if (empty($pass)) {
        $errors[] = 'Password is required.';
    } elseif (strlen($pass) < 6) {
        $errors[] = 'Password must be at least 6 characters long.';
    }

    // If no errors, hash password and insert into database
    if (empty($errors)) {
        $query = "SELECT name,email,password,role,id FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($pass, $user['password'])) {
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                header('Location: ../index.php');
                exit();
            } else {
                $errors[] = 'Invalid password.';
            }
        } else {
            $errors[] = 'No user found with that email.Please register first.';
        }      
    }

    $_SESSION['errors'] = $errors;
    header('Location: ../login.php');
    exit();
    

}