<?php
ob_start();
session_start();
$pageTitle = 'posts2';
$Title = 'posts2';
include 'inital.php';
include "check_token.php";
$getUser = $con->prepare("SELECT * FROM members WHERE username = ?");
$getUser->execute(array($sessionUser));
$info = $getUser->fetch();
if (isset($_SESSION['user']) && $info['regstatus'] == 1) { 
    include $tpl . 'header2.php'; 
    $getposts = $con->prepare("SELECT * FROM post where type = 1");
    $getposts->execute();
    $posts = $getposts->fetchAll();
?>
    <section class="section_9 text-right mt-5" style="direction: rtl;">
        <div class="container">
            <div class="section-header pt-5">
                <h2>المقالات</h2>
            </div>
            <?php 
                foreach ($posts as $post){
                    ?>
                    <div class="card mb-3">
                        <div class="row no-gutters">
                            <div class="col-md-4" style="padding: 0;">
                                <?php
                                    if (isset($post['post_image']) && $post['post_image'] !== '') {
                                        echo '<img src="admin/uploads/'.$post['post_image'].'" width="100%" height="100%">';
                                    } else{
                                        echo '<img src="layouts/img/x.jpg" width="100%" height="100%">';
                                    }
                                ?>
                            </div>
                            <div class="col-md-8" style="padding: 30px;">
                                <h4><?php echo $post['post_name'] ;?></h4>
                                <p class="card-text"><?php
                                $stringCut = substr( $post['post_description'], 0, 300);
                                $endPoint = strrpos($stringCut, ' ');
                                $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                echo $string ;?></p>
                                <p class="card-text"><small class="text-muted"><?php echo $post['post_data'] ;?></small></p>
                                <a href="postcontent.php?postid=<?php echo $post['post_id'] ;?>">اقرا المزيد....</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            ?>
            <hr>
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