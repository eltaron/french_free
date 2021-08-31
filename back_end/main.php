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
        $categories = $con->prepare("SELECT category_name, category_id FROM category where parent = 0 And category_id= ? ORDER BY category_id asc");
        $categories->execute(array($groupid));
        $category_name = $categories->fetch();
?>
    <main id="main">
        <section class="section11">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="nav flex-column nav-pills text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <div class="main">
                                <img src="assets/img/online-course.png">
                                <h2>المحتوى الدراسى</h2>
                                <p class="font-weight-light"><?php echo $category_name['category_name'];?></p>
                            </div>
                            <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">جميع الكورسات</a>
                            <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">الامتحانات الشاملة</a>
                            <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">البث المباشر</a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                <h2 class="text-right"> البث المباشر</h2>
                                <div class="row text-right">
                                <?php
                                    $stmt = $con->prepare("SELECT 
                                                                * 
                                                                FROM 
                                                                    category
                                                                WHERE 
                                                                    parent = ?
                                                                AND
                                                                    Visibility = 1 
                                                                ORDER BY ordering desc");
                                    $stmt->execute(array($category_name['category_id']));
                                    $categories = $stmt->fetchAll();
                                    foreach($categories as $category){
                                ?>
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <img class="card-img-top" src="admin/uploads/<?php echo $category['image']; ?>" alt="Card image cap">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo $category['category_name']; ?></h5>
                                                <p class="card-text"><?php echo $category['category_description']; ?></p>
                                                <a href="course_content.php?catygory_id=<?php echo $category['category_id']; ?>" >الذهاب للكورس</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                <h2 class="text-right"> الامتحانات الشامله</h2>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">الامتحان</th>
                                            <th scope="col">تاريخ الامتحان</th>
                                            <th scope="col">نوع الامتحان</th>
                                            <th scope="col"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $formErrors = array(); 
                                            $stmt = $con->prepare("SELECT 
                                                                        *  
                                                                    FROM 
                                                                        exams
                                                                    WHERE 
                                                                        type = 2 
                                                                    ORDER BY exam_date desc");
                                            $stmt->execute();
                                            $exams = $stmt->fetchAll();
                                            foreach($exams as $exam) {
                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $exam['exam_name']; ?></th>
                                            <td><?php echo $exam['exam_date']; ?></td>
                                            <td>
                                                <?php 
                                                    if($exam['exam_desc'] == ''){
                                                        echo '<label class="bg-primary text-light" style="font-size: 15px;">على المنصة</label>';
                                                    } else {
                                                        echo '<label class="bg-warning text-light" style="font-size: 15px;">Form</label>';
                                                    }
                                                ?>
                                            </td>
                                            <td><a href="
                                            <?php 
                                                    if($exam['exam_desc'] != ''){
                                                        echo $exam['exam_desc'];
                                                    } else {
                                                        echo 'full_exam.php?full_exam_id='.$exam['exam_id'];
                                                    }
                                                ?>
                                            ">الذهاب للامتحان</a></td>
                                        </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                <h2 class="text-right"> البث المباشر</h2>
                                <?php
                                    $formErrors = array(); 
                                    $stmt = $con->prepare("SELECT 
                                                                    *  
                                                            FROM 
                                                                live
                                                            WHERE 
                                                                cat_id = ? 
                                                            limit 1");
                                    $stmt->execute(array($groupid));
                                    $live = $stmt->fetch();
                                    if(isset($live['live_id'])){ ?>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">تاريخ الامتحان</th>
                                                    <th scope="col">البث المباشر</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td><?php echo $live['date']; ?></td>
                                                    <td><a href="<?php echo $live['link']; ?>">الذهاب للبث</a></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } else { ?>
                                    <h2 class="text-primary text-center"> لا يوجد بث الان</h2>
                                    <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php
include $tpl . 'footer.php'; 
include $tpl . 'scripts.php'; 
}else {
    header('Location: index.php');
    exit();
}
ob_end_flush();
?>