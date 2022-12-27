<?php
    header("Access-Control-Allow-Origin: http://localhost:3000");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once('db_connect.php');

    $studentID = $_GET['id'];

    $sql = "SELECT g.gradeID, sb.subject_name, CONCAT(u.fname, ' ', u.mname, ' ', u.lname) AS prof, 
                    g.midtermGrade, g.finalGrade FROM grades g
	            JOIN enrolled e ON g.gradeID = e.enrolledID
                JOIN professor p ON e.professorID = p.professorID
                JOIN subject sb ON p.subjectID = sb.subjectID
                JOIN users u ON p.userID = u.userID
            WHERE e.studentID = ?";
     
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