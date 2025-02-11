<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Admin | Log in</title>
    <!-- Favicon-->
    <link rel="icon" href="<?php echo asset_url('images/favicon.ico'); ?>" type="image/x-icon">
    <!-- Bootstrap Core Css -->
    <link href="<?php echo asset_url('plugins/bootstrap/css/bootstrap.css'); ?>" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Custom Css -->
    <link href="<?php echo asset_url('css/style.css'); ?>" rel="stylesheet">
<script type="text/javascript">
        var baseURL = "<?php echo base_url(); ?>";
    </script>
</head>

<body class="login-page">
    <div class="login-box">
      <div class="card">
          <div class="body">

              <form  id="log_in" method="POST" action="<?php echo base_url(); ?>resetPassword">
                  <div class="msg">
                    ADMIN DASHBOARD
                  </div>
                  <div class="input-group">
                      <span class="input-group-addon">
                          <i class="material-icons">person</i>
                      </span>
                      <div class="form-line">
                          <input type="text" class="form-control" name="email" placeholder="Email Address" required autofocus>
                      </div>
                  </div>
                  <div class="input-group">
                      <span class="input-group-addon">
                          <i class="material-icons">lock</i>
                      </span>
                      <div class="form-line">
                          <input type="password" class="form-control" name="password" placeholder="Password" required>
                      </div>
                  </div>
                  <?php $this->load->helper('form'); ?>
                  <div class="row">
                      <div class="col-md-12">
                          <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                      </div>
                  </div>
                  <?php
                  $this->load->helper('form');
                  $error = $this->session->flashdata('error');
                  if($error)
                  {
                      ?>
                      <div class="alert alert-danger alert-dismissable">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <?php echo $error; ?>
                      </div>
                  <?php }
                  $success = $this->session->flashdata('success');
                  if($success)
                  {
                      ?>
                      <div class="alert alert-success alert-dismissable">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <?php echo $success; ?>
                      </div>
                  <?php } ?>
                  <div class="row">
                      <div class="col-xs-12">
                          <button class="btn btn-block bg-pink waves-effect" type="submit">SIGN IN</button>
                      </div>
                  </div>

              </form>
          </div>
      </div>

    </div>

    <!-- CORE PLUGIN JS -->
    <script src="<?php echo asset_url('plugins/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo asset_url('plugins/bootstrap/js/bootstrap.js'); ?>"></script>
    <script src="<?php echo asset_url('plugins/jquery-slimscroll/jquery.slimscroll.js'); ?>"></script>


    <!-- LAYOUT JS -->
    <script src="<?php echo asset_url('js/demo.js'); ?>"></script>

</body>

</html>
