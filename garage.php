<?php
require 'code/conn.php';

$sql = "SELECT * FROM cars";
$result = $conn->query($sql);
?>


<!<!doctype html>
<html>
    <head>
        <meta charset="UTF8">
        <title>Garage</title>
    </head>
    <body>
        <h1>Registered Cars</h1>

        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "Brand: " . $row["brand"] . " - Model: " . $row["model"] . " - License: " . $row["license"] . "<br>";
            }
        } else {
            echo "No cars registered yet.";
        }
        ?>


        <br>
        <button onclick="window.location.href = 'cars.php';">Register a New Car</button>
    </body>
</html>
