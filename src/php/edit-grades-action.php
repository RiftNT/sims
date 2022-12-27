<?php 

    header("Access-Control-Allow-Origin: http://localhost:3000");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once('db_connect.php');

    $message = "";
    $status = 400; 

    $gradeID = $_POST['gradeID'];
    $midtermGrade = $_POST['midtermGrade'] != '' ? $_POST['midtermGrade'] : NULL;
    $finalGrade = $_POST['finalGrade'] != '' ? $_POST['finalGrade'] : NULL;
        
    $sql = "UPDATE grades SET midtermGrade=?, finalGrade=? WHERE gradeID=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("iii", $midtermGrade, $finalGrade, $gradeID);  
    $stmt->execute();
    $stmt->close();

    $status = 200;
    $message = "Grades successfully updated";
    

    $myObj = array(
        'status' => $status,
        'message' => $message  
    );

    $myJSON = json_encode($myObj, JSON_FORCE_OBJECT);
    echo $myJSON;

    $con->close();

?>