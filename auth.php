<?php
session_start();
require 'db.php';

function registerUser($name, $email, $password) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        return false; 
    }
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    return $stmt->execute([$name, $email, $hashedPassword]);
}

function loginUser($email, $password) {
    global $conn;

    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    $stmt->bind_result($id, $name, $hashedPassword);
    
    if ($stmt->fetch()) {
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;
            return true;
        }
    }

    return false;
}


function checkAuth() {
    return isset($_SESSION['user_id']);
}

function logoutUser() {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>