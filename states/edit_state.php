<?php include "../include/header.php";
ob_start();
error_reporting(0);
global $conn;
$errors = array();
$id = $_GET['id'];

$sql1="SELECT * FROM `states`WHERE id='$id'";
$result1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_assoc($result1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//    $id = $_GET['id'];
    $isformValid = true;
    if (empty($_POST["country_id"])) {
        $isformValid = false;
        $errors["country_id"] = "country  is required";
    } else {
        $country_id = $_POST["country_id"];
    }
    if (empty($_POST["name"])) {
        $isformValid = false;
        $errors['name'] = "state  name is required";
    } else {
        $state = $_POST["name"];
            $dublicate = "SELECT name FROM states WHERE name ='$state' AND id!='$id'";
            $select = mysqli_query($conn, $dublicate);
            $row1 = mysqli_fetch_row($select);

            if ($row1 > 0) {
                $isformValid = false;
                $errors['name'] = "state  name is already exist";
            }
        }

    if (empty($_POST["status"])) {
        $isformValid = false;
        $errors["status"] = "status is required";
    } else {
        $status = $_POST["status"];
    }
    if ($isformValid=="true") {

        $sql2 = "UPDATE `states` SET `country_id`=' $country_id',`name`='$state',`status`='$status' WHERE id='$id'";
        if (mysqli_query($conn, $sql2)) {
            $_SESSION['SUCCESS_MESSAGE']= "updated  SUCCESSFULLY";
            header("location:manage_state.php");
            exit;
        }
    }
} else {
    $_POST = $row1;

}

?>

<header class="page-header">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h1 class="separator">Edit states</h1>
        </div>
    </div>
</header>
<section class="page-content container-fluid section">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Edit states</h5>
                <form action="" method="POST">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Select Country</label>
                                    <select class="form-control" name="country_id">

                                        <option value="">select country</option>
                                        <?php
                                        $sql = "SELECT * FROM `countries`";
                                        $result = mysqli_query($conn, $sql);
                                        $count = mysqli_num_rows($result);
                                        if ($count>0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $country = $row['country_name'];
                                                $id=$row['id'];
                                                ?>

                                                <option value="<?php echo $id;?>"<?php echo (!empty($_POST["country_id"]) && $_POST["country_id"]=="$id")?'selected="selected"': ""; ?>><?php echo $country; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="errors"><?php echo !empty($errors['country_id']) ? $errors['country_id'] : ""; ?> </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>states Name</label>
                                    <input type="text" class="form-control" name="name"
                                           value="<?php echo !empty($_POST["name"]) ? $_POST["name"]: ""; ?>"
                                           placeholder="Enter state Name ">
                                    <div class="errors"><?php echo !empty($errors['name']) ? $errors['name'] : ""; ?> </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option value=""> please select</option>
                                        <option value="Active"<?php echo !empty($_POST['status']) && $_POST['status'] == "Active" ? 'selected ="selected"' : ""; ?> >
                                            Active
                                        </option>
                                        <option value="Inactive"<?php echo !empty($_POST['status']) && $_POST['status'] == "Inactive" ? 'selected ="selected"' : ""; ?> >
                                            Inactive
                                        </option>
                                    </select>
                                    <div class="errors"><?php echo !empty($errors['status']) ? $errors['status'] : ""; ?> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">update</button>
                        <button type="submit" class="btn btn-secondary"><a
                                href="<?php echo WWW_BASE; ?>/states/manage_state.php">Cancel</a></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include "../include/footer.php"; ?>
