<?php
ob_start(); // Output Buffering Start
session_start();
$pageTitle = 'Members';
if (isset($_SESSION['username'])) {
    include 'inital.php';
    $query = '';
        include 'includes/templates/header.php';
        include 'includes/templates/side.php';
    ?>
    <div class="main-panel ">
        <div class="content-wrapper ">
            <div class="page-header ">
                <h3 class="page-title ">
                    <span class="page-title-icon bg-gradient-primary text-white mr-2 ">
                        <i class="mdi mdi-home "></i>
                    </span>&nbsp; الاعضاء
                </h3>
                <div>
                <button style=" color:darkblue;font-size:20px " type="button " class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#group">تعديل العضو</button>
                <button style="color:darkblue;font-size:20px " type="button " class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#disabled_all">الغاء تفعيل حساب الجميع</button>    
                <button style=" color:darkblue;font-size:20px " type="button " class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#add">أضافة عضو</button>
                </div>
            </div>
            <?php 
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['add_member'])) {
                        $username 	= filter_var($_POST['username'], FILTER_SANITIZE_STRING);
                        $email 	    = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                        $password 	= filter_var($_POST['password'], FILTER_SANITIZE_STRING);
                        $phone      = filter_var($_POST['phone'],FILTER_SANITIZE_NUMBER_INT);
                        $parent 	= $_POST['parent'];
                        if (isset($username)) {
                            if (strlen($username) < 4) {$formErrors[] = 'اسم المستخدم يجب ان يكون اكبر من 4 احرف';}
                        }
                        if (isset($password)) {
                            if (strlen($password) < 4) {$formErrors[] = 'كلمة المرور يجب ان تكون اكبر من 4 ارقام';}
                        }
                        // Check If There's No Error Proceed The User Add
                        if (empty($formErrors)) {
                            // Check If User Exist in Database
                            $check = checkItem("username", "members", $username);
                            if ($check == 1) {
                                echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert" id="alert-message">
                                            هذا المستخدم موجود بالفعل
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>';
                            } else {
                                // Insert Userinfo In Database
                                $stmt = $con->prepare("INSERT INTO 
                                            members(username, password, phone, groupid, email, regstatus, date)
                                                    VALUES(:zuser, :zpass, :zphone, :zclass, :zemail, 1, now())");
                                $stmt->execute(array(
                                    'zuser' => $username,
                                    'zpass' => sha1($password),
                                    'zphone' => $phone,
                                    'zclass' => $parent,
                                    'zemail' => $email,

                                ));
                                if ($stmt) {
                                    echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                            تم اضافة العضو بنجاح
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>';
                                }
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
                        $userid = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT);
                        $check  = checkItem('userid', 'members', $userid);
                        // If There's Such ID Show The Form
                        if ($check > 0) {
                            $stmt = $con->prepare("DELETE FROM members WHERE userid = :zuser");
                            $stmt->bindParam(":zuser", $userid);
                            $stmt->execute();
                            if ($stmt) {
                                echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                        تم حذف العضو بنجاح
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert" id="alert-message">
                                    هذا المستخدم غير موجود 
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                        }
                    }
                    if (isset($_POST['activiate'])) {
                        $userid = filter_var($_POST['user_id'], FILTER_SANITIZE_NUMBER_INT);
                        $check  = checkItem('userid', 'members', $userid);
                        // If There's Such ID Show The Form
                        if ($check > 0) {
                            $stmt = $con->prepare("UPDATE members SET regstatus = 1 WHERE userid = ?");
                            $stmt->execute(array($userid));
                            $stmt->execute();
                            if ($stmt) {
                                echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                        تم تفعيل حساب العضو بنجاح
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert" id="alert-message">
                                    هذا المستخدم غير موجود 
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                        }
                    }
                    if (isset($_POST['edit'])) {
                        $userid     = filter_var($_POST['user_id'], FILTER_SANITIZE_NUMBER_INT);
                        $username 	= filter_var($_POST['username'], FILTER_SANITIZE_STRING);
                        $email 	    = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                        $password 	= filter_var($_POST['password'], FILTER_SANITIZE_STRING);
                        $phone      = filter_var($_POST['phone'],FILTER_SANITIZE_NUMBER_INT);
                        $parent 	= $_POST['parent'];
                        if (isset($username)) {
                            if (strlen($username) < 4) {$formErrors[] = 'اسم المستخدم يجب ان يكون اكبر من 4 احرف';}
                        }
                        if (isset($password)) {
                            if (strlen($password) < 4) {$formErrors[] = 'كلمة المرور يجب ان تكون اكبر من 4 ارقام';}
                        }
                        // Check If There's No Error Proceed The User Add
                        if (empty($formErrors)) {
                            // Check If User Exist in Database
                            $check = checkItem("username", "members", $username);
                            if ($check == 1) {
                                $stmt = $con->prepare("UPDATE members SET username = ?,email = ?, password = ?, phone = ?, groupid = ? WHERE userid = ?");
						        $stmt->execute(array($username, $email, sha1($password), $phone , $parent, $userid ));
                                if ($stmt) {
                                    echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                            تم تعديل العضو بنجاح
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>';
                                }
                            } else {
                                echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert" id="alert-message">
                                            اسم المستخدم  موجود
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
                    if (isset($_POST['disabled_all'])) {
                            $stmt = $con->prepare("UPDATE members SET regstatus = 0 ");
                            $stmt->execute();
                            $stmt->execute();
                            if ($stmt) {
                                echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                        تم الغاء تفعيل حساب الجميع بنجاح
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                            }
                    }
                    if (isset($_POST['group'])) {
                        $parent 	= $_POST['parent'];
                        $check = checkItem("username", "members", $_SESSION['username']);
                        if ($check == 1) {
                            $stmt = $con->prepare("UPDATE members SET groupid = ? WHERE userid = ?");
                            $stmt->execute(array( $parent, $_SESSION['ID'] ));
                            if ($stmt) {
                                echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                        تم تعديل العضو بنجاح
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert" id="alert-message">
                                        اسم المستخدم غير موجود
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                        }
                    }
                    if (isset($_POST['not_activiate'])) {
                        $cat_id = filter_var($_POST['cat_id'], FILTER_SANITIZE_NUMBER_INT);
                        $check  = checkItem('userid', 'members', $cat_id);
                        // If There's Such ID Show The Form
                        if ($check > 0) {
                            $stmt = $con->prepare("UPDATE members SET regstatus = 0 WHERE userid = ?");
                            $stmt->execute(array($cat_id));
                            $stmt->execute();
                            if ($stmt) {
                                echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                        تم الغاء تفعيل الطالب بنجاح
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert" id="alert-message">
                                    هذا الطالب غير موجود 
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                        }
                    }
                }
                $stmt = $con->prepare("SELECT 
                                        members.*, 
                                        category.category_name as category_name
                                        FROM members 
                                        inner join category
                                        on category.category_id = members.groupid
                                        ORDER BY userid DESC");
                $stmt->execute(array());
                $rows = $stmt->fetchAll();
                if (! empty($rows)) {
            ?>
            <div class="row ">
                <div class="col-12 grid-margin ">
                    <div class="card ">
                        <div class="card-body ">
                            <h4 class="card-title ">الطلاب </h4>
                            <div class="table-responsive ">
                                <table class="table" id="datatableid">
                                    <thead>
                                        <tr>
                                            <th>الرقم التعريفي</th>
                                            <th> اسم المستخدم </th>
                                            <th>رقم الهاتف</th>
                                            <th>تاريخ التسجيل</th>
                                            <th> الصف</th>
                                            <th>لوحة التحكم</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
							            foreach($rows as $row) {?>
                                            <tr>
                                                <td> <?php echo $row['userid'];?></td>
                                                <td>
                                                    <?php echo $row['username'];?>
                                                </td>
                                                <td><?php  echo $row['phone']; ?></td>
                                                <td> <?php echo $row['date'];?></td>
                                                <td> <?php echo $row['category_name'];?></td>
                                                <td>
                                                    <button type="button " class="btn btn-outline-success btn-sm edit"data-toggle="modal" data-target="#edit">تعديل</button>
                                                    <button type="button " class="btn btn-outline-danger btn-sm delete"data-toggle="modal" data-target="#remove">حذف</button>
                                                    <input type="hidden" value="<?php echo $row['userid'];?>" id="userid_2">
                                                    <?php  
                                                        if($row['regstatus']== 0) {
                                                                echo'<button type="button " class="btn btn-outline-primary btn-sm activiate" data-toggle="modal" data-target="#activiate">تفعيل</button>';
                                                            } else {
                                                                echo'<button type="button " class="btn btn-outline-dark btn-sm not_activiate" data-toggle="modal" data-target="#not_activiate">الغاء التفعيل</button>';
                                                            }
                                                    ?>
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
            <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h2 class="text-light">اضافة عضو </h2>
                        </div>
                        <form class="float-right" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                            <div class="modal-body">
                                    <div class="form-group ">
                                        <h4>الاسم</h4>
                                        <input type="text" name="username" autocomplete="off"  placeholder=" اسم المستخدم " required class="form-control inputName " id="Name ">
                                    </div>
                                    <div class="form-group ">
                                        <h4>البريد الالكترونى</h4>
                                        <input type="email" name="email" class="form-control Description"  placeholder="البريد الالكترونى يجب ان يكون صحيح" >
                                    </div>
                                    <div class="form-group ">
                                        <h4>كلمة المرور</h4>
                                        <input type="password" name="password"  class="form-control Description "  autocomplete="new-password" placeholder="الرقم السرى يجب ان يكون صعب توقعة" required>
                                    </div>
                                    <div class="form-group ">
                                        <h4>رقم الهاتف </h4>
                                        <input type="tel" name="phone"  class="form-control Description "  placeholder="ادخل رقم الهاتف">
                                    </div>
                                    <div class="form-group ">
                                        <h4>الصف</h4>
                                        <select class="custom-select form-control" name="parent">
                                            <?php 
                                                $stmt = $con->prepare("SELECT 
                                                                        category_name, category_id, ordering 
                                                                        FROM category 
                                                                        where parent = 0
                                                                        ");
                                                $stmt->execute(array());
                                                $rows = $stmt->fetchAll();
                                                foreach($rows as $row) {
                                            ?>
                                                <option value="<?php echo $row['category_id'];?>"><?php echo $row['category_name'];?></option>
                                            <?php 
                                                if($row['ordering'] == 6){echo '<option disabled ><hr></option>';}
                                            } ?>
                                        </select>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit " class="btn btn-info" name="add_member">اضافة عضو</button>    
                                <button type="button " class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="remove" tabindex="-1" aria-labelledby="removeLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h2 class="text-light">حذف عضو </h2>
                        </div>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                            <div class="modal-body">
                                <h3 class="text-center">هل تريد حذف هذاالشخص</h3>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" value="" name="userid" id="userid">
                                <button type="submit" class="btn btn-danger" name="remove">حذف</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="activiate" tabindex="-1" aria-labelledby="removeLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h2 class="text-light">تفعيل حساب عضو </h2>
                        </div>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                            <div class="modal-body">
                                <h3 class="text-center">هل تريد تفعيل حساب هذاالشخص</h3>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" value="" name="user_id" id="userid_3">
                                <button type="submit" class="btn btn-primary" name="activiate">تفعيل</button>
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
                            <h2 class="text-light">تعديل حساب عضو </h2>
                        </div>
                        <form class="float-right" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                            <div class="modal-body">
                                    <div class="form-group ">
                                        <h4>الاسم</h4>
                                        <input type="text" name="username" autocomplete="off"  placeholder=" اسم المستخدم " class="form-control inputName " id="Name ">
                                    </div>
                                    <div class="form-group ">
                                        <h4>البريد الالكترونى</h4>
                                        <input type="email" name="email" class="form-control Description"  placeholder="البريد الالكترونى يجب ان يكون صحيح" >
                                    </div>
                                    <div class="form-group ">
                                        <h4>كلمة المرور</h4>
                                        <input type="password" name="password"  class="form-control Description "  autocomplete="new-password" placeholder="الرقم السرى يجب ان يكون صعب توقعة" required>
                                    </div>
                                    <div class="form-group ">
                                        <h4>رقم الهاتف </h4>
                                        <input type="tel" name="phone"  class="form-control Description "  placeholder="ادخل رقم الهاتف">
                                    </div>
                                    <div class="form-group ">
                                        <h4>الصف</h4>
                                        <select class="custom-select form-control" name="parent">
                                            <?php 
                                                $stmt = $con->prepare("SELECT 
                                                                        category_name, category_id, ordering 
                                                                        FROM category 
                                                                        where parent = 0
                                                                        ");
                                                $stmt->execute(array());
                                                $rows = $stmt->fetchAll();
                                                foreach($rows as $row) {
                                            ?>
                                                <option value="<?php echo $row['category_id'];?>"><?php echo $row['category_name'];?></option>
                                            <?php 
                                                if($row['ordering'] == 6){echo '<option disabled ><hr></option>';}
                                            } ?>
                                        </select>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="edit" class="btn btn-success">تعديل</button>
                                <input type="hidden" value="" name="user_id" id="userid_4">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="disabled_all" tabindex="-1" aria-labelledby="removeLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-dark">
                            <h2 class="text-light">الغاء تفعيل الجميع</h2>
                        </div>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                            <div class="modal-body">
                                <h3 class="text-center">هل تريد الغاء تفعيل حساب الجميع</h3>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-dark" name="disabled_all">الغاء التفعيل</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="not_activiate" tabindex="-1" aria-labelledby="removeLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-dark">
                            <h2 class="text-light">الغاء تفعيل العضو</h2>
                        </div>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                            <div class="modal-body">
                                <h3 class="text-center">هل تريد الغاء اظهار العضو </h3>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" value="" name="cat_id" id="user_id_4">
                                <button type="submit" class="btn btn-dark" name="not_activiate">الغاء التفعيل</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
<?php } ?>
            <div class="modal fade" id="group" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h2 class="text-light">تعديل عضو </h2>
                        </div>
                        <form class="float-right" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                            <div class="modal-body">
                                    <div class="form-group ">
                                        <h4>الصف</h4>
                                        <select class="custom-select form-control" name="parent">
                                            <?php 
                                                $stmt = $con->prepare("SELECT 
                                                                        category_name, category_id, ordering 
                                                                        FROM category 
                                                                        where parent = 0
                                                                        ");
                                                $stmt->execute(array());
                                                $rows = $stmt->fetchAll();
                                                foreach($rows as $row) {
                                            ?>
                                                <option value="<?php echo $row['category_id'];?>"><?php echo $row['category_name'];?></option>
                                            <?php 
                                                if($row['ordering'] == 6){echo '<option disabled ><hr></option>';}
                                            } ?>
                                        </select>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit " class="btn btn-info" name="group">تعديل</button>    
                                <button type="button " class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
<?php
include 'includes/templates/footer.php';
?>
<?php
} else {
    header('Location: index.php');
    exit();
}
ob_end_flush(); 
?>