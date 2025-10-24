<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

$sql = "SELECT * FROM tasks WHERE user_id = ? AND status = 'completed' ORDER BY created_at DESC";
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
    <title>Completed Tasks</title>
    <link rel="stylesheet" href="completed_task.css">
</head>
<body>

    <header class="header">
        <h1>Completed Tasks</h1>
    </header>

    <div class="task-container">    
        <h2>Hello, <?php echo htmlspecialchars($user_name); ?>! 🎉</h2>
        <p>Here are all the tasks you’ve successfully completed.</p>

        <div class="task-list">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($task = $result->fetch_assoc()): ?>
                    <div class="task-card">
                        <h3><?php echo htmlspecialchars($task['title']); ?></h3>
                        <p><?php echo htmlspecialchars($task['description']); ?></p>
                        <span class="date">✅ Completed on: <?php echo date("F j, Y, g:i a", strtotime($task['created_at'])); ?></span>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-tasks">😴 No completed tasks yet. Keep going!</p>
            <?php endif; ?>
        </div>

        <a href="dashboard.php" class="btn back-btn">🏠 Back to Dashboard</a>
    </div>

    <footer class="footer">
        <p>This is a fictitious business created for a university course.</p>
    </footer>

</body>
</html>
