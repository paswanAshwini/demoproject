<?php
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     echo "<pre>";print_r($_POST);
//     die();
// }
include "../include/header.php";
ob_start();
global $conn;
error_reporting(0);
$errors = array();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 $category = $_POST['category_id'];
    $product = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $slug = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST["name"])));
    $query = "INSERT INTO `products`(`category_id`, `name`,`description`, `price`,`slug`) VALUES ('$category','$product', '$description','$price','$slug')";
    mysqli_query($conn, $query);
    $last_id_product = mysqli_insert_id($conn);
    foreach ($_FILES["product_image"]['name'] as $key => $value) {
        $filename = $_FILES['product_image']['name'][$key]['image'];
        $filepath = $_FILES['product_image']['tmp_name'][$key]['image'];
        $target_dir = "uploadgallery/";
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $uniquename = uniqid();
        $image_name = $uniquename . '.' . $extension;
        $target_file = $target_dir . $image_name;
        move_uploaded_file($filepath, $target_file);
        $featured = $_POST['product_image'][$key]["featured"];
         $image_sql = "INSERT INTO `product_images`(`product_id`,`image`,`featured`) VALUES ('$last_id_product','$image_name','$featured')";
        mysqli_query($conn, $image_sql);
    }

 foreach ($_POST["attribute"] as $key => $value) {
        //echo $value['attribute_name']."<br>" ;
        $attribute_name = $value['attribute_name'];
        $sql = "INSERT INTO `product_attribute`(`product_id`,`attribute_name`) VALUES ('$last_id_product','$attribute_name')";
        mysqli_query($conn, $sql);
        $last_id = mysqli_insert_id($conn);
        foreach ($value['options'] as $option_key => $optionvalue) {
            //echo $option_value["name"]."<br>";
            //echo $option_value["value"];
            $option_name = $optionvalue["name"];
            $option_value = $optionvalue["value"];

            $sql1 = "INSERT INTO `product_attribute_options`(`attribute_id`,`option_key`, `option_value`) VALUES ('$last_id','$option_name','$option_value')";
            mysqli_query($conn, $sql1);
            $last_id = mysqli_insert_id($conn);


        }
}
  $_SESSION['SUCCESS_MESSAGE'] = "Add successfully";
    
}

?>


<header class="page-header">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h1 class="separator">Add products</h1>
        </div>
    </div>
</header>
<section class="page-content container-fluid section">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Add products</h5>
                <form id="form" action="" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><h3>category name</h3></label>
                                    <select  name="category_id"  id="category_id" class="form-control">
                                        <option value="">--select category--</option>
                                        <?php
                                        function categoryTree($parents_id = 0, $sub_mark = '')
                                        {
                                            global $conn;
                                            $query = ("SELECT * FROM categories WHERE  parents_id = $parents_id ORDER BY name ASC");
                                            $result = mysqli_query($conn, $query);
                                            $data = mysqli_num_rows($result);
                                            if ($data > 0) {
                                                while ($row1 = mysqli_fetch_assoc($result)) { ?>
                                                    <option value="<?php echo $row1['id']; ?>"<?php echo !empty($_POST['category_id']) && $_POST['category_id'] == $row1['id'] ? ' selected="selected"' : ''; ?>> <?php echo $sub_mark . $row1['name']; ?></option>
                                                    <?php
                                                    categoryTree($row1['id'], $sub_mark . '-');
                                                }
                                            }
                                        }
                                        ?>
                                        <?php categoryTree(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><h3>product Name </h3></label>
                                    <input type="text" class="form-control" name="name" id="name"
                                           value="<?php echo !empty($_POST["name"]) ? $_POST["name"] : ""; ?>"
                                           placeholder="Enter product Name ">

                                </div>

                            </div>

                        </div>
                        <label><h2>Description:</h2></label>
                       <!--  <div  class="form-control"> -->
                        <textarea name="description" id="editor1"></textarea>
                        <!-- </div> -->
                        <br>
                        <label><h2>Price:</h2></label>
                        <div class="col-md-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text">₹</span>
                            <input type="text" class="form-control" name="price" id="price"  placeholder="enter the amount">

                        </div>
                        </div>
                        <br>
                        <label><h2>Images:</h2></label>
                        <div class="imageSection">
<!--                            <div class="card-body">-->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="file"  class="form-control" name="product_image[0][image]" >
                                    </div>
                                        <div class="col-sm-3">
                                           <input type="checkbox"  name="product_image[0][featured]" class="mycheck" checked="checked"   value="1">
                                            <label class="checkbox"> is featured</label>
                                        </div>
                                    <button type="button" id="imagebtn" class="btn btn-info">Add</button>
                                </div>
                                   </div>
                        <br>
<!--                        </div>-->

                            <label><h2>Attribute:</h2></label>
                            <div class="attrioptionValue">
                            <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="attribute[0][attribute_name]"  id="attribute"  value=""
                                                   placeholder=" Attribute name">
                                        </div>

                                    </div>
                                    <button type="button" id="attributebtn" class="btn btn-info">Add</button>
                                </div>
                                <div class="addmoresection">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> Name </label>
                                            <input type="text" class="form-control" name="attribute[0][options][0][name]"  id="attributeName" placeholder="name">
                                        </div>

                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>value</label>
                                            <input type="text" class="form-control"  name="attribute[0][options][0][value]"   id="attributeValue" placeholder="value">

                                        </div>

                                    </div>


                                    <button type="button"  attrIndex="0"  optionIndex="1" class="btn btn-info addoption">Add more</button>
                                </div>
                                </div>

                        </div>
                    </div>
                   
                    </div>
                    <div class="card-footer">
                        <button type="submit" id="button" class="btn btn-success">Add</button>
                        <button type="submit" class="btn btn-secondary"><a href="<?php echo WWW_BASE; ?>/product/manage_product.php">Cancel</a></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
<style>
    .error {
        color: red;
    }
</style>
<script>
    $(document).ready(function () {
        $('#form').validate({
               ignore: [],
            rules: {
                "category_id": {
                    required: true
                },
               "name": {
                    required: true
                },
                "description" : {
                    required: true
                },
                "price": {
                    required: true
                },
                "product_image[0][image]": {
                    required: true
                },
                "attribute[0][attribute_name]": {
                    required: true
                },
                "attribute[0][options][0][name]": {
                    required: true
                },
                "attribute[0][options][0][value]": {
                    required: true
                },

            },

            messages: {
                "category_id": {
                    required: 'Please select category',
                },
                "name": {
                    required: 'Please enter product',
                },
                "description": {
                    required: 'Please fill the  description',
                },
                "price": {
                    required: 'Please enter price',
                },
                "product_image[0][image]": {
                    required: 'fill the  images',
                },
                "attribute[0][attribute_name]": {
                    required: 'Please enter attribute',
                },
                "attribute[0][options][0][name]": {
                    required: 'Please enter attribute name',
                },
                "attribute[0][options][0][value]": {
                    required: 'Please enter attribute value',
                },
            },
            submitHandler: function (form) {
                return true;

            }
        });
    });

</script>




<script>
    CKEDITOR.replace('editor1');
</script>


<script>
     $(document).ready(function() {

         var image_index=1;
         $("#imagebtn").click(function () {
             var input_image = ` <div class="row imagerow">
                                         <div class="col-sm-6">
                                            <input type="file"  class="form-control" name="product_image[${image_index}][image]">
                                         </div>
                                          <div class="col-sm-3">
                                           <input name="product_image[${image_index}][featured]" type="hidden" value="0">
                                           <input type="checkbox"name="product_image[${image_index}][featured]"class="mycheck" value="1">
                                           <label class="checkbox"> is featured</label>
                                          </div>
                                           <button type="button"  class="btn btn-danger removebtn">X</button>
                                         </div>`;

             var total = $(this).closest(".imageSection").find(".imagerow").length;

             if (total < 10) {
                 $(".imageSection").append(input_image);
                 image_index++;
             }

             else {
                 $.alert({
                     title: 'Alert!',
                     content: 'exceed the limit!',
                 });
             }
         });

         $(document).on('change', '.mycheck', function() {
           $('.mycheck').not(this).prop("checked", false);

         });

             $(".imageSection").on("click", ".removebtn", function () {
             $(this).parent('div').remove();
                 total--;
         });

         // var optionindex=1;
         // var value_index=1;

         $(document).on("click",".addoption",function () {

             var attributeIndex = $(this).attr('attrIndex');
             var optionIndex = $(this).attr('optionIndex');

             var valuename=` <div class="row row1">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> Name</label>
                                            <input type="text" class="form-control" name="attribute[${attributeIndex}][options][${optionIndex}][name]" placeholder="name">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> value </label>
                                            <input type="text" class="form-control" name="attribute[${attributeIndex}][options][${optionIndex}][value]"  placeholder="value">
                                        </div>
                                    </div>
                                    <button type="button"  class="btn btn-danger cancelbtn">X</button>
                                </div>`;

             var total = $(this).closest(".addmoresection").find(".row1").length;

             if (total < 10) {
                 $(this).closest(".addmoresection").append(valuename);
                 optionIndex++;
                 $(this).attr('optionIndex',optionIndex);

                 // name_index++;
                 // value_index++;
             }
             else {
                 $.alert({
                     title: 'Alert!',
                     content: 'exceed the limit!',
                 });
             }
             $(".addmoresection").on("click", ".cancelbtn", function () {
                 $(this).closest('div').remove();
                 total--;

             });

         });


         var attrIndex=1;
         $("#attributebtn").click(function () {
             var input_attribute = `<div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <input type="text" value="" class="form-control" name="attribute[${attrIndex}][attribute_name]"
                                                   placeholder=" Attribute name">
                                        </div>
                                    </div>
                                    <button type="button"  class="btn btn-danger deletebtn">X</button>
                                </div>

                                <div class="addmoresection">
                                    <div class="row row1">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label> Name</label>
                                                <input type="text" class="form-control" name="attribute[${attrIndex}][options][0][name]" placeholder="name">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label> value </label>
                                                <input type="text" class="form-control"  name="attribute[${attrIndex}][options][0][value]" placeholder="value">
                                            </div>
                                        </div>
                                        <button type="button"  attrIndex="${attrIndex}"  optionIndex="1" name="attribute[${attrIndex}][attribute_name]"  class="btn btn-warning addoption ">Add attribute</button>

                                    </div>
                                    </div>
                                </div>
                            </div>`;
             var total_attribute = $(this).closest(".attrioptionValue").find(".card").length;

             if (total_attribute <= 10) {
                 $(".attrioptionValue").append(input_attribute);
                 attrIndex++;
             } else {
                 $.alert({
                     title: 'Alert!',
                     content: 'exceed the limit!',
                 });
             }

             $(".attrioptionValue").on("click", ".deletebtn", function () {
                 $(this).closest('.card').remove();
                 total_attribute--;
             });
         });




     });


</script>



<?php include "../include/footer.php"; ?>
