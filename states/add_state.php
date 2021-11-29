<?php include "../include/header.php";
ob_start();
global $conn;
$errors = array();

$sql = "SELECT *  FROM `countries`";
$result = mysqli_query($conn, $sql);
$count = mysqli_num_rows($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isformValid = true;
if (empty($_POST["country"])) {
    $isformValid = false;
    $errors["country"] = "country  is required";
} else {
    $countryname = $_POST["country"];
}
if (empty($_POST["name"])) {
    $isformValid = false;
    $errors['name'] = "state  name is required";
} else {
    $state = $_POST["name"];
    $dublicate = "SELECT name FROM states WHERE name ='$state'";
    $select = mysqli_query($conn, $dublicate);
    $row = mysqli_fetch_row($select);

    if ($row > 0) {
        $isformValid = false;
        $errors['state'] = "state  name is already exist";
    }
}

if (empty($_POST["status"])) {
    $isformValid = false;
    $errors["status"] = "status is required";
} else {
    $status = $_POST["status"];
}
 if ($isformValid=="true") {

   $sql1 = "INSERT INTO `states`(`country_id`, `name`, `status`) VALUES ('$countryname','$state','$status')";

        if (mysqli_query($conn, $sql1)) {
            $_SESSION['SUCCESS_MESSAGE']= "added  SUCCESSFULLY";
            header("location:manage_state.php");
            exit;
        }else{
            $_SESSION['ERROR_MESSAGE']= "FAILED TO add";
        }
    }
}

?>

<header class="page-header">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h1 class="separator">Add states</h1>
        </div>
    </div>
</header>
<section class="page-content container-fluid section">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Add states</h5>
                <form action="" method="POST">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Select Country</label>
                                    <select class="form-control" name="country">

                                        <option value="">select country</option>
                                        <?php
                                        if ($count>0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                        $country = $row['country_name'];
                                        $id=$row['id'];
                                        ?>

                                        <option value="<?php echo $id;?>"<?php echo (!empty($_POST["country"]) && $_POST["country"]== "$id")?'selected="selected"': ""; ?>><?php echo $country; ?></option>
                                        <?php
                                        }
                                        }
                                        ?>
                                    </select>
                                    <div class="errors"><?php echo !empty($errors['country']) ? $errors['country'] : ""; ?> </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>states Name</label>
                                    <input type="text" class="form-control" name="name"
                                           value="<?php echo !empty($_POST["name"]) ? $_POST["name"] : ""; ?>"
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
                                </div>
                            </div>
                            <div class="errors"><?php echo !empty($errors['status']) ? $errors['status'] : ""; ?> </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Add</button>
                        <button type="submit" class="btn btn-secondary"><a
                                    href="<?php echo WWW_BASE; ?>/states/manage_state.php">Cancel</a></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include "../include/footer.php"; ?>



<script>
    function load(){
        var country_id = $('#country-dropdown').val();

        $.ajax({
            url: "../ajax/states-by-country.php",
            type: "POST",
            data: {
                id: country_id
            },
            success: function (result) {
                $("#state-dropdown").html(result);

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

