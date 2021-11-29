<?php
// Create connection
$conn = new mysqli('localhost', 'root', '', 'registration');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);

}

// $firstnameErr=$lastnameErr=$emailErr=$passwordErr=$cpasswordErr=$genderErr=$courseErr=$qualificationErr=$yrs_of_qualifyErr="";
$errros = array();
if ($_SERVER["REQUEST_METHOD"] == "POST")
 {
    //echo "<pre/>"; print_r($_POST);die();
    $isformValid = true;
    if (empty($_POST["first_name"])) {
        $isformValid = false;
        $errros['first_name'] = "First name is required";
    } else {
        $fname = $_POST["first_name"];
    }

    /////// last name vali9dation////////

    if (empty($_POST["last_name"])) {
        $isformValid = false;
        $errros['last_name'] = "Last name is required";
    } else {
        $lname = $_POST["last_name"];
    }

    /////// email validation///////

    if (empty($_POST["email"])) {
        $isformValid = false;
        $errros['email'] = "email  is required";
    } else {
        $email = $_POST["email"];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errros['email'] = "not in valid format";
        }
    }

    ///////// password validation///////

    if (empty($_POST["password"])) {
        $isformValid = false;
        $errros['password'] = "password is required";
    } else {
        $pass = $_POST["password"];

        if (!empty($_POST["password"])&& ($_POST["password"])) {
            $pass = $_POST["password"];

        } elseif (strlen($_POST["password"]) <= '8') {
            $errros['password'] = "Your Password Must Contain At Least 8 Characters!";
        } elseif (!preg_match("#[0-9]+#", $pass)) {
            $errros['password'] = "Your Password Must Contain At Least 1 Number!";
        } elseif (!preg_match("#[A-Z]+#", $pass)) {
            $errros['password'] = "Your Password Must Contain At Least 1 Capital Letter!";
        } elseif (!preg_match("#[a-z]+#", $pass)) {
            $errros['password'] = "Your Password Must Contain At Least 1 Lowercase Letter!";
        }
    }



    /////// confirm password validation////////

    if (empty($_POST["cpassword"])) {
        $isformValid = false;
        $errros['cpassword'] = "confirm password  is required";
    } else {
        $cpass = $_POST["cpassword"];

    }


    /////// check password and confirm password/////

    if ((!empty($_POST["password"])) && (!empty($_POST["cpassword"]))) {
        if (($_POST["password"]) !== ($_POST["cpassword"])) {
            $isformValid = false;
            $errros['cpassword'] = "password is not matched";
        }
    }


    ////////  gender validation///////
    if (empty($_POST["gender"])) {
        $isformValid = false;
        $errros['gender'] = "gender is required";
    } else {
        $gender = $_POST["gender"];
    }

    ////// image validation//////

    if (empty($_FILES["image"]["tmp_name"])) {
        $isformValid = false;
        $errros['image'] = "image is required";
    } else {

        // echo "<pre/>"; print_r($_FILES);die();

        $image = $_FILES["image"]["name"];

        $target_dir = "upload/";
        $extension = pathinfo($image, PATHINFO_EXTENSION);
        $uniquename = uniqid();
        $image_name = $uniquename . '.' . $extension;
        $target_file = $target_dir . $image_name;

        // Check file size
        if ($_FILES["image"]["size"] > 1024 * 2 * 1024) {
            $errros['image'] = "Sorry, your file is too large.";

        }
        // Allow certain file formats
        if ($extension != "jpg" && $extension != "png" && $extension != "jpeg" && $extension != "gif") {
            $errros['image'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }
    }

    /////// hobby validation///////

    if (empty($_POST["hobby"])) {
        $isformValid = false;
        $errros['hobby'] = "hobby is required";
    } else {
        $hobby = $_POST["hobby"];
    }

    /////// course validation//////

    if (empty($_POST["course"])) {
        $isformValid = false;
        $errros['course'] = "course is required";
    } else {
        $course = $_POST["course"];
    }

    // ////// qualification validation//////

    if (empty($_POST["qualify"])) {
        $isformValid = false;
        $errros['qualify'] = "qualification is required";
    } else {
        $qualify = $_POST["qualify"];
    }

    /////  yrs of qualification////

    if (empty($_POST["yrs_of_qualify"])) {
        $isformValid = false;
        $errros['yrs_of_qualify'] = "year of qualification is required";
    } else {
        $yr_of_qualify = $_POST["yrs_of_qualify"];
    }

    if ($isformValid) {
        // $pass=$_POST["password"];
    $icypass=md5($_POST["password"]);
    $newpass= str_replace(' ', '',  $icypass);
//echo 'qqqq'.$newpass.'qqqq';

        // $hobby=$_POST["hobby"];
       $hobbies = implode(",", $hobby);

        if (move_uploaded_file($_FILES["image"]["tmp_name"],$target_file)) {
            // echo "The file  has been uploaded.";

            $sql = "INSERT INTO `register`(`first_name`, `last_name`, `email`, `password`, `gender`,`images`, `hobbies`, `course`, `qualification`, `yrs_of_qualification`) VALUES (' $fname','  $lname','$email','$newpass',' $gender','$image_name ','$hobbies',' $course','$qualify','$yr_of_qualify')";

            if (mysqli_query($conn, $sql)) {
                 'inserted successfully';
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        } else {
            $errros['image'] = "Sorry, there was an error uploading your file.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>registration form</title>
    <style>
        .error {
            color: red;
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<br>
<div class="container">
    <center>
        <h1 style="color:red;"> Registration form</h1>
    </center>
    <form action="" method="POST" enctype="multipart/form-data">
        <!-- FIRST NAME -->
        <h5 style="color: blue;">First name:*</h5>
        <input type="text" class="form-control" name="first_name" placeholder="Enter  first name"
               value="<?php echo(!empty($_POST["first_name"]) ? $_POST['first_name'] : ''); ?>">
        <span class="error"><?php echo !empty($errros['first_name']) ? $errros['first_name'] : ""; ?></span><br>

        <!-- LAST NAME -->
        <h5 style="color: blue;">Last name:*</h5>
        <input type="text" class="form-control" name="last_name" placeholder="Enter last name"
               value="<?php echo(!empty($_POST["last_name"]) ? $_POST['last_name'] : ''); ?>">
        <span class="error"><?php echo !empty($errros['last_name']) ? $errros['last_name'] : ""; ?></span><br>

        <!-- EMAIL -->
        <h5 style="color: blue;">Email:*</h5>
        <input type="text" class="form-control" name="email" placeholder="Enter email"
               value="<?php echo(!empty($_POST["email"]) ? $_POST['email'] : ''); ?>">
        <span class="error"><?php echo !empty($errros['email']) ? $errros['email'] : ""; ?></span><br>

        <!-- CONFIRM -->
        <h5 style="color: blue;">Password:*</h5>
        <input type="password" class="form-control" name="password" placeholder="Enter password"
               value="<?php echo(!empty($_POST["password"]) ? $_POST['password'] : ''); ?>">
        <span class="error"><?php echo !empty($errros['password']) ? $errros['password'] : ""; ?></span><br>

        <!-- confirm password -->
        <h5 style="color: blue;">Confirm Password:*</h5>
        <input type="password" class="form-control" name="cpassword" placeholder="Enter confirm password"
               value="<?php echo(!empty($_POST["cpassword"]) ? $_POST['cpassword'] : ''); ?>">
        <span class="error"><?php echo !empty($errros['cpassword']) ? $errros['cpassword'] : ""; ?></span><br>

        <!-- GENDER -->
        <h5 style="color: blue;">Gender:*</h5>
        <div class="form-check">
            <input type="radio" class="form-check-input" name="gender" value="Male"<?php echo (!empty($_POST["gender"]) && $_POST["gender"] == "Male") ? 'checked="checked"' : ''; ?>>Male<br>
            <input type="radio" class="form-check-input" name="gender" value="Female"<?php echo (!empty($_POST["gender"]) && $_POST["gender"] == "Female") ? 'checked="checked"' : ''; ?>>Female<br>
            <input type="radio" class="form-check-input" name="gender" value="transgender"<?php echo (!empty($_POST["gender"]) && $_POST["gender"] == "transgender") ? 'checked="checked"' : ''; ?>>transgender<br>
            <span class="error"><?php echo !empty($errros['gender']) ? $errros['gender'] : ""; ?></span><br>
        </div>
        <br>
        <!-- HOBBY -->
        <div>
            <h5 style="color: blue;">hobby:*</h5>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="hobby[]" value="cricket" <?php echo (!empty($_POST["hobby"]) && in_array('cricket', $_POST["hobby"])) ? 'checked="checked"' : ''; ?>>cricket
                </label>
            </div>

            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="hobby[]" value="football"<?php echo (!empty($_POST["hobby"]) && in_array('football', $_POST["hobby"])) ? 'checked="checked"' : ''; ?>>football
                </label>
            </div>

            <div class="form-check">
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="hobby[]" value="hockey"<?php echo (!empty($_POST["hobby"]) && $_POST["hobby"]) ? 'checked="checked"' : ''; ?>>hockey
                </label>
            </div>
            <span class="error"><?php echo !empty($errros['hobby']) ? $errros['hobby'] : ""; ?></span><br>
        </div>
        <br>
        <!-- images -->
        <div>
            <h5 style="color: blue;">images:*</h5>
            <input type="file" name="image"/>
            <span class="error"><?php echo !empty($errros['image']) ? $errros['image'] : ""; ?></span>
        </div>
        <br>
        <!-- COURSE -->
        <div class="form-group">
            <h5 style="color: blue;">Courses:*</h5>
            <select class="form-control" name="course">
                <option value="">--select--</option>
                <option value="B.TECH"<?php echo (!empty($_POST["course"]) && $_POST["course"] == "B.TECH") ? 'selected="selected"' : ''; ?>>
                    B.TECH
                </option>
                <option value="MBBS"<?php echo (!empty($_POST["course"]) && $_POST['course'] == "MBBS") ? 'selected="selected"' : ''; ?>>
                    MBBS
                </option>
                <option value="MBA"<?php echo (!empty($_POST["course"]) && $_POST['course'] == "MBA") ? 'selected="selected"' : ''; ?>>
                    MBA
                </option>
                <option value="MCA"<?php echo (!empty($_POST["course"]) && $_POST['course'] == "MCA") ? 'selected="selected"' : ''; ?> >
                    MCA
                </option>

            </select>
            <span class="error"><?php echo !empty($errros['course']) ? $errros['course'] : ""; ?></span><br>

        </div>
        <br>

        <!-- QUALIFICATION -->
        <div class="form-group">
            <h5 style="color: blue;">qualification:*</h5>
            <select class="form-control" name="qualify">
                <option value="">--select--</option>
                <option value="Graduate"<?php echo (!empty($_POST["qualify"]) && $_POST["qualify"] == "Graduate") ? 'selected="selected"' : ''; ?> >
                    Graduate
                </option>
                <option value="Post graduation" <?php echo (!empty($_POST["qualify"]) && $_POST["qualify"] == "Post graduation") ? 'selected="selected"' : ''; ?> >
                    Post graduation
                </option>
                <option value="Undergraduate"<?php echo (!empty($_POST["qualify"]) && $_POST["qualify"] == "Undergraduate") ? 'selected="selected"' : ''; ?> >
                    Undergraduate
                </option>
                <option value="Diploma" <?php echo (!empty($_POST["qualify"]) && $_POST["qualify"] == " Diploma") ? 'selected="selected"' : ''; ?> >
                    Diploma
                </option>
            </select>
            <span class="error"><?php echo !empty($errros['qualify']) ? $errros['qualify'] : ""; ?></span><br>
        </div>
        <br>

        <!-- YEARS OF QUALIFICATION -->
        <div class="container">
            <h5 style="color: blue;"> Years of Qualification:*</h5>
            <select name="yrs_of_qualify"
                    value="<?php echo(!empty($_POST["yrs_of_qualify"]) ? $_POST['yrs_of_qualify'] : ''); ?>">
                <option value="">--select--</option>
                <?php for ($i = 1996; $i <= date("Y"); $i++) { ?>
                    <option value="<?php echo $i; ?>" <?php echo (!empty($_POST["yrs_of_qualify"]) && $_POST["yrs_of_qualify"] == "$i") ? 'selected="selected"' : ''; ?> > <?php echo $i; ?></option>
                <?php } ?>
            </select>
            <span class="error"><?php echo !empty($errros['yrs_of_qualify']) ? $errros['yrs_of_qualify'] : ""; ?></span><br>
            <div>
                <br>
                <button type="submit" class="btn btn-success" name="submit">Submit</button>
    </form>
</div>
</body>
</html>