<body>
    <header id="header" class="header-fixed">
        <div class="container">
            <div id="logo" class="pull-left">
                <!-- Uncomment below if you prefer to use a text logo -->
                <!-- <h1><a href="#intro">The<span>Event</span></a></h1>-->
                <a href="index.php" class="scrollto"><img src="assets/img/eiffel-tower.png" alt="" title=""></a>
            </div>
            <nav id="nav-menu-container">
                <ul class="nav-menu">
                    <li><a href="logout.php">تسجيل الخروج</a></li>
                    <li class="<?php if($Title == 'account'){echo 'menu-active';} ?>"><a href="account.php">الحساب الشخصى</a></li>
                    <li class="<?php if($Title == 'events'){echo 'menu-active';} ?>"><a href="events.php">المهام</a></li>
                    <li class="<?php if($Title == 'activities'){echo 'menu-active';} ?>"><a href="activities.php">المنشورات</a></li>
                    <li class="<?php if($Title == 'posts2' || $Title == 'postContent'){echo 'menu-active';} ?>"><a href="posts2.php">المقالات</a></li>
                    <li class="<?php if($Title == 'main' || $Title == 'exam'){echo 'menu-active';} ?>"><a href="index.php">الرئيسية</a></li>
                </ul>
            </nav><!-- #nav-menu-container -->
        </div>
    </header>