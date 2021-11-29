<?php include "../include/header.php";
ob_start();
global $conn;
$errors = array();
$id = $_GET['id'];
$sql="SELECT * FROM `categories`WHERE id='$id'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isformValid = true;
    if (!empty($_POST["parents_id"])) {
        $parents_id = $_POST["parents_id"];

    } else {
        $parents_id = 0;
    }

    if (empty($_POST["name"])) {
        $isformValid = false;
        $errors['name'] = "category  name is required";
    } else {
        $name = $_POST["name"];
        $dublicate = "SELECT `name` FROM `categories` WHERE `name`= '$name' AND `parents_id` = '$parents_id' AND id!='$id'";
        $select = mysqli_query($conn, $dublicate);
//        $row = mysqli_num_rows($select);
        if ( $row = mysqli_num_rows($select) > 0) {
            $isformValid = false;
            $errors['name'] = "category  name is already exist";
        }
//        }
    }

        // echo "<pre/>"; print_r($_FILES);die();

    if (!empty($_FILES["image"]["tmp_name"])) {
        // Check file size
        if ($_FILES["image"]["size"] > 1024 * 2 * 1024) {
            $errors['image'] = "Sorry, your file is too large.";
            $isformValid = false;
        }
    }


    if (empty($_POST["status"])) {
        $isformValid = false;
        $errors['status'] = "status is required";
    } else {
        $status = $_POST["status"];
    }

    if($isformValid) {
        $sql = "UPDATE `categories` SET `parents_id`='$parents_id',`name`='$name',`status`='$status'";
        if (!empty($_FILES["image"]["tmp_name"])){
            $image = $_FILES["image"]["name"];
            $target_dir = "uploadfile/";
            $target_dir = "uploadfile/";
            $extension = pathinfo($image, PATHINFO_EXTENSION);
            $uniquename = uniqid();
            $image_name = $uniquename . '.' . $extension;
            $target_file = $target_dir . $image_name;
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
            $sql .= ",`image`='$image_name'";
       }
        $sql.=" WHERE `id`='$id'";

        if(mysqli_query($conn, $sql)){
            $_SESSION['SUCCESS_MESSAGE'] = "Updated successfully";
            if(!empty($row['image']) && file_exists("uploadfile/".$row['image'])){
                @unlink("uploadfile/".$row['image']);
            }
        } else {
            $_SESSION['ERROR_MESSAGE'] = "Failed";
        }
        header("location:manage_category.php");
        exit;
    }

}
else {
    $_POST = $row;

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
                    <h5 class="card-header">Edit category</h5>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>parent category</label>
                                        <select name="parents_id" class="form-control">
                                            <option value="0">--root--</option>

                                            <?php
                                            function categoryTree($parents_id = 0, $sub_mark = ''){
                                                global $conn;
                                                $query = ("SELECT * FROM categories WHERE  parents_id = $parents_id ORDER BY name ASC");
                                                $result=mysqli_query($conn, $query);
                                                $data=mysqli_num_rows($result);
                                                if($data >0){
                                                    while( $row1=mysqli_fetch_assoc($result)){ ?>
                                                        <option value="<?php echo $row1['id'];?>"<?php echo !empty($_POST['parents_id']) && $_POST['parents_id'] == $row1['id'] ? ' selected="selected"' : ''; ?>> <?php echo $sub_mark . $row1['name']; ?></option>
                                                        <?php
                                                        categoryTree($row1['id'], $sub_mark.'-');
                                                    }
                                                }
                                            }
                                            ?>
                                            <?php categoryTree(); ?>
                                        </select>
                                        <div class="errors"><?php echo !empty($errors['parents_id']) ? $errors['parents_id'] : ""; ?> </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>category Name</label>
                                        <input type="text" class="form-control" name="name"  value="<?php echo(!empty($_POST["name"]) ? $_POST['name'] : ''); ?>" placeholder="Enter category Name" >
                                        <div class="errors"><?php echo !empty($errors['name']) ? $errors['name'] : ""; ?> </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>image</label>
                                        <input type="file" name="image"/>
                                        <img src ="<?php echo WWW_BASE."/categories/uploadfile/".$row['image'] ;?>">
                                        <span class="errors"><?php echo !empty($errors['image']) ? $errors['image'] : ""; ?></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" name="status">
                                            <option value=""> please select </option>
                                            <option value="Active"<?php echo !empty($_POST['status']) && $_POST['status'] == "Active" ? 'selected ="selected"' : ""; ?> >Active
                                            </option>
                                            <option value="Inactive"<?php echo !empty($_POST['status']) && $_POST['status'] == "Inactive" ? 'selected ="selected"' : ""; ?> >Inactive
                                            </option>
                                        </select>
                                        <div class="errors"><?php echo !empty($errors['status']) ? $errors['status'] : ""; ?> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Add</button>
                            <button type="submit" class="btn btn-secondary" ><a href="<?php echo WWW_BASE ;?>/categories/manage_category.php">Cancel</a></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php  include "../include/footer.php"; ?>