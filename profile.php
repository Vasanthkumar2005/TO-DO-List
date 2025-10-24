<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT name, email FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result()->fetch_assoc();

$name = htmlspecialchars($user_result['name']);
$email = htmlspecialchars($user_result['email']);

$sql_tasks = "SELECT 
    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) AS completed_tasks,
    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS pending_tasks
    FROM tasks WHERE user_id = ?";
$stmt_tasks = $conn->prepare($sql_tasks);
$stmt_tasks->bind_param("i", $user_id);
$stmt_tasks->execute();
$task_summary = $stmt_tasks->get_result()->fetch_assoc();

$completed_tasks = $task_summary['completed_tasks'] ?? 0;
$pending_tasks = $task_summary['pending_tasks'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <div class="profile-container">
        <h2>User Profile</h2>
        <p><b>Name:</b> <?php echo $name; ?></p>
        <p><b>Email:</b> <?php echo $email; ?></p>

        <h3>Task Summary</h3>
        <p><b>Completed Tasks:</b> <?php echo $completed_tasks; ?></p>
        <p><b>Pending Tasks:</b> <?php echo $pending_tasks; ?></p>

        <a href="editprofile.php" class="btn edit-btn">Edit Profile</a>
        <a href="dashboard.php" class="btn dashboard-btn">Back to Dashboard</a>
        <a href="logout.php" class="btn logout-btn">Logout</a>
    </div>

    <footer class="footer">
        <p>This is a fictitious business created for a university course.</p>
    </footer>
</body>
</html>
