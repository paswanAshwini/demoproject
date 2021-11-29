<?php include "../include/header.php";
ob_start();
error_reporting(0);
global $conn;
$errors = array();
$id = $_GET['id'];
$sql="SELECT * FROM `countries`WHERE id='$id'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_GET['id'];
        $isformValid = true;
        if (empty($_POST["country_name"])) {
            $isformValid = false;
            $errors['country_name'] = "country  name is required";
        } else {
            $country_name = $_POST["country_name"];
            $dublicate = "SELECT country_name FROM countries WHERE country_name ='$country_name' AND id!='$id'";
            $select = mysqli_query($conn, $dublicate);
            $row1 = mysqli_fetch_row($select);

            if ($row1 > 0) {
                $isformValid = false;
                $errors['country_name'] = "country  name is already exist";
            }
        }

        if (empty($_POST["status"])) {
            $isformValid = false;
            $errors['status'] = "status  name is required";
        } else {
            $status = $_POST["status"];
        }

        if ($isformValid) {

            $sql1 = "UPDATE `countries` SET `country_name`='$country_name',`status`='$status' WHERE id='$id'";

            if (mysqli_query($conn, $sql1)) {
                $_SESSION['SUCCESS_MESSAGE'] = "update  SUCCESSFULLY";
                header("location:manage_country.php");
                exit();

            }

        }



    } else {
        $_POST = $row;

    }
?>
    <header class="page-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h1 class="separator">EDIT </h1>
                <nav class="breadcrumb-wrapper" aria-label="breadcrumb">
                </nav>
            </div>
        </div>
    </header>
    <section class="page-content container-fluid section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h5 class="card-header">Edit country</h5>
                    <form action="" method="POST">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Country Name</label>
                                        <input type="text" class="form-control" name="country_name" value="<?php echo !empty($_POST["country_name"]) ? $_POST["country_name"] : ""; ?>" placeholder="Enter Country Name ">
                                        <div class="errors"><?php echo !empty($errors['country_name']) ? $errors['country_name'] : ""; ?> </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" name="status">
                                            <option value="">Select Status</option>
                                            <option value="Active"<?php echo (!empty($_POST["status"]) && $_POST["status"] == 'Active' )? 'selected ="selected"' : ""; ?>>Active</option>
                                            <option value="Inactive"<?php echo (!empty($_POST["status"]) && $_POST["status"] == 'Inactive') ? 'selected ="selected"' : "";?>>Inactive</option>
                                        </select>
                                        <div class="errors"><?php echo !empty($errors['status']) ? $errors['status'] : ""; ?> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">update</button>
                            <a href="<?php echo WWW_BASE; ?>/country/manage_country.php"  class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


<?php include "../include/footer.php"; ?>