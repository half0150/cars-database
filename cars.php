<?php //
require 'code/conn.php';

function isLicenseValid($license) {
    return preg_match("/^[A-Za-z]{2}[0-9]{5}$/", $license);
}

$showMessage = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = $_POST['Status'];
    $LastInspectionDate = $_POST['LastInspectionDate'];
    $LastInspectionResult = $_POST['LastInspectionResult'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $license = $_POST['license'];
    $year = $_POST['year'];
    $vinno = $_POST['vinno'];
    $mileage = $_POST['mileage'];

    if (!empty($status) || !empty($LastInspectionDate) || !empty($LastInspectionResult) || !empty($brand) || !empty($model) || !empty($license) || !empty($year) || !empty($vinno) || !empty($mileage)) {
        $showMessage = true;

        if (isLicenseValid($license)) {
            $stmt = $conn->prepare("INSERT INTO cars (Status, LastInspectionDate, LastInspectionResult ,brand, model, year, license, vinno, mileage) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $status, $LastInspectionDate, $LastInspectionResult, $brand, $model, $year, $license, $vinno, $mileage);

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
        <link rel="stylesheet" href="style\style.css"/>
    </head>
    <body>
        <h1>Register a car</h1>
        <form action="cars.php" method="post">
            <label>Status</label>
            <input type="text" name="Status" placeholder="Skrottet">
            <label>Last Inspection Date</label>
            <input type="text" name="LastInspectionDate" placeholder="2023-01-30">
            <label>Last Inspection Result</label>
            <input type="text" name="LastInspectionResult" placeholder="Godkendt">
            <label>Brand</label>
            <input type="text" name="brand" placeholder="Audi">
            <label>Model</label>
            <input type="text" name="model" placeholder="A6">
            <label>Year</label>
            <input type="text" name="year" placeholder="2023-01-30">
            <label>License</label>
            <input type="text" name="license" placeholder="AA12345">
            <label>VIN</label>
            <input type="text" name="vinno" placeholder="1ABCD23EF4G567891">
            <label>Mileage</label>
            <input type="number" name="mileage" placeholder="111000">
            <button type="submit">Register</button>
        </form>

        <?php
        if ($showMessage) {
            echo "<p>{$message}</p>";
        }
        ?>

        <button onclick="location.href = 'garage.php'">View Registered Cars</button>
    </body>
</html>
