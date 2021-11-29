<?php include "../include/configure.php";
global $conn;
$id=$_GET['id'];

$sql = "DELETE  FROM `categories` WHERE id='$id'";
if( mysqli_query($conn, $sql)){

    header("location:manage_category.php");
}
$var_delete=$_SERVER['HTTP_REFERER'];
header("location:$var_delete");
exit;

?>




