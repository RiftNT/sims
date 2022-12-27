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

    $subjectID = $_POST['subjectID'];
    $subject_name = trim($_POST['subject_name']);
    $description = trim($_POST['description']);
    
    $stmt = $con->prepare("SELECT * FROM subject WHERE subject_name = ? AND subjectID != ?");
    $stmt->bind_param("si", $subject_name, $subjectID);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    if($result->num_rows > 0){
        $valid = false;
        $message = "Subject already exists.";
    }
    
    $sql = "UPDATE subject SET subject_name=?, description=? WHERE subjectID=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssi", $subject_name, $description, $subjectID);  
    $stmt->execute();
    $stmt->close();

    $status = 200;
    $message = "Course successfully updated";
    

    $myObj = array(
        'status' => $status,
        'message' => $message  
    );

    $myJSON = json_encode($myObj, JSON_FORCE_OBJECT);
    echo $myJSON;

    $con->close();

?>