<?php
$conn = new mysqli("localhost", "socialadmin", "password149", "socialnet");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $fullname = $_POST["fullname"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO account (username, fullname, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $fullname, $password);

    if ($stmt->execute()) {
        $message = "User created successfully!";
    } else {
        $message = "Error creating user.";
    }
}
?>

<h2>Create New User</h2>

<form method="POST">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Full Name:</label><br>
    <input type="fullname" name="fullname" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Create User</button>
</form>

<p><?php echo $message; ?></p>
