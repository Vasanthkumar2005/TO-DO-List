<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

$sql = "SELECT * FROM tasks WHERE user_id = ? AND status = 'pending' ORDER BY created_at ASC LIMIT 5";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reminders</title>
    <link rel="stylesheet" href="remainder.css">
</head>
<body>
    <div class="container">
        <h2>🔔 Task Reminders</h2>
        <p>Hello <b><?php echo htmlspecialchars($user_name); ?></b>, here are your upcoming pending tasks.</p>

        <?php if ($result->num_rows > 0): ?>
            <ul class="task-list">
                <?php while ($task = $result->fetch_assoc()): ?>
                    <li class="task-item">
                        <div class="task-info">
                            <h3><?php echo htmlspecialchars($task['title']); ?></h3>
                            <p><?php echo htmlspecialchars($task['description']); ?></p>
                            <span class="task-date">📅 <?php echo date("F j, Y - H:i", strtotime($task['created_at'])); ?></span>
                        </div>
                        <a href="edit_task.php?id=<?php echo $task['id']; ?>" class="btn edit-btn">✏ Edit</a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p class="no-tasks">🎉 No pending reminders! You are all caught up.</p>
        <?php endif; ?>

        <a href="dashboard.php" class="btn back-btn">⬅ Back to Dashboard</a>
    </div>
    <!-- Footer Section -->
    <footer class="footer">
        <p>This is a fictitious business created for a university course.</p>
    </footer>
</body>
</html>
