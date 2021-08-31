
<?php
    ob_start();
    session_start();
    $pageTitle = 'register';
    $Title = 'register';
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
            <?php 
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['sign'])) {
                        $formErrors = array();
                        $token = getToken(10);
                        $username 	= filter_var($_POST['username'],FILTER_SANITIZE_STRING);
                        $password 	= filter_var($_POST['password'],FILTER_SANITIZE_STRING);
                        $phone      = filter_var($_POST['phone'],FILTER_SANITIZE_NUMBER_INT);
                        $class      = $_POST['parent'];
                        $MAC = exec('getmac'); 
                        $MAC = strtok($MAC, ' '); 
                        if (isset($username)) {
                            if (strlen($username) < 4) {$formErrors[] = 'اسم المستخدم يجب ان يكون اكبر من 4 احرف';}
                        }
                        if (isset($password)) {
                            if (strlen($password) < 4) {$formErrors[] = 'كلمة المرور يجب ان تكون اكبر من 4 ارقام';}
                        }
                        if (isset($phone)) {
                            if (strlen($phone) < 8) {$formErrors[] = 'رقم الهاتف يجب ان يكون اكبر من 8 ارقام';}
                        }
                        if (empty($class)) {
                            $formErrors[] = 'يجب اختيار القسم';
                        }
                        // Check If There's No Error Proceed The User Add
                        if (empty($formErrors)) {
                            // Check If User Exist in Database
                            $check = checkItem("username", "members", $username);
                            if ($check == 1) {
                                $formErrors[] = 'هذا المستخدم موجود عليك استخدام اسم مستخدم اخر';
                            } else {
                                // Insert Userinfo In Database
                                $stmt = $con->prepare("INSERT INTO 
                                            members(username, password, phone, groupid, regstatus, date, mac)
                                                    VALUES(:zuser, :zpass, :zphone, :zclass, 0, now(), :mac)");
                                $stmt->execute(array(
                                    'zuser' => $username,
                                    'zpass' => sha1($password),
                                    'zphone' => $phone,
                                    'zclass' => $class,
                                    'mac'    => sha1($MAC)
                                ));
                                // Update user token 
                                $ins = $con->prepare("insert into user_token(username,token) VALUES(:zuser, :ztoken)");
                                $ins->execute(array(
                                    'zuser' 	=> $username,
                                    'ztoken'	=> $token
                                ));
                                // Echo Success Message
                                $succesMsg = 'لقد تم تسجيل البيانات قم بتسجيل الدخول';
                                header('Location: reg.php');
                                exit();
                                
                            }
                        }
                    }
                }
            ?>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div dir="rtl" class="row register-form">
                        <h3 class="register-heading"><i class="fa fa-angle-double-left"></i> أنشاء حساب</h3>
                        <?php 
                            if (!empty($formErrors)) {
                                foreach ($formErrors as $error) {
                                    echo '<div class="msg  alert alert-danger text-center" style="margin-top:30px;width:100%;">' . $error . '</div>';
                                }
                            }
                            if (isset($succesMsg)) {
                                echo '<div class="msg success alert alert-success text-center" style="margin-top:30pxwidth:100%;">' . $succesMsg . '</div>';
                            }
                        ?>
                        <div class="col-md-12">
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                <div class="form-group">
                                    <input type="text" class="form-control username" name="username" placeholder="اسم المستخدم" required />
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control phone" name="phone" placeholder="رقم هاتف ولى الامر" required/>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control password" name="password" placeholder="الرقم السرى" value="" required/>
                                </div>
                                <div class="form-row">
                                    <select class="custom-select show_btn" required>
                                        <option selected>الصف</option>
                                        <option value="2" data-show="1">الصف الأول الثانوى</option>
                                        <option value="2" data-show="2">الصف الثانى الثانوى </option>
                                        <option value="2" data-show="3">الصف الثالث الثانوى</option>
                                    </select>
                                </div>
                                <div class="form-row">
                                    <select name="parent" class="custom-select main_select show_item" id="1" required>
                                        <option selected disabled>المجموعة</option>
                                        <option value="1"> المجموعة الاولى</option>
                                        <option value="2">المجموعة الثانية</option>
                                        <option value="3">المجموعة التالتة</option>
                                        <option value="4">المجموعة الرابعة</option>
                                        <option value="5">المجموعة الخامسة</option>
                                        <option value="6">المجموعة السادسة</option>
                                    </select>
                                    <select name="parent" class="custom-select main_select show_item" id="2" required>
                                        <option selected disabled>المجموعة</option>
                                        <option value="7"> المجموعة الاولى</option>
                                        <option value="8">المجموعة الثانية</option>
                                        <option value="9">المجموعة التالتة</option>
                                        <option value="10">المجموعة الرابعة</option>
                                        <option value="11">المجموعة الخامسة</option>
                                        <option value="12">المجموعة السادسة</option>
                                    </select>
                                    <select name="parent" class="custom-select main_select show_item" id="3" required>
                                        <option selected disabled>المجموعة</option>
                                        <option value="13"> المجموعة الاولى</option>
                                        <option value="14">المجموعة الثانية</option>
                                        <option value="15">المجموعة التالتة</option>
                                        <option value="16">المجموعة الرابعة</option>
                                        <option value="17">المجموعة الخامسة</option>
                                        <option value="18">المجموعة السادسة</option>
                                    </select>
                                </div>
                                <button type="submit" name="sign" class="btnRegister center">انشاء حساب</button>
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