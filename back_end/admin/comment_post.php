<?php
ob_start(); // Output Buffering Start
session_start();
$pageTitle = 'Comment_post';
if (isset($_SESSION['username'])) {
    include 'inital.php';
    include 'includes/templates/header.php';
    include 'includes/templates/side.php';
    ?>
            <div class="main-panel ">
                <div class="content-wrapper ">
                    <div class="page-header ">
                        <h3 class="page-title ">
                            <span class="page-title-icon bg-gradient-primary text-white mr-2 ">
                                <i class="mdi mdi-home "></i>
                            </span>&nbsp; تعليقات المنشورات
                        </h3>
                    </div>
                    <?php 
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if (isset($_POST['remove'])) {
                                $comment_id = filter_var($_POST['comment_id'], FILTER_SANITIZE_NUMBER_INT);
                                $check  = checkItem('comment_id', 'comments', $comment_id);
                                // If There's Such ID Show The Form
                                if ($check > 0) {
                                    $stmt = $con->prepare("DELETE FROM comments WHERE comment_id = :comment ");
                                    $stmt->bindParam(":comment", $comment_id);
                                    $stmt->execute();
                                    if ($stmt) {
                                        echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                                تم حذف التعليق بنجاح
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert" id="alert-message">
                                            هذا التعليق غير موجود 
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>';
                                }
                            }
                            if (isset($_POST['activiate'])) {
                                $comment_id = filter_var($_POST['comment_id'], FILTER_SANITIZE_NUMBER_INT);
                                $check  = checkItem('comment_id', 'comments', $comment_id);
                                // If There's Such ID Show The Form
                                if ($check > 0) {
                                    $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE comment_id = ?");
                                    $stmt->execute(array($comment_id));
                                    $stmt->execute();
                                    if ($stmt) {
                                        echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                                تم تفعيل التعليق بنجاح
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert" id="alert-message">
                                            هذا التعليق غير موجود 
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>';
                                }
                            }
                        }
                        $stmt = $con->prepare("SELECT 
                                                comments.*, members.username AS Member, post.post_name AS post_name
                                                FROM 
                                                    comments
                                                INNER JOIN 
                                                    members 
                                                ON 
                                                    members.userid = comments.member_id
                                                INNER JOIN 
                                                    post 
                                                ON 
                                                    post.post_id = comments.post_id 
                                                AND 
                                                    post.type = 0
                                                ORDER BY 
                                                    comment_id DESC");
                                $stmt->execute(array());
                                $rows = $stmt->fetchAll();
                                if (! empty($rows)) {
                    ?>
                    <div class="row ">
                        <div class="col-12 grid-margin ">
                            <div class="card ">
                                <div class="card-body ">
                                    <h4 class="card-title ">تعليقات المنشورات</h4>
                                    <div class="table-responsive ">
                                        <table class="table " id="datatableid">
                                            <thead>
                                                <tr>
                                                    <th> رقم التعليق</th>
                                                    <th> التعليق</th>
                                                    <th>  تاريخ التعليق</th>
                                                    <th> الطالب</th>
                                                    <th>المنشور</th>
                                                    <th>لوحة التحكم</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
							            foreach($rows as $row) {?>
                                            <tr>
                                                <td> <?php echo $row['comment_id'];?></td>
                                                <td><?php echo $row['comment'];?></td>
                                                <td> <?php echo $row['comment_data'];?></td>
                                                <td> <?php echo $row['Member'];?></td>
                                                <td> <?php echo $row['post_name'];?></td>
                                                <td>
                                                    <button type="button " class="btn btn-outline-danger btn-sm delete_comment"data-toggle="modal" data-target="#remove">حذف</button>
                                                    <input type="hidden" value="<?php echo $row['comment_id'];?>" id="comment">
                                                    <?php  if($row['status']== 0){echo'<button type="button " class="btn btn-outline-primary btn-sm activiate_comment" data-toggle="modal" data-target="#activiate">تفعيل</button>';} ?>
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
                    <div class="modal fade" id="remove" tabindex="-1" aria-labelledby="removeLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                    <h2 class="text-light">حذف التعليق </h2>
                                </div>
                                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <div class="modal-body">
                                        <h3 class="text-center">هل تريد حذف التعليق</h3>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" value="" name="comment_id" id="comment_id">
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
                                    <h2 class="text-light">اظهار التعليق</h2>
                                </div>
                                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <div class="modal-body">
                                        <h3 class="text-center">هل تريد اظهار التعليق</h3>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" value="" name="comment_id" id="comment_id_2">
                                        <button type="submit" class="btn btn-primary" name="activiate">تفعيل</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php }
include 'includes/templates/footer.php';
} else {
    header('Location: index.php');
    exit();
}
ob_end_flush(); 
?>