<?php 
    header("Access-Control-Allow-Origin: http://localhost:3000");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    require_once('db_connect.php');

    $studentID = $_SESSION['studentID'];

    $condition = "g.midtermGrade + g.finalGrade / 2 <= 1";
    $sql = "SELECT s.subject_name, g.midtermGrade, g.finalGrade, s.subject_name, 
            CASE
                WHEN $condition <= 1 THEN 'Outstanding'
                WHEN $condition <= 2 AND $condition >= 1  THEN 'Exceeds Expectations'
                WHEN $condition <= 3 AND $condition >= 2  THEN 'Acceptable'
                WHEN $condition <= 4 AND $condition >= 3  THEN 'Poor'
                WHEN $condition <= 5 AND $condition >= 4  THEN 'Dreadful'
            END remark FROM grades g
            JOIN enrolled e ON g.enrolledID = e.enrolledID
            JOIN professor p ON e.professorID = p.professorID
            JOIN subject s ON p.subjectID = s.subjectID
            JOIN student st ON e.studentID = st.studentID
            WHERE st.studentID=?";

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