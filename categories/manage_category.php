<?php include "../include/header.php";
global $conn;
ob_start();
?>
<?php
$limit = 3;
if (!empty($_GET['limit'])) {
    $limit = $_GET["limit"];
}
//$page=$_GET['page'];
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = "1";
}
$offset = ($page - 1) * $limit;
$sql = "SELECT * FROM `categories`";
if (!empty($_GET['search'])) {
$search = $_GET["search"];
  $sql .= " WHERE parents_id LIKE '%$search%' OR name LIKE '%$search%'";
} else {
    $search ="";
}
$orderBy = !empty($_GET["orderby"]) ? $_GET["orderby"] : "name";
$order = !empty($_GET["order"]) ? $_GET["order"] : "asc";

 $sql .= " ORDER BY " . $orderBy . " " . $order;

$Category = "asc";
$parents = "asc";
$status = "asc";

if ($orderBy == "name" && $order == "asc") {
    $Category = "desc";
}
if ($orderBy == "parents_id" && $order == "asc") {
    $parents = "desc";
}

if ($orderBy == "status" && $order == "asc") {
    $status = "desc";
}
$result = mysqli_query($conn, $sql);

$total_records = mysqli_num_rows($result);

$total_page = ceil($total_records / $limit);

$sql .= " LIMIT  $offset , $limit";
$result = mysqli_query($conn, $sql);

function categoryTree($parents_id = 0, $array=array()){
    global $conn;
    $query = ("SELECT * FROM categories WHERE id = $parents_id ");
    $result=mysqli_query($conn, $query);
    $data=mysqli_num_rows($result);
    if($data >0) {
        while($row1 = mysqli_fetch_assoc($result)) {
            $array[] = $row1["name"];
            if($row1['parents_id']) {
                return categoryTree($row1['parents_id'], $array);

            }
        }
    }
    return $array;
}
?>
<div class="content">
    <header class="page-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h1 class="separator">Manage Category</h1>

                <nav class="breadcrumb-wrapper" aria-label="breadcrumb"></nav>
            </div>
        </div>
    </header>
    <section class="page-content container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body card_table_body">
                        <div class="card-header">
                            <form method="get" action="#"
                                  id="AjaxSearch">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row search_box align-items-center">
                                            <div class="col-sm-12 col-md-3 limit_box">
                                                    <label>
                                                        Show
                                                        <select id="LimitOptions" name="limit"
                                                                class="form-control form-control-sm">
                                                            <option value="3"<?php echo $limit == '3' ? 'selected="selected"' : ''; ?>>
                                                                3
                                                            </option>
                                                            <option value="5"<?php echo $limit == '5' ? 'selected="selected"' : ''; ?>>
                                                                5
                                                            </option>
                                                            <option value="10"<?php echo $limit == '10' ? 'selected="selected"' : ''; ?>>
                                                                10
                                                            </option>
                                                            <option value="15"<?php echo $limit == '15' ? 'selected="selected"' : ''; ?>>
                                                                15
                                                            </option>
                                                            <option value="20"<?php echo $limit == '20' ? 'selected="selected"' : ''; ?>>
                                                                20
                                                            </option>
                                                            <option value="30"<?php echo $limit == '30' ? 'selected="selected"' : ''; ?>>
                                                                30
                                                            </option>
                                                            <option value="40"<?php echo $limit == '40' ? 'selected="selected"' : ''; ?>>
                                                                40
                                                            </option>

                                                        </select>
                                                        Entries
                                                    </label>
                                            </div>
                                            <div class="col-sm-12 col-md-6 offset-md-3 float-right">

                                                <div class="input-group">
                                                    <input class="form-control" name="search" type="text"
                                                           placeholder="Search..."
                                                           value="<?php echo !empty($_GET["search"]) ? $_GET["search"] : ""; ?>">
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-success">Search</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Sl no.</th>
                                    <th>
                                        <a href="manage_category.php?orderby=name&order=<?php echo $Category; ?>&limit=<?php echo $limit; ?>&page=<?php echo $page; ?>&search=<?php echo $search; ?>">Category</a><i
                                                class="la <?php echo($orderBy == 'name' ? ($order == 'asc' ? 'la-sort-asc' : 'la-sort-desc') : 'la-sort'); ?>"></i>
                                    </th>
                                    <th>
                                        <a href="manage_category.php?orderby=parents_id&order=<?php echo $parents; ?>&limit=<?php echo $limit; ?>&page=<?php echo $page; ?>&search=<?php echo $search; ?>">parents</a><i
                                                class="la <?php echo($orderBy == 'parents_id' ? ($order == 'asc' ? 'la-sort-asc' : 'la-sort-desc') : 'la-sort'); ?>"></i>
                                    </th>
                                    <th>
                                        <a href="#">image</a><i
                                                class="la la-sort"></i>
                                    </th>
                                    <th>
                                        <a href="manage_category.php?orderby=status&order=<?php echo $status; ?>&limit=<?php echo $limit; ?>&page=<?php echo $page; ?>&search=<?php echo $search; ?>">status</a><i
                                                class="la <?php echo($orderBy == 'status' ? ($order == 'asc' ? 'la-sort-asc' : 'la-sort-desc') : 'la-sort'); ?>"></i>
                                    </th>
                                    <th class="text-right">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <?php
                                    $serial = 1;
                                    $serial = ($page - 1) * $limit + 1;
                                    $count = mysqli_num_rows($result);
                                    if ($count) {
                                    while ($row = mysqli_fetch_assoc($result)){
                                    $id = $row['id'];
                                    $category = $row['name'];
                                    $image = $row['image'];
                                    $status = $row['status'];

                                    ?>
                                    <td align="center"><?php echo $serial++; ?></td>
                                    <td><?php echo $category ?></td>
                                    <td>
                                        <?php
                                       $parentcategories = categoryTree($row['parents_id']);
                                        $xyz="";
                                   // print_r($parentcategories);
                                        if(!empty($parentcategories)) {
                                            $reverse = array_reverse($parentcategories);
                                          //  print_r($reverse);
                                            foreach ($reverse as $value) {
                                                $xyz .= $value;
                                                $xyz .="<br>|<br>";

                                            }
                                            $xyz=rtrim($xyz);

                                        }

                                            else{
                                                $xyz="root" ;
                                            }
                                        echo $xyz;
                                        ?>

                                    </td>
                                    <td><img src =<?php echo WWW_BASE."/categories/uploadfile/".$row['image'] ;?> </td>
                                    <td align="center">

                                        <a href="status_category.php?status=<?php echo $status; ?>&id=<?php echo $id; ?>&page=<?php echo $page; ?>"><span
                                                    class="badge <?php echo $status == "Active" ? "badge-success" : "badge-danger"; ?>"><?php echo $status; ?></span></a>
                                    </td>

                                    <td align="right">
                                        <a href="edit_category.php?id=<?php echo $id; ?>" class="btn btn-success btn-sm"><i
                                                    class="la la-pencil"></i> Edit</a>

                                        <a href="#" class="btn btn-danger btn-sm"
                                           onclick="myfuction(<?php echo $row['id']; ?>)"><i class="la la-pencil "></i>Delete</a>
                                    </td>
                                </tr>
                                <?php
                                }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-5 pl-4">
                                <div class="dataTables_info" id="bs4-table_info" role="status" aria-live="polite">
                                    <!--                                        Page 1 of 1, showing 2 record(s) out of 2 total-->
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="bs4-table_paginate">
                                    <ul class="pagination float-right m-0" role="navigation">
                                        <?php
                                        if ($page > 1) { ?>
                                            <li class="page-item" aria-disabled="true" aria-label="« Previous"><a
                                                        href="manage_category.php?page=<?php echo($page - 1); ?>&limit=<?php echo $limit; ?>&search=<?php echo $search; ?>">
                                                    <span class="page-link" aria-hidden="true">Prev</span>
                                            </li>
                                        <?php } ?>

                                        <?php

                                        for ($i = 1; $i <= $total_page; $i++) { ?>

                                            <li class="page-item <?php echo ($page == "$i") ? 'active' : ''; ?>"
                                                aria-current="page"><a
                                                        href="manage_category.php?page=<?php echo $i; ?>&limit=<?php echo $limit; ?>&search=<?php echo $search; ?>"><span
                                                            class="page-link"><?php echo $i; ?></span></a></li>

                                        <?php } ?>
                                        <?php
                                        if ($total_page > $page) { ?>
                                            <li class="page-item " aria-disabled="true" aria-label="Next »"><a
                                                        href="manage_category.php?page=<?php echo($page + 1); ?>&limit=<?php echo $limit; ?>&search=<?php echo $search; ?>">
                                                    <span class="page-link" aria-hidden="true">Next</span></a></li>

                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include "../include/footer.php"; ?>

<script>
    function myfuction(id) {
        $.confirm({
            title: 'Delete!',
            content: 'Are you sure you want to delete it',
            buttons: {
                confirm: function () {
                    window.location.href = "delete_category.php?id=" + id
                },
                cancel: function () {

                },

            }
        });
    }
</script>
<script>

    $(document).ready(function () {
        $('#LimitOptions').on('change', function () {
            this.form.submit();
        });
    });
</script>