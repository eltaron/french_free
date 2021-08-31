<?php 

if (isset($_SESSION['user'])) { 
    $result = $con->prepare("SELECT token FROM user_token where username= ?");
    $result->execute(array($_SESSION['user']));
    $count = $result->rowCount();
    if ($count > 0) {
        $row = $result->fetch(); 
        $token = $row['token']; 
        if($_SESSION['token'] !== $token){
            session_destroy();
            header('Location: index.php');
        }
    }
}