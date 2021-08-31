<?php
ob_start(); // Output Buffering Start
session_start();
$pageTitle = 'Events';
if (isset($_SESSION['username'])) {
    include 'inital.php';
    include 'includes/templates/header.php';
    include 'includes/templates/side.php';
    $sort= '';
    ?>
            <div class="main-panel ">
                <div class="content-wrapper ">
                    <div class="page-header ">
                        <h3 class="page-title ">
                            <span class="page-title-icon bg-gradient-primary text-white mr-2 ">
                                <i class="mdi mdi-home "></i>
                            </span>&nbsp; المهام
                        </h3>
                        <button style="margin-right:150px; color:darkblue; font-size:15px" type="button " class="btn btn-outline-info btn-sm"data-toggle="modal" data-target="#add">أضافة مهمة</button>
                    </div>
                    <?php 
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if (isset($_POST['add'])) {
                                $name 	       = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                                $description   = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
                                $date          = $_POST['date'];
                                $time          = $_POST['time'];
                                $parent        = filter_var($_POST['parent'], FILTER_SANITIZE_NUMBER_INT);
                                if (isset($name)) {
                                    if (strlen($name) < 4) {$formErrors[] = 'اسم القسم يجب ان يكون اكبر من 4 احرف';}
                                }
                                if (isset($description)) {
                                    if (strlen($description) < 4) {$formErrors[] = 'وصف القسم يجب ان يكون اكبر من 4 ارقام';}
                                }
                                if (empty($formErrors)) {
                                        $stmt = $con->prepare("INSERT INTO 
                                            events(events_name, events_description,events_date,events_time, cat_id)
                                        VALUES(:vname, :vdesc,:vdate,:vtime, :cat_id)");
                                        $stmt->execute(array(
                                            'vname' 	=> $name,
                                            'vdesc' 	=> $description,
                                            'vdate' 	=> $date,
                                            'vtime' 	=> $time,
                                            'cat_id'    => $parent
                                        ));
                                        if ($stmt) {
                                            echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                                    تم اضافة المهمة بنجاح
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
                            if (isset($_POST['remove'])) {
                                $eventid = filter_var($_POST['eventid'], FILTER_SANITIZE_NUMBER_INT);
                                $check  = checkItem('events_id','events',$eventid);
                                if ($check > 0) {
                                    $stmt = $con->prepare("DELETE FROM events WHERE events_id = :vevent");
                                    $stmt->bindParam(":vevent", $eventid);
                                    $stmt->execute();
                                    if ($stmt) {
                                        echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                                تم حذف المهمة بنجاح
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert" id="alert-message">
                                            هذة المهمة غير موجودة 
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>';
                                }
                            }
                            if (isset($_POST['edit'])) {
                                $name 	       = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                                $description   = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
                                // $userid        = filter_var($_POST['user'],FILTER_SANITIZE_NUMBER_INT);
                                $eventid        = filter_var($_POST['eventid'], FILTER_SANITIZE_NUMBER_INT);
                                $date          = filter_var($_POST['date'], FILTER_SANITIZE_NUMBER_INT);
                                $time          = filter_var($_POST['time'], FILTER_SANITIZE_NUMBER_INT);
                                if (empty($formErrors)) {
                                    $stmt = $con->prepare("UPDATE events SET events_name = ?,events_description=?,events_date=?,events_time=? WHERE events_id =?");
                                    $stmt->execute(array($name, $description,$date,$time,$eventid));
                                    if ($stmt) {
                                        echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                                تم تعديل المهمة بنجاح
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
                        }
                        $stmt = $con->prepare("SELECT *, category.category_name as category_name
                                                from events 
                                                inner join category
                                                on category.category_id = events.cat_id
                                                Order by events_id DESC");
                        $stmt->execute(array());
                        $rows = $stmt->fetchAll();
                        if (! empty($rows)) {
                    ?>
                    <div class="row ">
                        <div class="col-12 grid-margin ">
                            <div class="card ">
                                <div class="card-body ">
                                    <h4 class="card-title ">المهام</h4>
                                    <div class="table-responsive ">
                                        <table class="table" id="datatableid">
                                            <thead>
                                                <tr>
                                                    <th> رقم المهمة </th>
                                                    <th> اسم المهمة </th>
                                                    <th> تاريخ المهمة </th>
                                                    <th> ميعاد المهمة </th>
                                                    <th>القسم</th>
                                                    <th>لوحة التحكم</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach($rows as $row) {?>
                                                <tr>
                                                    <td> <?php echo $row['events_id'];?></td>
                                                    <td> <?php echo $row['events_name'];?></td>
                                                    <td> <?php echo $row['events_date'];?></td>
                                                    <td> <?php echo $row['events_time'];?></td>
                                                    <td> <?php echo $row['category_name'];?></td>
                                                    <td>
                                                        <button type="button " class="btn btn-outline-success btn-sm edit_event"data-toggle="modal" data-target="#edit">تعديل</button>
                                                        <input type="hidden" value="<?php echo $row['events_id'];?>" id="event">
                                                        <button type="button " class="btn btn-outline-danger btn-sm delete_event"data-toggle="modal" data-target="#remove">حذف</button>
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
                <?php } ?>
                    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <h2 class="text-light">اضافة مهمة</h2>
                                </div>
                                <form class="float-right" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="form-group ">
                                            <h4>اسم المهمة</h4>
                                            <input type="text" name="name"  placeholder=" اسم المهمة " required class="form-control inputName ">
                                        </div>
                                        <div class="form-group ">
                                            <h4>تفاصيل المهمة</h4>
                                            <textarea class="form-control" placeholder="تفاصيل  المهمة" name="description" style="height: 150px;"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <h4>تاريخ المهمة</h4>
                                            <input type="date" name="date"  placeholder="تاريخ المهمة" required class="form-control inputName ">
                                        </div>
                                        <div class="form-group">
                                            <h4>ميعاد المهمة</h4>
                                            <input type="time" name="time"  placeholder="ميعاد المهمة" required class="form-control inputName ">
                                        </div>
                                        <div class="form-group ">
                                            <h4>القسم</h4>
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
                                        <button type="submit " class="btn btn-info" name="add">اضافة مهمة</button>    
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
                                    <h2 class="text-light">حذف المهمة</h2>
                                </div>
                                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <div class="modal-body">
                                        <h3 class="text-center">هل تريد حذف هذة المهمة</h3>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" value="" name="eventid" id="eventid_2">
                                        <button type="submit" class="btn btn-danger" name="remove">حذف</button>
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
                                    <h2 class="text-light">تعديل المهمة</h2>
                                </div>
                                <form class="float-right" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <div class="modal-body">
                                            <div class="form-group ">
                                                <h4>اسم المهمة</h4>
                                                <input type="text" name="name"  placeholder=" اسم المهمة" class="form-control inputName " required>
                                            </div>
                                            <div class="form-group ">
                                                <h4>تفاصيل المهمة</h4>
                                                <textarea class="form-control" name="description" style="height: 150px;" required></textarea>
                                            </div>
                                            
                                        <div class="form-group">
                                            <h4>تاريخ المهمة</h4>
                                            <input type="date" name="date"  placeholder="تاريخ المهمة" required class="form-control inputName ">
                                        </div>

                                        <div class="form-group">
                                            <h4>ميعاد المهمة</h4>
                                            <input type="time" name="time"  placeholder="ميعاد المهمة" required class="form-control inputName ">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit " class="btn btn-success" name="edit">تعديل المهمة</button> 
                                        <input type="hidden" value="" name="eventid" id="event_2">   
                                        <button type="button " class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                    </div>
                                </form>
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