<?php
require '../code/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = $_POST['Status'];
    $lastInspectionDate = $_POST['LastInspectionDate'];
    $lastInspectionResult = $_POST['LastInspectionResult'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $license = $_POST['license'];
    $vinno = $_POST['vinno'];
    $mileage = $_POST['mileage'];
    $FuelType = $_POST['FuelType'];
    $kind = $_POST['kind'];
    $variant = $_POST['variant'];
    
    
    
    

    $stmt = $conn->prepare("INSERT INTO cars (Status, LastInspectionDate, LastInspectionResult ,brand, model, year, license, vinno, mileage, FuelType, kind, variant) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    try{
    $stmt->bind_param("ssssssssssss", $status, $lastInspectionDate, $lastInspectionResult, $brand, $model, $year, $license, $vinno, $mileage, $FuelType, $kind, $variant);
    
    

    if ($stmt->execute()) {
        echo "Car has been added to the database";
    } else {
        echo "Error: " . $stmt->error;
    }

    }catch(\Throwable $t){
        if ($t->getCode()=== 1062){
        //$stmt = $conn->prepare ("UPDATE `cars` SET `id`='[value-1]',`Status`='[value-2]',`LastInspectionDate`='[value-3]',`LastInspectionResult`='[value-4]',`brand`='[value-5]',`model`='[value-6]',`year`='[value-7]',`license`='[value-8]',`vinno`='[value-9]',`mileage`='[value-10]',`FuelType`='[value-11]',`kind`='[value-12]',`variant`='[value-13]'")
      $sql = "UPDATE `cars` SET "
               . "`Status`='$status',`LastInspectionDate`='$lastInspectionDate',`"
               . "LastInspectionResult`='$lastInspectionResult',`brand`='$brand',`model`='$model',"
               . "`year`='$year',`license`='$license',"
               . "`mileage`=$mileage,`FuelType`='$FuelType',`kind`='$kind',`variant`='$variant'"
               . " WHERE `vinno`='$vinno'";
       if($conn->query($sql)){
           echo "The current vehicle has already been registered and has been updated instead "; 
       }
       
      
                    }
    }
    
    
    
    $stmt->close();
}
?>
