<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'student') {
    header('Location: ../auth/login.php');
    exit;
}
?>