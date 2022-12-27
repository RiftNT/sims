<?php 
    header("Access-Control-Allow-Origin: http://localhost:3000");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once('db_connect.php');

    // $UID = $_SESSION['userID'];
    $stmt = $con->prepare("SELECT * FROM users WHERE userID=?");
    $stmt->bind_param("i", $_SESSION['userID']);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $r = $result->fetch_assoc();
        
    // var_dump($_SESSION); 
    echo json_encode($r); 

    $con->close();

?>