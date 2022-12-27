<?php 
    header("Access-Control-Allow-Origin: http://localhost:3000");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once('db_connect.php');

    $message = "You have entered an invalid email or password";
    $status = 400;
    $type = "";
    $email = trim($_REQUEST['email']);
    $password = trim($_REQUEST['password']);

    $sql = "SELECT u.*, p.professorID, s.studentID FROM users u 
            LEFT JOIN professor p ON u.userID = p.userID
            LEFT JOIN student s ON u.userID = s.userID
            WHERE u.email=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $obj = mysqli_fetch_object($result);
    $stmt->close(); 
    if($result->num_rows > 0) {
        $isPassword = password_verify($password, $obj->password);
        if($isPassword == true) {
            $status = 200;
            $message = "Successful";
            $data = $obj;
            $type = $obj->user_type;
            $_SESSION['userID'] = $obj->userID;
            $_SESSION['fname'] = $obj->fname;
            $_SESSION['mname'] = $obj->mname;
            $_SESSION['lname'] = $obj->lname;
            $_SESSION['email'] = $obj->email;
            $_SESSION['password'] = $obj->password;
            $_SESSION['user_type'] = $obj->user_type;
            $_SESSION['user_name'] = "$obj->fname $obj->mname $obj->lname";
            if($type == 'professor') {
                $_SESSION['professorID'] = $obj->professorID;
            }
            if($type == 'student') {
                $_SESSION['studentID'] = $obj->studentID;
            }
        }
    }   
    $myObj = array(
        'status' => $status,
        'type' => $type,
        'message' => $message
    );
    // var_dump($_SESSION);
    $myJSON = json_encode($myObj, JSON_FORCE_OBJECT);
    echo $myJSON;

    $con->close();
    
?>
