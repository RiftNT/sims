<?php 
    header("Access-Control-Allow-Origin: http://localhost:3000");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once('db_connect.php');

    $PID = $_GET['id'];

    $sql = "SELECT u.*, CONCAT(u.fname, ' ', u.mname, ' ', u.lname) AS fullname, s.*  FROM users u
            JOIN professor p ON u.userID = p.userID
            JOIN subject s ON p.subjectID = s.subjectID
            WHERE u.userID = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $PID);
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