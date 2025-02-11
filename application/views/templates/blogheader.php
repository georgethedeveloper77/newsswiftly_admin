<?php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="zxx" class="no-js">
	<head>
		<!-- Mobile Specific Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<!-- Favicon-->
		<link rel="shortcut icon" href="<?php echo asset_url('img/fav.png'); ?>">
		<!-- meta character set -->
		<meta charset="UTF-8">
		<!-- Site Title -->
		<title><?php echo $this->session->userdata ( 'site_name' ); ?></title>
		<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
		<!--
		CSS
		============================================= -->
		<link rel="stylesheet" href="<?php echo asset_url('css/linearicons.css'); ?>">
		<link rel="stylesheet" href="<?php echo asset_url('css/font-awesome.min.css'); ?>">
		<link rel="stylesheet" href="<?php echo asset_url('css/bootstrap.css'); ?>">
		<link rel="stylesheet" href="<?php echo asset_url('css/magnific-popup.css'); ?>">
		<link rel="stylesheet" href="<?php echo asset_url('css/nice-select.css'); ?>">
		<link rel="stylesheet" href="<?php echo asset_url('css/animate.min.css'); ?>">
		<link rel="stylesheet" href="<?php echo asset_url('css/owl.carousel.css'); ?>">
		<link rel="stylesheet" href="<?php echo asset_url('css/jquery-ui.css'); ?>">
		<link rel="stylesheet" href="<?php echo asset_url('css/main.css'); ?>">

    <script type="text/javascript">
            var baseURL = "<?php echo base_url(); ?>";
        </script>
    </head>
	</head>
	<body>
		<header>

			<div class="header-top">
				<div class="container">
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-6 header-top-left no-padding">
							<ul>
								<li><a href="<?php echo $this->session->userdata ( 'facebook_page_url' ); ?>"><i class="fa fa-facebook"></i></a></li>
								<li><a href="<?php echo $this->session->userdata ( 'twitter_page_url' ); ?>"><i class="fa fa-twitter"></i></a></li>
							</ul>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-6 header-top-right no-padding">
							<ul>
								<li><a href="tel:+440 012 3654 896"><span class="lnr lnr-phone-handset"></span><span>+440 012 3654 896</span></a></li>
								<li><a href="mailto:support@colorlib.com"><span class="lnr lnr-envelope"></span><span>support@newsextra.com</span></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="logo-wrap">
				<div class="container">
					<div class="row justify-content-between align-items-center">
						<div class="col-lg-4 col-md-4 col-sm-12 logo-left no-padding">
							<a href="<?php echo site_url(); ?>">
							<!--	<img class="img-fluid" src="<?php echo asset_url('img/logo.png'); ?>" alt=""> -->
							LOGO HERE
							</a>
						</div>
						<div class="col-lg-8 col-md-8 col-sm-12 logo-right no-padding ads-banner">
							<?php echo $top_banner_big_ad; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="container main-menu" id="main-menu">
				<div class="row align-items-center justify-content-between">
					<nav id="nav-menu-container">
						<ul class="nav-menu">
							<li class="menu-active"><a href="<?php echo base_url(); ?>">Home</a></li>
							<?php if(!empty($interests)){ ?>
							<?php
							 $count_ = 0;
							 while($count_ < 10) {
								 if($count_==count($interests))break;
                 $res = $interests[$count_];
                ?>
                <li><a href="<?php echo site_url().'posts/'.urlencode($res->name); ?>"><?php echo $res->name; ?></a></li>
              <?php
							   $count_++;
						     }
						  ?>
              <?php if(count((array)$interests)==11){
                 $res = $interests[10];
                 ?>
                <li><a href="<?php echo site_url().'posts/'.urlencode($res->name); ?>"><?php echo $res->name; ?></a></li>
              <?php }
                 if(count($interests)>11){
              ?>
							<li class="menu-has-children"><a href="">More</a>
							<ul>
                <?php for($i=11; $i<count($interests); $i++) {
                   $res = $interests[$i];
                  ?>
                  <li><a href="<?php echo site_url().'posts/'.urlencode($res->name); ?>"><?php echo $res->name; ?></a></li>
                <?php } ?>
							</ul>
						</li>
          <?php } ?>
				<?php } ?>
					</ul>
					</nav><!-- #nav-menu-container -->
					<div class="navbar-right">

					</div>
				</div>
			</div>
		</header>
