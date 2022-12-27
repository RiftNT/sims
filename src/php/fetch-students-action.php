<?php 
    header("Access-Control-Allow-Origin: http://localhost:3000");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once('db_connect.php');

    $sql = "SELECT u.userID, CONCAT(u.fname, ' ', u.mname, ' ', u.lname) AS fullname, u.email, s.year_level, s.house FROM users u
            JOIN student s ON u.userID = s.userID
            WHERE user_type = 1";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $rows = array();
    while($fetch = $result->fetch_assoc()) {
        $rows[] = $fetch;
    }

    echo json_encode($rows); 

    $con->close();

?>