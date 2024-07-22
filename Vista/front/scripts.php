    <script src="Recursos\js\front\jquery.min.js"></script>
    <script src="Recursos\js\front\popper.min.js"></script>
    <script src="Recursos\js\front\bootstrap.bundle.min.js"></script>
    <script src="Recursos\js\front\jquery-3.0.0.min.js"></script>
    <script src="Recursos\js\front\plugin.js"></script>
    <!-- sidebar -->
    <script src="Recursos\js\front\jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="Recursos\js\front\custom.js"></script>
    <!-- javascript -->
    <script src="Recursos\js\front\owl.carousel.js"></script>
    <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
    <script src="js\index.js"></script>

    <script>
        $(document).ready(function() {
            $(".fancybox").fancybox({
                openEffect: "none",
                closeEffect: "none"
            });

            $(".zoom").hover(function() {

                $(this).addClass('transition');
            }, function() {

                $(this).removeClass('transition');
            });
        });
    </script>