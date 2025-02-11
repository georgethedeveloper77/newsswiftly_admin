<?php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="zxx" class="no-js">
<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo asset_url('img/favicon-32x32.png'); ?>">
    <!-- Meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title><?php echo $this->session->userdata('site_name'); ?></title>
	<meta name="description" content="Stay updated with the latest news on politics, sports, technology, and entertainment from around the
									  world at NewsSwiftly.">
    <meta name="keywords" content="latest news, breaking news, world news, NewsSwiftly">
    <link rel="canonical" href="https://newsswiftly.com">

    <!-- Facebook Open Graph tags for better social media integration -->
    <meta property="og:title" content="NewsSwiftly - Latest News Updates">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://newsswiftly.com">
    <meta property="og:image" content="https://newsswiftly.com/assets/img/newsswiftly.jpg">
    <meta property="og:description" content="Get the latest and most comprehensive news updates from NewsSwiftly. Your go-to source for news
											 from all over the globe.">
    <meta property="og:site_name" content="NewsSwiftly">
    <meta property="og:locale" content="en_US">
    <!-- If using Facebook insights -->
    <meta property="fb:app_id" content="894572385107506">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
    <!-- CSS -->
    <style>
        /* Custom CSS to adjust the logo size */
        .logo-left img {
            max-width: 200px; /* Adjust this value to your desired size */
            height: 50px; /* This ensures the logo's aspect ratio is maintained */
        }

        /* Custom CSS for social icons and email */
        .header-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #000; /* Set background color to black */
            color: #fff; /* Set text color to white */
            padding: 10px 0;
        }

        .social-icons {
            list-style: none;
            padding: 0;
            margin: 0;
            text-align: right; /* Align the social icons to the right */
        }

        .social-icons li {
            display: inline-block;
            margin-left: 10px; /* Add some spacing between the social icons */
        }

        .social-icons li:first-child {
            margin-left: 0; /* Remove left margin for the first icon */
        }

        .social-icons a {
            color: #fff; /* Change social icon color to white */
            font-size: 18px;
        }

        .email-contact {
            display: inline-block;
            font-size: 14px;
            text-align: right; /* Align the email to the right */
        }

        /* Remove the white nav bar between the logo row and category navigation row */
        .header-bottom {
            background-color: transparent;
        }
    </style>
    <link rel="stylesheet" href="<?php echo asset_url('css/linearicons.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset_url('css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset_url('css/bootstrap.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset_url('css/magnific-popup.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset_url('css/nice-select.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset_url('css/animate.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset_url('css/owl.carousel.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset_url('css/jquery-ui.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset_url('css/main.css'); ?>">
    <!-- JavaScript -->
    <script type="text/javascript">
        var baseURL = "<?php echo base_url(); ?>";
    </script>
</head>
<body>
    <header>
        <div class="header-top">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-lg-4 col-md-4 col-sm-12 logo-left no-padding">
                        <a href="<?php echo site_url(); ?>">
                            <img class="img-fluid" src="<?php echo asset_url('img/newsswiftly.jpg'); ?>" alt="">
                        </a>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12 social-icons email-contact">
                        <ul class="social-icons">
                            <li><a href="<?php echo $this->session->userdata('facebook_page_url'); ?>"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="<?php echo $this->session->userdata('twitter_page_url'); ?>"><i class="fa fa-twitter"></i></a></li>
                        </ul>
                        <a href="mailto:support@colorlib.com"><span class="lnr lnr-envelope"></span><span>support@newsswiftly.com</span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="logo-wrap">
            <div class="container">
                <div class="row justify-content-between align-items-center header-bottom">
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
</body>
</html>
