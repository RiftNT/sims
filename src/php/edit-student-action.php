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
    $valid = true;

    $userID = $_POST['userID'];
    $fname = trim($_POST['fname']);
    $mname = trim($_POST['mname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $year = $_POST['year_level'];

    $stmt = $con->prepare("SELECT * FROM users WHERE email = ? AND userID != ?");
    $stmt->bind_param("si", $email, $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    if($result->num_rows > 0){
        $valid = false;
        $message = "Email already exists.";
    }
    
    if($valid) {
        if($password != '') {
            $sql = "UPDATE users SET fname=?, mname=?, lname=?, email=?, password=? WHERE userID=?";
            $stmt = $con->prepare($sql);
            $password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("sssssi", $fname, $mname, $lname, $email, $password, $userID);
        } else {
            $sql = "UPDATE users SET fname=?, mname=?, lname=?, email=? WHERE userID=?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ssssi", $fname, $mname, $lname, $email, $userID);
        }
        $stmt->execute();
        $stmt->close();

        $sql = "UPDATE student SET year_level = ? WHERE userID = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $year, $userID);
        $stmt->execute();
        $stmt->close();

        $status = 200;
        $message = "Account successfully updated";
    }

    $myObj = array(
        'status' => $status,
        'message' => $message  
    );
    $myJSON = json_encode($myObj, JSON_FORCE_OBJECT);
    echo $myJSON;

    $con->close();

?>