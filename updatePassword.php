<?php

require 'code/conn.php';

$username = $_POST['username'];
$oldPassword = $_POST['old_password'];
$newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

// Check if the user exists and old password is correct
$checkUserQuery = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($checkUserQuery);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    // Verify old password
    if (password_verify($oldPassword, $user['password'])) {
        // Update password
        $updatePasswordQuery = "UPDATE users SET password='$newPassword' WHERE username='$username'";
        
        if ($conn->query($updatePasswordQuery) === TRUE) {
            echo "Password updated successfully!";
        } else {
            echo "Error updating password: " . $conn->error;
        }
    } else {
        echo "Incorrect old password!";
    }
} else {
    echo "User not found!";
}

$conn->close();
?>
