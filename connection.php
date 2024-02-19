<?php

require('constants.php');

$conn = new mysqli(SERVER, USERNAME, PASSWORD, DATABASE);

if($conn->connect_error){
    die('No connection. Error: '.$conn->connect_error);
}
?>