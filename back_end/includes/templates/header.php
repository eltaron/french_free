<body>
    <header id="header" class="header-fixed" style="direction: rtl;">
        <div class="container">
            <div id="logo" class="pull-left">
                <!-- Uncomment below if you prefer to use a text logo -->
                <!-- <h1><a href="#intro">The<span>Event</span></a></h1>-->
                <a href="index.php" class="scrollto"><img src="assets/img/eiffel-tower.png" alt="" title=""></a>
            </div>
            <nav id="nav-menu-container">
                <ul class="nav-menu">
                    <li class="<?php if($Title == 'login'){echo 'menu-active';} ?>"><a href="login.php">تسجيل دخول</a></li>
                    <li class="<?php if($Title == 'register'){echo 'menu-active';} ?>"><a href="register.php">انشاء حساب</a></li>
                    <?php if($Title == 'Homepage'){
                        echo '<li><a href="#contact">تواصل معنا </a></li>';} 
                    ?>
                    <li class="<?php if($Title == 'posts'){echo 'menu-active';} ?>"><a href="posts.php">المقالات</a></li>
                    <li class="<?php if($Title == 'free'){echo 'menu-active';} ?>"><a href="free.php">الفيديوهات المجانية</a></li>
                    <li class="<?php if($Title == 'Homepage'){echo 'menu-active';} ?>"><a href="index.php">الرئيسية</a></li>
                </ul>
            </nav><!-- #nav-menu-container -->
        </div>
    </header>