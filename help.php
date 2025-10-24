<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help & Support</title>
    <link rel="stylesheet" href="help.css">
</head>
<body>
    <div class="help-container">
        <h2>Help & Support</h2>

        <h3>📌 How to Use the To-Do List</h3>
        <ul>
            <li><strong>Adding a Task:</strong> Click on the <b>"+ Add Task"</b> button on the dashboard and fill in the task details.</li>
            <li><strong>Editing a Task:</strong> Click the <b>"Edit"</b> button next to a task to update its details.</li>
            <li><strong>Marking a Task as Completed:</strong> Click the <b>"Mark Completed"</b> button next to a pending task.</li>
            <li><strong>Deleting a Task:</strong> Click the <b>"Delete"</b> button next to a task to remove it permanently.</li>
            <li><strong>Updating Account Settings:</strong> Visit the <b>"Settings"</b> page to modify your account details.</li>
        </ul>

        <h3>❓ Frequently Asked Questions</h3>
        <details>
            <summary>How do I reset my password?</summary>
            <p>Currently, there is no password reset feature. Please contact support.</p>
        </details>

        <details>
            <summary>Can I recover a deleted task?</summary>
            <p>No, deleted tasks are permanently removed.</p>
        </details>

        <details>
            <summary>Why am I logged out automatically?</summary>
            <p>For security reasons, your session expires after a certain period of inactivity.</p>
        </details>

        <a href="dashboard.php" class="btn">Back to Dashboard</a>
    </div>
    <footer class="footer">
        <p>This is a fictitious business created for a university course.</p>
    </footer>
</body>
</html>
