<?php
	session_start();
	$noNavbar = '';
	$pageTitle = 'Login';
	if (isset($_SESSION['username'])) {
		header('Location: dashboard.php'); // Redirect To Dashboard Page
	}
	include 'connect.php';
	// Check If User Coming From HTTP Post Request
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$username = $_POST['user'];
		$password = $_POST['pass'];
		$hashedPass = sha1($password);
		// Check If The User Exist In Database
		$stmt = $con->prepare("SELECT 
									userid, username, password
								FROM 
									members 
								WHERE 
									username = ? 
								AND 
									password = ? 
								AND 
								    only = 1
								LIMIT 1");
		$stmt->execute(array($username, $hashedPass));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		// If Count > 0 This Mean The Database Contain Record About This Username
		if ($count > 0) {
			$_SESSION['username'] = $username; // Register Session Name
            $_SESSION['ID'] = $row['userid']; // Register Session ID
			header('Location: dashboard.php'); // Redirect To Dashboard Page
			exit();
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin</title>
    <link rel="stylesheet" href="layout/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="layout/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="layout/css/style.css">
</head>
<body class="rtl">
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <div class="brand-logo text-center">
                                <img src="layout/images/eiffel-tower.png" class="pl-2" width="160">
                            </div>
                            <h4 style="float:right;">مرحبا بك </h4>
                            <h6 class="font-weight-bold">تسجيل الدخول</h6>
                            <form class="pt-3"  action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="اسم المستخدم" name="user" autocomplete="off" >
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="الرقم السرى"  name="pass" autocomplete="new-password">
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" href="index.php" value="Login">تسجيل دخول</button>
                                </div>
                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                        <input type="checkbox" class="form-check-input"> البقاء متصلا </label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
    </div>
    <script src="layout/js/vendor.bundle.base.js "></script>
    <script src="layout/js/Chart.min.js "></script>
    <script src="layout/js/off-canvas.js "></script>
    <script src="layout/js/hoverable-collapse.js "></script>
    <script src="layout/js/misc.js "></script>
    <script src="layout/js/dashboard.js "></script>
    <script src="layout/js/todolist.js "></script>
</body>
</html>