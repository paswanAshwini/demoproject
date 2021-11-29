<?php include "../include/header.php";
ob_start();
error_reporting(0);
global $conn;
$errors = array();
$id = $_GET['id'];
$sql1="SELECT * FROM `users`WHERE id='$id'";
$result1=mysqli_query($conn,$sql1);
$row1=mysqli_fetch_assoc($result1);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//echo "<pre/>"; print_r($_POST);die();
    $isformValid = true;
    if (empty($_POST["first_name"])) {
        $isformValid = false;
        $errors['first_name'] = "First name is required";
    } else {
        $firstname = $_POST["first_name"];
    }
    $isformValid = true;
    if (empty($_POST["last_name"])) {
        $isformValid = false;
        $errors['last_name'] = "last name is required";
    } else {
        $lastname = $_POST["last_name"];
    }

    if (empty($_POST["email"])) {
        $isformValid = false;
        $errors['email'] = "email  is required";
    }else{
        $email = $_POST["email"];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $isformValid = false;
            $errors['email'] = "not in valid format";
        }
    }
    if (!empty($_POST["email"])) {
        $email = $_POST["email"];
        $dublicate = "SELECT email FROM users WHERE email ='$email' AND id!='$id'";
        $select = mysqli_query($conn, $dublicate);
        $row = mysqli_fetch_row($select);

        if ($row > 0){

            $isformValid = false;
            $errors['email'] = "email is already exist";
        }

    }
    if (empty($_POST["status"])) {
        $isformValid = false;
        $errors["status"] = "status  is required";
    } else {
        $status = $_POST["status"];
    }

    if (empty($_POST["password"])) {
        $isformValid = false;
      //  $errors['password'] = "password is required";
    }else{
        $password = $_POST["password"];

        if (!empty($_POST["password"]) && ($_POST["password"])) {
            $password = $_POST["password"];

        } elseif (strlen($_POST["password"]) <= '8') {
            $errors['password'] = "Your Password Must Contain At Least 8 Characters!";
        } elseif (!preg_match("#[0-9]+#", $password)) {
            $errors['password'] = "Your Password Must Contain At Least 1 Number!";
        } elseif (!preg_match("#[A-Z]+#", $password)) {
            $errors['password'] = "Your Password Must Contain At Least 1 Capital Letter!";
        } elseif (!preg_match("#[a-z]+#", $password)) {
            $errors['password'] = "Your Password Must Contain At Least 1 Lowercase Letter!";
        }
    }

    if ((!empty($_POST["password"])) && (empty($_POST["confirmpassword"]))) {
        $isformValid = false;
        $errors['confirmpassword'] = "confirm password  is required";
    } else {
        $confirmpassword = $_POST["confirmpassword"];

    }

    if ((!empty($_POST["password"])) && (!empty($_POST["confirmpassword"]))) {
        if (($_POST["password"]) !== ($_POST["confirmpassword"])) {
            $isformValid = false;
            $errors['confirmpassword'] = "password is not matched";
        }
    }
    if (empty($_POST["country"])) {
        $isformValid = false;
        $errors["country"] = "country  is required";
    } else {

        $countryname = $_POST["country"];
    }
    if (empty($_POST["state"])) {
        $isformValid = false;
        $errors["state"] = "state  is required";
    } else {
        $state = $_POST["state"];
    }
    if (empty($_POST["city"])) {
        $isformValid = false;
        $errors["city"] = "city  is required";
    } else {
        $city = $_POST["city"];
    }
    if (empty($_POST["address"])) {
        $isformValid = false;
        $errors["address"] = "address  is required";
    } else {
        $address = $_POST["address"];
    }

    if ($isformValid) {
        // $pass=$_POST["password"];
        $icypass = md5($_POST["password"]);
        $newpassword = str_replace(' ', '', $icypass);

        $sql1="UPDATE `users` SET `first_name`='$firstname',`last_name`='$lastname',`email`=' $email',`status`='$status',`password`='$newpassword',`country`='$countryname',`state`='$state',`city`='$city',`address`='$address' WHERE id='$id'";
        if (mysqli_query($conn, $sql1)) {
            $_SESSION['SUCCESS_MESSAGE']= "updated  SUCCESSFULLY";
            header("location:manage_user.php");
            exit;
        }else{
            $_SESSION['ERROR_MESSAGE']= "FAILED TO update";
        }
    }
}
else {
    $_POST = $row1;
    $_POST['password'] = $row1[''];

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
                    <h5 class="card-header">edit user</h5>
                    <form action="" method="POST">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" class="form-control" name="first_name"
                                               placeholder="Enter  first name"
                                               value="<?php echo(!empty($_POST["first_name"]) ? $_POST['first_name'] : ''); ?>">
                                        <div class="errors"><?php echo !empty($errors['first_name']) ? $errors['first_name'] : ""; ?></div>
                                    </div>
                                </div>
                                <br>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" name="last_name"
                                               placeholder="Enter  last name"
                                               value="<?php echo(!empty($_POST["last_name"]) ? $_POST['last_name'] : ''); ?>">
                                        <div class="errors"><?php echo !empty($errors['last_name']) ? $errors['last_name'] : ""; ?></div>
                                    </div>
                                </div>
                                <br>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" name="email" placeholder="Enter  email"
                                               value="<?php echo(!empty($_POST["email"]) ? $_POST['email'] : ''); ?>">
                                        <div class="errors"><?php echo !empty($errors['email']) ? $errors['email'] : ""; ?></div>
                                    </div>
                                </div>
                                <br>
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
                                <br>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="password"
                                               placeholder="Enter  password"
                                               value="<?php echo(!empty($_POST["password"]) ? $_POST['password'] : ''); ?>">
                                        <div class="errors"><?php echo !empty($errors['password']) ? $errors['password'] : ""; ?></div>
                                    </div>
                                </div>
                                <br>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" class="form-control" name="confirmpassword"
                                               placeholder="Enter  confirmpassword"
                                               value="<?php echo(!empty($_POST["confirmpassword"]) ? $_POST['confirmpassword'] : ''); ?>">
                                        <div class="errors"><?php echo !empty($errors['confirmpassword']) ? $errors['confirmpassword'] : ""; ?></div>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Select Country</label>
                                        <select class="form-control" id="country-dropdown" name="country">

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

                                                    <option value="<?php echo $id; ?>"<?php echo (!empty($_POST["country"]) && $_POST["country"] == "$id") ? 'selected="selected"' : ""; ?>><?php echo $country; ?></option>
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
                                        <select class="form-control" id="state-dropdown" name="state">
                                            <option value="">select state</option>
                                        </select>
                                        <div class="errors"><?php echo !empty($errors['state']) ? $errors['state'] : ""; ?> </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>city Name</label>
                                        <select class="form-control" id="city-dropdown" name="city">
                                            <option value="">select city</option>
                                        </select>
                                        <div class="errors"><?php echo !empty($errors['city']) ? $errors['city'] : ""; ?> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <textarea class="form-control" name="address" placeholder="Enter address" value="" rows="3"><?php echo(!empty($_POST["address"]) ? $_POST["address"] : ''); ?></textarea>
                                <div class="errors"><?php echo !empty($errors["address"]) ? $errors["address"] : ""; ?></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">update</button>
                            <button type="submit" class="btn btn-secondary"><a
                                    href="<?php echo WWW_BASE; ?>/user/manage_user.php">Cancel</a></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php include "../include/footer.php";?>

<script>
    var selectedState = "";
    <?php if(!empty($_POST['state'])){?>
    selectedState = parseInt(<?php echo $_POST['state']; ?>);
    <?php } ?>
    function load() {
        var country_id = $('#country-dropdown').val();

        $.ajax({
            type: "POST",
            async:false,
            url: "../ajax/city-states-country.php",
            data: {
                id: country_id
            },
            success: function (result) {
                $("#state-dropdown").html(result);
                if (selectedState) {
                    $("#state-dropdown").val(selectedState);
                }
            }
        });
    }
    var selectedcity = "";
    <?php if(!empty($_POST['city'])){?>
    selectedcity = parseInt(<?php echo $_POST['city']; ?>);
    <?php } ?>
    function load1() {
        var state_id = $('#state-dropdown').val();

        $.ajax({
            url: "../ajax/city-states-country.php",
            type: "POST",
            data: {
                id1 : state_id
            },
            success: function (result1) {
                $("#city-dropdown").html(result1);
                if (selectedcity) {
                    $("#city-dropdown").val(selectedcity);
                }

            }
        });
    }

    $(document).ready(function () {
        load();
        load1();

        $('#country-dropdown').on('change', function () {
            load();
        });
        $('#state-dropdown').on('change', function () {
            load1();
        });
    });

</script>


