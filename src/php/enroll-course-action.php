<?php 

    header("Access-Control-Allow-Origin: http://localhost:3000");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once('db_connect.php');

    $message = "";
    $status = 400;

    $professorID = $_GET['id'];
    $studentID = $_SESSION['studentID'];

    $sql = "INSERT INTO enrolled (studentID, professorID) VALUES(?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $studentID, $professorID);
    $stmt->execute();
    $stmt->close();
 
    $status = 200;
    $message = "Successfully Enrolled!";
    
    header('location: http://localhost:3000/student/add-course');

?>