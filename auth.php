<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the inputs from the form
    $user_input = $_POST['user'];
    $pass_input = $_POST['pass'];

    // Search for the user in the database
    $stmt = $conn->prepare("SELECT user_id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $user_input);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Check if password matches
        if ($pass_input === $row['password']) {
            // SUCCESS: Set session variables
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            
            // Now redirect to the dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Wrong password!'); window.location='login.php';</script>";
        }
    } else {
        echo "<script>alert('User not found!'); window.location='login.php';</script>";
    }
}
?>