<?php
	ob_start();
	session_start();
    $pageTitle = 'main';
    $Title = 'account';
	include 'inital.php';
    include "check_token.php";
    $getUser = $con->prepare("SELECT * FROM members WHERE username = ?");
    $getUser->execute(array($sessionUser));
    $info = $getUser->fetch();
    if (isset($_SESSION['user']) && $info['regstatus'] == 1) {
        include $tpl . 'header2.php'; 
        $username  = $info['username'];
        $groupid  = $info['groupid'];
        $categories = $con->prepare("SELECT category_name, category_id FROM category where parent = 0 And category_id= ? ORDER BY category_id asc");
        $categories->execute(array($groupid));
        $category_name = $categories->fetch();
?>
    <section class="section11 account mt-5">
        <div class="container">
            <?php 
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['sign'])) {
                        // Get Variables From The Form
                        $username 	= filter_var($_POST['username'],FILTER_SANITIZE_STRING);
                        $email 	    = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
                        $phone      = filter_var($_POST['phone'],FILTER_SANITIZE_NUMBER_INT);
                        $password   = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
                        $hashedPass = sha1($password);
                        // Validate The Form
                        $formErrors = array();
                        if (strlen($username) < 4) {
                            $formErrors[] = 'الاسم لا يجب ان يكون اقل من 4 احرف';
                        }
                        if (isset($password)) {
                            if (strlen($password) < 4) {$formErrors[] = 'كلمة المرور يجب ان تكون اكبر من 4 ارقام';}
                        }
                        // Loop Into Errors Array And Echo It
                        foreach($formErrors as $error) {
                            echo '<div class="alert pt-3 alert-danger alert-dismissible text-center fade show" role="alert" id="alert-message">
                                    ' . $error . '
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                        }
                        // Check If There's No Error Proceed The Update Operation
                        if (empty($formErrors)) {
                            // Update The Database With This Info
                            $stmt = $con->prepare("UPDATE members SET username = ?, email = ?, phone = ?, password = ? WHERE userid = ?");
                            $stmt->execute(array($username, $email, $phone, $hashedPass, $_SESSION['uid'] ));
                            // Echo Success Message
                            echo '<div class="alert alert-success alert-dismissible text-center fade show" role="alert" id="alert-message">
                                    تم تعديل البيانات بنجاح
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                        }
                } 
                if (isset($_POST['message'])) { 
                    $comment 	= filter_var($_POST['message_text'], FILTER_SANITIZE_STRING);
                    $userid 	= $_SESSION['uid'];
                    if (! empty($comment)) {
                        $stmt = $con->prepare("INSERT INTO 
                            message(message, user_id, date)
                            VALUES(:message, :user_id, NOW())");
                        $stmt->execute(array(
                            'message' => $comment,
                            'user_id' => $userid
                        ));
                        if ($stmt) {
                            echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                    تم ارسال الرسالة بنجاح
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                        }
                    } else {
                        echo '<div class="alert alert-warning alert-dismissible text-center fade show" role="alert" id="alert-message">
                                يجب عليك اضافة الرساله
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
                    }
                }
            }
            ?>
            <div class="row">
                <div class="col-md-3">
                    <div class="nav flex-column nav-pills text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <div class="main">
                            <img src="assets/img/bussiness-man.png" class="img">
                            <h2><?php echo $info['username']; ?></h2>
                            <p class="font-weight-light"><?php echo $info['email']; ?></p>
                            <h5><?php echo $info['phone']; ?></h5>
                        </div>
                        <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">الحساب الشخصى</a>
                        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">تعديل الحساب</a>
                        <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">نتائج الامتحان</a>
                        <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">تواصل معنا</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active text-right" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <h2>الحساب الشخصى</h2>
                            <form class="sign" action="#">
                                <label for="name">&#8592; اسم المستخدم</label>
                                <input type="text" placeholder="<?php echo $info['username']; ?>" id="name" disabled>
                                <label for="email">&#8592; البريد الالكتروني</label>
                                <input type="text" placeholder="<?php echo $info['email']; ?>" id="email" disabled>
                                <label for="phone">&#8592; رقم الهاتف</label>
                                <input type="text" placeholder="<?php echo $info['phone']; ?>" id="phone" disabled>
                                <label for="group">&#8592; الصف الدراسى</label>
                                <input type="text" placeholder="<?php echo $category_name['category_name'];?>" id="group" disabled >
                                <label for="date">&#8592; تاريخ التسجيل</label>
                                <input type="text" placeholder="<?php echo $info['date']; ?>" id="date" disabled>
                            </form>
                        </div>
                        <div class="tab-pane fade text-right" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <h2>تعديل الحساب</h2>
                            <form class="sign" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                <label for="name">&#8592; اسم المستخدم</label>
                                <input type="text" class="username" name="username" placeholder="<?php echo $info['username']; ?>" id="name" required>
                                <label for="email">&#8592; البريد الالكتروني</label>
                                <input type="email" class="email" name="email" placeholder="<?php echo $info['email']; ?>" id="email" required>
                                <label for="phone">&#8592; رقم الهاتف</label>
                                <input type="number" class="phone" name="phone" placeholder="<?php echo $info['phone']; ?>" id="phone" required>
                                <label for="password">&#8592; كلمة المرور</label>
                                <input type="password" class="password" name="password" id="password" placeholder="كلمة المرور" required>
                                <button type="submit" name="sign">تعديل</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                            <h2 class="text-right"> نتائج الامتحانات</h2>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">الامتحان</th>
                                        <th scope="col">تاريخ الاداء</th>
                                        <th scope="col">النتيجة</th>
                                        <th scope="col">نوع الامتحان</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $formErrors = array(); 
                                            $stmt = $con->prepare("SELECT 
                                                                        answer.*, exams.exam_name AS exam_name, exams.type as type  
                                                                    FROM 
                                                                        answer
                                                                    INNER JOIN 
                                                                        exams 
                                                                    ON 
                                                                        exams.exam_id = answer.exam_id 
                                                                    WHERE 
                                                                        answer.user_id = ? 
                                                                    ORDER BY date desc");
                                            $stmt->execute(array($_SESSION['uid']));
                                            $exams = $stmt->fetchAll();
                                            foreach ($exams as $exam) {  ?>
                                        <tr>
                                            <td><?php echo $exam['exam_name'] ?></td>
                                            <td><?php echo $exam['date'] ?></td>
                                            <td><?php echo $exam['mark'] ?></td>
                                            <td>
                                                <?php 
                                                    if($exam['type'] == 1){
                                                        echo '<label class="bg-primary text-light" style="font-size: 15px;">جزئي</label>';
                                                    } elseif($exam['type'] == 2) {
                                                        echo '<label class="bg-warning text-light" style="font-size: 15px;">شامل</label>';
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade text-right" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                            <h2>تواصل معنا</h2>
                            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                <textarea placeholder="كتابة الرسالة" id="message" name="message_text"></textarea>
                                <button type="submit" name="message">ارسال</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
include $tpl . 'footer.php'; 
include $tpl . 'scripts.php';
}else {
    header('Location: index.php');
    exit();
}
ob_end_flush();
?>