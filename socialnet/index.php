<?php
session_start();

// 1. Redirect if not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: /socialnet/signin.php");
    exit;
}

// 2. DB connection
require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/partials/menubar.php";
// 3. Get current user info
$user_id = $_SESSION["user_id"];

$stmt = $conn->prepare("SELECT username, fullname FROM account WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();

$current_user = $stmt->get_result()->fetch_assoc();

// 4. Get list of all users (basic list)
$users_result = $conn->query("SELECT id, username, fullname FROM account");
?>

<h2>Home Page</h2>

<!-- Current user info -->
<h3>Welcome</h3>
<p><b>Username:</b> <?php echo $current_user["username"]; ?></p>
<p><b>Full name:</b> <?php echo $current_user["fullname"]; ?></p>

<hr>

<!-- List of users -->
<h3>Users</h3>

<ul>
<?php while ($row = $users_result->fetch_assoc()) : ?>
    <li>
        <?php echo $row["username"] . " (" . $row["fullname"] . ")"; ?>
    </li>
<?php endwhile; ?>

</ul>
