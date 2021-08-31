<?php
include("connect.php");
$key=$_POST['id'];  
$stmt = $con->prepare("SELECT 
                            answer.*,members.username AS username
                        FROM 
                            answer
                        INNER JOIN 
                            members 
                        ON 
                            members.userid  = answer.user_id 
                        WHERE 
                            exam_id = ? 
                        ORDER BY date desc");
$stmt->execute(array($key));
$exams = $stmt->fetchAll();
if(!empty($exams)){
    ?>
    <tr class="bg-dark text-light" style="font-weight: bold;">
        <td > الاسم</td>
        <td> نتيجة الامتحان</td>
        <td> تاريخ اداء الامتحان</td>
    </tr>
    <?php
    foreach($exams as $exam){ ?>
        <tr>
            <td><?php echo $exam['username'] ?></td>
            <td ><?php echo $exam['mark'] ?></td>
            <td><?php echo $exam['date'] ?></td>
        </tr>
    <?php }
} else{
    echo '<h2>لا يوجد اجابات لهذا الامتحان بعد</h2>';
}