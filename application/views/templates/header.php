<?php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Admin Dashboard</title>
    <!-- Favicon-->
    <link rel="icon" href="<?php echo asset_url('images/favicon.ico'); ?>" type="image/x-icon">
	
	<meta name="description" content="Stay updated with the latest news on politics, sports, technology, and entertainment from around the world at NewsSwiftly.">
    <meta name="keywords" content="latest news, breaking news, world news, NewsSwiftly">
    <link rel="canonical" href="https://newsswiftly.com">

    <!-- Facebook Open Graph tags for better social media integration -->
    <meta property="og:title" content="NewsSwiftly - Latest News Updates">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://newsswiftly.com">
    <meta property="og:image" content="https://newsswiftly.com/assets/img/newsswiftly.jpg">
    <meta property="og:description" content="Get the latest and most comprehensive news updates from NewsSwiftly. Your go-to source for news from all over the globe.">
    <meta property="og:site_name" content="NewsSwiftly">
    <meta property="og:locale" content="en_US">
    <!-- If using Facebook insights -->
    <meta property="fb:app_id" content="894572385107506">

    <!--REQUIRED PLUGIN CSS-->

    <link href="<?php echo asset_url('plugins/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo asset_url('plugins/bootstrap/css/bootstrap.css'); ?>" rel="stylesheet">
     <link href="<?php echo asset_url('plugins/sweetalert/sweetalert.css'); ?>" rel="stylesheet">
   <link href="<?php echo asset_url('plugins/alertify/css/alertify.css'); ?>" rel="stylesheet">
    <link href="<?php echo asset_url('plugins/bootstrap-select/css/bootstrap-select.css'); ?>" rel="stylesheet">
    <link href="<?php echo asset_url('plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css'); ?>" rel="stylesheet">
    <link href="<?php echo asset_url('plugins/bootstrap-daterange/daterangepicker.css'); ?>" rel="stylesheet">


        <!--THIS PAGE LEVEL CSS-->
        <link href="<?php echo asset_url('plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css'); ?>" rel="stylesheet">
        <link href="<?php echo asset_url('plugins/jquery-datatable/skin/bootstrap/css/responsive.bootstrap.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo asset_url('plugins/jquery-datatable/skin/bootstrap/css/scroller.bootstrap.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo asset_url('plugins/jquery-datatable/skin/bootstrap/css/fixedHeader.bootstrap.min.css'); ?>" rel="stylesheet">

    <!--THIS PAGE LEVEL CSS-->
    <link href="<?php echo asset_url('plugins\alertify\css\alertify.css'); ?>" rel="stylesheet">

    <link href="<?php echo asset_url('plugins/jquery-datatable/skin/bootstrap/css/scroller.bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo asset_url('plugins/jquery-datatable/skin/bootstrap/css/fixedHeader.bootstrap.min.css'); ?>" rel="stylesheet">

    <!--REQUIRED THEME CSS -->
    <link href="<?php echo asset_url('plugins/dropify/dist/css/dropify.min.css'); ?>" rel="stylesheet">


    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Animation Css -->
    <link href="<?php echo asset_url('plugins/animate-css/animate.css'); ?>" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?php echo asset_url('css/style.css'); ?>" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo asset_url('css/themes/all-themes.css'); ?>" rel="stylesheet" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<script type="text/javascript">
        var baseURL = "<?php echo base_url(); ?>";
    </script>

</head>

<body class="light layout-fixed theme-blue">
  <!-- #END# Search Bar -->
  <!-- Top Bar -->
  <nav class="navbar">
      <div class="container-fluid">
          <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
              <a class="navbar-brand" href="<?php echo site_url(); ?>">ADMIN DASHBOARD</a>
          </div>

          <div class="collapse navbar-collapse" id="navbar-collapse">
              <ul class="nav navbar-nav navbar-right">
                  <!-- #END# Call Search -->
                  <!-- Notifications -->

                  <!-- #END# Tasks -->
                  <li class="pull-right" title="logout"><a href="<?php echo base_url(); ?>logout" class="js-right-sidebar" data-close="true"><i class="material-icons">logout</i></a></li>

                  <li class="pull-right" title="send notifications"><a href="<?php echo base_url(); ?>notification" class="js-right-sidebar" data-close="true"><i class="material-icons">send</i></a></li>
                <li class="pull-right" title="update settings"><a href="<?php echo base_url(); ?>settings" class="js-right-sidebar" data-close="true"><i class="material-icons">settings</i></a></li>
                </ul>
          </div>

      </div>
  </nav>

  <!-- #Top Bar -->
  <section>
      <!-- Left Sidebar -->
      <aside id="leftsidebar" class="sidebar">
        <div class="user-info" style="display:block;">

            <div class="info-container">
                <div class="email"><?php echo $this->session->userdata ( 'userId' ); ?></div>
                <div class="btn-group user-helper-dropdown">
                    <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="<?php echo site_url(); ?>logout"><i class="material-icons">input</i>Sign Out</a></li>
                    </ul>
                </div>
            </div>
        </div>
          <!-- Menu -->
          <div class="menu">
              <ul class="list">
                <li class="header">MAIN NAVIGATION</li>
                  <li <?php if (strpos($url,'dashboard') !== false){ ?> class="active" <?php } ?>>
                      <a href="<?php echo base_url(); ?>dashboard">
                          <i class="material-icons">home</i>
                          <span>Dashboard</span>
                      </a>
                  </li>
                  <li <?php if (strpos($url,'newInterest') !== false || strpos($url,'interestListing') !== false){ ?> class="active" <?php } ?>>
                      <a href="#categories"  data-toggle="collapse" class="menu-toggle" aria-expanded="false">
                          <i class="material-icons">pages</i>
                          <span>Interests</span>
                      </a>
                      <ul class="ml-menu">
                          <li>
                              <a href="<?php echo base_url(); ?>interestListing" title="interestListing">Listing</a>
                          </li>
                          <li>
                              <a href="<?php echo base_url(); ?>newInterest" title="newInterest">Add New</a>
                          </li>

                      </ul>
                  </li>

                  <li <?php if (strpos($url,'languageListing') !== false || strpos($url,'languageListing') !== false){ ?> class="active" <?php } ?>>
                      <a href="#languages"  data-toggle="collapse" class="menu-toggle" aria-expanded="false">
                          <i class="material-icons">tag_faces</i>
                          <span>Languages</span>
                      </a>
                      <ul class="ml-menu">
                          <li>
                              <a href="<?php echo base_url(); ?>langaugeListing" title="langaugeListing">Listing</a>
                          </li>
                          <li>
                              <a href="<?php echo base_url(); ?>newLanguage" title="newLanguage">Add New</a>
                          </li>

                      </ul>
                  </li>



                  <li <?php if (strpos($url,'rssLinksListing') !== false || strpos($url,'newRssLink') !== false){ ?> class="active" <?php } ?>>
                      <a data-toggle="collapse" class="menu-toggle" aria-expanded="false">
                          <i class="material-icons">link</i>
                          <span>RSS Links</span>
                      </a>
                      <ul class="ml-menu">
                          <li>
                              <a href="<?php echo base_url(); ?>rssLinksListing" title="rssLinksListing">Listing</a>
                          </li>
                          <li>
                              <a href="<?php echo base_url(); ?>newRssLink" title="newRssLink">Add New</a>
                          </li>

                      </ul>
                  </li>
                  <li <?php if (strpos($url,'rssFeedsListing') !== false || strpos($url,'newRssFeed') !== false){ ?> class="active" <?php } ?>>
                      <a  data-toggle="collapse" class="menu-toggle" aria-expanded="false">
                          <i class="material-icons">rss_feed</i>
                          <span>RSS Feeds</span>
                      </a>
                      <ul class="ml-menu">
                          <li>
                              <a href="<?php echo base_url(); ?>rssFeedsListing" title="rssFeedsListing">Listing</a>
                          </li>
                          <li>
                              <a href="<?php echo base_url(); ?>newRssFeed" title="newRssFeed">Add New</a>
                          </li>

                      </ul>
                  </li>

                  <li <?php if (strpos($url,'youtubeLinksListing') !== false || strpos($url,'newYoutubeRssLink') !== false){ ?> class="active" <?php } ?>>
                      <a data-toggle="collapse" class="menu-toggle" aria-expanded="false">
                          <i class="material-icons">verified_user</i>
                          <span>Youtube Channels</span>
                      </a>
                      <ul class="ml-menu">
                          <li>
                              <a href="<?php echo base_url(); ?>youtubeLinksListing" title="youtubeLinksListing">Listing</a>
                          </li>
                          <li>
                              <a href="<?php echo base_url(); ?>newYoutubeRssLink" title="newYoutubeRssLink">Add New</a>
                          </li>

                      </ul>
                  </li>
                  <li <?php if (strpos($url,'newyoutubefeed') !== false || strpos($url,'youtubeFeedsListing') !== false){ ?> class="active" <?php } ?>>
                      <a  data-toggle="collapse" class="menu-toggle" aria-expanded="false">
                          <i class="material-icons">video_library</i>
                          <span>Youtube Videos</span>
                      </a>
                      <ul class="ml-menu">
                          <li>
                              <a href="<?php echo base_url(); ?>youtubeFeedsListing" title="youtubeFeedsListing">Listing</a>
                          </li>
                          <li>
                              <a href="<?php echo base_url(); ?>newYoutubeFeed" title="newYoutubeFeed">Add New</a>
                          </li>
                          <li>
                              <a href="<?php echo base_url(); ?>livestreams" title="newLiveTv">Live LiveTv</a>
                          </li>
                      </ul>
                  </li>
                  <li <?php if (strpos($url,'newRadioLink') !== false || strpos($url,'radioListing') !== false){ ?> class="active" <?php } ?>>
                      <a  data-toggle="collapse" class="menu-toggle" aria-expanded="false">
                          <i class="material-icons">radio</i>
                          <span>Radio Channels</span>
                      </a>
                      <ul class="ml-menu">
                          <li>
                              <a href="<?php echo base_url(); ?>radioListing" title="radioListing">Listing</a>
                          </li>
                          <li>
                              <a href="<?php echo base_url(); ?>newRadioLink" title="newRadioLink">Add New</a>
                          </li>

                      </ul>
                  </li>
                  <li <?php if (strpos($url,'androidUsers') !== false){ ?> class="active" <?php } ?>>
                      <a href="<?php echo base_url(); ?>androidUsers" title="androidUsers">
                          <i class="material-icons">android</i>
                          <span>Android Users</span>
                      </a>
                  </li>
                  <li <?php if (strpos($url,'usercomments') !== false || strpos($url,'reportedcomments') !== false){ ?> class="active" <?php } ?>>
                      <a href="#categories"  data-toggle="collapse" class="menu-toggle" aria-expanded="false">
                          <i class="material-icons">comment</i>
                          <span>Comments</span>
                      </a>
                      <ul class="ml-menu">
                          <li>
                              <a href="<?php echo base_url(); ?>usercomments" title="usercomments">Users Comments</a>
                          </li>
                          <li>
                              <a href="<?php echo base_url(); ?>reportedcomments" title="reportedcomments">Reported Comments</a>
                          </li>

                      </ul>
                  </li>
                  <li <?php if (strpos($url,'adminListing') !== false || strpos($url,'newAdmin') !== false){ ?> class="active" <?php } ?>>
                      <a  data-toggle="collapse" class="menu-toggle" aria-expanded="false">
                          <i class="material-icons">account_circle</i>
                          <span>Admin Users</span>
                      </a>
                      <ul class="ml-menu">
                          <li>
                              <a href="<?php echo base_url(); ?>adminListing" title="adminListing">Listing</a>
                          </li>
                          <li>
                              <a href="<?php echo base_url(); ?>newAdmin" title="newAdmin">Add New</a>
                          </li>

                      </ul>
                  </li>

              </ul>
          </div>
          <!-- #Menu -->
          <!-- Footer -->
          <div class="legal">
              <div class="copyright">
                  &copy; <?php echo date('Y'); ?> <a href="javascript:void(0);">Admin Dashboard</a>.
              </div>

          </div>
          <!-- #Footer -->
      </aside>
      <!-- #END# Left Sidebar -->
  </section>
