<?php include "../include/header.php";
ob_start();
global $conn;
$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

//echo "<pre/>"; print_r($_POST);die();

    $isformValid = true;
    if (empty($_POST["country_name"])) {

        $isformValid = false;
        $errors['country_name'] = "country  name is required";
    } else {
//        if (!empty($_POST["country_name"])) {
        $country_name = $_POST["country_name"];
        $dublicate = "SELECT country_name FROM countries WHERE country_name ='$country_name'";
        $select = mysqli_query($conn, $dublicate);
        $row = mysqli_fetch_row($select);

        if ($row > 0) {
            $isformValid = false;
            $errors['country_name'] = "country  name is already exist";
        }
//        }
    }

    if (empty($_POST["status"])) {
        $isformValid = false;
        $errors['status'] = "status is required";
    } else {
        $status = $_POST["status"];
    }

    if ($isformValid) {

        $sql = "INSERT INTO `countries`(`country_name`, `status`) VALUES ('$country_name','$status')";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['SUCCESS_MESSAGE'] = "added  SUCCESSFULLY";
            header("location:manage_country.php");
            exit;
        } else {
            $_SESSION['ERROR_MESSAGE'] = "FAILED TO add";
        }
    }
}

?>
<header class="page-header">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
        </div>

    </div>
</header>
<section class="page-content container-fluid section">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Add country</h5>
                <form action="" method="POST">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Country Name</label>
                                    <input type="text" class="form-control" name="country_name"
                                           value="<?php echo !empty($_POST["country_name"]) ? $_POST["country_name"] : ""; ?>"
                                           placeholder="Enter Country Name ">
                                    <div class="errors"><?php echo !empty($errors['country_name']) ? $errors['country_name'] : ""; ?> </div>
                                </div>
                            </div>
                            <div class="col-md-6">
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
                        <button type="submit" class="btn btn-success">Add</button>
                        <button type="submit" class="btn btn-secondary"><a
                                    href="<?php echo WWW_BASE; ?>/country/manage_country.php">Cancel</a></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include "../include/footer.php"; ?>
