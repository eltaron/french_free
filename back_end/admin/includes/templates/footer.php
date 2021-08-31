<footer class="footer ">
                    <div class="container-fluid clearfix ">
                        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block ">Copyright © MasterCode.com</span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="layout/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="layout/js/Chart.min.js"></script>
    <?php
    if ($pageTitle == 'Dashboard') {
        echo '<script src="layout/js/Chart.js"></script>';
    }
    ?>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="layout/js/off-canvas.js"></script>
    <script src="layout/js/hoverable-collapse.js "></script>
    <script src="layout/js/misc.js "></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="layout/js/dashboard.js"></script>
    <script src="layout/js/todolist.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(function () {
            $("#alert-message").fadeTo(5000, 500).slideUp(500, function () {
                $('#alert-message').slideUp(500);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#datatableid').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json"
                }
            });
        } );
    </script>
    <script>
        $(document).ready(function() {
            $('#datatableid2').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json"
                }
            });
        } );
    </script>
    <script src="layout/js/index_mai.js "></script>
    <script src="layout/js/file-upload.js"></script>

    <!-- End custom js for this page -->
</body>
<script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
</html>