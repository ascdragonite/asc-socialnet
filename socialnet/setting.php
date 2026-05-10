<?php
session_start();
require_once __DIR__ . "/../config.php";

// Redirect if not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: /socialnet/signin.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$message = "";

// Get current user data
$stmt = $conn->prepare("SELECT username, fullname, description FROM account WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $description = $_POST["description"];

    $update = $conn->prepare("UPDATE account SET description = ? WHERE id = ?");
    $update->bind_param("si", $description, $user_id);
    $update->execute();

    $message = "Profile updated successfully";

    // refresh data
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
}
?>

<h2>Settings</h2>

<p><b>Username:</b> <?php echo $user["username"]; ?></p>
<p><b>Fullname:</b> <?php echo $user["fullname"]; ?></p>

<hr>

<form method="POST">
    <label>Description:</label><br>
    <textarea name="description" rows="5" cols="40"><?php
        echo htmlspecialchars($user["description"]);
    ?></textarea><br><br>

    <button type="submit">Save</button>
</form>

<p style="color:green;">
    <?php echo $message; ?>
</p>
