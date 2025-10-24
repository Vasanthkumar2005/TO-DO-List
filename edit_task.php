<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$task_id = intval($_GET['id']); 

$sql = "SELECT * FROM tasks WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $task_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $task = $result->fetch_assoc();
} else {
    header("Location: dashboard.php?error=Task+Not+Found");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $status = $_POST["status"];

    if (!empty($title) && !empty($description)) {
        $update_sql = "UPDATE tasks SET title = ?, description = ?, status = ? WHERE id = ? AND user_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("sssii", $title, $description, $status, $task_id, $user_id);

        if ($update_stmt->execute()) {
            header("Location: dashboard.php?message=Task+Updated+Successfully");
            exit();
        } else {
            echo "<p class='error-message'>Error updating task. Try again.</p>";
        }
    } else {
        echo "<p class='error-message'>Please fill all fields.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="edit_task.css">
</head>
<body>
    <div class="edit-task-container">
        <h2>Edit Task</h2>
        <form action="" method="POST">
            <label for="title">Task Title:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($task['description']); ?></textarea>

            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="pending" <?php echo ($task['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="completed" <?php echo ($task['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
            </select>

            <div class="button-group">
                <button type="submit" class="btn update-btn">Edit</button>
                <a href="delete_task.php?id=<?php echo $task_id; ?>" class="btn delete-btn">Delete</a>
            </div>
        </form>
    </div>

    <footer class="footer">
        <p>This is a fictitious business created for a university course.</p>
    </footer>

</body>
</html>
