<?php
include "../include/configure.php";
global $conn;
if(isset($_POST["id"])){
$id = $_POST["id"];
$sql="SELECT * FROM states WHERE country_id='$id'";
$result = mysqli_query($conn,$sql);
?>
    <option value="">Select State</option>
<?php
while($row = mysqli_fetch_assoc($result)) {
    ?>
    <option value="<?php echo $row["id"];?>"><?php echo $row["name"];?></option>
    <?php
}
}
if(isset($_POST["id1"])){
$id1 = $_POST["id1"];
$sql1="SELECT * FROM cities WHERE state_id='$id1'";
$result1 = mysqli_query($conn,$sql1);
?>
<option value="">Select city</option>
<?php
while($row1 = mysqli_fetch_assoc($result1)) {
    ?>
    <option value="<?php echo $row1["id"];?>"><?php echo $row1["city"];?></option>
    <?php
}
}

?>
