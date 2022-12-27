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

    $fname = trim($_POST['fname']);
    $mname = trim($_POST['mname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $year = $_POST['year'];
    $house = $_POST['house'];
    $type = 1;

    if($valid){
        $stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if($result->num_rows > 0){
            $valid = false;
            $message = "Email already exists.";
        }
    }

    if($valid) {
        $sql = "INSERT INTO users(fname, mname, lname, email, password, user_type) VALUES(?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("sssssi", $fname, $mname, $lname, $email, $password, $type);
        $stmt->execute();
        $newID = $con->insert_id;
        $stmt->close();

        $sql = "INSERT INTO student(userID, year_level, house) VALUES(?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iii", $newID, $year, $house);
        $stmt->execute();
        $stmt->close();

        $status = 200;
        $message = "Account successfully created";
    }

    $myObj = array(
        'status' => $status,
        'message' => $message  
    );
    $myJSON = json_encode($myObj, JSON_FORCE_OBJECT);
    echo $myJSON;

?>