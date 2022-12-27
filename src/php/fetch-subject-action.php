<?php
    header("Access-Control-Allow-Origin: http://localhost:3000");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once('db_connect.php');

    $subjectID = $_GET['id'];

    $sql = "SELECT subjectID, subject_name, description FROM subject WHERE subjectID=?";
     
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $subjectID);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $rows = array();
    while($fetch = $result->fetch_assoc()) {
        $rows = $fetch;
    }

    echo json_encode($rows); 

    $con->close();

?>