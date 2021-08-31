<?php
ob_start(); // Output Buffering Start
session_start();
$pageTitle = 'Qoutes';
if (isset($_SESSION['username'])) {
    include 'inital.php';
    include 'includes/templates/header.php';
    include 'includes/templates/side.php';
    ?>
    <div class="main-panel ">
        <div class="content-wrapper ">
            <div class="page-header ">
                <h3 class="page-title ">
                    <span class="page-title-icon bg-gradient-primary text-white mr-2 ">
                        <i class="mdi mdi-home "></i>
                    </span>&nbsp;فوائد تربوية
                </h3>
                <button style="margin-right:150px; color:darkblue; font-size:15px" type="button " class="btn btn-outline-info btn-sm"data-toggle="modal" data-target="#add">أضافة فائدة تربوية</button>
            </div>
            <?php 
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['add'])) {
                        if(isset($_POST['description'])){
                            $description  = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
                        } else{
                            $description = '';
                        }
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
                                    benfits(benfit_image,benfit_date, description)
                                VALUES(:benimage, now(), :description)");
                                $stmt->execute(array(
                                    'benimage'    => $img,
                                    'description' => $description,
                                ));
                                if ($stmt) {
                                    echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                            تم اضافة الفائدة بنجاح
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
                        $benfitid = filter_var($_POST['benfit_id'], FILTER_SANITIZE_NUMBER_INT);
                        $check  = checkItem('benfit_id','benfits',$benfitid);
                        if ($check > 0) {
                            $stmt = $con->prepare("DELETE FROM benfits WHERE benfit_id = :zbenfit");
                            $stmt->bindParam(":zbenfit", $benfitid);
                            $stmt->execute();
                            if ($stmt) {
                                echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                        تم حذف الفائدة بنجاح
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert" id="alert-message">
                                    هذه الفائدة غير موجودة
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                        }
                    }
                }
                    
                $stmt = $con->prepare("SELECT * from benfits Order by benfit_id DESC");
                $stmt->execute(array());
                $rows = $stmt->fetchAll();
                if (! empty($rows)) {
                ?>
            <div class="row">
                <div class="row" style="margin: auto;width:100%;">
                <?php
				foreach($rows as $row) { ?>
                    <div class="col-md-3">
                        <div class="card mb-4">
                            <img src="uploads/<?php echo $row['benfit_image'];?>" class="card-img-top" height="210px">
                                <?php if($row['description'] !== ''){ ?>
                                    <p class="text-center mt-2" style="font-weight: bold;"><?php echo $row['description'];?></p>
                                <?php } ?>
                                <button type="button " style="font-size: 25px;height: 60px;border-radius: 0;" class="btn btn-danger btn-sm delete_ben"data-toggle="modal" data-target="#remove">حذف</button>
                                <input type="hidden" value="<?php echo $row['benfit_id'];?>" name="benfit" id="benfit">
                        </div>
                    </div>
                <?php } ?>
                </div>
            </div>
            <?php } ?>
                    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <h2 class="text-light">اضافة فائدة تربوية</h2>
                                </div>
                                <form class="float-right" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="form-group ">
                                            <h4> الصوره</h4>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="image" >
                                                <label class="custom-file-label text-center" for="inputGroupFile01">اختر ملف</label>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <h4>التفاصيل</h4>
                                            <textarea class="form-control" placeholder="وصف للفائدة التربوية " name="description" style="height: 150px;"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit " class="btn btn-info" name="add"> اضافة فائدة تربوية</button>    
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
                                    <h2 class="text-light">حذف الفائدة</h2>
                                </div>
                                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <div class="modal-body">
                                        <h3 class="text-center">هل تريد حذف الفائدة</h3>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="benfit_id" id="benfit_id">
                                        <button type="submit" class="btn btn-danger" name="remove">حذف</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php 
include 'includes/templates/footer.php';
?>
<?php
} else {
    header('Location: index.php');
    exit();
}
ob_end_flush(); 
?>