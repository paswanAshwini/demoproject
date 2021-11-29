<?php include "../include/configure.php";
global $conn;
$id=$_GET['id'];

    $sql = "DELETE  FROM `countries` WHERE id='$id'";
        if( mysqli_query($conn, $sql)){

            header("location:manage_country.php");
    }
$var_delete=$_SERVER['HTTP_REFERER'];
header("location:$var_delete");
exit;

?>



