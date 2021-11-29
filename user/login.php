<?php
include "include/login_header.php";
global $conn;
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isformValid='true';
    if($isformValid) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $icypass = md5($password);
        //ECHO "<pre>";print_r($_POST);die;
        $sql = "SELECT * FROM `register` where email ='$email' AND password ='$icypass'";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        if ($count == 1) {
            $user =  mysqli_fetch_assoc($result);
            if(!empty($_POST['remember'])){
                setcookie("user", $email, time()+60*60*24*365);
            }
            $_SESSION['SUCCESS_MESSAGE']= "LOGIN  SUCCESSFULLY";
            $_SESSION['user']= $user;
            header("location:dashboard.php");
            exit();
        }else{
            $_SESSION['ERROR_MESSAGE']= "FAILED TO LOGIN";
        }
    }
}
?>

    <form class="sign-in-form" action="" method="POST">
        <div class="card">
            <div class="card-body">
                <a href="#" class="brand text-center d-block m-b-20">
                    <img src="assets/img/qt-logo%402x.png" alt="QuantumPro Logo"/>
                </a>
                <h5 class="sign-in-heading text-center m-b-20">Sign in to your account</h5>
                <div class="form-group">
                    <label for="inputEmail" class="sr-only">Email address</label>
                    <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email">
                </div>

                <div class="form-group">
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password">
                </div>
                <div class="checkbox m-b-10 m-t-20">
                    <div class="custom-control custom-checkbox checkbox-primary form-check">
                        <input type="checkbox" class="custom-control-input" id="stateCheck1"  name ="remember" checked="">
                        <label class="custom-control-label" for="stateCheck1" > Remember me</label>
                    </div>
                    <a href="#" class="float-right">Forgot Password?</a>
                </div>
                <button class="btn btn-primary btn-rounded btn-floating btn-lg btn-block" type="submit">Sign In
                </button>
                <p class="text-muted m-t-25 m-b-0 p-0">Don't have an account yet?<a href="userform.php">Create an
                        account</a></p>
            </div>

        </div>
    </form>

<?php include "include/login_footer.php"; ?>
