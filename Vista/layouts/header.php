<!DOCTYPE html>
<html>

<head>
    <html lang="es">
    <meta charset="utf-8">
    <meta content="" name="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="" rel="icon" id="faviconHeader">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../Recursos/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../Recursos/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Select 2 -->
    <link rel="stylesheet" href="../Recursos/css/select2.css">
    <link rel="stylesheet" href="../Recursos/css/styles.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="../Recursos/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../Recursos/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="../Recursos/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="../Recursos/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">


    <script src="../Recursos/js/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../Recursos/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../Recursos/js/adminlte.min.js"></script>
    <!-- Sweet alert -->
    <!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script> -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Select 2 -->
    <script src="../Recursos/js/select2.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <!-- jQuery -->

    <script src="../Recursos/js/nav.js"></script>
    <!-- Bootstrap 4 -->
    <!-- <script src="../Recursos/js/bootstrap.bundle.min.js"></script> -->

    <script src="../Recursos/js/jquery-validation/jquery.validate.min.js"></script>
    <script src="../Recursos/js/jquery-validation/additional-methods.min.js"></script>

    <!-- Bootstrap4 Duallistbox -->
    <script src="../Recursos/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="../Recursos/moment/moment.min.js"></script>
    <script src="../Recursos/inputmask/min/jquery.inputmask.bundle.min.js"></script>
    <!-- date-range-picker -->
    <script src="../Recursos/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="../Recursos/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../Recursos/js/demo.js"></script>
    <!-- <style>
            #container {
                width: 1000px;
                margin: 20px auto;
            }

            .ck-editor__editable[role="textbox"] {
                /* editing area */
                min-height: 200px;
            }

            .ck-content .image {
                /* block images */
                max-width: 80%;
                margin: 20px auto;
            }
        </style> -->


    <?php
    if (isset($_SESSION['empresa']['google_analitycs'])) {
    ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?= $_SESSION['empresa']['google_analitycs'] ?>">
        </script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', '<?= $_SESSION['empresa']['google_analitycs'] ?>"');
        </script>
    <?php
    }
    ?>
</head>