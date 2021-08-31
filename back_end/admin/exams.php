<?php
ob_start(); // Output Buffering Start
session_start();
$pageTitle = 'Exams';
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
                            </span>&nbsp; الأمتحانات 
                        </h3>
                        <div class="">
                            <button style="color:darkblue;font-size:15px " type="button " class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#add2"> أضافة أمتحان جزئي</button>
                            <button style="color:darkblue;font-size:15px " type="button " class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#add3"> أضافة أمتحان بلنك</button>
                            <button style="color:darkblue;font-size:15px " type="button " class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#add"> أضافة أمتحان شامل</button>
                        </div>
                    </div>
                    <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if (isset($_POST['add'])) {
                                $name 	     = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                                $number 	 = filter_var($_POST['number'], FILTER_SANITIZE_NUMBER_INT);
                                $time 	 = filter_var($_POST['time'], FILTER_SANITIZE_NUMBER_INT);
                                if(isset($_POST['category'])){
                                    $category  = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
                                } else{
                                    $category = '';
                                }
                                if(isset($_POST['lesson'])){
                                    $lesson  = filter_var($_POST['lesson'], FILTER_SANITIZE_NUMBER_INT);
                                } else{
                                    $lesson = '';
                                }
                                if (isset($name)) {
                                    if (strlen($name) < 4) {$formErrors[] = 'يجب وضع اسم للدرس ';}
                                }
                                // Check If There's No Error Proceed The User Add
                                if (empty($formErrors)) {
                                        $stmt = $con->prepare("INSERT INTO 
                                                    exams(exam_name, exam_date, categ_id, member_id, lesson_id, number, type, time)
                                                    VALUES(:exam_name, now(), :categ_id, :member_id, :lesson_id, :number, 1, :time)");
                                        $stmt->execute(array(
                                            'exam_name'  => $name,
                                            'categ_id'   => $category,
                                            'member_id'  => $_SESSION['ID'],
                                            'lesson_id'  => $lesson,
                                            'number'     => $number,
                                            'time'       => $time
                                        ));
                                        if ($stmt) {
                                            echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                                    تم اضافة الامتحان بنجاح
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
                                $examid = filter_var($_POST['examid'], FILTER_SANITIZE_NUMBER_INT);
                                $check  = checkItem('exam_id', 'exams', $examid);
                                // If There's Such ID Show The Form
                                if ($check > 0) {
                                    $stmt = $con->prepare("DELETE FROM exams WHERE exam_id = :exam_id");
                                    $stmt->bindParam(":exam_id", $examid);
                                    $stmt->execute();
                                    if ($stmt) {
                                        echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                                تم حذف الامتحان بنجاح
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert" id="alert-message">
                                            هذا الامتحان غير موجود 
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>';
                                }
                            }
                            if (isset($_POST['edit'])) {
                                $name 	     = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                                $examid      = filter_var($_POST['examid'], FILTER_SANITIZE_NUMBER_INT);
                                if (isset($name)) {
                                    if (strlen($name) < 4) {$formErrors[] = 'يجب وضع اسم للدرس ';}
                                }
                                // Check If There's No Error Proceed The User Add
                                if (empty($formErrors)) {
                                        $stmt = $con->prepare("UPDATE exams 
                                                                SET exam_name = ?
                                                                WHERE exam_id = ?");
                                        $stmt->execute(array($name, $examid));
                                        if ($stmt) {
                                            echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                                    تم تعديل الامتحان بنجاح
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
                            if (isset($_POST['add3'])) {
                                $name 	     = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                                $link        = $_POST['link'];
                                if (isset($name)) {
                                    if (strlen($name) < 4) {$formErrors[] = 'يجب وضع اسم للدرس ';}
                                }
                                // Check If There's No Error Proceed The User Add
                                if (empty($formErrors)) {
                                        $stmt = $con->prepare("INSERT INTO 
                                                    exams(exam_name, exam_desc, type, exam_date, member_id )
                                                    VALUES(:exam_name, :exam_desc, 2, now(), :member_id)");
                                        $stmt->execute(array(
                                            'exam_name'  => $name,
                                            'exam_desc'  => $link,
                                            'member_id'  => $_SESSION['ID']
                                        ));
                                        if ($stmt) {
                                            echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                                    تم اضافة الامتحان بنجاح
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
                            if (isset($_POST['add2'])) {
                                $name 	     = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                                $number 	 = filter_var($_POST['number'], FILTER_SANITIZE_NUMBER_INT);
                                $time 	 = filter_var($_POST['time'], FILTER_SANITIZE_NUMBER_INT);
                                if (isset($name)) {
                                    if (strlen($name) < 4) {$formErrors[] = 'يجب وضع اسم للدرس ';}
                                }
                                // Check If There's No Error Proceed The User Add
                                if (empty($formErrors)) {
                                        $stmt = $con->prepare("INSERT INTO 
                                                    exams(exam_name, exam_date, member_id, number, type, time)
                                                    VALUES(:exam_name, now(), :member_id, :number, 2, :time)");
                                        $stmt->execute(array(
                                            'exam_name'  => $name,
                                            'member_id'  => $_SESSION['ID'],
                                            'number'     => $number,
                                            'time'       => $time
                                        ));
                                        if ($stmt) {
                                            echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                                    تم اضافة الامتحان بنجاح
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
                        $stmt = $con->prepare("SELECT 
                                                exams.*,category.category_name AS category_name
                                            FROM 
                                                exams
                                            INNER JOIN 
                                                category 
                                            ON 
                                                category.category_id = exams.categ_id 
                                            ORDER BY 
                                                exam_id DESC");
                        $stmt->execute(array());
                        $rows = $stmt->fetchAll();
                        if (! empty($rows)) {
                    ?>
                    <div class="row ">
                        <div class="col-12 grid-margin ">
                            <div class="card ">
                                <div class="card-body ">
                                    <h4 class="card-title ">الامتحانات الجزئية</h4>
                                    <div class="table-responsive ">
                                        <table class="table "id="datatableid">
                                            <thead>
                                                <tr>
                                                    <th>رقم الأمتحان</th>
                                                    <th>اسم الأمتحان </th>
                                                    <th>تاريخ الامتحان</th>
                                                    <th> القسم</th>
                                                    <th> عدد الاسئلة</th>
                                                    <th> وقت الامتحان</th>
                                                    <th>لوحة التحكم</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
							            foreach($rows as $row) {?>
                                            <tr>
                                                <td> <?php echo $row['exam_id'];?></td>
                                                <td><?php echo $row['exam_name'];?></td>
                                                <td> <?php echo $row['exam_date'];?></td>
                                                <td> <?php echo $row['category_name'];?></td>
                                                <td> <?php echo $row['number'];?></td>
                                                <td> <?php echo $row['time'];?></td>
                                                <td>
                                                    <button type="button " class="btn btn-gradient-dark btn-sm"><a href="exam_content.php?exam_id=<?php echo $row['exam_id']; ?>" style="text-decoration: none;color:#ccc;">تفاصيل</a></button>
                                                    <button type="button " class="btn btn-outline-warning btn-sm main_view"
                                                    value="<?php echo $row['exam_id'];?>" 
                                                    >اظهار النتائج</button>
                                                    <button type="button " class="btn btn-outline-success btn-sm edit_exam" data-toggle="modal" data-target="#edit">تعديل</button>
                                                    <input type="hidden" value="<?php echo $row['exam_id'];?>" id="exam">
                                                    <button type="button " class="btn btn-outline-danger btn-sm exam_delete"data-toggle="modal" data-target="#remove">حذف</button>
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
                    <div class="row ">
                        <div class="col-12 grid-margin ">
                            <div class="card ">
                                <div class="card-body ">
                                    <h4 class="card-title ">الامتحانات الشاملة</h4>
                                    <div class="table-responsive ">
                                        <table class="table "id="datatableid2">
                                            <thead>
                                                <tr>
                                                    <th>رقم الأمتحان</th>
                                                    <th>اسم الأمتحان </th>
                                                    <th>تاريخ الامتحان</th>
                                                    <th>النوع</th>
                                                    <th> وقت الامتحان</th>
                                                    <th>لوحة التحكم</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $stmt = $con->prepare("SELECT 
                                                                    * 
                                                                FROM 
                                                                exams
                                                                where
                                                                type = 2
                                                                ORDER BY 
                                                                    lesson_id asc");
                                            $stmt->execute();
                                            $rows = $stmt->fetchAll();
                                            foreach($rows as $row) {?>
                                                <tr>
                                                    <td> <?php echo $row['exam_id'];?></td>
                                                    <td><?php echo $row['exam_name'];?></td>
                                                    <td> <?php echo $row['exam_date'];?></td>
                                                    <td>
                                                        <?php 
                                                            if(! empty($row['exam_desc'])){
                                                                echo '<label class="badge badge-gradient-warning">امتحان بلنك</label>';
                                                            } else {
                                                                echo '<label class="badge badge-gradient-success"> امتحان شامل</label>';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                            if(empty($row['time'])){
                                                                echo '<label class="badge badge-gradient-warning">امتحان بلنك</label>';
                                                            } else {
                                                                echo $row['time'];
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                            if(! empty($row['exam_desc'])){
                                                                echo '<button type="button " class="btn btn-gradient-light btn-sm lesson_edit"><a href="'. $row['exam_desc'].'" style="text-decoration: none;">الذهاب للامتحان</a></button>';
                                                            } else {
                                                                echo '
                                                                <button type="button " class="btn btn-gradient-dark btn-sm"><a href="exam_content.php?exam_id='. $row['exam_id'].'" style="text-decoration: none;color:#ccc;">تفاصيل</a></button>
                                                                <button type="button " class="btn btn-outline-warning btn-sm main_view"
                                                                value="'.$row['exam_id'].'" 
                                                                >اظهار النتائج</button>
                                                                ';
                                                            }
                                                        ?>
                                                        <button type="button " class="btn btn-outline-success btn-sm edit_exam" data-toggle="modal" data-target="#edit">تعديل</button>
                                                        <input type="hidden" value="<?php echo $row['exam_id'];?>" id="exam">
                                                        <button type="button " class="btn btn-outline-danger btn-sm exam_delete"data-toggle="modal" data-target="#remove">حذف</button>
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
                                    <h2 class="text-light">حذف الامتحان </h2>
                                </div>
                                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <div class="modal-body">
                                        <h3 class="text-center">هل تريد حذف هذا الامتحان</h3>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" value="" name="examid" id="examid">
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
                                    <h2 class="text-light">تعديل الامتحان</h2>
                                </div>
                                <form class="float-right" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <div class="modal-body">
                                            <div class="form-group ">
                                                <h4>عنوان الامتحان</h4>
                                                <input type="text" name="name" placeholder="اسم الامتحان" class="form-control" required>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit " class="btn btn-success" name="edit">تعديل امتحان</button> 
                                        <input type="hidden" value="" name="examid" id="exam_2">
                                        <button type="button " class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="mark" tabindex="-1" aria-labelledby="removeLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-warning">
                                    <h2 class="text-light">جميع نتائج الامتحان</h2>
                                </div>
                                    <div class="modal-body">
                                        <div class="table-responsive" id="divToPrint">
                                            <table class="text-center table table-bordered main_td">
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-warning" value="print" onclick="PrintDiv();">اطبع الاجابات</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                    </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                    <div class="modal fade" id="add2" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <h2 class="text-light">اضافة امتحان </h2>
                                </div>
                                <form class="float-right" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <div class="modal-body">
                                            <div class="form-group ">
                                                <h4>عنوان الامتحان</h4>
                                                <input type="text" name="name" placeholder="اسم الامتحان" class="form-control" required>
                                            </div>
                                            <div class="form-group ">
                                                <h4>القسم</h4>
                                                <select name="category" class="form-control" required>
                                                    <option disabled selected>...</option>
                                                    <?php
                                                        $allCats = getAllFrom("*", "category", "where parent = 0", "", "category_id", "asc");
                                                        foreach ($allCats as $cat) {
                                                            echo "<option value='" . $cat['category_id'] . "' >" . $cat['category_name'] . "</option>";
                                                            $childCats = getAllFrom("*", "category", "where parent = {$cat['category_id']}", "", "category_id", "asc");
                                                            foreach ($childCats as $child) {
                                                                echo "<option value='" . $child['category_id'] . "'>--- " . $child['category_name'] . "</option>";
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <h4>الدرس المرتبط به</h4>
                                                <select name="lesson" class="form-control" >
                                                    <option disabled selected>...</option>
                                                    <?php
                                                        $allMembers = getAllFrom("*", "lessons", "", "", "lesson_id");
                                                        foreach ($allMembers as $lesson) {
                                                            echo "<option value='" . $lesson['lesson_id'] . "'>" . $lesson['lesson_name'] . "</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group ">
                                                <h4>عدد الاسئلة</h4>
                                                <input type="number" name="number" placeholder="عدد الاسئلة" class="form-control" required>
                                            </div>
                                            <div class="form-group ">
                                                <h4>الوقت</h4>
                                                <input type="number" name="time" placeholder="وقت الامتحان باللملي ثانية" class="form-control" required>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit " class="btn btn-info" name="add">اضافة امتحان</button>    
                                        <button type="button " class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="add3" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <h2 class="text-light"> اضافة امتحان شامل</h2>
                                </div>
                                <form class="float-right" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <div class="modal-body">
                                            <div class="form-group ">
                                                <h4>عنوان الامتحان</h4>
                                                <input type="text" name="name" placeholder="اسم الامتحان" class="form-control" required>
                                            </div>
                                            <div class="form-group ">
                                                <h4>رابط الامتحان</h4>
                                                <textarea class="form-control" name="link" style="height: 100px;" required></textarea>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit " class="btn btn-info" name="add3">اضافة امتحان</button>    
                                        <button type="button " class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <h2 class="text-light">اضافة امتحان شامل</h2>
                                </div>
                                <form class="float-right" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <div class="modal-body">
                                            <div class="form-group ">
                                                <h4>عنوان الامتحان</h4>
                                                <input type="text" name="name" placeholder="اسم الامتحان" class="form-control" required>
                                            </div>
                                            <div class="form-group ">
                                                <h4>عدد الاسئلة</h4>
                                                <input type="number" name="number" placeholder="عدد الاسئلة" class="form-control" required>
                                            </div>
                                            <div class="form-group ">
                                                <h4>الوقت</h4>
                                                <input type="number" name="time" placeholder="وقت الامتحان باللملي ثانية" class="form-control" required>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit " class="btn btn-info" name="add2">اضافة امتحان</button>    
                                        <button type="button " class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php
include 'includes/templates/footer.php';
?>
<script>
        $('.main_view').click(function () {
            let id = $(this).val();
            var url = "mark.php";
            $.ajax({
                type:"POST",
                url:url,
                data:"id="+id,
                success:function(data){
                    $('.main_td').html(data);
                    $('#mark').modal('show');
                }
            });
        });
</script>
<script type="text/javascript">     
    function PrintDiv() {    
        var divToPrint=document.getElementById("divToPrint");
        newWin= window.open("");
        newWin.document.write(divToPrint.outerHTML);
        var css =`table, td, th {
            text-align:center;
            margin:auto;
            direction:rtl;
        }
        table{border: 1px solid #dee2e6;}
        th,td{
            padding: .75rem;
            vertical-align: top;
            border: 2px solid #dee2e6;border-bottom-width: 2px;
        }
        #printTable2 .row:first-child{display:none;}
        #printTable2 .row:last-child{display:none;}`;
    var div = $("<div />", {
        html: '&shy;<style>' + css + '</style>'
    }).appendTo( newWin.document.body);
        newWin.print();
        newWin.close();
        }
</script>
<?php
} else {
    header('Location: index.php');
    exit();
}
ob_end_flush(); 
?>