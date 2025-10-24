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
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_name = trim($_POST["name"]);
    $new_email = trim($_POST["email"]);
    $new_password = trim($_POST["password"]);
    
    if (!empty($new_name) && !empty($new_email)) {
        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("sssi", $new_name, $new_email, $hashed_password, $user_id);
        } else {
            $update_sql = "UPDATE users SET name = ?, email = ? WHERE id = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("ssi", $new_name, $new_email, $user_id);
        }

        if ($stmt->execute()) {
            $_SESSION['user_name'] = $new_name;
            header("Location: settings.php?success=Settings+Updated");
            exit();
        } else {
            echo "<p style='color: red;'>Error updating settings. Try again.</p>";
        }
    } else {
        echo "<p style='color: red;'>Please fill in all required fields.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="settings.css">
</head>
<body>

    <div class="settings-container">
        <h2>Account Settings</h2>
        <?php if (isset($_GET['success'])): ?>
            <p class="success-msg"><?php echo htmlspecialchars($_GET['success']); ?></p>
        <?php endif; ?>
        <form action="settings.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="password">New Password (leave blank to keep current password):</label>
            <input type="password" id="password" name="password">

            <button type="submit" class="btn save-btn">Save Changes</button>
            <a href="dashboard.php" class="btn cancel-btn">Cancel</a>
        </form>
    </div>

    <footer class="footer">
        <p>This is a fictitious business created for a university course.</p>
    </footer>

</body>
</html>
