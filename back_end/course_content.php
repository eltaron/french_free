<?php
	ob_start();
	session_start();
    $pageTitle = 'main';
    $Title = 'main';
	include 'inital.php';
    include "check_token.php";
    $getUser = $con->prepare("SELECT * FROM members WHERE username = ?");
    $getUser->execute(array($sessionUser));
    $info = $getUser->fetch();
    if (isset($_SESSION['user']) && $info['regstatus'] == 1) {
        include $tpl . 'header2.php'; 
        $username  = $info['username'];
        $groupid  = $info['groupid'];
        $category_id = isset($_GET['catygory_id']) && is_numeric($_GET['catygory_id']) ? intval($_GET['catygory_id']) : 0;
        $getlessons = $con->prepare("SELECT * FROM lessons WHERE cat_id = ?");
        $getlessons->execute(array($category_id));
        $count = $getlessons->rowCount();
        if ($count > 0) {
            $lessons = $getlessons->fetchAll();
            $categories = $con->prepare("SELECT category_name, image, category_description FROM category where category_id = ?");
            $categories->execute(array($category_id));
            $category = $categories->fetch();
?>
    <section class="section11" style="direction: rtl;">
        <div class="container">
            <div class="row">
                <div class="card text-center">
                    <div class="card-header">
                        <h2><?php echo $category['category_name'];?></h2>
                        <p><?php echo $category['category_description'];?></p>
                    </div>
                    <img src="admin/uploads/<?php echo $category['image'];?>"  class="card-img-top">
                    <div class="card-footer text-muted">
                        <h3>محتويات الكورس</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                        <?php foreach($lessons as $index => $lesson){ ?>
                            <div class="col-lg-4">
                                <div class="card">
                                    <img class="card-img-top" src="admin/uploads/<?php echo $category['image'];?>" alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $lesson['lesson_name']; ?></h5>
                                        <p class="card-text"><?php
                                        $stringCut = substr( $lesson['lesson_description'], 0, 100);
                                        $endPoint = strrpos($stringCut, ' ');
                                        $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                        echo $string ;?></p>
                                        <?php 
                                        $getexam = $con->prepare("SELECT exam_id FROM exams WHERE lesson_id = ? AND type = 1 ");
                                        $getexam->execute(array($lesson['lesson_id']));
                                        $getexam = $getexam->fetch();
                                        if(! empty($getexam)){
                                            echo '<a href="exam.php?exam_id='.$getexam['exam_id'].'" >الامتحان</a>';
                                        }
                                        ?>
                                        <a href="lesson.php?lesson_id=<?php echo $lesson['lesson_id']; ?>" >الدرس</a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php 
        include $tpl . 'footer.php'; 
        include $tpl . 'scripts.php'; 
        } else { 
            header('Location: course_main.php');
            exit();
        }
}else {
    header('Location: index.php');
    exit();
}
ob_end_flush();
?>