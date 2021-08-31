<?php 
ob_start();
session_start();
$pageTitle = 'end';
$Title = '';
include 'inital.php';
include "check_token.php";
    $getUser = $con->prepare("SELECT * FROM members WHERE username = ?");
    $getUser->execute(array($sessionUser));
    $info = $getUser->fetch();
    if (isset($_SESSION['user']) && $info['regstatus'] == 1) {
        if (isset($_POST['exam'])) {
            $i=0; 
            $exam_id = isset($_GET['exam_id']) && is_numeric($_GET['exam_id']) ? intval($_GET['exam_id']) : 0;
            $exams = $con->prepare("SELECT number FROM exams WHERE exam_id = ? AND type = 1");
            $exams->execute(array($exam_id));
            $exam = $exams->fetch();
            $number = $exam['number']; 
            $stmt = $con->prepare('SELECT * FROM question where exam_id = ? ORDER BY RAND() 
            LIMIT ' . $number);
            $stmt->execute(array($exam_id));
            $exams = $stmt->fetchAll(); 
            foreach ($exams as $key=>$exam ) { 
                $ques    = $_POST['main' . $exam['id']];
                $answer  = $exam['right_answer'];
                $answer2 = $exam['answer'];
                if($ques == $answer || $ques == $answer2){$i++;}
            }
            $stmt = $con->prepare("SELECT user_id FROM answer WHERE user_id = ? AND exam_id = ?");
            $stmt->execute(array($_SESSION['uid'], $exam_id));
            $count = $stmt->rowCount();
            if ($count ==  0) { 
                $stmt = $con->prepare("INSERT INTO 
                                    answer(exam_id, mark, user_id, date)
                                    VALUES(:exam_id, :mark, :user_id, now())");
                $stmt->execute(array(
                    'exam_id'   => $exam_id,
                    'mark'      => $i,
                    'user_id'   => $_SESSION['uid']
                ));
            }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>TheEvent Bootstrap Template - Speaker Details</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@800&display=swap" rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">
</head>
<style>
    .main_register{background-color: transparent;}
</style>
<body>
<!-- ======= Header ======= -->
<!-- End Header -->
    <div class="register" style="height: 100vh;">
        <div class="row">
            <div class="col-md-3 register-left error_left">
                <img src="assets/img/eiffel-tower.png" alt=""/>
                <h3 style="color: #fff;">مرحبا</h3>
                <p>للمتابعة والدخول للدروس قم بأنشاء حساب</p>
            </div>
            <div class="col-md-9 register-right error main_register">
            <h2 class="mb-4"> لقد تم اداء الامتحان بنجاح </h2>
            <table class="table table-bordered" style="direction: rtl;">
                <tbody>
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">النتيجة</th>
                            <th scope="col">النتيجة الكلية</th>
                        </tr>
                    </thead>
                    <tr>
                        <td><h3 class="text-light"><?php echo $i; ?></h3></td>
                        <td><h3 class="text-light"><?php echo $number; ?></h3></td>
                    </tr>
                </tbody>
            </table>
            <a href="main.php">الرئيسية</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php
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