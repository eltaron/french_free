<?php
    ob_start();
    session_start();
    $pageTitle = 'Homepage';
    $Title = 'Homepage';
    if (isset($_SESSION['user'])) {
		header('Location: main.php');
	}
    include 'inital.php';
?>
<body>
<!-- ======= Header ======= -->
<header id="header">
    <div class="container">
        <nav id="nav-menu-container">
        <ul class="nav-menu">
            <li><a href="login.php">تسجيل دخول</a></li>
            <li><a href="register.php">انشاء حساب</a></li>
            <li><a href="#contact">تواصل معنا </a></li>
            <li><a href="posts.php">المقالات</a></li>
            <li><a href="free.php">الفيديوهات المجانية</a></li>
            <li class="menu-active"><a href="index.php">الرئيسية</a></li>
        </ul>
        </nav>
        <!-- #nav-menu-container -->
        <div id="logo" class="pull-left">
            <!-- Uncomment below if you prefer to use a text logo -->
            <!-- <h1><a href="#intro">The<span>Event</span></a></h1>-->
            <a href="index.php" class="scrollto"><img src="assets/img/eiffel-tower.png" alt="" title=""></a>
        </div>
    </div>
</header>
<section id="intro">
    <div class="intro-container" data-aos="zoom-in" data-aos-delay="100">
        <h1 class="mb-4 pb-0">le Génie <br><span>العبقرى فى الفرنسية</span></h1>
        <p class="mb-4 pb-0"></p>
        <a href="https://www.youtube.com/watch?v=BliDUlParaQ" class="venobox play-btn mb-4" data-vbtype="video" data-autoplay="true"></a>
        <a href="#about" class="about-btn scrollto">نبذة تعريفية</a>
    </div>
</section>
<main id="main">
    <!-- ======= About Section ======= -->
    <section id="about">
        <div class="container" data-aos="fade-up">
            <div class="row">
            <div class="text-center">
                <div class="section-header"><h2>نبذة تعريفية</h2></div> 
                <p>لوريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص، بل انه حتى صار مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع إصدار رقائق "ليتراسيت" (Letraset) البلاستيكية تحوي مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل "ألدوس بايج مايكر" (Aldus PageMaker) والتي حوت أيضاً على نسخ من نص لوريم إيبسوم.</p>
            </div>
            </div>
        </div>
    </section><!-- End About Section -->
    <!-- ======= Speakers Section ======= -->
    <section id="speakers">
        <div class="container" data-aos="fade-up">
            <div class="section-header">
                <h2>المقالات</h2>
            </div>
            <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="speaker" data-aos="fade-up" data-aos-delay="100">
                <img src="assets/img/speakers/1.jpg"alt="Speaker 1" class="img-fluid">
                <div class="details">
                    <h3><a href="posts.php">مقال 2</a></h3>
                    <p>اللغة الفرنسية</p>
                    <a href="wait.php" class="about-btn scrollto">المزيد</a>
                </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="speaker" data-aos="fade-up" data-aos-delay="200">
                <img src="assets/img/speakers/2.jpg" alt="Speaker 2" class="img-fluid">
                <div class="details">
                    <h3><a href="posts.php">مقال 1</a></h3>
                    <p>اللغة الفرنسية</p>
                    <a href="wait.php" class="about-btn scrollto">المزيد</a>
                </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="speaker" data-aos="fade-up" data-aos-delay="300">
                <img src="assets/img/speakers/3.jpg" alt="Speaker 3" class="img-fluid">
                <div class="details">
                    <h3><a href="posts.php">مقال 4</a></h3>
                    <p>اللغة الفرنسية</p>
                    <a href="wait.php" class="about-btn scrollto">المزيد</a>
                </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="speaker" data-aos="fade-up" data-aos-delay="100">
                <img src="assets/img/speakers/4.jpg" alt="Speaker 4" class="img-fluid">
                <div class="details">
                    <h3><a href="posts.php">مقال 3</a></h3>
                    <p>اللغة الفرنسية</p>
                    <a href="wait.php" class="about-btn scrollto">المزيد</a>
                </div>
                </div>
            </div>
            </div>
        </div>
    </section><!-- End Speakers Section -->
    <!-- ======= Hotels Section ======= -->
    <section id="hotels" class="section-with-bg">
        <div class="container" data-aos="fade-up">
            <div class="section-header">
                <h2>الفيديوهات المجانية</h2>
            </div>
            <div class="row" data-aos="fade-up" data-aos-delay="100">
                <div class="col-lg-4 col-md-6">
                    <div class="hotel">
                    <div class="hotel-img">
                        <img src="assets/img/hotels/1.jpg"  data-toggle="modal" data-target="#exampleModal" alt="Hotel 1" class="img-fluid">
                    </div>
                    <h3>فيديو 3</h3>
                    <p>اللغة الفرنسية</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="hotel">
                    <div class="hotel-img">
                        <img src="assets/img/hotels/2.jpg"  data-toggle="modal" data-target="#exampleModal_2" alt="Hotel 2" class="img-fluid">
                    </div>
                    <h3>فيديو 2</h3>
                    <p>اللغة الفرنسية</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="hotel">
                    <div class="hotel-img">
                        <img src="assets/img/hotels/3.jpg"  data-toggle="modal" data-target="#exampleModal_3" alt="Hotel 3" class="img-fluid">
                    </div>
                    <h3>فيديو 1</h3>
                    <p>اللغة الفرنسية</p>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Hotels Section -->
    <!-- ======= Gallery Section ======= -->
    <section id="gallery">
        <div class="container" data-aos="fade-up">
            <div class="section-header">
                <h2>طلابنا المتميزين </h2>
            </div>
        </div>
        <div class="owl-carousel gallery-carousel" data-aos="fade-up" data-aos-delay="100">
            <a href="assets/img/gallery/1.jpg" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/1.jpg" alt=""></a>
            <a href="assets/img/gallery/2.jpg" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/2.jpg" alt=""></a>
            <a href="assets/img/gallery/3.jpg" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/3.jpg" alt=""></a>
            <a href="assets/img/gallery/4.jpg" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/4.jpg" alt=""></a>
            <a href="assets/img/gallery/5.jpg" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/5.jpg" alt=""></a>
            <a href="assets/img/gallery/6.jpg" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/6.jpg" alt=""></a>
            <a href="assets/img/gallery/7.jpg" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/7.jpg" alt=""></a>
            <a href="assets/img/gallery/8.jpg" class="venobox" data-gall="gallery-carousel"><img src="assets/img/gallery/8.jpg" alt=""></a>
        </div>
    </section><!-- End Gallery Section -->
    <section id="faq">
        <div data-aos="fade-up">
            <div class="section-header pt-4">
                <h2>الأسئلة الشائعة</h2>
            </div>
            <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="100">
                <div class="col-lg-9">
                    <ul id="faq-list">
                        <li>
                            <a data-toggle="collapse" class="collapsed" href="#faq1">ما هى تعليمات تسجيل الدخول ؟<i class="fa fa-minus-circle"></i></a>
                            <div id="faq1" class="collapse" data-parent="#faq-list">
                            <p>
                                يجب الأنتظار حتى يقوم المسئول بتفعيلك               
                            </p>
                            </div>
                        </li>
                        <li>
                            <a data-toggle="collapse" class="collapsed" href="#faq2">ما المدة التى يجب  على الأنتظار حتى يتم تفعيلى ؟ <i class="fa fa-minus-circle"></i></a>
                            <div id="faq2" class="collapse" data-parent="#faq-list">
                            <p>
                               المده لن تزيد عن يوم واحد               
                            </p>
                            </div>
                        </li>

                        <li>
                            <a data-toggle="collapse" class="collapsed" href="#faq3">كيف يمكن التواصل مع المسئول ؟ <i class="fa fa-minus-circle"></i></a>
                            <div id="faq3" class="collapse" data-parent="#faq-list">
                            <p>
                               يمكنك التواصل عن طريق الرسائل وعن طريق  رقم الهاتف وعن طريق البريد الألكترونى                  
                            </p>
                            </div>
                        </li>
                        <li>
                            <a data-toggle="collapse" class="collapsed" href="#faq4">كم تكلفة الأشتراك بالمنصة ؟ <i class="fa fa-minus-circle"></i></a>
                            <div id="faq4" class="collapse" data-parent="#faq-list">
                            <p>
                               قيمة الأشتراك يتم تحديدها على حسب الصف              
                            </p>
                            </div>
                        </li>
                        <li>
                            <a data-toggle="collapse" class="collapsed" href="#faq5">هل يتم تقديم الخدمة فقط للطلاب المسجلين فى نفس الصف ؟<i class="fa fa-minus-circle"></i></a>
                            <div id="faq5" class="collapse" data-parent="#faq-list">
                            <p>
                               لا الخدمة يتم تقديمها لجميع الطلاب فى جميع الصفوف            </p>
                            </div>
                        </li>
                       
                    </ul>
                </div>
            </div>
        </div>
    </section><!-- End  F.A.Q Section --><!-- End  F.A.Q Section -->
    <!-- ======= Subscribe Section ======= -->
    <section class="section4">
        <div class="padding">
            <div class="container">
            <h2 class="main"> احصائيات</h2>
            <p>هدفنا التفوق دائما </p>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="container">
                                <div class="row text-center">
                                    <div class="col-lg-8"><h2>الاف الطلاب</h2></div>
                                    <div class="col-lg-4"><img src="assets/img/group.png"></div>
                                </div>
                            </div>
                            <p>سعدنا بالتعامل مع الاف الاطلاب</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="container">
                                <div class="row text-center">
                                    <div class="col-lg-8"><h2>عشرات المراجع</h2></div>
                                    <div class="col-lg-4"><img src="assets/img/books-stack-of-three.png"></div>
                                </div>
                            </div>
                            <p>دائما على اطلاع بما هو جديد</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="container">
                                <div class="row text-center">
                                    <div class="col-lg-8"><h2>مئات الامتحانات</h2></div>
                                    <div class="col-lg-4"><img src="assets/img/exam.png"></div>
                                </div>
                            </div>
                            <p>ستسطيع حل الكثير من الامتحانات</p>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>
    <!-- ======= Buy Ticket Section ======= -->
    <!-- ======= Contact Section ======= -->
    <section id="contact" class="section-bg">
        <div class="container" data-aos="fade-up">
            <div class="section-header">
                <h2>تواصل معنا </h2>
                <p>نسعد بتواصلكم دائما</p>
            </div>
            <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $username 	= filter_var($_POST['username'], FILTER_SANITIZE_STRING);
                    $email 	    = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                    $comment 	= filter_var($_POST['message'], FILTER_SANITIZE_STRING);
                    if (! empty($comment)) {
                        $stmt = $con->prepare("INSERT INTO 
                            message(message, username, email, date)
                            VALUES(:message, :username, :email, NOW())");
                        $stmt->execute(array(
                            'message'   => $comment,
                            'username'  => $username,
                            'email'     => $email
                        ));
                        if ($stmt) {
                            echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert" id="alert-message">
                                    تم ارسال الرسالة بنجاح
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                        }
                    } else {
                        echo '<div class="alert alert-warning alert-dismissible text-center fade show" role="alert" id="alert-message">
                                يجب عليك اضافة الرساله
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
                    }
                }
            ?>
            <div class="row contact-info">
                <div class="col-md-4">
                    <div class="contact-address">
                    <i class="fa fa-map-marker"></i>
                    <h3>العنوان </h3>
                    <address>كفر الشيخ </address>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-phone">
                    <i class="fa fa-phone"></i>
                    <h3>رقم الهاتف</h3>
                    <p><a href="#">01023645987</a></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-email">
                    <i class="fa fa-envelope"></i>
                    <h3>البريد الألكترونى</h3>
                    <p><a href="mailto:info@example.com">teacher@gmail.com</a></p>
                    </div>
                </div>
            </div>
            <div class="form">
                <form action="#contact" method="POST" role="form" class="php-email-form">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input dir="rtl" type="email" class="form-control" name="email" id="email" placeholder="البريد الألكترونى" required />
                            <div class="validate"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <input dir="rtl" type="text" name="username" class="form-control" id="name" placeholder="الأسم" required />
                            <div class="validate"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea dir="rtl" class="form-control" name="message" placeholder="الرسالة" required></textarea>
                        <div class="validate"></div>
                    </div>
                    <div class="text-center"><button type="submit">أرسال</button></div>
                </form>
            </div>
        </div>
    </section><!-- End Contact Section -->
</main><!-- End #main -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <iframe width="100%" height="500" src="https://www.youtube.com/embed/BliDUlParaQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal_2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <iframe width="100%" height="500" src="https://www.youtube.com/embed/BliDUlParaQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal_3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <iframe width="100%" height="500" src="https://www.youtube.com/embed/BliDUlParaQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>
<?php 
    include $tpl . 'footer.php'; 
    include $tpl . 'scripts.php'; 
    ob_end_flush();
?>