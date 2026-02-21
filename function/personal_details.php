<?php 
session_start();
require_once '../config/db.php';

// Initialize variables
$errors = [];

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // print_r($_POST);die;
    // Retrieve and sanitize form data
    $address = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING) ?? '');
    $phone = mysqli_real_escape_string($conn, filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_NUMBER_INT) ?? '');
    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING) ?? '';
    $dob = filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_STRING) ?? '';

    // Validate name
    if (empty($address)) {
        $errors[] = 'Address is required.';
    } elseif (strlen($name) < 2) {
        $errors[] = 'Address must be at least 2 characters long.';
    }
    $pattern = '/^\d{10}$/';
    // Validate email
    if (empty($phone)) {
        $errors[] = 'Phone number is required.';
    } elseif (!preg_match($pattern, $phone)) {
        $errors[] = 'Please enter a valid phone.';
    } else {
        $result = mysqli_query($conn, "SELECT phone FROM personal WHERE phone = '$phone'");
        if (mysqli_num_rows($result) > 0) {
            $errors[] = 'Phone is already registered.';
        }
    }

    // Validate password
    if (empty($gender)) {
        $errors[] = 'Gender is required.';
    } 

    if (empty($dob)) {
        $errors[] = 'Date of Birth is required.';
    } 


    // If no errors, hash password and insert into database
    if (empty($errors)) {
        $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session after login
         // Insert personal details into the database
        $query = "INSERT INTO personal (address, phone, gender, dob, user_id) VALUES ('$address', '$phone', '$gender', '$dob', '$user_id')";

        if (mysqli_query($conn, $query)) {
            header('Location: ../index.php?success=1');
            exit();
        }else {
            $errors[] = 'Failed to register: ' . mysqli_error($conn);
        }
       
    }

    $_SESSION['errors'] = $errors;
    header('Location: ../index.php?page=personal');
    exit();
    

}