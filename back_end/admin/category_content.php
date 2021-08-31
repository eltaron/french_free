<?php
ob_start(); // Output Buffering Start
session_start();
$pageTitle = 'Category';
if (isset($_SESSION['username'])) {
    include 'inital.php';
    $category_id = isset($_GET['category_id']) && is_numeric($_GET['category_id']) ? intval($_GET['category_id']) : 0;
    $stmt = $con->prepare("SELECT * FROM category where category_id = ?");
    $stmt->execute(array($category_id));
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
                                </span>&nbsp; <?php echo $row['category_name']; ?> 
                            </h3>
                        </div>
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title"><?php echo $row['category_name']; ?></h4>
                                        <div class="d-flex">
                                            <div class="d-flex align-items-center text-muted font-weight-light">
                                                <span class="badge badge-success">قسم رئيسي</span>
                                            </div>
                                        </div>
                                        <div class="mt-5 align-items-top">
                                            <h2>التفاصيل</h2>
                                            <p><?php echo $row['category_description']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-lg-12 grid-margin ">
                                <div class="card ">
                                    <div class="card-body ">
                                        <h4> الطلبة بالقسم</h4>
                                        <div class="table-responsive " id="printTable">
                                            <table class="table" id="datatableid" >
                                                <thead>
                                                    <tr>
                                                        <th>الرقم التعريفي</th>
                                                        <th>اسم الطالب</th>
                                                        <th>رقم الهاتف</th>
                                                        <th>تاريخ الانضمام</th>
                                                        <th>الحالة</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                <?php 
                                                    $members = $con->prepare("SELECT *
                                                                                FROM members 
                                                                                inner join category
                                                                                on category.category_id = members.groupid
                                                                                where category.category_id = ?
                                                                                ORDER BY userid  desc");
                                                    $members->execute(array($category_id));
                                                    $members = $members->fetchAll();
                                                    foreach($members as $member){
                                                        echo '
                                                            <td>'.$member['userid'].'</td>
                                                            <td>'.$member['username'].'</td>
                                                            <td>'.$member['phone'].'</td>
                                                            <td>'.$member['date'].'</td>
                                                        ';
                                                        if($member['regstatus'] == 1){
                                                            echo '<td><label class="badge badge-success">مفعل</label></td>';
                                                        } else {
                                                            echo '<td><label class="badge badge-warning">غير مفعل</label></td>';
                                                        }
                                                    }
                                                ?>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <button id="print" class="btn btn-gradient-info mt-3 float-left">الطباعة</button>
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
                        