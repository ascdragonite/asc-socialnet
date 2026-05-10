<?php

$conn = new mysqli("localhost", "socialadmin", "password149", "socialnet");

if ($conn->connect_error) {
    die("Database connection failed!!!: " . $conn->connect_error);
}
