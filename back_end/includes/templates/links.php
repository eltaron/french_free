<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>le Génie</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@800&display=swap" rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
    <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <?php 
        if($pageTitle == 'main'){
            echo '
                <link rel="stylesheet" href="assets/css/main_content.css">
            ';
        }
        if($pageTitle == 'activities'){
            echo '
                <link rel="stylesheet" href="assets/css/activity.css">
            ';
        }
        if($pageTitle == 'postContent'){
            echo '
                <link rel="stylesheet" href="assets/css/posts.css">
            ';
        }
        if($pageTitle == 'free' || $pageTitle == 'posts' || $pageTitle = 'register' || $pageTitle == 'posts2' || $pageTitle == 'events'){
            echo '
                <link href="assets/css/main.css" rel="stylesheet">
            ';
        }
        if($Title == 'exam'){
            echo '
                <link rel="stylesheet" href="assets/css/main_content.css">
                <link rel="stylesheet" href="assets/css/countdown-lights.css" />
            ';
        }
    ?>
</head>