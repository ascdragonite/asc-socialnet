<?php
session_start();

//reedirect if not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: /socialnet/signin.php");
    exit;
}

require_once __DIR__ . "/../config.php";
// get current user info
$user_id = $_SESSION["user_id"];

$stmt = $conn->prepare("SELECT username, fullname FROM account WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();

$current_user = $stmt->get_result()->fetch_assoc();

// get list of all users
$users_result = $conn->query("SELECT id, username, fullname FROM account");
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/socialnet/assets/style.css">
</head>
<body>

<?php require_once __DIR__ . "/partials/menubar.php"; ?>
  <div class="container">
    <h2>Home Page</h2>

    <h3>Welcome</h3>
    <p><b>Username:</b> <?php echo $current_user["username"]; ?></p>
    <p><b>Full name:</b> <?php echo $current_user["fullname"]; ?></p>

    <h3>Users</h3>

    <ul>
      <?php while ($row = $users_result->fetch_assoc()) : ?>
      <li>
              <?php echo $row["username"] . " (" . $row["fullname"] . ")"; ?>
      </li>
      <?php endwhile; ?>

    </ul>
  </div>
</body>
</html>
