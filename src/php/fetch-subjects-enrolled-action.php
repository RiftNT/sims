<?php 
    header("Access-Control-Allow-Origin: http://localhost:3000");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    require_once('db_connect.php');

    $studentID = $_SESSION['studentID'];

    $sql = "SELECT s.*, CONCAT(u.fname, ' ', u.mname, ' ', u.lname) AS fullname, e.enrolledID FROM subject s
            JOIN professor p ON s.subjectID = p.subjectID
            JOIN users u ON p.userID = u.userID
            JOIN enrolled e ON p.professorID = e.professorID
            WHERE e.studentID = ? AND e.dropped = 1";

    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $studentID);
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