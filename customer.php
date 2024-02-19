<?php
Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE'); //method allowed
header("Content-Type: application/json");
require('connection.php');

$requestType = $_SERVER['REQUEST_METHOD'];

$data = array();


switch ($requestType) {
    case 'POST':
        // if (isset($_POST['action'])) {
        //     extract($_POST);
        $action = $_POST['action'];
        $action($conn);
        // } else {
        //     $data = array('status' => false, 'message' => 'action key is missing.');
        //     echo json_encode($data);
        // }
        break;
    case 'GET':
        showInstructions();
        break;
    case 'DELETE':
        echo $requestType;
        break;
    default:
        echo $requestType;
        break;
}

function showInstructions()
{
    $data = array(('status') => false, ('message') => 'Please, ask your teacher Abdirahman about this API Usage.');
    echo json_encode($data);
}

function addNewCustomer($conn)
{
    extract($_POST);

    if (isset($_POST["fullname"]) && isset($_POST["phone"]) && isset($_POST["email"]) && isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["address"])) {

        $query = "call signup_sp('$fullname','$phone','$email','$username','$password', '$address)";
        $result = $conn->query($query);
        $message = array();

        if ($result) {
            $data = $result->fetch_assoc();

            if (isset($data['message'])) {
                $message = $data['message'];
            } else {
                $message = $data;
            }
            $data = array(('status') => true, ('message') => $message);
        } else {
            $data = array(('status') => false, ('message') => $conn->error);
        }
    }else{
        $data = array(('status') => false, ('message') => '[fullname], [phone], [email], [username], [password] or [address] is missing.');
    }

    echo json_encode($data);
}

function login($conn)
{
    extract($_POST);

    $query = "call login_sp('$username','$password')";
    $result = $conn->query($query);

    if ($result) {
        $data = $result->fetch_assoc();

        if (isset($data['message'])) {
            $message = $data['message'];
        } else {
            $message = $data;
        }
        if ($message == "Invalid Username or Password") {
            $data = array(('status') => false, ('message') => $message);
        } else if ($message == "Username does not exist") {
            $data = array(('status') => false, ('message') => $message);
        } else {
            $data = array(('status') => true, ('message') => $message);
        }
    } else {
        $data = array(('status') => false, ('message') => $conn->error);
    }

    echo json_encode($data);
}

function getAllUsers($conn)
{
    extract($_POST);

    $query = "SELECT * FROM customer";
    $result = $conn->query($query);
    $result_data = array();

    if ($result) {
        while ($message = $result->fetch_assoc()) {
            $result_data[] = $message;
        }
        $data = array(('status') => true, ('message') => $result_data);
    } else {
        $data = array(('status') => false, ('message') => $conn->error);
    }

    echo json_encode($data);
}
