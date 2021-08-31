<?php
ob_start(); // Output Buffering Start
session_start();
$pageTitle = 'Lesson';
if (isset($_SESSION['username'])) {
    include 'inital.php';
    $lesson_id = isset($_GET['lesson_id']) && is_numeric($_GET['lesson_id']) ? intval($_GET['lesson_id']) : 0;
    $stmt = $con->prepare("SELECT * FROM lessons where lesson_id = ?");
    $stmt->execute(array($lesson_id));
    $row = $stmt->fetch();
    if (! empty($row)) {
        include 'includes/templates/header.php';
        include 'includes/templates/side.php';
        ?>
        <div class="main-panel ">
                        <div class="content-wrapper ">
                            <div class="page-header ">
                                <h3 class="page-title ">
                                    <span class="page-title-icon bg-gradient-primary text-white mr-2 ">
                                        <i class="mdi mdi-home "></i>
                                    </span>&nbsp; <?php echo $row['lesson_name']; ?> 
                                </h3>
                            </div>
                            <div class="row">
                                <div class="col-12 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title"><?php echo $row['lesson_name']; ?></h4>
                                            <div class="d-flex">
                                                <div class="d-flex align-items-center text-muted font-weight-light">
                                                    <i class="mdi mdi-clock icon-sm mr-2"></i>
                                                    <span><?php echo $row['lesson_data']; ?></span>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-12 pr-1">
                                                    <?php 
                                                        if(! empty($row['video']) )
                                                        {echo $row['video']; } else {
                                                            echo '<video width="100%" controls autoplay controlsList="nodownload" oncontextmenu="return false;">
                                                                    <source src="uploads/'.$row['video_name'].'">
                                                                </video>';
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="mt-5 align-items-top">
                                                <h2>التفاصيل</h2>
                                                <p><?php echo $row['lesson_description']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-lg-6 grid-margin ">
                                    <div class="card ">
                                        <div class="card-body ">
                                            <h4> الحضور</h4>
                                            <div class="table-responsive " id="printTable">
                                                <table class="table" id="datatableid" >
                                                    <thead>
                                                        <tr>
                                                            <th>الرقم التعريفي</th>
                                                            <th>اسم الطالب</th>
                                                            <th>وقت الحضور</th>
                                                            <th>وقت الانتهاء</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php 
                                                        $lessons = $con->prepare("SELECT lesson_member.*,
                                                                                    members.username as username,
                                                                                    members.userid as userid
                                                                                    FROM lesson_member 
                                                                                    inner join members
                                                                                    on lesson_member.member_id = members.userid
                                                                                    where lesson_member.lesson_id = ? 
                                                                                    ORDER BY lesson_member_id  desc");
                                                        $lessons->execute(array($lesson_id));
                                                        $lessons = $lessons->fetchAll();
                                                        foreach($lessons as $lesson){
                                                            $date  = $lesson['date']; 
                                                            $date  = date('(h:i:s) m/d/Y', strtotime($date));
                                                            $date2 = $lesson['last_date'];
                                                            if(isset($date2)) {
                                                                $date2 = date('(h:i:s) m/d/Y', strtotime($date2));
                                                            } else {
                                                                $date2 = 'لم يتم المشاهدة';
                                                            }
                                                            echo '
                                                                <td>'.$lesson['userid'].'</td>
                                                                <td>'.$lesson['username'].'</td>
                                                                <td>'.$date.'</td>
                                                                <td>'.$date2.'</td>
                                                            ';
                                                        }
                                                    ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <button id="print" class="btn btn-gradient-info mt-3 float-left">الطباعة</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 grid-margin ">
                                    <div class="card ">
                                        <div class="card-body ">
                                            <h4> الغياب</h4>
                                            <div class="table-responsive " id="printTable2">
                                                <table class="table" id="datatableid2">
                                                    <thead>
                                                        <tr>
                                                            <th>الرقم التعريفي</th>
                                                            <th>اسم الطالب</th>
                                                            <th>رقم الهاتف</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php 
                                                        $lessons = $con->prepare("SELECT members.*
                                                                                    FROM members 
                                                                                    inner join lesson_member
                                                                                    on lesson_member.member_id != members.userid
                                                                                    where lesson_member.lesson_id = ? 
                                                                                    And members.groupid = ?
                                                                                    ORDER BY userid  desc");
                                                        $lessons->execute(array($lesson_id, $row['cat_id']));
                                                        $lessons = $lessons->fetchAll();
                                                        foreach($lessons as $lesson){
                                                            echo '
                                                                <td>'.$lesson['userid'].'</td>
                                                                <td>'.$lesson['username'].'</td>
                                                                <td>'.$lesson['phone'].'</td>
                                                            ';
                                                        }
                                                    ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <button id="print2" class="btn btn-gradient-info mt-3 float-left">الطباعة</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
        <?php
        include 'includes/templates/footer.php'; ?>
        <script>
            function printData()
            {
                var divToPrint=document.getElementById("printTable");
                newWin= window.open("");
                newWin.document.write(divToPrint.outerHTML);
                var css =`table, td, th {
                    border: 1px solid black;
                    text-align:center;
                    margin:auto;
                    direction:rtl;
                }
                #datatableid_wrapper .row:first-child{display:none;}
                #datatableid_wrapper .row:last-child{display:none;}
                th {
                    background-color: #7a7878;
                    text-align:center
                }`;
            var div = $("<div />", {
                html: '&shy;<style>' + css + '</style>'
            }).appendTo( newWin.document.body);
                newWin.print();
                newWin.close();
            }

            $('#print').on('click',function(){
            printData();
            })
            function printData2()
            {
                var divToPrint=document.getElementById("printTable2");
                newWin= window.open("");
                newWin.document.write(divToPrint.outerHTML);
                var css =`table, td, th {
                    border: 1px solid black;
                    text-align:center;
                    margin:auto;
                    direction:rtl;
                }
                #printTable2 .row:first-child{display:none;}
                #printTable2 .row:last-child{display:none;}
                th {
                    background-color: #7a7878;
                    text-align:center
                }`;
            var div = $("<div />", {
                html: '&shy;<style>' + css + '</style>'
            }).appendTo( newWin.document.body);
                newWin.print();
                newWin.close();
            }

            $('#print2').on('click',function(){
            printData2();
            })
        </script>
        <?php
    } else {
        header('Location: error-404.html');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
ob_end_flush(); 
?>
                        