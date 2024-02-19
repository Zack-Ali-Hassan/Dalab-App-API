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
        $action = $_POST['action'];
        $action($conn);
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
    $data = array(('status') => false, ('message') => 'Please, ask your Zack Ali Hassan about this API Usage.');
    echo json_encode($data);
}

function addCategory($conn)
{
    extract($_POST);

    if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['description']) && isset($_POST['image'])) {
        $query = "call category_sp('$id','$name', '$description', '$image', 'addCategory')";
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
    } else {
        $data = array(('status') => false, ('message') => '[id], [name], [description] or [image] is missing');
    }

    echo json_encode($data);
}

function deleteCategory($conn)
{
    extract($_POST);

    if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['description']) && isset($_POST['image'])) {
        $query = "call category_sp('$id','$name', '$description', '$image', 'addCategory')";
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
    } else {
        $data = array(('status') => false, ('message') => '[id], [name], [description] or [image] is missing');
    }

    echo json_encode($data);
}

function getCategories($conn)
{
    extract($_POST);

    $query = "SELECT * FROM category";
    $result = $conn->query($query);
    $result_data = array();

    if ($result) {
        while ($message = $result->fetch_assoc()) {
            $result_data[] = $message;
        }
        $data = $result_data;
    } else {
        $data = array(('status') => false, ('message') => $conn->error);
    }

    echo json_encode($data);
}

//TODO: FINISH THIS ADDPRODUCT FUNCTION
function addProduct($conn)
{
    extract($_POST);

    $query = "call products_sp('$username','$password')";
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

    echo json_encode($data);
}
//TODO: FINISH THIS DELETEPRODUCT FUNCTION
function deleteProduct($conn)
{
    extract($_POST);

    $query = "DELETE FROM products WHERE id = '$id'";
    $result = $conn->query($query);
    $message = array();
    // echo $result;
    die($result->fetch_assoc());
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

    echo json_encode($data);
}

function logout($conn)
{
    extract($_POST);

    $query = "call logout_sp('$token')";
    $result = $conn->query($query);

    if ($result) {
        $message = $result->fetch_assoc();

        if (isset($message['message'])) {
            $result_data = $message['message'];
        } else {
            $result_data = $message;
        }
        $data = array(('status') => true, ('message') => $result_data);
    } else {
        $data = array(('status') => false, ('message') => $conn->error);
    }

    echo json_encode($data);
}
function register_customer($conn){
    extract($_POST);
    $message =array();
    $query = "INSERT INTO `customer`(`customer_name`, `email`, `address`, `mobile`) 
    VALUES ('$name', '$email', COALESCE('$address', 'Hodan'), '$mobile');
    "; 
    $result =$conn->query($query);
    if($result){
        
        $message = "Register successfully";
    }
    else{
        $message = $conn->error;
    }
    echo json_encode($message);
}
function getNewProducts($conn)
{
    extract($_POST);

    $query = "SELECT * FROM `products` order by p_id desc";
    $result = $conn->query($query);
    $result_data = array();

    if ($result) {
        while ($message = $result->fetch_assoc()) {
            $result_data[] = $message;
        }
        $data = $result_data;
    } else {
        $data = array(('status') => false, ('message') => $conn->error);
    }

    echo json_encode($data);
}
function getDiscountProducts($conn)
{
    extract($_POST);

    $query = "SELECT * FROM `products` WHERE products.discount > 0";
    $result = $conn->query($query);
    $result_data = array();

    if ($result) {
        while ($message = $result->fetch_assoc()) {
            $result_data[] = $message;
        }
        $data = $result_data;
    } else {
        $data = array(('status') => false, ('message') => $conn->error);
    }

    echo json_encode($data);
}
function getWomenClothesProducts($conn)
{
    extract($_POST);

    $query = "SELECT * FROM `products` WHERE sub_category_id = 1";
    $result = $conn->query($query);
    $result_data = array();

    if ($result) {
        while ($message = $result->fetch_assoc()) {
            $result_data[] = $message;
        }
        $data = $result_data;
    } else {
        $data = array(('status') => false, ('message') => $conn->error);
    }

    echo json_encode($data);
}
function getWomenShoesProducts($conn)
{
    extract($_POST);

    $query = "SELECT * FROM `products` WHERE sub_category_id = 2";
    $result = $conn->query($query);
    $result_data = array();

    if ($result) {
        while ($message = $result->fetch_assoc()) {
            $result_data[] = $message;
        }
        $data = $result_data;
    } else {
        $data = array(('status') => false, ('message') => $conn->error);
    }

    echo json_encode($data);
}
function getMenClothesProducts($conn)
{
    extract($_POST);

    $query = "SELECT * FROM `products` WHERE sub_category_id = 3";
    $result = $conn->query($query);
    $result_data = array();

    if ($result) {
        while ($message = $result->fetch_assoc()) {
            $result_data[] = $message;
        }
        $data = $result_data;
    } else {
        $data = array(('status') => false, ('message') => $conn->error);
    }

    echo json_encode($data);
}
function getMenShoesProducts($conn)
{
    extract($_POST);

    $query = "SELECT * FROM `products` WHERE sub_category_id = 4";
    $result = $conn->query($query);
    $result_data = array();

    if ($result) {
        while ($message = $result->fetch_assoc()) {
            $result_data[] = $message;
        }
        $data = $result_data;
    } else {
        $data = array(('status') => false, ('message') => $conn->error);
    }

    echo json_encode($data);
}
function getKidsClothesProducts($conn)
{
    extract($_POST);

    $query = "SELECT * FROM `products` WHERE sub_category_id = 5";
    $result = $conn->query($query);
    $result_data = array();

    if ($result) {
        while ($message = $result->fetch_assoc()) {
            $result_data[] = $message;
        }
        $data = $result_data;
    } else {
        $data = array(('status') => false, ('message') => $conn->error);
    }

    echo json_encode($data);
}
function getKidsShoesProducts($conn)
{
    extract($_POST);

    $query = "SELECT * FROM `products` WHERE sub_category_id = 6";
    $result = $conn->query($query);
    $result_data = array();

    if ($result) {
        while ($message = $result->fetch_assoc()) {
            $result_data[] = $message;
        }
        $data = $result_data;
    } else {
        $data = array(('status') => false, ('message') => $conn->error);
    }

    echo json_encode($data);
}

// function fetch($conn)
// {
//     extract($_POST);
//     $query = "SELECT * FROM users WHERE user_id = '$user_id'";
//     $result = $conn->query($query);
//     $result_data = array();
//     if ($result) {
//         $num_rows = $result->num_rows;
//         if ($num_rows > 0) {
//             $data = [];
//             $row = $result->fetch_assoc();
//             $data = $row;
//             $result_data = array("status" => true, "message" => $data);
//         } else {
//             $result_data = array("status" => false, "message" => "Data Not Found");
//         }
//     } else {
//         $result_data = array("status" => false, "message" => $conn->error);
//     }

//     echo json_encode($result_data);
// }

// function income_management($conn)
// {
//     extract($_POST);

//     $query = "call income_sp('$id','$user_id','$name','$amount','$category_id','$income_date', '$type')";
//     $result = $conn->query($query);

//     if ($result) {
//         $message = $result->fetch_assoc();
//         if (is_array($message) && in_array('message', $message)) {
//             $data = array(('status') => true, ('message') => $message['message']);
//         } else {
//             $data = array(('status') => true, ('message') => $message);
//         }
//     } else {
//         $data = array(('status') => false, ('message') => $conn->error);
//     }

//     echo json_encode($data);
// }
