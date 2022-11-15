<!DOCTYPE html>
<html lang="en">


<!-- auth-login.html  21 Nov 2019 03:49:32 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login - Monitoring GHA</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?php echo base_url();?>/assets-panel/css/app.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>/assets-panel/bundles/bootstrap-social/bootstrap-social.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?php echo base_url();?>/assets-panel/css/style.css">
  <link rel="stylesheet" href="<?php echo base_url();?>/assets-panel/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="<?php echo base_url();?>/assets-panel/css/custom.css">
  <!-- <link rel='shortcut icon' type='image/x-icon' href='<?php echo base_url();?>/assets-panel/img/favicon.png' /> -->
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <?php echo $this->renderSection('content');?>
  </div>
  <!-- General JS Scripts -->
  <script src="<?php echo base_url();?>/assets-panel/js/app.min.js"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  
  <script src="<?php echo base_url();?>/assets-panel/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="<?php echo base_url();?>/assets-panel/js/custom.js"></script>
  
  <script src="<?php echo base_url();?>/assets-panel/js/axios/dist/axios.js"></script>
    <?php echo $this->renderSection('jslibraries');?>
  <!-- Template JS File -->
</body>


<!-- auth-login.html  21 Nov 2019 03:49:32 GMT -->
</html>