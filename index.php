<?php
require("code/conn.php");
$sql = "SELECT * FROM users ORDER BY username";

if ($result = $conn->query($sql)) {
    $row = $result->fetch_row();
    // Display field lengths
   
    foreach ($result->lengths as $i => $val) {
        printf("Field %2d has length: %2d\n", $i + 1, $val);
        
    }
    $result->free_result();
}


echo $conn->server_info;

$conn->close();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>User Registration and Login</title>
    </head>
    <body>
        <h1>Create Account</h1>
        <form action="register.php" method="post">
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Password">
            <button type="submit">Create</button>
        </form>

        <h1>Login</h1>
        <form action="login.php" method="post">
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Password">
            <button type="submit">Login</button>
        </form>


        <h1>Update password</h1>

        <form action="updatePassword.php" method="post">
            <input type="text" name="username" placeholder="Enter your username">
            <input type="password" name="old_password" placeholder="Enter old password">
            <input type="password" name="new_password" placeholder="Enter your new password">
            <button type="submit">Update</button>
        </form>


        <h3>Apple's left: <span id="stockCount">50</span></h3>

        <button type="button" onclick="buyApple()">Buy Now</button>

        <script>
            let stock = 50;

            function buyApple() {
                if (stock > 0) {
                    stock--;
                    document.getElementById('stockCount').textContent = stock;
                } else {
                    alert("Sorry, no more apples in stock!");
                }
            }
        </script>




    </body>
</html>
