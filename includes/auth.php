<?php
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ../dashboard/login.php');
        exit;
    }
}
?>