<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Vehicle Search</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }

            .vehicle-card {
                background-color: #fff;
                border: 1px solid #ddd;
                border-radius: 5px;
                padding: 15px;
                margin: 10px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            strong {
                font-weight: bold;
            }
        </style>
    </head>
    <body>

        <form method="post">
            <label for="search">Enter License Plate or VIN:</label>
            <input type="text" id="search" name="search">
            <button type="submit">Search</button>
        </form>

        <?php
        $api_key = 'sb_sk_34a670e7c3c9cdc7718a1dda2c11c5b7';
        $endpoint = 'https://api.synsbasen.dk/v1/vehicles/search';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $search_term = isset($_POST['search']) ? $_POST['search'] : '';

            $headers = [
                'Authorization: Bearer ' . $api_key,
                'Content-Type: application/json',
            ];

            $request_body = [
                'query' => [
                    'registration_start' => $search_term,
                ],
                'method' => 'SELECT',
                'page' => 1,
                'per_page' => 10,
                'sorts' => 'registration ASC',
            ];

            $ch = curl_init($endpoint);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request_body));

            $response = curl_exec($ch);

            curl_close($ch);

            $result = json_decode($response, true);

            if ($result === null) {
                echo 'Error decoding JSON response.';
            } else {
                foreach ($result['data'] as $vehicle) {
                    echo '<div class="vehicle-card">';
                    echo '<strong>Status:</strong> ' . $vehicle['status'] . '<br>';
                    echo '<strong>Last Inspection Date:</strong> ' . $vehicle['last_inspection_date'] . '<br>';
                    echo '<strong>Last Inspection Result:</strong> ' . $vehicle['last_inspection_result'] . '<br>';
                    echo '<strong>Brand:</strong> ' . $vehicle['brand'] . '<br>';
                    echo '<strong>Model:</strong> ' . $vehicle['model'] . '<br>';
                    echo '<strong>Year:</strong> ' . $vehicle['first_registration_date'] . '<br>';
                    echo '<strong>License Plate:</strong> ' . $vehicle['registration'] . '<br>';
                    echo '<strong>VIN:</strong> ' . $vehicle['vin'] . '<br>';
                    echo '<strong>Mileage:</strong> ' . $vehicle['mileage'] . ' km<br>';
                    echo '<strong>Fuel Type:</strong> ' . $vehicle['fuel_type'] . '<br>';
                    echo '<strong>Kind:</strong> ' . $vehicle['kind'] . '<br>';
                    echo '<strong>Variant:</strong> ' . $vehicle['variant'] . '<br>';

                    echo '<button id="btn" ';
                    //ondoubleclick="addToDatabase(' . json_encode($vehicle) . ')"
                            echo '>Add to Database</button>';

                    echo '</div>';
                }
            }
        }
        ?>

        <script>
            const submitbutton = document.querySelector("#btn");
            
            
            submitbutton.addEventListener("click", function(e){
               addToDatabase(<?php echo json_encode($vehicle) ?>);
            });
            
            function addToDatabase(vehicle) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            alert(xhr.responseText);
                        } else {
                            alert('Error: ' + xhr.status);
                        }
                    }
                };

                xhr.open("POST", "../CarReg/insert_into_database.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                let data = "Status=" + encodeURIComponent(vehicle.status) +
                        "&LastInspectionDate=" + encodeURIComponent(vehicle.last_inspection_date) +
                        "&LastInspectionResult=" + encodeURIComponent(vehicle.last_inspection_result) +
                        "&brand=" + encodeURIComponent(vehicle.brand) +
                        "&model=" + encodeURIComponent(vehicle.model) +
                        "&year=" + encodeURIComponent(vehicle.first_registration_date) +
                        "&license=" + encodeURIComponent(vehicle.registration) +
                        "&vinno=" + encodeURIComponent(vehicle.vin) +
                        "&mileage=" + encodeURIComponent(vehicle.mileage) +
                        "&FuelType=" + encodeURIComponent(vehicle.fuel_type) +
                        "&kind=" + encodeURIComponent(vehicle.kind) +
                        "&variant=" + encodeURIComponent(vehicle.variant);

                xhr.send(data);
            }
        </script>
    </body>
</html>
