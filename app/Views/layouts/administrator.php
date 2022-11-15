<!DOCTYPE html>
<html lang="en">


<!-- index.html  21 Nov 2019 03:44:50 GMT -->

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Monitoring GHA - Administrator</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?php echo base_url();?>/assets-panel/css/app.min.css">

    <?php echo $this->renderSection('csslibraries');?>

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/bundles/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href=" <?php echo base_url();?>/assets-panel/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets-panel/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets-panel/bundles/datatables/datatables.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets-panel/css/components.css">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>/assets-panel/css/custom.css">
    <!-- <link rel='shortcut icon' type='image/x-icon' href='<?php echo base_url();?>/assets-panel/img/favicon.png' /> -->

    <link href="<?php echo base_url();?>/assets-panel/font-awesome/css/font-awesome.min.css" rel="stylesheet"
        type="text/css" />

    <!-- Add CssNew -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>

            <!-- start site-header -->
            <?php echo view('includes/administrator/header');?>
            <!-- end site-header -->

            <!-- start site-header -->
            <?php echo view('includes/administrator/menubar');?>
            <!-- end site-header -->

            <!-- Main Content -->
            <div class="main-content">
                <?php echo $this->renderSection('content');?>
            </div>
            <!-- End Content -->

            <!-- start site-footer -->
            <?php view('includes/administrator/footer'); ?>
            <!-- end site-footer -->

        </div>
    </div>
    <!-- General JS Scripts -->
    <script src="<?php echo base_url();?>/assets-panel/js/app.min.js"></script>

    <!-- JS Libraies -->


    <!-- Template JS File -->
    <script src="<?php echo base_url();?>/assets-panel/js/scripts.js"></script>
    <!-- Custom JS File -->
    <script src="<?php echo base_url();?>/assets-panel/js/custom.js"></script>
    <script src="<?php echo base_url();?>/assets-panel/js/axios/dist/axios.js"></script>
    <script src="<?php echo base_url();?>/assets/js/page/ion-icons.js"></script>


    <script src="<?php echo base_url();?>/assets-panel/bundles/datatables/export-tables/buttons.flash.min.js"></script>
    <script src="<?php echo base_url();?>/assets-panel/bundles/datatables/export-tables/buttons.print.min.js"></script>
    <script src="<?php echo base_url();?>/assets-panel/bundles/datatables/export-tables/jszip.min.js"></script>
    <script src="<?php echo base_url();?>/assets-panel/bundles/datatables/export-tables/dataTables.buttons.min.js">
    </script>
    <script src="<?php echo base_url();?>/assets-panel/bundles/datatables/export-tables/pdfmake.min.js"></script>
    <script src="<?php echo base_url();?>/assets-panel/bundles/datatables/export-tables/vfs_fonts.js"></script>

    <!-- Add Canvas.js -->
    <script src="<?php echo base_url(); ?>/assets-panel/canvas/canvasjs.min.js" type="text/javascript"></script>

    <script>
        function convertToRupiah(angka) {
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for (var i = 0; i < angkarev.length; i++)
            if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
        return rupiah.split('', rupiah.length - 1).reverse().join('');
    }
    </script>


    <?php echo $this->renderSection('jslibraies');?>
</body>

<!-- index.html  21 Nov 2019 03:47:04 GMT -->

</html>