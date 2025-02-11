<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php echo $this->session->userdata ( 'site_name' ); ?></title>
    <link href="<?php echo asset_url('login/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo asset_url('login/css/common.css'); ?>" rel="stylesheet">


<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet">
<link href="<?php echo asset_url('login/css/theme-02.css'); ?>" rel="stylesheet">

</head>

<body>
  <div class="forny-container">

<div class="forny-inner">

  <div class="forny-form text-center">
      <div class="reset-form d-block">
  <form  method="POST" action="<?php echo base_url(); ?>verifyPhone">
  <h4 class="mb-5">Verify Phone Number</h4>
  <p class="mb-10">
      We sent a verification code to your phone, Enter the code to verify your account.
  </p>
  <div class="form-group">
  <div class="input-group">
      <input required="" class="form-control" name="code" type="number" placeholder="Verification Code">
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
      <div class="col-md-12">
          <button class="btn btn-primary btn-block" type="submit">Verify Phone</button>
      </div>
  </div>
  <div class="text-center mt-10">
       <a href="<?php echo base_url(); ?>/resendcode">Resend verification code</a>
  </div>
  <div class="text-center mt-10">
      <a href="<?php echo base_url(); ?>signin">Back to Login</a>
  </div>
</form>
</div>
  </div>
</div>

  </div>

    <script src="<?php echo asset_url('login/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo asset_url('login/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo asset_url('login/js/main.js'); ?>"></script>
    <script src="<?php echo asset_url('login/js/demo.js'); ?>"></script>

</body>

</html>
