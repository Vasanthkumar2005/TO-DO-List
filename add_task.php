<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $due_date = $_POST["due_date"];
    $category = $_POST["category"];
    $status = "pending"; 

    if (!empty($title) && !empty($description) && !empty($due_date) && !empty($category)) {
        $sql = "INSERT INTO tasks (user_id, title, description, due_date, category, status, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssss", $user_id, $title, $description, $due_date, $category, $status);

        if ($stmt->execute()) {
            header("Location: dashboard.php"); 
            exit();
        } else {
            echo "<p style='color: red;'>Error adding task. Try again.</p>";
        }
    } else {
        echo "<p style='color: red;'>Please fill all fields.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
    <link rel="stylesheet" href="addtask.css">
</head>
<body>
    <div class="task-container">
        <h2>Add a New Task</h2>
        <form action="add_task.php" method="POST">
            <label for="title">Task Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="due_date">Due Date:</label>
            <input type="date" id="due_date" name="due_date" required>

            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <option value="Work">Work</option>
                <option value="Study">Study</option>
                <option value="Personal">Personal</option>
                <option value="Others">Others</option>
            </select>

            <button type="submit" class="btn">Add Task</button>
            <a href="dashboard.php" class="btn cancel-btn">Cancel</a>
        </form>
    </div>
    <footer>
        <p>This is a fictitious business created for a university course.</p>
    </footer>
</body>
</html>