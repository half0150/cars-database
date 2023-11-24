<?php
require 'code/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $license = $_POST['license'];

    $sql = "INSERT INTO cars (brand, model, license) VALUES ('$brand', '$model', '$license')";

    
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

<?php if ($conn->query($sql) === TRUE) {
        echo "Car has been registered";
    } else {
        echo "Error: " . $sql . $conn->error;
    }
}
?>