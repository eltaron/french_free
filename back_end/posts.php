<?php
    ob_start();
    session_start();
    $pageTitle = 'posts';
    $Title = 'posts';
    if (isset($_SESSION['user'])) {
		header('Location: main.php');
	}
    include 'inital.php';
    include $tpl . 'header.php'; 
?>
<main id="main" class="main-page">
    <!-- ======= Speaker Details Sectionn ======= -->
    <section id="speakers-details">
        <div class="container">
            <div class="section-header">
                <h2>المقالات</h2>
            </div>
            <section class="section6">
                <div id="Rooms">
                    <!-- start section-1 -->
                    <div class="row" id="Deluxe Suite">
                        <div id="room1" class="carousel slide col-sm-12 col-md-6 order-1 p-0" data-ride="carousel">
                            <!-- Indicators -->
                            <!-- The slideshow -->
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="assets/img/speakers/1.jpg" alt="room-1" class=" img-fluid " >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 mt-4 order-2" id="right-content">
                            
                            <h3>برج ايفيل </h3>
                            <p>لوريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص، بل انه حتى صار مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع إصدار رقائق "ليتراسيت" (Letraset) البلاستيكية تحوي مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل "ألدوس بايج مايكر" (Aldus PageMaker) والتي حوت أيضاً على نسخ من نص لوريم إيبسوم.
                            </p>
                            <a href="wait.php">قراءة المزيد</a>
                        </div>
                    </div>
                    <!-- End section-1 -->
                    <!-- start section-1 -->
                    <div class="row" id="Deluxe Suite">
                        <div id="room2" class="carousel slide col-sm-12 col-md-6 order-1 order-md-2 p-0" data-ride="carousel">
                            <!-- Indicators -->
                            <!-- The slideshow -->
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="assets/img/speakers/2.jpeg" alt="room-1" class=" img-fluid " >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 mt-4 order-2 order-md-1" id="right-content">
                            <h3>برج ايفيل </h3>
                            <p>لوريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص، بل انه حتى صار مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع إصدار رقائق "ليتراسيت" (Letraset) البلاستيكية تحوي مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل "ألدوس بايج مايكر" (Aldus PageMaker) والتي حوت أيضاً على نسخ من نص لوريم إيبسوم.
                            </p>
                        </div>
                    </div>
                    <!-- End section-1 -->
                    <!-- start section-1 -->
                    <div class="row" id="Deluxe Suite">
                        <div id="room3" class="carousel slide col-sm-12 col-md-6 order-1 p-0" data-ride="carousel">
                            <!-- The slideshow -->
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="assets/img/speakers/3.jpg" alt="room-3" class=" img-fluid " >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 mt-4 order-2" id="right-content">
                            <h3>برج ايفيل </h3>
                            <p>لوريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص، بل انه حتى صار مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع إصدار رقائق "ليتراسيت" (Letraset) البلاستيكية تحوي مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل "ألدوس بايج مايكر" (Aldus PageMaker) والتي حوت أيضاً على نسخ من نص لوريم إيبسوم.
                            </p>
                        </div>
                    </div>
                    <!-- End section-1 -->
                    <!-- start section-1 -->
                    <div class="row" id="Deluxe Suite">
                        <div id="room4" class="carousel slide col-sm-12 col-md-6 order-1 order-md-2 p-0" data-ride="carousel">
                            <!-- Indicators -->
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="assets/img/speakers/4.jpg" alt="room-1" class=" img-fluid " >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 mt-4 order-2 order-md-1" id="right-content">
                            <h3>برج ايفيل </h3>
                            <p>لوريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص، بل انه حتى صار مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع إصدار رقائق "ليتراسيت" (Letraset) البلاستيكية تحوي مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل "ألدوس بايج مايكر" (Aldus PageMaker) والتي حوت أيضاً على نسخ من نص لوريم إيبسوم.
                            </p>
                        </div>
                    </div>
                </div> 
            </section>
        </div>
    </section>
</main>
<?php 
    include $tpl . 'footer.php'; 
    include $tpl . 'scripts.php'; 
    ob_end_flush();
?>