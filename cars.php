<?php
require 'code/conn.php';

function isLicenseValid($license) {
    return preg_match("/^[A-Za-z]{2}[0-9]{5}$/", $license);
}

$showMessage = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $license = $_POST['license'];
    $year = $_POST['year'];
    $vinno = $_POST['vinno'];

    if (!empty($brand) || !empty($model) || !empty($license) || !empty($year) || !empty($vinno)) {
        $showMessage = true;

        if (isLicenseValid($license)) {
            $stmt = $conn->prepare("INSERT INTO cars (brand, model, year, license, vinno) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $brand, $model, $year, $license, $vinno);

            if ($stmt->execute()) {
                $message = "Car has been registered";
            } else {
                $message = "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $message = "Invalid license format";
        }
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
        <input type="number" name="year" placeholder="1999">
        <input type="text" name="license" placeholder="AA12345">
        <input type="text" name="vinno" placeholder="VIN">
        <button type="submit">Register</button>
    </form>

    <?php
    if ($showMessage) {
        echo "<p>{$message}</p>";
    }
    ?>

    <button onclick="location.href='garage.php'">View Registered Cars</button>
</body>
</html>
