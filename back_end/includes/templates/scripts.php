</body>
    <!-- Vendor JS Files -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
    <!-- <script src="assets/vendor/php-email-form/validate.js"></script> -->
    <script src="assets/vendor/venobox/venobox.min.js"></script>
    <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
    <script src="assets/vendor/superfish/superfish.min.js"></script>
    <script src="assets/vendor/hoverIntent/hoverIntent.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    <?php 
    if($Title == 'register' || $Title == 'login'){ ?>
        <script>
            $("select.show_btn").change(function(){
                $selected = $(this).children("option:selected").data('show');
                console.log($selected);
                $("#"+ $selected).show().siblings('.show_item').hide();
            });
        </script>
        <script src="assets/js/forms.js"></script>
    <?php } ?>
    <?php if($Title == 'activities'){ ?>
        <script>
            $('.show_btn').on('click', function(){
                $selected = $(this).data('show_item');
                $(this).parent().nextAll("#"+ $selected).fadeIn().siblings('.show_item').fadeOut();
            });
        </script>
    <?php } ?>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
    <?php 
        if ($Title == 'exam') {
            echo'
                <script>
                    window.addEventListener("load", function () {
                        counter.init("demoB", '.$time.', function(idx){
                            window.location.replace("time_out.php");
                        });
                    });
                </script>
                <script src="assets/js/countdowns.js"></script>
            ';
        } 
    ?> 
