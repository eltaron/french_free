<?php
ob_start(); // Output Buffering Start
session_start();
$pageTitle = 'Category';
if (isset($_SESSION['username'])) {
    include 'inital.php';
    $sort= '';
        include 'includes/templates/header.php';
        include 'includes/templates/side.php';
    ?>
            <div class="main-panel ">
                <div class="content-wrapper ">
                    <div class="page-header ">
                        <h3 class="page-title ">
                            <span class="page-title-icon bg-gradient-primary text-white mr-2 ">
                                <i class="mdi mdi-home "></i>
                            </span>&nbsp; الأقسام
                        </h3>
                        <button style="margin-right:150px; color:darkblue;font-size:15px" type="button " class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#add">أضافة قسم</button>
                    </div>
                    <?php 
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['add'])) {
                        $name 	       = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                        $description   = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
                        $parent 	   = filter_var($_POST['parent'], FILTER_SANITIZE_NUMBER_INT);
                        $ordering      = filter_var($_POST['ordering'],FILTER_SANITIZE_NUMBER_INT);
                        // Upload Variables
                        $imgName  = $_FILES['image']['name'];
                        $imgSize  = $_FILES['image']['size'];
                        $imgTmp	  = $_FILES['image']['tmp_name'];
                        $imgType  = $_FILES['image']['type'];
                        // List Of Allowed File Typed To Upload
                        $imgAllowedExtension = array("jpg", "png", "gif");
                        // Get Avatar Extension
                        $imgs = explode('.', $imgName);
                        $imgExtension = strtolower(end($imgs));
                        if (isset($name)) {
                            if (strlen($name) < 4) {$formErrors[] = 'اسم القسم يجب ان يكون اكبر من 4 احرف';}
                        }
                        if (isset($description)) {
                            if (strlen($description) < 4) {$formErrors[] = 'وصف القسم يجب ان يكون اكبر من 4 ارقام';}
                        }
                        if (! empty($imgName) && ! in_array($imgExtension, $imgAllowedExtension)) {
                            $formErrors[] = 'امتداد الصورة هذا غير متوفر';
                        }
                        // Check If There's No Error Proceed The User Add
                        if (empty($formErrors)) {
                                $img = rand(0, 100000) . '_' . $imgName;
                                $uploads_dir = 'uploads';
                                move_uploaded_file($imgTmp, "$uploads_dir/$img");
                                // Insert Userinfo In Database
                                $stmt = $con->prepare("INSERT INTO 
                                    category(category_name, category_description, parent, ordering, image)
                                VALUES(:zname, :zdesc, :zparent, :zorder, :zimage)");
                                $stmt->execute(array(
                                    'zname' 	=> $name,
                                    'zdesc' 	=> $description,
                                    'zparent' 	=> $parent,
                                    'zorder' 	=> $ordering,
                                    'zimage' 	=> $img
                                ));
                                if ($stmt) {
                                    echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                            تم اضافة القسم بنجاح
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>';
                                }
                        } else{
                            foreach($formErrors as $formError){
                                echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert" id="alert-message">
                                            '.$formError.'
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>';
                            }
                        }
                    }
                    if (isset($_POST['remove'])) {
                        $catid = filter_var($_POST['catid'], FILTER_SANITIZE_NUMBER_INT);
                        $check  = checkItem('category_id', 'category', $catid);
                        if ($check > 0) {
                            $stmt = $con->prepare("DELETE FROM category WHERE category_id = :zcat");
                            $stmt->bindParam(":zcat", $catid);
                            $stmt->execute();
                            if ($stmt) {
                                echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                        تم حذف القسم بنجاح
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert" id="alert-message">
                                    هذا القسم غير موجود 
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                        }
                    }
                    if (isset($_POST['edit'])) {
                        $name 	       = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                        $description   = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
                        $parent 	   = filter_var($_POST['parent'], FILTER_SANITIZE_NUMBER_INT);
                        $ordering      = filter_var($_POST['ordering'],FILTER_SANITIZE_NUMBER_INT);
                        $catid         = filter_var($_POST['catid'], FILTER_SANITIZE_NUMBER_INT);
                        if (empty($formErrors)) {
                            $stmt = $con->prepare("UPDATE category SET category_name = ?,category_description = ?, ordering = ?, parent = ? WHERE category_id  = ?");
                            $stmt->execute(array($name, $description, $ordering , $parent, $catid ));
                            if ($stmt) {
                                echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                        تم تعديل القسم بنجاح
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                            }
                        } else{
                            foreach($formErrors as $formError){
                                echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert" id="alert-message">
                                            '.$formError.'
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>';
                            }
                        }
                    }
                    if (isset($_POST['activiate'])) {
                        $cat_id = filter_var($_POST['cat_id'], FILTER_SANITIZE_NUMBER_INT);
                        $check  = checkItem('category_id', 'category', $cat_id);
                        // If There's Such ID Show The Form
                        if ($check > 0) {
                            $stmt = $con->prepare("UPDATE category SET Visibility = 1 WHERE category_id = ?");
                            $stmt->execute(array($cat_id));
                            $stmt->execute();
                            if ($stmt) {
                                echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                        تم تفعيل القسم بنجاح
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert" id="alert-message">
                                    هذا القسم غير موجود 
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                        }
                    }
                    if (isset($_POST['not_activiate'])) {
                        $cat_id = filter_var($_POST['cat_id'], FILTER_SANITIZE_NUMBER_INT);
                        $check  = checkItem('category_id', 'category', $cat_id);
                        // If There's Such ID Show The Form
                        if ($check > 0) {
                            $stmt = $con->prepare("UPDATE category SET Visibility = 0 WHERE category_id = ?");
                            $stmt->execute(array($cat_id));
                            $stmt->execute();
                            if ($stmt) {
                                echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                        تم الغاء تفعيل القسم بنجاح
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert" id="alert-message">
                                    هذا القسم غير موجود 
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                        }
                    }
                }
                $stmt = $con->prepare("SELECT * FROM category ORDER BY ordering $sort");
                $stmt->execute();
                $rows = $stmt->fetchAll();
                if (! empty($rows)) {
            ?>
                    <div class="row ">
                        <div class="col-12 grid-margin ">
                            <div class="card ">
                                <div class="card-body ">
                                    <h4 class="card-title ">الأقسام</h4>
                                    <div class="table-responsive ">
                                        <table class="table" id="datatableid">
                                            <thead>
                                                <tr>
                                                    <th>رقم القسم</th>
                                                    <th>اسم القسم</th>
                                                    <th>تفاصيل القسم</th>
                                                    <th> القسم الرئيسي</th>
                                                    <th>لوحة التحكم</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                foreach($rows as $row) {?>
                                            <tr>
                                                <td> <?php echo $row['category_id'];?></td>
                                                <td>
                                                    <!-- <img src="layout/images/faces/face1.jpg " class="mr-2 " alt="image ">  -->
                                                    <?php echo $row['category_name'];?>
                                                </td>
                                                <td> <?php echo $row['category_description'];?></td>
                                                <td> <?php 
                                                    if($row['parent']==0){
                                                        echo '<button type="button " class="btn btn-gradient-light btn-sm lesson_edit"><a href="category_content.php?category_id='.$row['category_id'].'" style="text-decoration: none;">تفاصيل</a></button>';
                                                    }
                                                ?></td>
                                                <td>
                                                    <button type="button " class="btn btn-outline-success btn-sm edit_cat" data-toggle="modal" data-target="#edit">تعديل</button>
                                                    <input type="hidden" value="<?php echo $row['category_id'];?>" id="cat">
                                                    <button type="button " class="btn btn-outline-danger btn-sm delete_cat" data-toggle="modal" data-target="#remove">حذف</button>
                                                    <?php  
                                                        if($row['Visibility']== 0) {
                                                                echo'<button type="button " class="btn btn-outline-primary btn-sm activiate" data-toggle="modal" data-target="#activiate">تفعيل</button>';
                                                            } else {
                                                                echo'<button type="button " class="btn btn-outline-dark btn-sm not_activiate" data-toggle="modal" data-target="#not_activiate">الغاء التفعيل</button>';
                                                            }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>          
                    </div>
                    <div class="modal fade" id="remove" tabindex="-1" aria-labelledby="removeLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                    <h2 class="text-light">حذف قسم </h2>
                                </div>
                                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <div class="modal-body">
                                        <h3 class="text-center">هل تريد حذف هذا القسم</h3>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" value="" name="catid" id="catid">
                                        <button type="submit" class="btn btn-danger" name="remove">حذف</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-success">
                                    <h2 class="text-light">تعديل قسم </h2>
                                </div>
                                <form class="float-right" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <div class="modal-body">
                                            <div class="form-group ">
                                                <h4>الاسم</h4>
                                                <input type="text" name="name"  placeholder=" اسم القسم " class="form-control inputName ">
                                            </div>
                                            <div class="form-group ">
                                                <h4>وصف القسم</h4>
                                                <textarea class="form-control" name="description" style="height: 100px;"></textarea>
                                            </div>
                                            <div class="form-group ">
                                                <h4>القسم الرئيسي؟</h4>
                                                <select name="parent" class="form-control inputName ">
                                                    <option value="0">فارغ</option>
                                                    <?php 
                                                        $allCats = getAllFrom("*", "category", "where parent = 0", "", "ordering", "ASC");
                                                        foreach($allCats as $cat) {
                                                            echo "<option value='" . $cat['category_id'] . "'>" . $cat['category_name'] . "</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group ">
                                                <h4>الترتيب</h4>
                                                <input type="number" name="ordering" class="form-control" placeholder=" ترتيب القسم" />
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit " class="btn btn-success" name="edit">تعديل القسم</button> 
                                        <input type="hidden" value="" name="catid" id="cat_2">   
                                        <button type="button " class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="activiate" tabindex="-1" aria-labelledby="removeLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h2 class="text-light">تفعيل القسم  </h2>
                                </div>
                                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <div class="modal-body">
                                        <h3 class="text-center">هل تريد اظهار القسم </h3>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" value="" name="cat_id" id="cat_id_3">
                                        <button type="submit" class="btn btn-primary" name="activiate">تفعيل</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="not_activiate" tabindex="-1" aria-labelledby="removeLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-dark">
                                    <h2 class="text-light">الغاء تفعيل القسم</h2>
                                </div>
                                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <div class="modal-body">
                                        <h3 class="text-center">هل تريد الغاء اظهار القسم للجميع</h3>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" value="" name="cat_id" id="cat_id_4">
                                        <button type="submit" class="btn btn-dark" name="not_activiate">الغاء التفعيل</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <h2 class="text-light">اضافة قسم </h2>
                                </div>
                                <form class="float-right" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="form-group ">
                                            <h4>الاسم</h4>
                                            <input type="text" name="name"  placeholder=" اسم القسم " required class="form-control inputName ">
                                        </div>
                                        <div class="form-group ">
                                            <h4>وصف القسم</h4>
                                            <textarea class="form-control" name="description" style="height: 100px;"></textarea>
                                        </div>
                                        <div class="form-group ">
                                            <h4>القسم الرئيسي؟</h4>
                                            <select name="parent" class="form-control inputName ">
                                                <option value="0">فارغ</option>
                                                <?php 
                                                    $allCats = getAllFrom("*", "category", "where parent = 0", "", "ordering", "ASC");
                                                    foreach($allCats as $cat) {
                                                        echo "<option value='" . $cat['category_id'] . "'>" . $cat['category_name'] . "</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group ">
                                            <h4>الترتيب</h4>
                                            <input type="number" name="ordering" class="form-control" placeholder=" ترتيب القسم" />
                                        </div>
                                        <div class="form-group mb-3">
                                            <h4>اختر صورة</h4>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="image" >
                                                <label class="custom-file-label text-center" for="inputGroupFile01">اختر ملف</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit " class="btn btn-info" name="add">اضافة القسم</button>    
                                        <button type="button " class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php
include 'includes/templates/footer.php';
} else {
    header('Location: index.php');
    exit();
}
ob_end_flush(); 
?>
