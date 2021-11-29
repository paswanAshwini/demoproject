<?php include "../include/header.php";
global $conn;
ob_start();
error_reporting(0);
$errors = array();
$id = $_GET['id'];
$sql1="SELECT * FROM `cities`WHERE id='$id'";
$result1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_assoc($result1);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isformValid = true;
    if (empty($_POST["country_id"])) {
        $isformValid = false;
        $errors["country_id"] = "country  is required";
    } else {
        $countryname = $_POST["country_id"];
    }
    if (empty($_POST["state_id"])) {
        $isformValid = false;
        $errors["state_id"] = "state  is required";
    } else {
        $state = $_POST["state_id"];
    }
    if (empty($_POST["city"])) {
        $isformValid = false;
        $errors["city"] = "city  is required";
    } else {
        $city = $_POST["city"];
        $dublicate = "SELECT city FROM cities WHERE city ='$city'";
        $select = mysqli_query($conn, $dublicate);
        $row = mysqli_num_rows($select);
        if ($row > 0) {
            $isformValid = false;
            $errors["city"] = "city  name is already exist";
        }
    }
    if (empty($_POST["status"])) {
        $isformValid = false;
        $errors["status"] = "status  is required";
    } else {
        $status = $_POST["status"];
    }
    if ($isformValid=="true") {
        $sql2="UPDATE `cities` SET `country_id`='$countryname',`state_id`='$state',`city`='$city',`status`=' $status' WHERE id='$id'";
        if (mysqli_query($conn, $sql2)) {
            $_SESSION['SUCCESS_MESSAGE']= "EDIT SUCCESSFULLY";
            header("location:manage_city.php");
            exit;
        }else{
            $_SESSION['ERROR_MESSAGE']= "FAILED TO add";
        }
    }
} else {
    $_POST = $row1;

}
?>


<div class="content">
    <header class="page-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h1 class="separator">Edit city</h1>
            </div>
        </div>
    </header>
    <section class="page-content container-fluid section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h5 class="card-header">Edit city</h5>
                    <form action="" method="POST">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Select Country</label>
                                        <select class="form-control" id="country-dropdown" name="country_id">

                                            <option value="">select country</option>
                                            <?php
                                            $sql = "SELECT *  FROM `countries`";
                                            $result = mysqli_query($conn, $sql);
                                            $count = mysqli_num_rows($result);

                                            if ($count > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $country = $row['country_name'];
                                                    $id = $row['id'];
                                                    ?>

                                                    <option value="<?php echo $id; ?>"<?php echo (!empty($_POST["country_id"]) && $_POST["country_id"] == "$id") ? 'selected="selected"' : ""; ?>><?php echo $country; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <div class="errors"><?php echo !empty($errors['country_id']) ? $errors['country_id'] : ""; ?> </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>states Name</label>
                                        <select class="form-control" id="state-dropdown" name="state_id">
                                            <option value="">select state</option>
                                            <option value=""></option>
                                        </select>
                                        <div class="errors"><?php echo !empty($errors['state_id']) ? $errors['state_id'] : ""; ?> </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>city Name</label>
                                        <input type="text" class="form-control" name="city" value="<?php echo !empty($_POST["city"]) ? $_POST["city"] : ""; ?>" placeholder="Enter city Name ">
                                        <div class="errors"><?php echo !empty($errors['city']) ? $errors['city'] : ""; ?> </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
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
                                    href="<?php echo WWW_BASE; ?>/city/manage_city.php">Cancel</a></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include "../include/footer.php"; ?>
<script>
    var selectedState ="";
    <?php if(!empty($_POST['state_id'])){?>
    selectedState = parseInt(<?php echo $_POST['state_id']; ?>);
    <?php } ?>
    function load(){
        var country_id = $('#country-dropdown').val();

        $.ajax({
            url: "../ajax/city-states-country.php",
            type: "POST",
            data: {
                id: country_id
            },
            success: function (result) {
                $("#state-dropdown").html(result);
                if( selectedState ){
                    $("#state-dropdown").val(selectedState);
                }

            }
        });
    }

    $(document).ready(function () {
        load();
        $('#country-dropdown').on('change', function () {
            load();
        });
    });

</script>
