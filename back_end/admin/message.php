<?php
ob_start(); // Output Buffering Start
session_start();
$pageTitle = 'message';
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
                    </span>&nbsp; رسائل الصفحة 
                </h3>
            </div>
            <?php 
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['remove'])) {
                        $message_id = filter_var($_POST['message_id'], FILTER_SANITIZE_NUMBER_INT);
                        $check  = checkItem('id', 'message', $message_id);
                        // If There's Such ID Show The Form
                        if ($check > 0) {
                            $stmt = $con->prepare("DELETE FROM message WHERE id = :comment ");
                            $stmt->bindParam(":comment", $message_id);
                            $stmt->execute();
                            if ($stmt) {
                                echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                        تم حذف الرسالة بنجاح
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert" id="alert-message">
                                    الرسالة غير موجود 
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                        }
                    }
                }
            ?>
            <div class="row ">
                <?php 
                    $stmt = $con->prepare("SELECT 
                                            *
                                        FROM 
                                            message
                                        where
                                            username != ''
                                        ORDER BY 
                                            id DESC");
                        $stmt->execute(array());
                        $rows = $stmt->fetchAll();
                        if (! empty($rows)) { ?>
                            <div class="col-12 grid-margin ">
                                <div class="card ">
                                    <div class="card-body ">
                                        <h4 class="card-title "> رسائل الصفحة</h4>
                                        <h2 class="text-center text-success" style="margin: 15px;">رسائل من خارج المشتركين</h2>
                                        <div class="table-responsive ">
                                            <table class="table " id="datatableid">
                                                <thead>
                                                    <tr>
                                                        <th> رقم الرسالة</th>
                                                        <th> الرسالة</th>
                                                        <th>  تاريخ الرسالة</th>
                                                        <th> اسم المرسل</th>
                                                        <th>الايميل</th>
                                                        <th>لوحة التحكم</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                            foreach($rows as $row) {?>
                                                <tr>
                                                    <td> <?php echo $row['id'];?></td>
                                                    <td><?php echo $row['message'];?></td>
                                                    <td> <?php echo $row['date'];?></td>
                                                    <td> <?php echo $row['username'];?></td>
                                                    <td> <?php echo $row['email'];?></td>
                                                    <td>
                                                        <button type="button " class="btn btn-outline-danger btn-sm delete_message"data-toggle="modal" data-target="#remove">حذف</button>
                                                        <input type="hidden" value="<?php echo $row['id'];?>" id="message">
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <hr>
                                        <?php 
                                            $stmt = $con->prepare("SELECT 
                                                                    message.*, members.username AS Member
                                                                FROM 
                                                                    message
                                                                INNER JOIN 
                                                                    members 
                                                                ON 
                                                                    members.userid = message.user_id
                                                                where
                                                                    user_id != ''
                                                                ORDER BY 
                                                                    id DESC");
                                                $stmt->execute(array());
                                                $rows = $stmt->fetchAll();
                                                if (! empty($rows)) { ?>
                                                    <h2 class="text-center text-success" style="margin: 15px;">رسائل من المشتركين</h2>
                                                    <div class="table-responsive ">
                                                        <table class="table " id="datatableid_2">
                                                            <thead>
                                                                <tr>
                                                                    <th> رقم الرسالة</th>
                                                                    <th> الرسالة</th>
                                                                    <th>  تاريخ الرسالة</th>
                                                                    <th> اسم المرسل</th>
                                                                    <th>لوحة التحكم</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php
                                                        foreach($rows as $row) {?>
                                                            <tr>
                                                                <td> <?php echo $row['id'];?></td>
                                                                <td><?php echo $row['message'];?></td>
                                                                <td> <?php echo $row['date'];?></td>
                                                                <td> <?php echo $row['Member'];?></td>
                                                                <td>
                                                                    <button type="button " class="btn btn-outline-danger btn-sm delete_message"data-toggle="modal" data-target="#remove">حذف</button>
                                                                    <input type="hidden" value="<?php echo $row['id'];?>" id="message">
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php }
                ?>
            </div>
            <div class="modal fade" id="remove" tabindex="-1" aria-labelledby="removeLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h2 class="text-light">حذف الرسالة </h2>
                        </div>
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                            <div class="modal-body">
                                <h3 class="text-center">هل تريد حذف الرسالة</h3>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" value="" name="message_id" id="message_id">
                                <button type="submit" class="btn btn-danger" name="remove">حذف</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
                <?php 
include 'includes/templates/footer.php';
?>
<script>
    $('#datatableid_2').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json"
                }
            });
</script>
<?php
} else {
    header('Location: index.php');
    exit();
}
ob_end_flush(); 
?>