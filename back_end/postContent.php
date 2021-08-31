<?php
ob_start();
session_start();
$pageTitle = 'postContent';
$Title = 'postContent';
include 'inital.php';
include "check_token.php";
$getUser = $con->prepare("SELECT * FROM members WHERE username = ?");
$getUser->execute(array($sessionUser));
$info = $getUser->fetch();
if (isset($_SESSION['user']) && $info['regstatus'] == 1) { 
    include $tpl . 'header2.php'; 
    $post_id = isset($_GET['postid']) && is_numeric($_GET['postid']) ? intval($_GET['postid']) : 0;
    $getposts = $con->prepare("SELECT * FROM post where post_id = ?");
    $getposts->execute(array($post_id));
    $post = $getposts->fetch();
?>
    <section class="section10 text-right" style="direction: rtl; margin-top: 7rem!important;">
        <div class="container">
            <?php 
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $comment 	= filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                $userid 	= $_SESSION['uid'];
                if (! empty($comment)) {
                    $stmt = $con->prepare("INSERT INTO 
                        comments(comment, status, comment_data, post_id, member_id)
                        VALUES(:zcomment, 0, NOW(), :post_id, :zuserid)");
                    $stmt->execute(array(
                        'zcomment' => $comment,
                        'post_id' => $post_id,
                        'zuserid' => $userid
                    ));
                    if ($stmt) {
                        echo '<div class="alert mt-3 alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                تم اضافة التعليق في انتظار الموافقة
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
                    }
                } else {
                    echo '<div class="alert mt-3 alert-warning alert-dismissible text-center fade show" role="alert" id="alert-message">
                            يجب عليك اضافة التعليق
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
                }
            }
            ?>
            <div class="card mb-3 mt-3">
            <?php
                if (isset($post['post_image']) && $post['post_image'] !== '') {
                    echo '<img src="admin/uploads/'.$post['post_image'].'" class="card-img-top" style="height: 500px;">';
                } else{
                    echo '<img src="assets/img/important.jpg" class="card-img-top" style="height: 500px;">';
                }
            ?>
                <div class="card-body">
                    <h2 class="card-title"><?php echo $post['post_name'] ;?></h2>
                    <p class="card-text"><small class="text-muted"><?php echo $post['post_data'] ;?></small></p>
                    <p class="card-text"><?php echo $post['post_description'] ;?>
                    </p>
                    <hr>
                    <div class="main_comments">
                        <h2> التعليقات</h2>
                        <?php    
                $stmt = $con->prepare("SELECT 
                                            comments.*, members.username AS Member, members.avatar As image  
                                        FROM 
                                            comments
                                        INNER JOIN 
                                            members 
                                        ON 
                                            members.userid = comments.member_id
                                        WHERE 
                                            post_id = ?
                                        AND 
                                            status = 1
                                        ORDER BY 
                                            post_id desc");
                $stmt->execute(array($post['post_id']));
                $comments = $stmt->fetchAll();
            ?>
                        
                        <?php 
                    foreach ($comments as $comment) {
                        ?>
                        <div class="row mb-3">
                            <div class="col-1">
                            <img src="assets/img/group.png" class="card-img-top" alt="...">
                            </div>
                            <div class="col-11">
                                <h3><?php echo $comment['Member'] ?></h3>
                                <p><?php echo $comment['comment'] ?></p>
                            </div>
                            </div>
                            <?php
                    }
                ?>
                        
                        
                    <hr>
                    <form  action="postContent.php?postid=<?php echo $post['post_id'] ;?>" method="POST">
                        <h2>اضافة التعليقات</h2>
                        <textarea name="comment" placeholder="اضافة تعليق"></textarea>
                        <button type="submit">ارسال</button>
                    </form>
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
