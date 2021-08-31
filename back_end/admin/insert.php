<?php 
include 'connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_member'])) {
        $formErrors = array();
        $username 	= filter_var($_POST['username'],FILTER_SANITIZE_STRING);
        $password 	= filter_var($_POST['password'],FILTER_SANITIZE_STRING);
        $password2 	= filter_var($_POST['password2'],FILTER_SANITIZE_STRING);
        $email      = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
        $phone      = filter_var($_POST['phone'],FILTER_SANITIZE_NUMBER_INT);
        $class      = $_POST['parent'];
        if (isset($username)) {
            if (strlen($username) < 4) {$formErrors[] = 'اسم المستخدم يجب ان يكون اكبر من 4 احرف';}
        }
        if (isset($password)) {
            if (strlen($password) < 4) {$formErrors[] = 'كلمة المرور يجب ان تكون اكبر من 4 ارقام';}
        }
        if (isset($password) && isset($password2)) {
            if (empty($password)) {$formErrors[] = ' كلمة المرور لا يجب ان تكون فارغة ';}
            if (sha1($password) !== sha1($password2)) {$formErrors[] = 'كلمة المرور غير متطابقة';}
        }
        if (isset($phone)) {
            if (strlen($phone) < 8) {$formErrors[] = 'رقم الهاتف يجب ان يكون اكبر من 8 ارقام';}
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
                            members(username, password, phone, groupid, email, regstatus, date)
                                    VALUES(:zuser, :zpass, :zphone, :zclass, :zemail, 0, now())");
                $stmt->execute(array(
                    'zuser' => $username,
                    'zpass' => sha1($password),
                    'zphone' => $phone,
                    'zclass' => $class,
                    'zemail' => $email
                ));
                $succesMsg = 'لقد تم تسجيل البيانات قم بتسجيل الدخول';
                header('Location: reg.php');
                exit();
                
            }
        }
    }
}
?>