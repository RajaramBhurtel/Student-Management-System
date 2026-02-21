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
    $name = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING) ?? '');
    $email = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '');
    $pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING) ?? '';
    $c_pass = filter_input(INPUT_POST, 'c_password', FILTER_SANITIZE_STRING) ?? '';
    $agree_terms = isset($_POST['agree']) ? 1 : 0;

    // Validate name
    if (empty($name)) {
        $errors[] = 'Full Name is required.';
    } elseif (strlen($name) < 2) {
        $errors[] = 'Name must be at least 2 characters long.';
    }

    // Validate email
    if (empty($email)) {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    } else {
        // Check if email already exists
        $result = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
        if (mysqli_num_rows($result) > 0) {
            $errors[] = 'Email is already registered.';
        }
    }

    // Validate password
    if (empty($pass)) {
        $errors[] = 'Password is required.';
    } elseif (strlen($pass) < 6) {
        $errors[] = 'Password must be at least 6 characters long.';
    }

    // Validate confirm password
    if ($pass !== $c_pass) {
        $errors[] = 'Passwords do not match.';
    }

    // Validate terms agreement
    if (!$agree_terms) {
        $errors[] = 'You must agree to the terms.';
    }

    // If no errors, hash password and insert into database
    if (empty($errors)) {
        $pass = password_hash($pass, PASSWORD_BCRYPT);
        $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$pass')";

        if (mysqli_query($conn, $query)) {
            header('Location: ../login.php?success=1');
            exit();
        }else {
            $errors[] = 'Failed to register: ' . mysqli_error($conn);
        }
       
    }

    $_SESSION['errors'] = $errors;
    header('Location: ../signup.php');
    exit();
    

}