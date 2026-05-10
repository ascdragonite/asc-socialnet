<?php
session_start();
require_once __DIR__ . "/../config.php";

// Redirect if not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: /socialnet/signin.php");
    exit;
}

// 1. Determine owner
if (isset($_GET["owner"])) {
    $owner_username = $_GET["owner"];
} else {
    // fallback: current user
    $stmt = $conn->prepare("SELECT username FROM account WHERE id = ?");
    $stmt->bind_param("i", $_SESSION["user_id"]);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    $owner_username = $result["username"];
}

// 2. Get profile data
$stmt = $conn->prepare("SELECT username, fullname, description FROM account WHERE username = ?");
$stmt->bind_param("s", $owner_username);
$stmt->execute();

$profile = $stmt->get_result()->fetch_assoc();

// 3. If user not found
if (!$profile) {
    die("User not found");
}
?>

<h2>Profile Page</h2>

<p><b>Owner:</b> <?php echo $profile["username"]; ?></p>
<p><b>Full Name:</b> <?php echo $profile["fullname"]; ?></p>

<hr>

<h3>Description</h3>
<p>
    <?php echo nl2br(htmlspecialchars($profile["description"])); ?>
</p>
