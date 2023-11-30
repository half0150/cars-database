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

    xhr.open("POST", "database/CarReg/insert_into_database.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    var data = "Status=" + encodeURIComponent(vehicle.status) +
            "&LastInspectionDate=" + encodeURIComponent(vehicle.last_inspection_date) +
            "&LastInspectionResult=" + encodeURIComponent(vehicle.last_inspection_result) +
            "&brand=" + encodeURIComponent(vehicle.brand) +
            "&model=" + encodeURIComponent(vehicle.model) +
            "&year=" + encodeURIComponent(vehicle.first_registration_date) +
            "&license=" + encodeURIComponent(vehicle.registration) +
            "&vinno=" + encodeURIComponent(vehicle.vin) +
            "&mileage=" + encodeURIComponent(vehicle.mileage);

    xhr.send(data);
}
