<?php
	ob_start();
	session_start();
    $pageTitle = 'exam';
    $Title = 'exam';
	include 'inital.php';
    include "check_token.php";
    $getUser = $con->prepare("SELECT * FROM members WHERE username = ?");
    $getUser->execute(array($sessionUser));
    $info = $getUser->fetch();
    if (isset($_SESSION['user']) && $info['regstatus'] == 1) {
        include $tpl . 'header2.php'; 
        $username  = $info['username'];
        $groupid  = $info['groupid'];
        $exam_id = isset($_GET['exam_id']) && is_numeric($_GET['exam_id']) ? intval($_GET['exam_id']) : 0;
        $getexam = $con->prepare("SELECT * FROM exams WHERE exam_id  = ? AND type = 1");
        $getexam->execute(array($exam_id));
        $count = $getexam->rowCount();
        if ($count > 0) {
            $exam = $getexam->fetch();
            $numbers = $exam['number']; 
            $time    = $exam['time']; 
            $answers = array(); 
            $stmt = $con->prepare("SELECT 
                                        * 
                                    FROM 
                                        question
                                    where
                                    exam_id = ?
                                    ORDER BY RAND() 
                                    LIMIT " . $numbers );
            $stmt->execute(array($exam_id));
            $exams = $stmt->fetchAll();
?>
                <section class="section11">
                    <div class="container">
                        <div class="row">
                            <form  action="end.php?exam_id=<?php echo $exam['exam_id'];?>" method="POST" style="width: 100%;">
                                <div class="card text-center" style="margin-bottom: 0;">
                                    <div class="card-header">
                                        <h2><?php echo $exam['exam_name']; ?></h2>
                                        <h5><?php echo $exam['number']; ?> سؤال</h5>
                                        <h5 class="text-left text-muted"><?php echo $exam['exam_date']; ?></h5>
                                    </div>
                                    <div id="demoB" style="width: 100%; direction:ltr;"></div>
                                        <div class="card-body">
                                            <div class="exam_content text-right">
                                                <?php 
                                                    foreach ($exams as $exam ) {
                                                        if(empty($exam['answer'])){ ?>
                                                            <div class="question">
                                                                <h4><?php echo $exam['ques']; ?></h4>
                                                                <?php  
                                                                    if (isset($exam['photo'])&&$exam['photo']!=='') {
                                                                        ?>
                                                                            <img src="admin/uploads/<?php echo $exam['photo']; ?>" class="mb-4" width="100%" height="200">
                                                                        <?php
                                                                    }
                                                                ?>
                                                                <div class="q">
                                                                    <input type="radio" id="chose1" name="<?php echo 'main'.$exam['id']; ?>" value="1">
                                                                    <label for="chose1"><?php echo $exam['answer_1'];?></label>
                                                                </div>
                                                                <div class="q">
                                                                    <input type="radio" id="chose2" name="<?php echo 'main'.$exam['id']; ?>" value="2">
                                                                    <label for="chose2"><?php echo $exam['answer_2'];?></label>
                                                                </div>
                                                                <div class="q">
                                                                    <input type="radio"  id="chose3" name="<?php echo 'main'.$exam['id']; ?>" value="3">
                                                                    <label for="chose3"><?php echo $exam['answer_3'];?></label>
                                                                </div>
                                                                <div class="q">
                                                                    <input type="radio"  id="chose4" name="<?php echo 'main'.$exam['id']; ?>" value="4">
                                                                    <label for="chose4"><?php echo $exam['answer_4'];?></label>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        <?php } else { ?>
                                                        <div class="question">
                                                            <h4> <?php echo $exam['ques']; ?></h4>
                                                            <input type="text" placeholder="اضافة اجابة" class="main_question" name="<?php echo 'main'.$exam['id']; ?>" required>
                                                        </div>
                                                <?php } } ?>
                                            </div>
                                        </div>
                                </div>
                                <div class="content_control text-center">
                                    <div class="center_content">
                                        <button type="submit" name="exam" class="btn main_btn">ارسال الامتحان</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
                
<?php 
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