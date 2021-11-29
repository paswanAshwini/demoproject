
<?php include "../include/configure.php";
global $conn;
if(!empty($_GET['status']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    if ($status == "Active") {
        $status = "Inactive";
    } else {
        $status = "Active";
    }
    $sql = "UPDATE `cities` SET `status`='$status' WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    mysqli_query($conn, $sql);
    $_SESSION['SUCCESS_MESSAGE'] = "UPDATE  SUCCESSFULLY";


}  else {
    $_SESSION['ERROR_MESSAGE'] = "  failed to update";

}
$var_status=$_SERVER['HTTP_REFERER'];
header("location:$var_status");
exit;

?>

