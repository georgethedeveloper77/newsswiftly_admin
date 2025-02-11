

		<div class="site-main-container">
			<!-- Start top-post Area -->
			<section class="top-post-area pt-10">
				<div class="container no-padding">
					<?php if(!empty($news)){ ?>
					<div class="row small-gutters">

						<div class="col-lg-8 top-post-left">
							<div class="feature-image-thumb relative">
								<div class="overlay overlay-bg"></div>
								<img class="img-fluid" src="<?php echo $news[0]->thumbnail; ?>" alt="" style="height:410px;">
							</div>
							<div class="top-post-details">
								<ul class="tags">
									<li><a><?php echo $news[0]->interest; ?></a></li>
								</ul>
								<a href="<?php echo site_url().'post/'.$news[0]->id; ?>">
									<h3><?php echo (strlen($news[0]->title) > 150) ? substr($news[0]->title,0,147).'...' : $news[0]->title; ?></h3>
								</a>
								<ul class="meta">
									<li><a><span class="lnr lnr-user"></span><?php echo $news[0]->source; ?></a></li>
									<li><a><span class="lnr lnr-calendar-full"></span><?php echo $news[0]->date; ?></a></li>
								</ul>
							</div>
						</div>
						<div class="col-lg-4 top-post-right">
							<?php if(count($news) >=2){ ?>
							<div class="single-top-post">
								<div class="feature-image-thumb relative">
									<div class="overlay overlay-bg"></div>
									<img class="img-fluid" src="<?php echo $news[1]->thumbnail; ?>" alt="" style="height:200px;">
								</div>
								<div class="top-post-details">
									<ul class="tags">
										<li><a href="#"><?php echo $news[1]->interest; ?></a></li>
									</ul>
									<a href="<?php echo site_url().'post/'.$news[1]->id; ?>">
										<h4><?php echo (strlen($news[1]->title) > 40) ? substr($news[1]->title,0,37).'...' : $news[1]->title; ?></h4>
									</a>
									<ul class="meta">
										<li><a href="#"><span class="lnr lnr-user"></span><?php echo $news[1]->source; ?></a></li>
										<li><a href="#"><span class="lnr lnr-calendar-full"></span><?php echo $news[1]->date; ?></a></li>
									</ul>
								</div>
							</div>
						<?php } ?>
							<?php if(count($news) >=3){ ?>
							<div class="single-top-post mt-10">
								<div class="feature-image-thumb relative">
									<div class="overlay overlay-bg"></div>
									<img class="img-fluid" src="<?php echo $news[2]->thumbnail; ?>" alt="" style="height:200px;">
								</div>
								<div class="top-post-details">
									<ul class="tags">
										<li><a href="#"><?php echo $news[2]->interest; ?></a></li>
									</ul>
									<a href="<?php echo site_url().'post/'.$news[2]->id; ?>">
										<h4><?php echo (strlen($news[2]->title) > 40) ? substr($news[2]->title,0,37).'...' : $news[2]->title; ?></h4>
									</a>
									<ul class="meta">
										<li><a href="#"><span class="lnr lnr-user"></span><?php echo $news[2]->source; ?></a></li>
										<li><a href="#"><span class="lnr lnr-calendar-full"></span><?php echo $news[2]->date; ?></a></li>
									</ul>
								</div>
							</div>
						<?php } ?>
						</div>

					</div>
				<?php } ?>
				</div>
			</section>
			<!-- End top-post Area -->
			<!-- Start latest-post Area -->
			<section class="latest-post-area pb-120">
				<div class="container no-padding">
					<div class="row">
						<div class="col-lg-8 post-list">
							<!-- Start latest-post Area -->
							<div class="latest-post-wrap">
								<h4 class="cat-title">Latest News</h4>
                <?php if(!empty($news)){ ?>
								<?php for($i=3; $i<count($news); $i++) {
									?>
								<div class="single-latest-post row align-items-center">
									<div class="col-lg-5 post-left">
										<div class="feature-img relative">
											<div class="overlay overlay-bg"></div>
											<img class="img-fluid" src="<?php echo $news[$i]->thumbnail; ?>" alt="" style="max-height:220px;">
										</div>
										<ul class="tags">
											<li><a href="#"><?php echo $news[$i]->interest; ?></a></li>
										</ul>
									</div>
									<div class="col-lg-7 post-right">
										<a href="<?php echo site_url().'post/'.$news[$i]->id; ?>">
											<h4><?php echo $news[$i]->title; ?></h4>
										</a>
										<ul class="meta">
											<li><a href="#"><span class="lnr lnr-user"></span><?php echo $news[$i]->source; ?></a></li>
											<li><a href="#"><span class="lnr lnr-calendar-full"></span><?php echo $news[$i]->date; ?></a></li>
										</ul>
										<p class="excert">
											<?php echo (strlen($news[$i]->content) > 150) ? substr($news[$i]->content,0,150).'...' : $news[$i]->content; ?>
										</p>
									</div>
								</div>

							<?php } ?>
						<?php } ?>

							</div>
							<!-- End latest-post Area -->

							<!-- Start banner-ads Area -->
							<div class="col-lg-12 ad-widget-wrap mt-30 mb-30">
								<?php echo $feed_big_ad; ?>
							</div>
							<!-- End banner-ads Area -->
							<!-- Start popular-post Area -->
							<div class="popular-post-wrap">
								<h4 class="title">Latest Video News</h4>

								<?php if(!empty($videos) ){ ?>
								<div class="feature-post relative">
									<div class="feature-img relative">
										<div class="overlay overlay-bg"></div>
										<img class="img-fluid" src="<?php echo $videos[0]->thumbnail; ?>" alt="" style="max-height:400px;">
									</div>
									<div class="details">
										<ul class="tags">
											<li><a><?php echo $videos[0]->interest; ?></a></li>
										</ul>
										<a href="<?php echo site_url().'video/'.$videos[0]->id; ?>">
											<h3><?php echo $videos[0]->title; ?></h3>
										</a>
										<ul class="meta">
											<li><a href="#"><span class="lnr lnr-user"></span><?php echo $videos[0]->source; ?></a></li>
											<li><a href="#"><span class="lnr lnr-calendar-full"></span><?php echo $videos[0]->date; ?></a></li>
										</ul>
									</div>
								</div>
								<div class="row mt-20 medium-gutters">

									<?php
									if(count($videos)>=2){
									 $vid_count = 1;
									 while($vid_count<3){
                      if($vid_count>count($videos))break;
										 ?>
									<div class="col-lg-6 single-popular-post">
										<div class="feature-img-wrap relative">
											<div class="feature-img relative">
												<div class="overlay overlay-bg"></div>
												<img class="img-fluid" src="<?php echo $videos[$vid_count]->thumbnail; ?>" alt="">
											</div>
											<ul class="tags">
												<li><a href=""><?php echo $videos[$vid_count]->interest; ?></a></li>
											</ul>
										</div>
										<div class="details">
											<a href="<?php echo site_url().'video/'.$videos[$vid_count]->id; ?>">
												<h4><?php echo $videos[$vid_count]->title; ?></h4>
											</a>
											<ul class="meta">
												<li><a href="#"><span class="lnr lnr-user"></span><?php echo $videos[$vid_count]->source; ?></a></li>
												<li><a href="#"><span class="lnr lnr-calendar-full"></span><?php echo $videos[$vid_count]->date; ?></a></li>
											</ul>

										</div>
									</div>
								<?php
							   	$vid_count++;
							   }
							 }
							 ?>

								</div>

								<div class="row mt-20 medium-gutters">

									<?php for($i=3; $i<count($videos); $i++){ ?>
									<div class="col-lg-6 single-popular-post">
										<div class="feature-img-wrap relative">
											<div class="feature-img relative">
												<div class="overlay overlay-bg"></div>
												<img class="img-fluid" src="<?php echo $videos[$i]->thumbnail; ?>" alt="">
											</div>
											<ul class="tags">
												<li><a href=""><?php echo $videos[$i]->interest; ?></a></li>
											</ul>
										</div>
										<div class="details">
											<a href="<?php echo site_url().'video/'.$videos[$i]->id; ?>">
												<h4><?php echo $videos[$i]->title; ?></h4>
											</a>
											<ul class="meta">
												<li><a href="#"><span class="lnr lnr-user"></span><?php echo $videos[$i]->source; ?></a></li>
												<li><a href="#"><span class="lnr lnr-calendar-full"></span><?php echo $videos[$i]->date; ?></a></li>
											</ul>
										</div>
									</div>
								<?php } ?>

								</div>
							<?php }else{
								echo "videos are empty";
							} ?>

							</div>
							<!-- End popular-post Area -->

						</div>
						<div class="col-lg-4">
							<div class="sidebars-area">
								<div class="single-sidebar-widget editors-pick-widget">
									<h6 class="title">Football Latest</h6>
									<?php if(!empty($football)){ ?>
									<div class="editors-pick-post">
										<div class="feature-img-wrap relative">
											<div class="feature-img relative">
												<div class="overlay overlay-bg"></div>
												<img class="img-fluid" src="<?php echo $football[0]->thumbnail; ?>" alt="">
											</div>
											<ul class="tags">
												<li><a href="#"><?php echo $football[0]->interest; ?></a></li>
											</ul>
										</div>
										<div class="details">
											<a href="<?php echo site_url().'post/'.$football[0]->id; ?>">
												<h4 class="mt-20"><?php echo $football[0]->title; ?></h4>
											</a>
											<ul class="meta">
												<li><a href="#"><span class="lnr lnr-user"></span><?php echo $football[0]->source; ?></a></li>
												<li><a href="#"><span class="lnr lnr-calendar-full"></span><?php echo $football[0]->date; ?></a></li>
											</ul>
											<p class="excert">
												<?php echo (strlen($football[0]->content) > 150) ? substr($football[0]->content,0,150).'...' : $football[0]->content; ?>
											</p>
										</div>
										<div class="post-lists">
											<?php for($i=1; $i<count($football); $i++){ ?>
											<div class="single-post d-flex flex-row">
												<div class="thumb">
													<img src="<?php echo $football[$i]->thumbnail; ?>" alt="" style="height:80px; width:100px;">
												</div>
												<div class="detail">
													<a href="<?php echo site_url().'post/'.$football[$i]->id; ?>"><h6><?php echo $football[$i]->title; ?></h6></a>
													<ul class="meta">
														<li><a><span class="lnr lnr-calendar-full"></span><?php echo $football[$i]->date; ?></a></li>
													</ul>
												</div>
											</div>
										<?php } ?>
										</div>
									</div>
								<?php } ?>
								</div>
								<div class="single-sidebar-widget ads-widget">
									<?php echo $side_bar_small_ad; ?>
								</div>

								<div class="single-sidebar-widget most-popular-widget" style="margin-top:15px;">
									<h6 class="title">Latest in Technology</h6>
                  <?php if(!empty($news)){ ?>
									<?php for($i=0; $i<count($technology); $i++){ ?>
									<div class="single-list d-flex flex-row">
										<div class="thumb">
											<img src="<?php echo $technology[$i]->thumbnail; ?>" alt="" style="height:80px; width:100px;">
										</div>
										<div class="details">
											<a href="<?php echo site_url().'post/'.$technology[$i]->id; ?>"><h6><?php echo $technology[$i]->title; ?></h6></a>
											<ul class="meta">
												<li><a><span class="lnr lnr-calendar-full"></span><?php echo $technology[$i]->date; ?></a></li>
											</ul>
										</div>
									</div>
								<?php }  ?>
							<?php } ?>
								</div>
								<div class="single-sidebar-widget social-network-widget">
    <h6 class="title">Social Networks</h6>
    <ul class="social-list">
        <li class="d-flex justify-content-between align-items-center fb">
            <a href="https://www.facebook.com/mindberzerk" target="_blank">
				<div class="icons d-flex flex-row align-items-center">
                <i class="fa fa-facebook" aria-hidden="true"></i>
                <p>Like Our Page</p>
            </div>
            </a>
        </li>
        <li class="d-flex justify-content-between align-items-center tw">
           <a href="https://twitter.com/mindberzerk" target="_blank"> <div class="icons d-flex flex-row align-items-center">
                <i class="fa fa-twitter" aria-hidden="true"></i>
                <p>Follow Us</p>
            </div>
            </a>
        </li>
        <!-- New list item for Google Play Store -->
        <li class="d-flex justify-content-between align-items-center yt">
           <a href="https://play.google.com/store/apps/details?id=com.mindhunter.newsflash" target="_blank">
			   <div class="icons d-flex flex-row align-items-center">
                <i class="fa fa-google-plus" aria-hidden="true"></i>
                <p>Download on App on Google Play</p>
            </div>
            </a>
        </li>
    </ul>
</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- End latest-post Area -->
		</div>
