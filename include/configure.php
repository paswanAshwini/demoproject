<?php
session_start();
// Create connection
$conn = new mysqli('localhost', 'root', '', 'registration');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);

}
if($_SERVER['HTTP_HOST'] == "localhost") {
    define('WWW_BASE', "http://localhost/registration");
    define('PATH_NAME' , "registration/");
}

function pre($array=[]){
    echo '<pre>';
    print_r($array);
    echo '<pre/>';
}
?>
