<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

$sql = "SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$sql_remainder = "SELECT title FROM tasks WHERE user_id = ? AND status = 'pending' ORDER BY created_at ASC LIMIT 1";
$stmt_remainder = $conn->prepare($sql_remainder);
$stmt_remainder->bind_param("i", $user_id);
$stmt_remainder->execute();
$remainder_result = $stmt_remainder->get_result();
$remainder_task = $remainder_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="navbar">
        <h2>To-Do Dashboard</h2>
        <div class="nav-links">
            <a href="add_task.php" class="btn">+ Add Task</a>
            <a href="profile.php" class="profile-btn">Profile</a>
            <a href="logout.php" class="logout-btn">Logout</a>
            <a href="settings.php" class="btn settings-btn">⚙ Settings</a> 
            <a href="completed_task.php" class="btn completed-task-btn">View Completed Tasks</a>
            <a href="help.php" class="btn help-btn">Help</a>
            <a href="remainder.php" class="btn remainder-btn">Reminders</a>
        </div>
    </div>

    <div class="dashboard-container">
        <h2>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h2>

        <h3>Your Tasks</h3>
        <table>
            <tr>
                <th>Task</th>
                <th>Description</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($task = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($task['title']); ?></td>
                        <td><?php echo htmlspecialchars($task['description']); ?></td>
                        <td class="<?php echo $task['status']; ?>"><?php echo ucfirst($task['status']); ?></td>
                        <td>
                            <a href="edit_task.php?id=<?php echo $task['id']; ?>" class="btn edit-btn">Edit</a>
                            <a href="delete_task.php?id=<?php echo $task['id']; ?>" class="btn delete-btn">Delete</a>
                            <?php if ($task['status'] === 'pending'): ?>
                                <a href="complete_task.php?id=<?php echo $task['id']; ?>" class="btn complete-btn">Mark Completed</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4">No tasks found. Add some tasks!</td></tr>
            <?php endif; ?>
        </table>
    </div>

    <script>
        function showReminderNotification() {
            <?php if (!empty($remainder_task)) : ?>
                let taskTitle = "<?php echo addslashes($remainder_task['title']); ?>";

                if (!("Notification" in window)) {
                    alert("This browser does not support desktop notifications.");
                } else if (Notification.permission === "granted") {
                    new Notification("Reminder: Pending Task", {
                        body: taskTitle,
                        icon: "notification_icon.png"
                    });
                } else if (Notification.permission !== "denied") {
                    Notification.requestPermission().then(permission => {
                        if (permission === "granted") {
                            new Notification("Reminder: Pending Task", {
                                body: taskTitle,
                                icon: "notification_icon.png"
                            });
                        } else {
                            alert("Notifications are blocked. Enable them to receive task reminders.");
                        }
                    });
                }
            <?php endif; ?>
        }

        document.addEventListener("DOMContentLoaded", () => {
            if (Notification.permission !== "granted" && Notification.permission !== "denied") {
                Notification.requestPermission();
            }
            setTimeout(showReminderNotification, 2000); 
        });
    </script>
    <footer>
    <p>This is a fictitious business created for a university course.</p>
</footer>

</body>
</html>
