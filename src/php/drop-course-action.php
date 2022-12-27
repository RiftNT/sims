<?php 

    header("Access-Control-Allow-Origin: http://localhost:3000");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once('db_connect.php');

    $message = "Invalid Session";
    
    $enrolledID = $_GET['id'];
    $studentID = $_SESSION['studentID'];
    
    $sql = "SELECT * FROM enrolled WHERE studentID=? AND enrolledID=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $studentID, $enrolledID);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    
    if($result->num_rows > 0) {
        $sql = "UPDATE enrolled SET dropped=2 WHERE enrolledID=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $enrolledID);
        $stmt->execute();
        $stmt->close();
        $message = "Dropped Course";
    }

    echo $message;
    header('location: http://localhost:3000/student/add-course');
?>