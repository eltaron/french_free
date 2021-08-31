<?php 
ob_start();
session_start();
if (isset($_SESSION['username'])) {
    $pageTitle = 'Dashboard';
    include 'inital.php';
    $numUsers = 8;
    $latestUsers = getLatest("*", "members", "userid", $numUsers);
    $numlessons = 6;
    $latestlessons = getLatest("*", 'lessons', 'lesson_id', $numlessons);
    $numposts = 6;
    $latestposts = getLatest("*", 'post', 'post_id', $numposts);
    $nummessage = 7;
    $message = getLatest("*", 'message', 'id', $nummessage);
    $numComments = 4;
    $member_1 = checkItem("groupid ", 'members', 1);
    $member_2 = checkItem("groupid ", 'members', 2);
    $member_3 = checkItem("groupid ", 'members', 3);
    $member_4 = checkItem("groupid ", 'members', 4);
    $member_5 = checkItem("groupid ", 'members', 5);
    $member_6 = checkItem("groupid ", 'members', 6);

    $member_13 = checkItem("groupid ", 'members', 7);
    $member_14 = checkItem("groupid ", 'members', 8);
    $member_15 = checkItem("groupid ", 'members', 9);
    $member_16 = checkItem("groupid ", 'members', 10);
    $member_17 = checkItem("groupid ", 'members', 11);
    $member_18 = checkItem("groupid ", 'members', 12);

    $member_19 = checkItem("groupid ", 'members', 13);
    $member_20 = checkItem("groupid ", 'members', 14);
    $member_21 = checkItem("groupid ", 'members', 15);
    $member_22 = checkItem("groupid ", 'members', 16);
    $member_23 = checkItem("groupid ", 'members', 17);
    $member_24 = checkItem("groupid ", 'members', 18);
include 'includes/templates/header.php';
include 'includes/templates/side.php';
?>
<div class="main-panel ">
    <div class="content-wrapper ">
        <div class="page-header ">
            <h3 class="page-title ">
                <span class="page-title-icon bg-gradient-primary text-white mr-2 ">
                <i class="mdi mdi-home "></i>
                </span>&nbsp; الصفحه الرئيسية
            </h3>
        </div>
        <div class="row">
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                    <div class="card-body">
                        <img src="layout/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image">
                        <h4 class="font-weight-normal mb-3"> عدد الطلاب <i class="mdi mdi-account-multiple-plus mdi-24px float-right"></i>
                        </h4>
                        <h2 class="mb-5"> <?php echo countItems('userid', 'members') ?> طالب </h2>
                        
                    </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img src="layout/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image">
                    <h4 class="font-weight-normal mb-3"> عدد الامتحانات <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"> <?php echo countItems('exam_id', 'exams') ?> امتحان</h2>
                   
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                  <div class="card-body">
                    <img src="layout/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image">
                    <h4 class="font-weight-normal mb-3"> عدد الدروس <i class="mdi mdi-note-multiple-outline mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"> <?php echo countItems('lesson_id', 'lessons') ?> درس </h2>
                  </div>
                </div>
              </div>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">احصائيات الطلاب</h4>
                        <canvas id="areaChart" style="height:250px"></canvas>
                        <input type="hidden" id="num_1" value="<?php echo $member_1;?>">
                        <input type="hidden" id="num_2" value="<?php echo $member_2;?>">
                        <input type="hidden" id="num_3" value="<?php echo $member_3;?>">
                        <input type="hidden" id="num_4" value="<?php echo $member_4;?>">
                        <input type="hidden" id="num_5" value="<?php echo $member_5;?>">
                        <input type="hidden" id="num_6" value="<?php echo $member_6;?>">

                        <input type="hidden" id="num_13" value="<?php echo $member_13;?>">
                        <input type="hidden" id="num_14" value="<?php echo $member_14;?>">
                        <input type="hidden" id="num_15" value="<?php echo $member_15;?>">
                        <input type="hidden" id="num_16" value="<?php echo $member_16;?>">
                        <input type="hidden" id="num_17" value="<?php echo $member_17;?>">
                        <input type="hidden" id="num_18" value="<?php echo $member_18;?>">

                        <input type="hidden" id="num_19" value="<?php echo $member_19;?>">
                        <input type="hidden" id="num_20" value="<?php echo $member_20;?>">
                        <input type="hidden" id="num_21" value="<?php echo $member_21;?>">
                        <input type="hidden" id="num_22" value="<?php echo $member_22;?>">
                        <input type="hidden" id="num_23" value="<?php echo $member_23;?>">
                        <input type="hidden" id="num_24" value="<?php echo $member_24;?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">احصائيات الموقع</h4>
                        <canvas id="pieChart" style="height:250px"></canvas>
                        <input type="hidden" id="num_7" value="<?php echo countItems('userid', 'members');?>">
                        <input type="hidden" id="num_8" value="<?php echo countItems('lesson_id', 'lessons');?>">
                        <input type="hidden" id="num_9" value="<?php echo countItems('exam_id', 'exams');?>">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">احصائيات الموقع</h4>
                        <canvas id="pieChart2" style="height:250px"></canvas>
                        <input type="hidden" id="num_10" value="<?php echo checkItem('type', 'post', '0');?>">
                        <input type="hidden" id="num_11" value="<?php echo checkItem('type', 'post', '1');?>">
                        <input type="hidden" id="num_12" value="<?php echo countItems('events_id', 'events');?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-12 grid-margin ">
                <div class="card ">
                    <div class="card-body ">
                        <h2> اخرالطلاب</h2>
                        <div class="table-responsive ">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th>الرقم التعريفي</th>
                                        <th> اسم المستخدم </th>
                                        <th> الايميل  </th>
                                        <th>حاله التسجيل</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if (! empty($latestUsers)) {
                                            foreach ($latestUsers as $user) {
                                                    echo '<tr>';
                                                        echo '<td>'.$user['userid']. '</td>';
                                                        echo '<td>'.$user['username']. '</td>';
                                                        echo '<td>'.$user['email']. '</td>';
                                                        echo '<td>';
                                                            if($user['regstatus']==0){echo'<label class="badge badge-gradient-warning">غير مفعل</label>';}
                                                            else {echo'<label class="badge badge-gradient-success"> مفعل</label>';}
                                                        echo '</td>';
                                                    echo '</tr>';
                                                }
                                            } else {
                                                echo 'لا يوجد اعضاء';
                                            }
                                        ?> 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 grid-margin ">
                <div class="card ">
                    <div class="card-body ">
                        <h4> اخر الدروس</h4>
                        <div class="table-responsive ">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th>الرقم التعريفي</th>
                                        <th> اسم الدرس</th>
                                        <th> ورق الشرح</th>
                                        <th> تاريخ النشر</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    if (! empty($latestlessons)) {
										foreach ($latestlessons as $lesson) {
                                                echo '<tr>';
                                                    echo '<td>'.$lesson['lesson_id']. '</td>';
                                                    echo '<td>'.$lesson['lesson_name']. '</td>';
                                                    echo '<td>';
                                                        if($lesson['pdf']==''){echo'<label class="badge badge-gradient-warning">لا يوجد</label>';}
                                                        else {echo'<label class="badge badge-gradient-success"> يوجد ورق شرح</label>';}
                                                    echo '</td>';
                                                    echo '<td>'.$lesson['lesson_data']. '</td>';
                                                echo '</tr>';
                                            }
                                        } else {
                                            echo 'لا يوجد اعضاء';
                                        }
                                    ?> 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 grid-margin ">
                <div class="card ">
                    <div class="card-body ">
                        <h4> اخر الرسائل</h4>
                        <div class="table-responsive ">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th>كاتب الرسالة</th>
                                        <th>الرسالة</th>
                                        <th>التاريخ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
									$stmt = $con->prepare("SELECT 
																message.*, members.username AS Member  
															FROM 
                                                                message
															INNER JOIN 
																members 
															ON 
																members.userid = message.user_id
															ORDER BY 
                                                                id DESC
															LIMIT $nummessage");
									$stmt->execute();
									$comments = $stmt->fetchAll();
									if (! empty($comments)) {
										foreach ($comments as $comment) {
                                                echo '<tr>';
                                                    echo '<td>'; 
                                                        if($comment['user_id']==''){echo $comment['username'];}
                                                        else {echo $comment['Member'];}
                                                    echo '</td>';
                                                    echo '<td>'. $comment['message']. '</td>';
                                                    echo '<td>'. $comment['date']. '</td>';
                                                echo '</tr>';
                                            }
                                        } else {
                                            echo 'لا يوجد اعضاء';
                                        }
                                    ?> 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php 
include 'includes/templates/footer.php';
} else {
    header('Location: index.php');
    exit();
}
ob_end_flush(); 
?>