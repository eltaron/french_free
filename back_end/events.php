<?php
ob_start();
session_start();
$pageTitle = 'events';
$Title = 'events';
include 'inital.php';
include "check_token.php";
$getUser = $con->prepare("SELECT * FROM members WHERE username = ?");
$getUser->execute(array($sessionUser));
$info = $getUser->fetch();
if (isset($_SESSION['user']) && $info['regstatus'] == 1) { 
    include $tpl . 'header2.php'; 
    $groupid   = $info['groupid'];
    $getposts = $con->prepare("SELECT * FROM events where cat_id = ? ORDER BY events_id DESC");
    $getposts->execute(array($groupid));
    $events = $getposts->fetchAll();
?>
    <section id="events" class="events" style="direction: rtl;">
        <div class="container" data-aos="fade-up">
            <div class="section-header">
                <h2 class="mt-4">المهام</h2>
            </div>
            <div class="row">
                <?php foreach($events as $event){ ?>
                    <div class="col-md-6 d-flex align-items-stretch">
                        <div class="card">
                            <div class="card-img">
                                <img src="assets/img/events-1.jpg">
                            </div>
                            <div class="card-body">
                                <?php 
                                    $date    = new DateTime($event['events_date']);
                                    $result  = $date->format('m');
                                    $result2 = $date->format('d');
                                    $result3 = $date->format('Y');
                                    if($result == '01'){$result = 'يناير';}
                                    if($result == '02'){$result = 'فبراير';}
                                    if($result == '03'){$result = 'مارس';}
                                    if($result == '04'){$result = 'ابريل';}
                                    if($result == '05'){$result = 'مايو';}
                                    if($result == '06'){$result = 'يونيو';}
                                    if($result == '07'){$result = 'يوليو';}
                                    if($result == '08'){$result = 'اغسطس';}
                                    if($result == '09'){$result = 'سبتمبر';}
                                    if($result == '10'){$result = 'اكتوبر';}
                                    if($result == '11'){$result = 'نوفمبر';}
                                    if($result == '12'){$result = 'ديسمبر';}
                                ?>
                                <h5 class="card-title"><?php echo $event['events_name'];?></h5>
                                <p class="font-italic text-center"><?php echo $result2. '/' . $result . '/' . $result3 . '   - الساعة (' . $event['events_time'] . ')'  ;?></p>
                                <p><?php echo $event['events_description'];?></p>          
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php
include $tpl . 'footer.php'; 
include $tpl . 'scripts.php'; 
} else {
    header('Location: index.php');
    exit();
}
ob_end_flush();
?>