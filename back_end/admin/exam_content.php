<?php
ob_start(); // Output Buffering Start
session_start();
$pageTitle = 'Exams';
if (isset($_SESSION['username'])) {
    include 'inital.php';
    include 'includes/templates/header.php';
    include 'includes/templates/side.php';
    $exam_id = isset($_GET['exam_id']) && is_numeric($_GET['exam_id']) ? intval($_GET['exam_id']) : 0;
    $stmt = $con->prepare("SELECT * FROM exams where exam_id = ?");
    $stmt->execute(array($exam_id));
    $main = $stmt->fetch();
    if (! empty($main)) {
    ?>
            <div class="main-panel ">
                <div class="content-wrapper ">
                    <div class="page-header ">
                        <h3 class="page-title ">
                            <span class="page-title-icon bg-gradient-primary text-white mr-2 ">
                                <i class="mdi mdi-home "></i>
                            </span>&nbsp; 
                            <?php 
                                if($main['type']==1){
                                    echo 'الاسئلة الجزئية';
                                } elseif($main['type']==2) {
                                    echo 'الاسئلة الشاملة';
                                }
                            ?> 
                        </h3>
                        <?php 
                            if($main['type']==1){
                                echo '
                                <div>
                                    <button style="color:darkblue;font-size:20px" type="button " class="btn btn-outline-info btn-sm"data-toggle="modal" data-target="#add">أضافة سؤال اختيارى</button>
                                    <button style="color:darkblue;font-size:20px" type="button " class="btn btn-outline-info btn-sm"data-toggle="modal" data-target="#add2">أضافة سؤال مقالى</button>
                                </div>
                                ';
                            } elseif($main['type']==2) {
                                echo '
                                    <button style="color:darkblue;font-size:20px" type="button " class="btn btn-outline-info btn-sm"data-toggle="modal" data-target="#add3">أضافة جزء</button>
                                ';
                            }
                        ?>
                    </div>
                    <?php 
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if($main['type']==1){
                                if (isset($_POST['add'])) {
                                    // Get Variables From The Form
                                    if(isset($_POST['question'])){
                                        $question  = filter_var($_POST['question'], FILTER_SANITIZE_STRING);
                                    } else{
                                        $question = '';
                                    }
                                    $ans1       = filter_var($_POST['ans_1'], FILTER_SANITIZE_STRING);
                                    $ans2       = filter_var($_POST['ans_2'], FILTER_SANITIZE_STRING);
                                    $ans3       = filter_var($_POST['ans_3'], FILTER_SANITIZE_STRING);
                                    $ans4       = filter_var($_POST['ans_4'], FILTER_SANITIZE_STRING);
                                    if(isset($_POST['right'])){
                                        $right  = filter_var($_POST['right'], FILTER_SANITIZE_NUMBER_INT);
                                    } else{
                                        $right = '';
                                    }
                                    //right answer
                                    if ($right == 1){$rightAns = $ans1;}
                                    elseif ($right == 2){$ans2;}
                                    elseif ($right == 3){$ans3;}
                                    elseif ($right == 4){$ans4;}
                                    else {echo 'تم ادخال قيمة خطا';}
                                    // Upload Variables
                                    $imgName = $_FILES['image']['name'];
                                    $imgSize = $_FILES['image']['size'];
                                    $imgTmp	= $_FILES['image']['tmp_name'];
                                    $imgType = $_FILES['image']['type'];
                                    // List Of Allowed File Typed To Upload
                                    $imgAllowedExtension = array("jpeg", "jpg", "png", "gif");
                                    // Get Avatar Extension
                                    $imgs = explode('.', $imgName);
                                    $imgExtension = strtolower(end($imgs));
                                    $formErrors = array();
                                    if (empty($question)) {
                                        $formErrors[] = 'يجب اضافة سؤال';
                                    }
                                    if (empty($ans1)) {
                                        $formErrors[] = 'يجب اضافة اول اجابة';
                                    }
                                    if (empty($ans2)) {
                                        $formErrors[] = 'يجب وضع ثاني اجابة';
                                    }
                                    if (empty($ans3)) {
                                        $formErrors[] = 'يجب اضافة ثالث اجابة';
                                    }
                                    if (empty($ans4)) {
                                        $formErrors[] = 'يجب وضع رابع اجابة';
                                    }
                                    if (empty($right)) {
                                        $formErrors[] = 'يجب وضع الاجابة الصحيحة';
                                    }
                                    if (! empty($imgName) && ! in_array($imgExtension, $imgAllowedExtension)) {
                                    $formErrors[] = 'امتداد الصورة هذا غير متوفر';
                                    }
                                    if (empty($formErrors)) {
                                        $img = $imgName;
                                        $uploads_dir = 'uploads';
                                        move_uploaded_file($imgTmp, "$uploads_dir/$img");
                                        $stmt = $con->prepare("INSERT INTO 
                                            question(ques, added_date, answer_1, answer_2, answer_3, answer_4, right_answer, exam_id, photo)
                                            VALUES(:zques, now(), :zanswer_1, :zanswer_2, :zanswer_3, :zanswer_4, :zright, :exam_id, :zphoto)");
                                        $stmt->execute(array(
                                            'zques' 	    => $question,
                                            'zanswer_1'     => $ans1,
                                            'zanswer_2'     => $ans2,
                                            'zanswer_3'	    => $ans3,
                                            'zanswer_4'  	=> $ans4,
                                            'zright'	    => $right,
                                            'exam_id'	    => $exam_id,
                                            'zphoto'        => $img
                                        ));
                                        if ($stmt) {
                                            echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                                    تم اضافة السؤال بنجاح
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
                                    // Get Variables From The Form
                                    if(isset($_POST['question'])){
                                        $question  = filter_var($_POST['question'], FILTER_SANITIZE_STRING);
                                    } else{
                                        $question = '';
                                    }
                                    $ans1       = filter_var($_POST['ans_1'], FILTER_SANITIZE_STRING);
                                    $formErrors = array();
                                    if (empty($question)) {
                                        $formErrors[] = 'يجب اضافة سؤال';
                                    }
                                    if (empty($ans1)) {
                                        $formErrors[] = 'يجب اضافة اول اجابة';
                                    }
                                    if (empty($formErrors)) {
                                        $stmt = $con->prepare("INSERT INTO 
                                            question(ques, added_date, answer, right_answer, exam_id)
                                            VALUES(:zques, now(), :zanswer, :zright, :exam_id)");
                                        $stmt->execute(array(
                                            'zques' 	  => $question,
                                            'zanswer'     => $ans1,
                                            'zright'	  => $ans1,
                                            'exam_id'	  => $exam_id
                                        ));
                                        if ($stmt) {
                                            echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                                    تم اضافة الكلمة بنجاح
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
                                    $quesid = filter_var($_POST['quesid'], FILTER_SANITIZE_NUMBER_INT);
                                    $check  = checkItem('id', 'question', $quesid);
                                    // If There's Such ID Show The Form
                                    if ($check > 0) {
                                        $stmt = $con->prepare("DELETE FROM question WHERE id = :ques_id");
                                        $stmt->bindParam(":ques_id", $quesid);
                                        $stmt->execute();
                                        if ($stmt) {
                                            echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                                    تم حذف السؤال بنجاح
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>';
                                        }
                                    } else {
                                        echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert" id="alert-message">
                                                هذا السؤال غير موجود 
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>';
                                    }
                                }
                            } elseif($main['type']==2) {
                                if (isset($_POST['add3'])) {
                                    // Get Variables From The Form
                                    if(isset($_POST['part'])){
                                        $part  = filter_var($_POST['part'], FILTER_SANITIZE_STRING);
                                    } else{
                                        $part = '';
                                    }
                                    $number       = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
                                    $time         = filter_var($_POST['time'], FILTER_SANITIZE_STRING);
                                    // Upload Variables
                                    $imgName = $_FILES['image']['name'];
                                    $imgSize = $_FILES['image']['size'];
                                    $imgTmp	= $_FILES['image']['tmp_name'];
                                    $imgType = $_FILES['image']['type'];
                                    // List Of Allowed File Typed To Upload
                                    $imgAllowedExtension = array("jpeg", "jpg", "png", "gif");
                                    // Get Avatar Extension
                                    $imgs = explode('.', $imgName);
                                    $imgExtension = strtolower(end($imgs));
                                    $formErrors = array();
                                    if (empty($part)) {
                                        $formErrors[] = 'يجب اضافة جزء';
                                    }
                                    if (! empty($imgName) && ! in_array($imgExtension, $imgAllowedExtension)) {
                                    $formErrors[] = 'امتداد الصورة هذا غير متوفر';
                                    }
                                    if (empty($formErrors)) {
                                        $img = $imgName;
                                        $uploads_dir = 'uploads';
                                        move_uploaded_file($imgTmp, "$uploads_dir/$img");
                                        $stmt = $con->prepare("INSERT INTO 
                                            part(part_name, exam_id, number, photo, date, time)
                                            VALUES(:part_name, :exam_id, :number, :photo, now(), :time)");
                                        $stmt->execute(array(
                                            'part_name'  => $part,
                                            'exam_id'    => $exam_id,
                                            'number'     => $number,
                                            'photo'      => $img,
                                            'time'       => $time
                                        ));
                                        if ($stmt) {
                                            echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                                    تم اضافة الجزء بنجاح
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
                                    $quesid = filter_var($_POST['quesid'], FILTER_SANITIZE_NUMBER_INT);
                                    $check  = checkItem('part_id', 'part', $quesid);
                                    // If There's Such ID Show The Form
                                    if ($check > 0) {
                                        $stmt = $con->prepare("DELETE FROM part WHERE part_id = :ques_id");
                                        $stmt->bindParam(":ques_id", $quesid);
                                        $stmt->execute();
                                        if ($stmt) {
                                            echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                                    تم حذف الجزء بنجاح
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>';
                                        }
                                    } else {
                                        echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert" id="alert-message">
                                                هذا الجزء غير موجود 
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
                                <?php if($main['type']==1){
                                    $stmt = $con->prepare("SELECT question.*,exams.exam_name AS exam_name
                                                            FROM question
                                                            INNER JOIN 
                                                                exams 
                                                            ON 
                                                                exams.exam_id  = question.exam_id 
                                                            WHERE exams.exam_id = ?
                                                            ORDER BY id DESC");
                                    $stmt->execute(array($exam_id));
                                    $rows = $stmt->fetchAll();
                                    if (! empty($rows)) {
                                ?>
                                <div class="card-body ">
                                    <h4 class="card-title ">الاسئلة الجزئية</h4>
                                    <div class="table-responsive ">
                                        <table class="table "id="datatableid">
                                            <thead>
                                                <tr>
                                                    <th>رقم السؤال</th>
                                                    <th>السؤال</th>
                                                    <th> تاريخ الاضافة</th>
                                                    <th> الأمتحان</th>
                                                    <th>لوحة التحكم</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
							            foreach($rows as $row) {?>
                                            <tr>
                                                <td> <?php echo $row['id'];?></td>
                                                <td>
                                                    <!-- <img src="layout/images/faces/face1.jpg " class="mr-2 " alt="image "> -->
                                                    <?php echo $row['ques'];?>
                                                </td>
                                                <td> <?php echo $row['added_date'];?></td>
                                                <td> <?php echo $row['exam_name'];?></td>
                                                <td>
                                                    <button type="button " class="btn btn-outline-danger btn-sm delete_ques"data-toggle="modal" data-target="#remove">حذف</button>
                                                    <input type="hidden" value="<?php echo $row['id'];?>" id="question_id">
                                                </td>
                                            </tr>
                                        <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php } } elseif($main['type']==2) { 
                                    $stmt = $con->prepare("SELECT part.*,exams.exam_name AS exam_name
                                                            FROM part
                                                            INNER JOIN 
                                                                exams 
                                                            ON 
                                                                exams.exam_id  = part.exam_id 
                                                            ORDER BY part_id DESC");
                                    $stmt->execute();
                                    $rows = $stmt->fetchAll();
                                    if (! empty($rows)) {
                                    ?>
                                    <div class="card-body ">
                                        <h4 class="card-title ">الاسئلة الجزئية</h4>
                                        <div class="table-responsive ">
                                            <table class="table "id="datatableid">
                                                <thead>
                                                    <tr>
                                                        <th>رقم الجزء</th>
                                                        <th>الجزء</th>
                                                        <th> تاريخ الاضافة</th>
                                                        <th> عدد الاسئلة</th>
                                                        <th> وقت الامتحان</th>
                                                        <th> الأمتحان</th>
                                                        <th>لوحة التحكم</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                foreach($rows as $row) {?>
                                                    <tr>
                                                        <td> <?php echo $row['part_id'];?></td>
                                                        <td>
                                                            <?php echo $row['part_name'];?>
                                                        </td>
                                                        <td> <?php echo $row['date'];?></td>
                                                        <td> <?php echo $row['number'];?></td>
                                                        <td> <?php echo $row['time'];?></td>
                                                        <td> <?php echo $row['exam_name'];?></td>
                                                        <td>
                                                            <button type="button " class="btn btn-outline-danger btn-sm delete_ques"data-toggle="modal" data-target="#remove">حذف</button>
                                                            <input type="hidden" value="<?php echo $row['part_id'];?>" id="question_id">
                                                            <button type="button " class="btn btn-gradient-dark btn-sm"><a href="part_content.php?part_id=<?php echo $row['part_id']; ?>" style="text-decoration: none;color:#ccc;">تفاصيل</a></button>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php } }?>
                            </div>
                        </div>
                    </div>
                    <?php if($main['type']==1){?>
                        <div class="modal fade" id="remove" tabindex="-1" aria-labelledby="removeLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger">
                                        <h2 class="text-light">حذف السؤال </h2>
                                    </div>
                                    <form action="exam_content.php?exam_id=<?php echo $exam_id;?>" method="POST">
                                        <div class="modal-body">
                                            <h3 class="text-center">هل تريد حذف هذا السؤال</h3>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" value="" name="quesid" id="quesid">
                                            <button type="submit" class="btn btn-danger" name="remove">حذف</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-info">
                                        <h2 class="text-light">اضافة الاسئلة </h2>
                                    </div>
                                    <form class="float-right" action="exam_content.php?exam_id=<?php echo $exam_id;?>" method="POST"  enctype="multipart/form-data">
                                        <div class="modal-body">
                                                <div class="form-group ">
                                                    <h4> اضافة السؤال</h4>
                                                    <input type="text" name="question" placeholder=" السؤال" class="form-control" >
                                                </div>
                                                <div class="form-group ">
                                                    <h4> اضافة صورة</h4>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="image" >
                                                        <label class="custom-file-label text-center" for="inputGroupFile01">اختر ملف</label>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <h4> اضافة الاجابة الاولي</h4>
                                                    <input type="text" name="ans_1" placeholder="الاجابة الاول" class="form-control" required>
                                                </div>
                                                <div class="form-group ">
                                                    <h4> اضافة الاجابة الثانية</h4>
                                                    <input type="text" name="ans_2" placeholder="الاجابة الثانية" class="form-control" required>
                                                </div>
                                                <div class="form-group ">
                                                    <h4> اضافة الاجابة الثالثة</h4>
                                                    <input type="text" name="ans_3" placeholder="الاجابة الثالثة" class="form-control" required>
                                                </div>
                                                <div class="form-group ">
                                                    <h4> اضافة الاجابة الرابعة</h4>
                                                    <input type="text" name="ans_4" placeholder="الاجابة الرابعة" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <h4>الاجابة الصحيحة</h4>
                                                    <select name="right" class="form-control" >
                                                        <option disabled selected>...</option>
                                                        <?php
                                                            echo "<option value='1'>" . "الاختيار الاول" . "</option>";
                                                            echo "<option value='2'>" . "الاختيار الثانى" . "</option>";
                                                            echo "<option value='3'>" . "الاختيار الثالث" . "</option>";
                                                            echo "<option value='4'>" . "الاختيار الرابع" . "</option>";
                                                        ?>
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit " class="btn btn-info" name="add">اضافة السؤال</button>    
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
                                        <h2 class="text-light">اضافة الاسئلة المقالية </h2>
                                    </div>
                                    <form class="float-right" action="exam_content.php?exam_id=<?php echo $exam_id;?>" method="POST"  enctype="multipart/form-data">
                                        <div class="modal-body">
                                                <div class="form-group ">
                                                    <h4> اضافة السؤال</h4>
                                                    <input type="text" name="question" placeholder=" السؤال" class="form-control" >
                                                </div>
                                                <div class="form-group ">
                                                    <h4> اضافة الاجابة</h4>
                                                    <input type="text" name="ans_1" placeholder="الاجابة " class="form-control" required>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit " class="btn btn-info" name="add2">اضافة سؤال مقالى</button>    
                                            <button type="button " class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } elseif($main['type']==2) { ?>
                        <div class="modal fade" id="remove" tabindex="-1" aria-labelledby="removeLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger">
                                        <h2 class="text-light">حذف الجزء </h2>
                                    </div>
                                    <form action="exam_content.php?exam_id=<?php echo $exam_id;?>" method="POST">
                                        <div class="modal-body">
                                            <h3 class="text-center">هل تريد حذف هذا الجزء</h3>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" value="" name="quesid" id="quesid">
                                            <button type="submit" class="btn btn-danger" name="remove">حذف</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="add3" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-info">
                                        <h2 class="text-light">اضافة الاجزاء </h2>
                                    </div>
                                    <form class="float-right" action="exam_content.php?exam_id=<?php echo $exam_id;?>" method="POST"  enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="form-group ">
                                                <h4> اضافة الجزء</h4>
                                                <input type="text" name="part" placeholder="اضافة الجزء" class="form-control" required>
                                            </div>
                                            <div class="form-group ">
                                                <h4> اضافة صورة</h4>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="image" >
                                                    <label class="custom-file-label text-center" for="inputGroupFile01">اختر ملف</label>
                                                </div>
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
                                            <button type="submit " class="btn btn-info" name="add3">اضافة الجزء</button>    
                                            <button type="button " class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
    <?php
    include 'includes/templates/footer.php';
    } else {
        header('Location: error-404.html');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
ob_end_flush(); 
?>