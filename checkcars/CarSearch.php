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
                    echo '<strong>License Plate:</strong> ' . $vehicle['registration'] . '<br>';
                    echo '<strong>VIN:</strong> ' . $vehicle['vin'] . '<br>';
                    echo '<strong>Year:</strong> ' . $vehicle['first_registration_date'] . '<br>';
                    echo '<strong>Mileage:</strong> ' . $vehicle['mileage'] . ' km<br>';
                    echo '<strong>Brand:</strong> ' . $vehicle['brand'] . '<br>';
                    echo '<strong>Model:</strong> ' . $vehicle['model'] . '<br>';
                    echo '</div>';
                }
            }
        }
        ?>
    </body>
</html>
