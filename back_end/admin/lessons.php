<?php
ob_start(); // Output Buffering Start
session_start();
$pageTitle = 'Lesson';
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
                            </span>&nbsp; الدروس
                        </h3>
                        <div class="">
                            <button style="color:darkblue;font-size:15px " type="button " class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#add">أضافة درس</button>
                            <button style="color:darkblue;font-size:15px " type="button " class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#add2">أضافة درس يوتيوب</button>
                        </div>
                    </div>
                    <?php 
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if (isset($_POST['add'])) {
                                $name 	        = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                                $description    = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
                                $pdf            = $_POST['pdf'];
                                $parent         = filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
                                $approve        = $_POST['approve'];
                                // Upload Variables
                                $videoName  = $_FILES['video']['name'];
                                $videoSize  = $_FILES['video']['size'];
                                $videoTmp	  = $_FILES['video']['tmp_name'];
                                $videoType  = $_FILES['video']['type'];
                                // List Of Allowed File Typed To Upload
                                $videoAllowedExtension = array("avi", "mov", "mp4", "AVI", "MOV", "MP4");
                                // Get Avatar Extension
                                $videos = explode('.', $videoName);
                                $videoExtension = strtolower(end($videos));
                                if (isset($name)) {
                                    if (strlen($name) < 4) {$formErrors[] = 'يجب وضع اسم للدرس ';}
                                }
                                if (isset($description)) {
                                    if (strlen($description) < 4) {$formErrors[] = ' يجب وضع وصف للدرس ';}
                                }
                                if (! empty($videoName) && ! in_array($videoExtension, $videoAllowedExtension)) {
                                    $formErrors[] = 'امتداد الفيديو هذا غير متوفر';
                                }
                                // Check If There's No Error Proceed The User Add
                                if (empty($formErrors)) {
                                        $video = $videoName;
                                        $uploads_dir = 'uploads';
                                        if (move_uploaded_file($videoTmp, "$uploads_dir/$video")){
                                            $stmt = $con->prepare("INSERT INTO 
                                                    lessons(lesson_name, lesson_description, lesson_data, member_id, cat_id, pdf, Approve, video_name)
                                                    VALUES(:lesson_name, :lesson_description, now(), :member_id, :cat_id, :pdf, :Approve, :video_name)");
                                            $stmt->execute(array(
                                                'lesson_name'           => $name,
                                                'lesson_description'    => $description,
                                                'member_id'             => $_SESSION['ID'],
                                                'cat_id'                => $parent,
                                                'pdf'                   => $pdf,
                                                'Approve'               => $approve,
                                                'video_name'            => $video
                                            ));
                                            if ($stmt) {
                                                echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                                        تم اضافة الدرس بنجاح
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>';
                                            }
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
                            if (isset($_POST['add2'])) {
                                $name 	        = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                                $description    = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
                                $link 	        = $_POST['link'];
                                $pdf            = $_POST['pdf'];
                                $parent         = filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
                                $approve        = $_POST['approve'];
                                if (isset($name)) {
                                    if (strlen($name) < 4) {$formErrors[] = 'يجب وضع اسم للدرس ';}
                                }
                                if (isset($description)) {
                                    if (strlen($description) < 4) {$formErrors[] = ' يجب وضع وصف للدرس ';}
                                }
                                if (isset($video)) {
                                    if (strlen($video) < 4) {$formErrors[] = 'يجب وضع لنك الفيديو';}
                                }
                                if (isset($pdf)) {
                                    if (strlen($pdf) < 4) {$formErrors[] = 'يجب وضع لنك ورق الشرح';}
                                }
                                // Check If There's No Error Proceed The User Add
                                if (empty($formErrors)) {
                                        $stmt = $con->prepare("INSERT INTO 
                                                    lessons(lesson_name, lesson_description, video, lesson_data, member_id, cat_id, pdf, Approve)
                                                    VALUES(:lesson_name, :lesson_description, :video, now(), :member_id, :cat_id, :pdf, :Approve)");
                                        $stmt->execute(array(
                                            'lesson_name'           => $name,
                                            'lesson_description'    => $description,
                                            'video'                 => $link,
                                            'member_id'             => $_SESSION['ID'],
                                            'cat_id'                => $parent,
                                            'pdf'                   => $pdf,
                                            'Approve'               => $approve
                                        ));
                                        if ($stmt) {
                                            echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                                    تم اضافة الدرس بنجاح
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
                                $lessonid = filter_var($_POST['lessonid'], FILTER_SANITIZE_NUMBER_INT);
                                $check  = checkItem('lesson_id', 'lessons', $lessonid);
                                // If There's Such ID Show The Form
                                if ($check > 0) {
                                    $stmt = $con->prepare("SELECT video_name FROM lessons where lesson_id = ? ");
                                    $stmt->execute(array($lessonid));
                                    $count = $stmt->rowCount();
                                    if ($check > 0) {
                                        $row = $stmt->fetch();
                                        $name = 'uploads/';
                                        unlink($name.$row['video_name']);
                                        $stmt = $con->prepare("DELETE FROM lessons WHERE lesson_id = :lessonid");
                                        $stmt->bindParam(":lessonid", $lessonid);
                                        $stmt->execute();
                                        if ($stmt) {
                                            echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                                    تم حذف الدرس بنجاح
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>';
                                        }
                                    }
                                } else {
                                    echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert" id="alert-message">
                                            هذا الدرس غير موجود 
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>';
                                }
                            }
                            if (isset($_POST['activiate'])) {
                                $lesson_id = filter_var($_POST['lesson_id'], FILTER_SANITIZE_NUMBER_INT);
                                $check  = checkItem('lesson_id', ' lessons', $lesson_id);
                                // If There's Such ID Show The Form
                                if ($check > 0) {
                                    $stmt = $con->prepare("UPDATE  lessons SET Approve = 1 WHERE lesson_id = ?");
                                    $stmt->execute(array($lesson_id));
                                    $stmt->execute();
                                    if ($stmt) {
                                        echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                                تم تفعيل الدرس بنجاح
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert" id="alert-message">
                                            هذا الدرس غير موجود 
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>';
                                }
                            }
                            if (isset($_POST['edit'])) {
                                $name 	        = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                                $description    = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
                                $video 	        = filter_var($_POST['video'], FILTER_SANITIZE_STRING);
                                $pdf            = filter_var($_POST['pdf'],FILTER_SANITIZE_STRING);
                                $parent         = filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
                                $lessonid       = filter_var($_POST['lessonid'], FILTER_SANITIZE_NUMBER_INT);
                                $approve        = $_POST['approve'];
                                if (isset($name)) {
                                    if (strlen($name) < 4) {$formErrors[] = 'يجب وضع اسم للدرس ';}
                                }
                                if (isset($description)) {
                                    if (strlen($description) < 4) {$formErrors[] = ' يجب وضع وصف للدرس ';}
                                }
                                if (isset($video)) {
                                    if (strlen($video) < 4) {$formErrors[] = 'يجب وضع لنك الفيديو';}
                                }
                                if (isset($pdf)) {
                                    if (strlen($pdf) < 4) {$formErrors[] = 'يجب وضع لنك ورق الشرح';}
                                }
                                // Check If There's No Error Proceed The User Add
                                if (empty($formErrors)) {
                                        $stmt = $con->prepare("UPDATE lessons 
                                                                SET lesson_name = ?, lesson_description = ?, video = ?, member_id = ?, cat_id = ?, pdf = ?, Approve = ?
                                                                WHERE lesson_id  = ?");
                                        $stmt->execute(array($name, $description, $video , $_SESSION['ID'], $parent, $pdf, $approve, $lessonid ));
                                        if ($stmt) {
                                            echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                                    تم تعديل الدرس بنجاح
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
                            if (isset($_POST['not_activiate'])) {
                                $cat_id = filter_var($_POST['lesson_id'], FILTER_SANITIZE_NUMBER_INT);
                                $check  = checkItem('lesson_id', 'lessons', $cat_id);
                                // If There's Such ID Show The Form
                                if ($check > 0) {
                                    $stmt = $con->prepare("UPDATE lessons SET Approve = 0 WHERE lesson_id = ?");
                                    $stmt->execute(array($cat_id));
                                    $stmt->execute();
                                    if ($stmt) {
                                        echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                                تم الغاء تفعيل الدرس بنجاح
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert" id="alert-message">
                                            هذا الدرس غير موجود 
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>';
                                }
                            }
                        }
                        $stmt = $con->prepare("SELECT 
                                                lessons.*, 
                                                category.category_name AS category_name
                                            FROM 
                                                lessons
                                            INNER JOIN 
                                                category 
                                            ON 
                                                category.category_id = lessons.cat_id 
                                            ORDER BY 
                                                lesson_id asc");
                            $stmt->execute();
                            $rows = $stmt->fetchAll();
                            if (! empty($rows)) {
                    ?>
                    <div class="row ">
                        <div class="col-12 grid-margin ">
                            <div class="card ">
                                <div class="card-body ">
                                    <h4 class="card-title ">أخر الدروس</h4>
                                    <div class="table-responsive ">
                                        <table class="table" id="datatableid">
                                            <thead>
                                                <tr>
                                                    <th> رقم الدرس </th>
                                                    <th> اسم الدرس </th>
                                                    <th> ملفات الدرس</th>
                                                    <th>النوع</th>
                                                    <th>تاريخ الاضافة</th>
                                                    <th> القسم</th>
                                                    <th>لوحة التحكم</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
							            foreach($rows as $row) {?>
                                            <tr>
                                                <td> <?php echo $row['lesson_id'];?></td>
                                                <td>
                                                    <!-- <img src="layout/images/faces/face1.jpg " class="mr-2 " alt="image ">  -->
                                                    <?php echo $row['lesson_name'];?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        if($row['video_name']==''){echo'<label class="badge badge-gradient-danger">يوتيوب</label>';}
                                                        else {echo'<label class="badge badge-gradient-primary"> علي المنصة</label>';}
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        if($row['pdf']==''){echo'<label class="badge badge-gradient-warning">لا يوجد</label>';}
                                                        else {echo'<label class="badge badge-gradient-success"> يوجد </label>';}
                                                    ?>
                                                </td>
                                                <td> <?php echo $row['lesson_data'];?></td>
                                                <td> <?php echo $row['category_name'];?></td>
                                                <td>
                                                    <button type="button " class="btn btn-gradient-light btn-sm lesson_edit"><a href="lesson_content.php?lesson_id=<?php echo $row['lesson_id']; ?>" style="text-decoration: none;">تفاصيل</a></button>
                                                    <button type="button " class="btn btn-outline-success btn-sm lesson_edit"data-toggle="modal" data-target="#edit">تعديل</button>
                                                    <input type="hidden" value="<?php echo $row['lesson_id'];?>" id="lesson">
                                                    <button type="button " class="btn btn-outline-danger btn-sm lesson_delete"data-toggle="modal" data-target="#remove">حذف</button>
                                                    <?php  
                                                        if($row['Approve']== 0) {
                                                                echo'<button type="button " class="btn btn-outline-primary btn-sm activiate_lesson" data-toggle="modal" data-target="#activiate">تفعيل</button>';
                                                            } else {
                                                                echo'<button type="button " class="btn btn-outline-dark btn-sm not_activiate_lesson" data-toggle="modal" data-target="#not_activiate">الغاء التفعيل</button>';
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
                                    <h2 class="text-light">حذف الدرس </h2>
                                </div>
                                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <div class="modal-body">
                                        <h3 class="text-center">هل تريد حذف هذا الدرس</h3>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" value="" name="lessonid" id="lessonid_2">
                                        <button type="submit" class="btn btn-danger" name="remove">حذف</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="activiate" tabindex="-1" aria-labelledby="removeLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h2 class="text-light">تفعيل الدرس </h2>
                                </div>
                                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <div class="modal-body">
                                        <h3 class="text-center">هل تريد تفعيل هذا الدرس</h3>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" value="" name="lesson_id" id="lesson_id">
                                        <button type="submit" class="btn btn-primary" name="activiate">تفعيل</button>
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
                                    <h2 class="text-light">تعديل الدرس </h2>
                                </div>
                                <form class="float-right" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <div class="modal-body">
                                            <div class="form-group ">
                                                <h4>عنوان الدرس</h4>
                                                <input type="text" name="name" placeholder="اسم الدرس" class="form-control" required>
                                            </div>
                                            <div class="form-group ">
                                                <h4>وصف الدرس</h4>
                                                <textarea name="description" class="form-control" style="height: 100px;" required></textarea>
                                            </div>
                                            <div class="form-group ">
                                                <h4>الفيديو</h4>
                                                <textarea name="video" class="form-control" style="height: 100px;" required></textarea>
                                            </div>
                                            <div class="form-group ">
                                                <h4>ورق الشرح</h4>
                                                <textarea name="pdf" class="form-control"  style="height: 100px;" required></textarea>
                                            </div>
                                            <div class="form-group ">
                                                <h4>القسم</h4>
                                                <select name="category" class="form-control">
                                                    <option disabled selected>...</option>
                                                    <?php
                                                        $getAll = $con->prepare("SELECT * FROM category where parent = 0 ORDER BY ordering asc");
                                                        $getAll->execute();
                                                        $allCats = $getAll->fetchAll();
                                                        foreach ($allCats as $cat) {
                                                            echo "<option disabled>" . $cat['category_name'] . "</option>";
                                                            $childCats = $con->prepare("SELECT * FROM category where parent = ? ORDER BY ordering asc");
                                                            $childCats->execute(array($cat['category_id']));
                                                            $childCats = $childCats->fetchAll();
                                                            foreach ($childCats as $child) {
                                                                echo "<option value='" . $child['category_id'] . "'>--- " . $child['category_name'] . "</option>";
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group ">
                                                <h4>  اظهار الدرس :</h4>
                                                <div class="im" style="margin-top: 15px;">
                                                    <input id="vis-yes" type="radio" name="approve" value="0" checked style="width:20px;height:20px;"/>
                                                    <label for="vis-yes"  style="font-size: 20px;margin-right: 10px;">لا</label> 
                                                </div>
                                                <div class="im" style="margin-top: 15px;">
                                                    <input id="vis-no" type="radio" name="approve" value="1" style="width:20px;height:20px;"/>
                                                    <label for="vis-no" style="font-size: 20px; margin-right: 10px;">نعم</label> 
                                                </div>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit " class="btn btn-success" name="edit">تعديل الدرس</button>   
                                        <input type="hidden" value="" name="lessonid" id="lesson_2">
                                        <button type="button " class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="not_activiate" tabindex="-1" aria-labelledby="removeLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-dark">
                                    <h2 class="text-light">الغاء تفعيل الدرس</h2>
                                </div>
                                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <div class="modal-body">
                                        <h3 class="text-center">هل تريد الغاء اظهار الدرس </h3>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" value="" name="lesson_id" id="lesson_id_4">
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
                                    <h2 class="text-light">اضافة درس </h2>
                                </div>
                                <form class="float-right" action="lessons.php" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                            <div class="form-group ">
                                                <h4>عنوان الدرس</h4>
                                                <input type="text" name="name" placeholder="اسم الدرس" class="form-control" required>
                                            </div>
                                            <div class="form-group ">
                                                <h4>وصف الدرس</h4>
                                                <textarea name="description" class="form-control" style="height: 100px;" required></textarea>
                                            </div>
                                            <div class="form-group ">
                                                <h4>الفيديو</h4>
                                                <input type="file" class="file-upload-default" name="video" required/>  
                                                <div class="input-group col-xs-12" style="background-color: #fff;">
                                                    <input type="text" class="form-control file-upload-info" disabled placeholder="تحميل فيديو">
                                                    <span class="input-group-append">
                                                        <button class="file-upload-browse btn btn-gradient-primary" type="button" style="border-radius: 0;">تحميل</button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <h4>ورق الشرح</h4>
                                                <textarea name="pdf" class="form-control"  style="height: 100px;"></textarea>
                                            </div>
                                            <div class="form-group ">
                                                <h4>القسم</h4>
                                                <select name="category" class="form-control">
                                                    <option disabled selected>...</option>
                                                    <?php
                                                        $getAll = $con->prepare("SELECT * FROM category where parent = 0 ORDER BY ordering asc");
                                                        $getAll->execute();
                                                        $allCats = $getAll->fetchAll();
                                                        foreach ($allCats as $cat) {
                                                            echo "<option value='" . $cat['category_id'] . "'>" . $cat['category_name'] . "</option>";
                                                            $childCats = $con->prepare("SELECT * FROM category where parent = ? ORDER BY ordering asc");
                                                            $childCats->execute(array($cat['category_id']));
                                                            $childCats = $childCats->fetchAll();
                                                            foreach ($childCats as $child) {
                                                                echo "<option value='" . $child['category_id'] . "'>--- " . $child['category_name'] . "</option>";
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group ">
                                                <h4> : اظهار الدرس  بدون امتحان</h4>
                                                <div class="im" style="margin-top: 15px;">
                                                    <input id="vis-yes" type="radio" name="approve" value="0" checked style="width:20px;height:20px;"/>
                                                    <label for="vis-yes"  style="font-size: 20px;margin-right: 10px;">لا</label> 
                                                </div>
                                                <div class="im" style="margin-top: 15px;">
                                                    <input id="vis-no" type="radio" name="approve" value="1" style="width:20px;height:20px;"/>
                                                    <label for="vis-no" style="font-size: 20px; margin-right: 10px;">نعم</label> 
                                                </div>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit " class="btn btn-info" name="add">اضافة درس</button>    
                                        <button type="button " class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="add2" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <h2 class="text-light">اضافة درس </h2>
                                </div>
                                <form class="float-right" action="lessons.php" method="POST">
                                    <div class="modal-body">
                                            <div class="form-group ">
                                                <h4>عنوان الدرس</h4>
                                                <input type="text" name="name" placeholder="اسم الدرس" class="form-control" required>
                                            </div>
                                            <div class="form-group ">
                                                <h4>وصف الدرس</h4>
                                                <textarea name="description" class="form-control" style="height: 100px;" required></textarea>
                                            </div>
                                            <div class="form-group ">
                                                <h4>لنك الفيديو</h4>
                                                <textarea name="link" class="form-control" style="height: 100px;" reqired></textarea>
                                            </div>
                                            <div class="form-group ">
                                                <h4>ورق الشرح</h4>
                                                <textarea name="pdf" class="form-control"  style="height: 100px;"></textarea>
                                            </div>
                                            <div class="form-group ">
                                                <h4>القسم</h4>
                                                <select name="category" class="form-control">
                                                    <option disabled selected>...</option>
                                                    <?php
                                                        $getAll = $con->prepare("SELECT * FROM category where parent = 0 ORDER BY ordering asc");
                                                        $getAll->execute();
                                                        $allCats = $getAll->fetchAll();
                                                        foreach ($allCats as $cat) {
                                                            echo "<option value='" . $cat['category_id'] . "'>" . $cat['category_name'] . "</option>";
                                                            $childCats = $con->prepare("SELECT * FROM category where parent = ? ORDER BY ordering asc");
                                                            $childCats->execute(array($cat['category_id']));
                                                            $childCats = $childCats->fetchAll();
                                                            foreach ($childCats as $child) {
                                                                echo "<option value='" . $child['category_id'] . "'>--- " . $child['category_name'] . "</option>";
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group ">
                                                <h4> : اظهار الدرس  بدون امتحان</h4>
                                                <div class="im" style="margin-top: 15px;">
                                                    <input id="vis-yes" type="radio" name="approve" value="0" checked style="width:20px;height:20px;"/>
                                                    <label for="vis-yes"  style="font-size: 20px;margin-right: 10px;">لا</label> 
                                                </div>
                                                <div class="im" style="margin-top: 15px;">
                                                    <input id="vis-no" type="radio" name="approve" value="1" style="width:20px;height:20px;"/>
                                                    <label for="vis-no" style="font-size: 20px; margin-right: 10px;">نعم</label> 
                                                </div>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit " class="btn btn-info" name="add2">اضافة درس</button>    
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