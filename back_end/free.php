<?php
    ob_start();
    session_start();
    $pageTitle = 'free';
    $Title = 'free';
    if (isset($_SESSION['user'])) {
		header('Location: main.php');
	}
    include 'inital.php';
    include $tpl . 'header.php'; 
?>
<section id="portfolio" class="portfolio">
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>الفيديوهات المجانية</h2>
      </div>

      <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">

        <div class="col-lg-6 col-md-6 portfolio-item filter-app">
          <img src="assets/img/venue-gallery/1.jpg" class="img-fluid" alt="">
          <div class="portfolio-info">
            <h4>فيديو 2</h4>
            <a href="https://www.youtube.com/watch?v=mBbLQ_7UevY" class="venobox play-btn mb-4" data-vbtype="video" data-autoplay="true"><i class="fa fa-play"></i></a>
          </div>
        </div>

        <div class="col-lg-6 col-md-6 portfolio-item filter-web">
          <img src="assets/img/venue-gallery/2.jpg" class="img-fluid" alt="">
          <div class="portfolio-info">
            <h4>فيديو 1</h4>
            <a href="https://www.youtube.com/watch?v=mBbLQ_7UevY" class="venobox play-btn mb-4" data-vbtype="video" data-autoplay="true"><i class="fa fa-play"></i></a>
          </div>
        </div>

        <div class="col-lg-6 col-md-6 portfolio-item filter-app">
          <img src="assets/img/venue-gallery/3.jpg" class="img-fluid" alt="">
          <div class="portfolio-info">
            <h4>فيديو 4</h4>
            <a href="https://www.youtube.com/watch?v=mBbLQ_7UevY" class="venobox play-btn mb-4" data-vbtype="video" data-autoplay="true"><i class="fa fa-play"></i></a>
          </div>
        </div>

        <div class="col-lg-6 col-md-6 portfolio-item filter-card">
          <img src="assets/img/venue-gallery/4.jpg" class="img-fluid" alt="">
          <div class="portfolio-info">
            <h4>فيديو 3</h4>
            <a href="https://www.youtube.com/watch?v=mBbLQ_7UevY" class="venobox play-btn mb-4" data-vbtype="video" data-autoplay="true"><i class="fa fa-play"></i></a>
          </div>
        </div>

      </div>

    </div>
  </section>
<a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>
<?php 
    include $tpl . 'footer.php'; 
    include $tpl . 'scripts.php'; 
    ob_end_flush();
?>