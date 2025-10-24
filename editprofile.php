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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_name = trim($_POST["name"]);
    $new_email = trim($_POST["email"]);

    if (!empty($new_name) && !empty($new_email)) {
        $update_sql = "UPDATE users SET name = ?, email = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ssi", $new_name, $new_email, $user_id);

        if ($update_stmt->execute()) {
            header("Location: profile.php?message=Profile+Updated+Successfully");
            exit();
        } else {
            echo "<p style='color: red;'>Error updating profile. Try again.</p>";
        }
    } else {
        echo "<p style='color: red;'>Please fill in all fields.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="editprofile.css">
</head>
<body>
    <div class="edit-profile-container">
        <h2>Edit Profile</h2>
        <form action="" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user_result['name']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_result['email']); ?>" required>

            <button type="submit" class="btn save-btn">Save Changes</button>
            <a href="profile.php" class="btn cancel-btn">Cancel</a>
        </form>
    </div>
    <footer class="footer">
        <p>This is a fictitious business created for a university course.</p>
    </footer>
</body>
</html>
