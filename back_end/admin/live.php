<?php
ob_start(); // Output Buffering Start
session_start();
$pageTitle = 'live';
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
                            </span>&nbsp; البث المباشر 
                        </h3>
                        <button style="margin-right:150px; font-size:22px" type="button " class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add">أضافة بث مباشر</button>
                    </div>
                    <?php 
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if (isset($_POST['add'])) { 
                                $description   = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
                                $parent 	   = filter_var($_POST['parent'], FILTER_SANITIZE_NUMBER_INT);
                                if (isset($description)) {
                                    if (strlen($description) < 4) {$formErrors[] = 'اللنك  يجب ان يكون اكبر من 4 ارقام';}
                                }
                                if (empty($formErrors)) {
                                    $stmt = $con->prepare("INSERT INTO 
                                            live( link, cat_id, date)
                                        VALUES(:link, :cat_id, now())");
                                        $stmt->execute(array(
                                            'link' 	 => $description,
                                            'cat_id' => $parent
                                        ));
                                        if ($stmt) {
                                            echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                                    تم اضافة البث بنجاح
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
                                $userid = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT);
                                $check  = checkItem('live_id', 'live', $userid);
                                if ($check > 0) {
                                    $stmt = $con->prepare("DELETE FROM live WHERE live_id = :id");
                                    $stmt->bindParam(":id", $userid);
                                    $stmt->execute();
                                    if ($stmt) {
                                        echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                                تم حذف البث بنجاح
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert" id="alert-message">
                                            هذا البث غير موجود 
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>';
                                }
                            }
                        }
                    ?>
                    <div class="row ">
                        <div class="col-12 grid-margin ">
                            <div class="card ">
                                <div class="card-body ">
                                    <h4> البث المباشر</h4>
                                    <div class="table-responsive ">
                                        <table class="table ">
                                            <thead>
                                                <tr>
                                                    <th>رقم البث</th>
                                                    <th>التاريخ</th>
                                                    <th>القسم</th>
                                                    <th>التحكم</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                $stmt = $con->prepare("SELECT * FROM live");
                                                $stmt->execute(array());
                                                $lives = $stmt->fetchAll();
                                                if (! empty($lives)) {
                                                    foreach ($lives as $live) {
                                                            echo '<tr>';
                                                                echo '<td>'. $live['live_id']. '</td>';
                                                                echo '<td>'. $live['date']. '</td>';
                                                                if($live['cat_id']==1){
                                                                    echo '<td>الصف الاول الاعدادى</td>';
                                                                }if($live['cat_id']==2){
                                                                    echo '<td>الصف الثاني الاعدادى</td>';
                                                                }if($live['cat_id']==3){
                                                                    echo '<td>الصف الثالث الاعدادى</td>';
                                                                }if($live['cat_id']==4){
                                                                    echo '<td>الصف الاول الثانوى</td>';
                                                                }if($live['cat_id']==5){
                                                                    echo '<td>الصف الثانى الثانوى</td>';
                                                                }if($live['cat_id']==6){
                                                                    echo '<td>الصف الثالث الثانوى</td>';
                                                                }
                                                                ?>
                                                                <td>
                                                                <button type="button " class="btn btn-outline-danger btn-sm delete"data-toggle="modal" data-target="#remove">حذف</button>
                                                                <input type="hidden" value="<?php echo $live['live_id'];?>" id="live">
                                                                </td>
                                                                <?php
                                                            echo '</tr>';
                                                        }
                                                    } else {
                                                        echo 'لا يوجد اعضاء';
                                                    }
                                                ?> 
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
                                    <h2 class="text-light">اضافة بث مباشر </h2>
                                </div>
                                <form class="float-right" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="form-group ">
                                            <h4>اضافة لنك البث</h4>
                                            <textarea class="form-control" name="description" style="height: 100px;"></textarea>
                                        </div>
                                        <div class="form-group ">
                                            <h4>القسم الرئيسي؟</h4>
                                            <select name="parent" class="form-control inputName ">
                                                <option value="0">فارغ</option>
                                                <?php 
                                                    $allCats = getAllFrom("*", "category", "where parent = 0", "", "ordering", "ASC");
                                                    foreach($allCats as $cat) {
                                                        echo "<option value='" . $cat['ordering'] . "'>" . $cat['category_name'] . "</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit " class="btn btn-info" name="add">اضافة بث مباشر</button>    
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
                                    <h2 class="text-light">حذف عضو </h2>
                                </div>
                                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <div class="modal-body">
                                        <h3 class="text-center">هل تريد حذف هذاالشخص</h3>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" value="" name="userid" id="liveid">
                                        <button type="submit" class="btn btn-danger" name="remove">حذف</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
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