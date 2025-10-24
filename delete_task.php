<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $task_id = intval($_GET['id']); 

    $sql = "DELETE FROM tasks WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $task_id, $user_id);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php?message=Task+Deleted+Successfully");
        exit();
    } else {
        echo "<p style='color: red;'>Error deleting task.</p>";
    }
} else {
    header("Location: dashboard.php");
    exit();
}
?>
