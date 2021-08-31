<div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.php -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item nav-profile">
                        <a href="#" class="nav-link">
                            <div class="nav-profile-image">
                                <img src="layout/images/faces/face1.jpg" alt="profile">
                                <span class="login-status online"></span>
                                <!--change to offline or busy as needed-->
                            </div>
                            <div class="nav-profile-text d-flex flex-column">
                                <span class="font-weight-bold mb-2"><?php echo $_SESSION['username'];?></span>
                            </div>
                            <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <span class="menu-title">الصفحه الرئيسيه</span>
                            <i class="mdi mdi-home menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="members.php">
                            <span class="menu-title">الاعضاء</span>
                            <i class="mdi mdi-contacts menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="category.php">
                            <span class="menu-title">الاقسام</span>
                            <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="lessons.php">
                            <span class="menu-title">الدروس</span>
                            <i class="mdi mdi-chart-bar menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="exams.php">
                            <span class="menu-title">الامتحانات</span>
                            <i class="mdi mdi-help menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="posts.php">
                            <span class="menu-title">المنشورات</span>
                            <i class="mdi mdi-tooltip-edit menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="events.php">
                            <span class="menu-title">المهام</span>
                            <i class="mdi mdi-calendar-plus menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="posts2.php">
                            <span class="menu-title">المقالات</span>
                            <i class="mdi mdi-tooltip-edit menu-icon"></i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="comment_lesson.php">
                            <span class="menu-title">تعليقات المقالات</span>
                            <i class="mdi mdi-comment menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="comment_post.php">
                            <span class="menu-title ">تعليقات المنشورات</span>
                            <i class="mdi mdi-comment menu-icon "></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="message.php">
                            <span class="menu-title ">رسائل الصفحة</span>
                            <i class="mdi mdi-email-outline menu-icon "></i>

                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="qoutes.php">
                            <span class="menu-title ">فوائد تربويه</span>
                            <i class="mdi mdi-star menu-icon "></i>

                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="live.php">
                            <span class="menu-title ">البث المباشر</span>
                            <i class="mdi mdi-star menu-icon "></i>
                        </a>
                    </li>
                    
                    <li class="nav-item ">
                        <a class="nav-link " data-toggle="collapse " href="../index.php" aria-expanded="false " aria-controls="general-pages ">
                            <span class="menu-title ">الواجهه</span>
                            <i class="mdi mdi-medical-bag menu-icon "></i>
                        </a>
                    </li>
                </ul>
            </nav>