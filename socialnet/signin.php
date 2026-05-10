<?php
session_start();

require_once(__DIR__ . "/../config.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // find user
    $stmt = $conn->prepare("SELECT id, username, password FROM account WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {
        // login success
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["fullname"] = $user["fullname"];
        $_SESSION["description"] = $user["description"];


        header("Location: /socialnet/index.php");
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/socialnet/assets/style.css">
</head>

<body>


<div class="container">
<h2>Sign In</h2>

<form method="POST">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Login</button>
</form>

<p style="color:red;"><?php echo $error; ?></p>
</div>

</body>
</html>
