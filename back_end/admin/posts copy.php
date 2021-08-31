<!-- المنشورات -->
<?php
ob_start(); // Output Buffering Start
session_start();
$pageTitle = 'Posts';
if (isset($_SESSION['username'])) {
    include 'inital.php';
    include 'includes/templates/header.php';
    include 'includes/templates/side.php';
    $sort= '';
    $stmt = $con->prepare("SELECT 
                        post.*, members.username AS Member
                    FROM 
                        post
                    INNER JOIN 
                        members 
                    ON 
                        members.userid = post.users
                    Where type =0
                    ORDER BY 
                    post_id DESC");
    $stmt->execute();
    $rows = $stmt->fetchAll();
    if (! empty($rows)) {
    ?>
<div class="main-panel ">
                <div class="content-wrapper ">
                    <div class="page-header ">
                        <h3 class="page-title ">
                            <span class="page-title-icon bg-gradient-primary text-white mr-2 ">
                  <i class="mdi mdi-home "></i>
                </span>&nbsp; المنشورات
                         </h3>
                         <button style="margin-right:150px; color:darkblue; font-size:15px" type="button " class="btn btn-outline-info btn-sm"data-toggle="modal" data-target="#add">أضافة منشور</button>
                    </div>
                    <?php 
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['add'])) {
                        $name 	       = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                        $description   = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
                        // $userid        = filter_var($_POST['user'],FILTER_SANITIZE_NUMBER_INT);
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
                                move_uploaded_file($imgTmp, "uploads\\" . $img);
                                // Insert Userinfo In Database
                                $stmt = $con->prepare("INSERT INTO 
                                    post(post_name, post_description,post_data,users,type,post_image)
                                VALUES(:pname, :pdesc,now(),:puser,0,:pimage)");
                                $stmt->execute(array(
                                    'pname' 	=> $name,
                                    'pdesc' 	=> $description,
                                    'puser'     =>$_SESSION['ID'],
                                    'pimage'    => $img
                                ));
                                if ($stmt) {
                                    echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                            تم اضافة المنشور بنجاح
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
                        $postid = filter_var($_POST['postid'], FILTER_SANITIZE_NUMBER_INT);
                        $check  = checkItem('post_id','post',$postid);
                        if ($check > 0) {
                            $stmt = $con->prepare("DELETE FROM post WHERE post_id = :zpost");
                            $stmt->bindParam(":zpost", $postid);
                            $stmt->execute();
                            if ($stmt) {
                                echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                        تم حذف المنشور بنجاح
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert" id="alert-message">
                                    هذا المنشور غير موجود 
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                        }
                    }
                    if (isset($_POST['edit'])) {
                        $name 	       = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                        $description   = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
                        // $userid        = filter_var($_POST['user'],FILTER_SANITIZE_NUMBER_INT);
                        $postid        = filter_var($_POST['postid'], FILTER_SANITIZE_NUMBER_INT);
                        if (empty($formErrors)) {
                            $stmt = $con->prepare("UPDATE post SET post_name = ?,post_description=?, type=0 WHERE post_id =?");
                            $stmt->execute(array($name, $description,$postid));
                            if ($stmt) {
                                echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                        تم تعديل المنشور بنجاح
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
                }
            ?>
                    <div class="row ">
                        <div class="col-12 grid-margin ">
                            <div class="card ">
                                <div class="card-body ">
                                    <h4 class="card-title ">المنشورات</h4>
                                    <div class="table-responsive ">
                                        <table class="table" id="datatableid">
                                            <thead>
                                                <tr>
                                                    <th> رقم المنشور </th>
                                                    <th> اسم المنشور </th>
                                                    <th> تاريخ المنشور</th>
                                                    <th>لوحة التحكم</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
							            foreach($rows as $row) {?>
                                            <tr>
                                                <td> <?php echo $row['post_id'];?></td>
                                                <td> <?php echo $row['post_name'];?></td>
                                               
                                                <td> <?php echo $row['post_data'];?></td>
                                                <td>
                                                    <button type="button " class="btn btn-outline-success btn-sm edit_post"data-toggle="modal" data-target="#edit">تعديل</button>
                                                    <input type="hidden" value="<?php echo $row['post_id'];?>" id="post">
                                                    <button type="button " class="btn btn-outline-danger btn-sm delete_post"data-toggle="modal" data-target="#remove">حذف</button>
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
                <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <h2 class="text-light">اضافة منشور</h2>
                                </div>
                                <form class="float-right" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="form-group ">
                                            <h4>اسم المنشور</h4>
                                            <input type="text" name="name"  placeholder=" اسم المنشور " required class="form-control inputName ">
                                        </div>
                                        <div class="form-group ">
                                            <h4>تفاصيل المنشور</h4>
                                            <textarea class="form-control" placeholder="تفاصيل المنشور" name="description" style="height: 150px;"></textarea>
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
                                        <button type="submit " class="btn btn-info" name="add">اضافة المنشور</button>    
                                        <button type="button " class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="remove" tabindex="-1" aria-labelledby="removeLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                    <h2 class="text-light">حذف منشور </h2>
                                </div>
                                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <div class="modal-body">
                                        <h3 class="text-center">هل تريد حذف هذا المنشور</h3>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" value="" name="postid" id="postid_2">
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
                                    <h2 class="text-light">تعديل منشور</h2>
                                </div>
                                <form class="float-right" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <div class="modal-body">
                                            <div class="form-group ">
                                                <h4>اسم المنشور</h4>
                                                <input type="text" name="name"  placeholder=" اسم المنشور" class="form-control inputName ">
                                            </div>
                                            <div class="form-group ">
                                                <h4>تفاصيل المنشور</h4>
                                                <textarea class="form-control" name="description" style="height: 150px;"></textarea>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit " class="btn btn-success" name="edit">تعديل المنشور</button> 
                                        <input type="hidden" value="" name="postid" id="post_2">   
                                        <button type="button " class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php }
include 'includes/templates/footer.php';
} else {
    header('Location: index.php');
    exit();
}
ob_end_flush(); 
?>