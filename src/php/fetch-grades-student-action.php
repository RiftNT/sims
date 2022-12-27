<?php 
    header("Access-Control-Allow-Origin: http://localhost:3000");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once('db_connect.php');

    $profID = $_SESSION['professorID'];
    $studID = $_GET['id'];

    $sql = "SELECT g.gradeID, g.midtermGrade, g.finalGrade FROM users u
            JOIN student s ON u.userID = s.userID
            JOIN enrolled e ON s.studentID = e.studentID
            JOIN grades g ON e.enrolledID = g.enrolledID
            WHERE e.professorID = ? AND u.userID = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $profID, $studID);
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