<?php
require 'code/conn.php';

function isLicenseValid($license) {
    return preg_match("/^[A-Za-z]{2}[0-9]{5}$/", $license);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $license = $_POST['license'];

    if (isLicenseValid($license)) {
        $stmt = $conn->prepare("INSERT INTO cars (brand, model, license) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $brand, $model, $license);

        if ($stmt->execute()) {
            echo "Car has been registered";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Invalid license format";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Car registration</title>
</head>
<body>
    <h1>Register a car</h1>
    <form action="cars.php" method="post">
        <input type="text" name="brand" placeholder="brand">
        <input type="text" name="model" placeholder="model">
        <input type="text" name="license" placeholder="AA12345">
        <button type="submit">Register</button>
    </form>
    
    <button onclick="location.href='garage.php'">View Registered Cars</button>
</body>
</html>
