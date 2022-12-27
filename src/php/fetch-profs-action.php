<?php 
    header("Access-Control-Allow-Origin: http://localhost:3000");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once('db_connect.php');

    $sql = "SELECT u.userID, CONCAT(u.fname, ' ', u.mname, ' ', u.lname) AS fullname, u.email, s.subject_name FROM users u
            JOIN professor p ON u.userID = p.userID
            JOIN subject s ON p.subjectID = s.subjectID
            WHERE user_type = 2";
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