
<?php
    ob_start();
    session_start();
    $pageTitle = 'login';
    $Title = 'login';
    if (isset($_SESSION['user'])) {
		header('Location: main.php');
	}
    include 'inital.php';
    include $tpl . 'header.php'; 
?>
<div class="register">
    <div class="row">
        <div class="col-md-3 register-left">
            <img src="assets/img/eiffel-tower.png" alt=""/>
            <h3 style="color: #fff;">مرحبا</h3>
            <p>للمتابعة والدخول للدروس قم بأنشاء حساب</p>
        </div>
        <div class="col-md-9 register-right">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div dir="rtl" class="row register-form">
                        <h3 class="register-heading"><i class="fa fa-angle-double-left"></i> تسجيل الدخول</h3>
                        <?php 
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (isset($_POST['login'])) {
                                    $user = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
                                    $pass = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
                                    $hashedPass = sha1($pass);
                                    $MAC = exec('getmac'); 
                                    $MAC = strtok($MAC, ' '); 
                                    // Check If The User Exist In Database
                                    $stmt = $con->prepare("SELECT 
                                                                userid, username, password, only 
                                                            FROM 
                                                                members 
                                                            WHERE 
                                                                username = ? 
                                                            AND 
                                                                password = ?
                                                            AND
                                                                mac = ?");
                                    $stmt->execute(array($user, $hashedPass, sha1($MAC)));
                                    $get = $stmt->fetch();
                                    $count = $stmt->rowCount();
                                    // If Count > 0 This Mean The Database Contain Record About This Username
                                    if ($count > 0) {
                                        $token = getToken(10);
                                        $_SESSION['user'] = $user; // Register Session Name
                                        $_SESSION['uid'] = $get['userid']; // Register User ID in Session
                                        $_SESSION['token'] = $token;
                                        // Update user token 
                                        $result_token = $con->prepare("select count(*) as allcount from user_token where username = ? ");
                                        $result_token->execute(array($user));
                                        $row_token = $result_token->rowCount();
                                        if ($row_token > 0) {
                                            $mod = $con->prepare("update user_token set token = ? where username = ?");
                                            $mod->execute(array($token, $user)); 
                                        } else {
                                            $ins = $con->prepare("insert into user_token(username,token) VALUES(:zuser, :ztoken)");
                                            $ins->execute(array(
                                                'zuser' 	=> $user,
                                                'ztoken'	=> $token
                                            ));
                                        }
                                        header('Location:main.php'); // Redirect To Dashboard Page
                                        exit();
                                    } else {
                                        echo '<div class="alert text-center mt-3 alert-danger alert-dismissible text-center fade show" style="width:100%" role="alert" id="alert-message">
                                        خطأ بالتسجيل
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                                    }
                                } 
                            }
                        ?>
                        <div class="col-md-12">
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                <div class="form-group">
                                    <input type="text" class="form-control username" name="username" placeholder="اسم المستخدم" required />
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control password" name="password" placeholder="الرقم السرى" value="" required/>
                                </div>
                                <button type="submit" name="login" class="btnRegister center mt-4">تسجيل الدخول</button>
                            </div>
                        </form> 
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
<?php 
    include $tpl . 'footer.php'; 
    include $tpl . 'scripts.php'; 
    ob_end_flush();
?>