<?php
	ob_start();
	session_start();
    $pageTitle = 'main';
    $Title = 'main';
	include 'inital.php';
    include "check_token.php";
    $getUser = $con->prepare("SELECT * FROM members WHERE username = ?");
    $getUser->execute(array($sessionUser));
    $info = $getUser->fetch();
    if (isset($_SESSION['user']) && $info['regstatus'] == 1) {
        include $tpl . 'header2.php';
        $username  = $info['username'];
        $groupid  = $info['groupid'];
        $lesson_id = isset($_GET['lesson_id']) && is_numeric($_GET['lesson_id']) ? intval($_GET['lesson_id']) : 0;
        $getlessons = $con->prepare("SELECT * FROM lessons WHERE lesson_id = ?");
        $getlessons->execute(array($lesson_id));
        $count = $getlessons->rowCount();
        if ($count > 0) {
            $lesson = $getlessons->fetch();
            $stmt = $con->prepare("SELECT 
                                    answer.mark  
                                FROM 
                                    answer
                                INNER JOIN 
                                    exams 
                                ON 
                                    exams.exam_id = answer.exam_id
                                where 
                                    exams.lesson_id = ?
                                AND
                                    exams.type = 1
                                ");
            $stmt->execute(array($lesson['lesson_id']));
            $mark = $stmt->fetch();
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['add'])) {
                    $stmt = $con->prepare("SELECT * FROM lesson_member WHERE lesson_id = ? AND member_id = ?");
                    $stmt->execute(array($lesson['lesson_id'], $_SESSION['uid']));
                    $count = $stmt->rowCount();
                    if ($count ==  0) { 
                        $stmt = $con->prepare("INSERT INTO 
                            lesson_member(lesson_id, member_id, date, cat_id, type)
                            VALUES(:lesson, :member, NOW(), :cat_id, 1)");
                        $stmt->execute(array(
                            'lesson' 	=> $lesson['lesson_id'],
                            'member' 	=> $_SESSION['uid'],
                            'cat_id'    => $lesson['cat_id']
                        ));
                    }
                }
                if (isset($_POST['end'])) {
                    $stmt = $con->prepare("SELECT * FROM lesson_member WHERE lesson_id = ? AND member_id = ? and type = 1");
                    $stmt->execute(array($lesson['lesson_id'], $_SESSION['uid']));
                    $count = $stmt->rowCount();
                    if ($count ==  1) { 
                        $stmt = $con->prepare("UPDATE lesson_member 
                                                SET type = 2, last_date = now()
                                                WHERE lesson_id = ? AND member_id = ? ");
                        $stmt->execute(array($lesson['lesson_id'], $_SESSION['uid']));
                    }
                }
            }
?>
            <?php if ($lesson['Approve'] > 0 || $mark['mark'] > 5){ ?>
                <section class="section11" style="direction: rtl;">
                    <div class="container">
                        <div class="row">
                            <div class="card text-center" style="width: 100%; padding:0;">
                                <div class="card-header">
                                    <h2><?php echo $lesson['lesson_name']; ?></h2>
                                    <h5 class="text-left text-muted"><?php echo $lesson['lesson_data']; ?></h5>
                                </div>
                                <div class="video main_video">
                                    <?php 
                                        $stmt = $con->prepare("SELECT * FROM lesson_member WHERE lesson_id = ? AND member_id = ?");
                                        $stmt->execute(array($lesson['lesson_id'], $_SESSION['uid']));
                                        $count = $stmt->rowCount();
                                        if ($count ==  0) {
                                    ?>
                                            <form action="lesson.php?lesson_id=<?php echo $lesson['lesson_id']; ?>" method="POST">
                                                <button name="add" type="submit" class="main_button">بدء الدرس</button>
                                            </form>
                                    <?php 
                                        } else {
                                            if($lesson['video'] != ''){
                                                echo '
                                                <div class="embed-responsive embed-responsive-16by9">
                                                    '.$lesson['video'].'
                                                </div>
                                                ';
                                            } else {
                                                echo '
                                                <video width="100%" controls controlsList="nodownload" oncontextmenu="return false;">
                                                    <source src="admin/uploads/'.$lesson['video_name'].'">
                                                </video> 
                                                ';
                                            }
                                        }
                                    ?> 
                                </div>
                                <div class="card-footer">
                                    <?php 
                                    $stmt = $con->prepare("SELECT * FROM lesson_member WHERE lesson_id = ? AND member_id = ? AND type = 1");
                                    $stmt->execute(array($lesson['lesson_id'], $_SESSION['uid']));
                                    $count = $stmt->rowCount();
                                    if ($count ==  1) {?>
                                        <h5 class="text-right pt-3">انهاء الدرس</h5>
                                        <form class="text-right" action="lesson.php?lesson_id=<?php echo $lesson['lesson_id']; ?>" method="POST">
                                            <button name="end" type="submit" class="main_btn mt-3" style="padding: 7px 46px;">انهاء</button>
                                        </form>
                                    <?php } ?>
                                    <h5 class="text-right pt-3">تفاصيل الدرس</h5>
                                    <p class="text-right pb-3"><?php echo $lesson['lesson_description']; ?></p>
                                    <?php
                                        if(! empty($lesson['pdf'])){
                                            echo '
                                            <h5 class="text-right">للحصول على ورق الشرح يرجى تتبع الرابط </h5>
                                            <a href="'.$lesson['pdf'].'" class="float-right">ورق الشرح</a>
                                            ';
                                        }  
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php } else {
                echo '
                    <section style="height:500px">
                        <div class="container">
                            <div class="alert alert-warning alert-dismissible fade show text-center" style="font-size:20px;margin-top:150px;" role="alert">
                            هذا الدرس غير متوفر الا عند اداء الامتحان المخصص له 
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                        </div>
                    </section>
                ';
            }
            include $tpl . 'footer.php'; 
            include $tpl . 'scripts.php'; 
        } else { 
            header('Location: 404-error.php');
            exit();
        }
}else {
    header('Location: index.php');
    exit();
}
ob_end_flush();
?>