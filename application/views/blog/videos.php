

		<div class="site-main-container">
			<!-- Start latest-post Area -->
			<section class="latest-post-area pb-120">
				<div class="container no-padding">
					<div class="row">
						<div class="col-lg-8 post-list">
							<!-- Start latest-post Area -->
							<div class="latest-post-wrap">
								<h4 class="cat-title"><?php echo $category; ?></h4>

								<?php for($i=0; $i<count($videos); $i++) {
									?>
								<div class="single-latest-post row align-items-center">
									<div class="col-lg-5 post-left">
										<div class="feature-img relative">
											<div class="overlay overlay-bg"></div>
											<img class="img-fluid" src="<?php echo $videos[$i]->thumbnail; ?>" alt="" style="width: 100%;max-height: 150px;">
										</div>
										<ul class="tags">
											<li><a href="#"><?php echo $videos[$i]->interest; ?></a></li>
										</ul>
									</div>
									<div class="col-lg-7 post-right">
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

							<div class="single-latest-post row align-items-center">
								<div class="col-lg-12">
							  	<?php echo $links; ?>
							 </div>
					  	</div>


							</div>
							<!-- End latest-post Area -->

							<!-- Start banner-ads Area -->
							<div class="col-lg-12 ad-widget-wrap mt-30 mb-30">
								<?php echo $feed_big_ad; ?>
							</div>
							<!-- End banner-ads Area -->


						</div>
						<div class="col-lg-4">
							<div class="sidebars-area">
								<div class="single-sidebar-widget ads-widget">
									<?php echo $side_bar_small_ad; ?>
								</div>
								<?php if(count($news)>0) { ?>
								<div class="single-sidebar-widget editors-pick-widget">
									<h6 class="title">Posts on <?php echo $category; ?></h6>

									<div class="editors-pick-post">
										<div class="feature-img-wrap relative">
											<div class="feature-img relative">
												<div class="overlay overlay-bg"></div>
												<img class="img-fluid" src="<?php echo $news[0]->thumbnail; ?>" alt="">
											</div>
											<ul class="tags">
												<li><a href="#"><?php echo $news[0]->interest; ?></a></li>
											</ul>
										</div>
										<div class="details">
											<a href="<?php echo site_url().'post/'.$news[0]->id; ?>">
												<h4 class="mt-20"><?php echo $news[0]->title; ?></h4>
											</a>
											<ul class="meta">
												<li><a href="#"><span class="lnr lnr-user"></span><?php echo $news[0]->source; ?></a></li>
												<li><a href="#"><span class="lnr lnr-calendar-full"></span><?php echo $news[0]->date; ?></a></li>
											</ul>
											<p class="excert">
												<?php echo (strlen($news[0]->content) > 150) ? substr($news[0]->content,0,150).'...' : $news[0]->content; ?>
											</p>
										</div>
										<div class="post-lists">
											<?php for($i=1; $i<count($news); $i++){ ?>
											<div class="single-post d-flex flex-row">
												<div class="thumb">
													<img src="<?php echo $news[$i]->thumbnail; ?>" alt="" style="height:80px; width:100px;">
												</div>
												<div class="detail">
													<a href="<?php echo site_url().'post/'.$news[$i]->id; ?>"><h6><?php echo $news[$i]->title; ?></h6></a>
													<ul class="meta">
														<li><a><span class="lnr lnr-calendar-full"></span><?php echo $news[$i]->date; ?></a></li>
													</ul>
												</div>
											</div>
										<?php } ?>
										</div>

										<div class="single-latest-post row align-items-center">
											<div class="col-lg-12 text-center">
										  	<a href="<?php echo site_url().'posts/'.$category; ?>" class="btn btn-default">more posts on <?php echo $category; ?></a>
										 </div>
								  	</div>
									</div>

								</div>
								<?php } ?>


							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- End latest-post Area -->
		</div>
