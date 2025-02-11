<div class="site-main-container">

  <!-- Start latest-post Area -->
  <section class="latest-post-area pb-120">
    <div class="container no-padding">
      <div class="row">
        <div class="col-lg-8 post-list">
          <!-- Start single-post Area -->
          <div class="single-post-wrap">
            <div class="feature-img-thumb relative">
              <div class="overlay overlay-bg"></div>
              <img class="img-fluid" src="<?php echo $post->thumbnail; ?>" alt="" style="max-height:500px;">
            </div>
            <div class="content-wrap">
              <ul class="tags mt-10">
                <li><a><?php echo $post->interest; ?></a></li>
                <li><a href="<?php echo $post->link; ?>">Visit Article Link</a></li>
              </ul>
              <a>
                <h3><?php echo $post->title; ?></h3>
              </a>
              <ul class="meta pb-20">
                <li><a><span class="lnr lnr-user"></span><?php echo $post->source; ?></a></li>
                <li><a><span class="lnr lnr-calendar-full"></span><?php echo $post->date; ?></a></li>
              </ul>
              <p><?php echo nl2br($post->content); ?></p>

            <div class="comment-sec-area">
              <div class="container">
                <div class="row flex-column">
                  <div id="disqus_thread"></div>
                  <script>

                  /**
                  *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                  *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/

                  var disqus_config = function () {
                  this.page.url = "<?php echo site_url().'post/'.$post->id; ?>";  // Replace PAGE_URL with your page's canonical URL variable
                  this.page.identifier = "<?php echo $post->id; ?>"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                  };

                  (function() { // DON'T EDIT BELOW THIS LINE
                  var d = document, s = d.createElement('script');
                  s.src = '<?php echo $disqus_server_url; ?>';
                  s.setAttribute('data-timestamp', +new Date());
                  (d.head || d.body).appendChild(s);
                  })();
                  </script>
                  <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- End single-post Area -->
      </div>
      <div class="col-lg-4">
        <div class="sidebars-area">

          <div class="single-sidebar-widget editors-pick-widget">
            <div class="single-sidebar-widget ads-widget">
              <?php echo $side_bar_small_ad; ?>
            </div>
            <h6 class="title">Related Posts</h6>
            <div class="editors-pick-post">
              <div class="feature-img-wrap relative">
                <div class="feature-img relative">
                  <div class="overlay overlay-bg"></div>
                  <img class="img-fluid" src="<?php echo $related[0]->thumbnail; ?>" alt="">
                </div>
                <ul class="tags">
                  <li><a href="#"><?php echo $related[0]->interest; ?></a></li>
                </ul>
              </div>
              <div class="details">
                <a href="<?php echo site_url().'post/'.$related[0]->id; ?>">
                  <h4 class="mt-20"><?php echo $related[0]->title; ?></h4>
                </a>
                <ul class="meta">
                  <li><a href="#"><span class="lnr lnr-user"></span><?php echo $related[0]->source; ?></a></li>
                  <li><a href="#"><span class="lnr lnr-calendar-full"></span><?php echo $related[0]->date; ?></a></li>
                </ul>
                <p class="excert">
                  <?php echo (strlen($related[0]->content) > 150) ? substr($related[0]->content,0,150).'...' : $related[0]->content; ?>
                </p>
              </div>
              <div class="post-lists">
                <?php for($i=1; $i<count($related); $i++){ ?>
                <div class="single-post d-flex flex-row">
                  <div class="thumb">
                    <img src="<?php echo $related[$i]->thumbnail; ?>" alt="" style="height:80px; width:100px;">
                  </div>
                  <div class="detail">
                    <a href="<?php echo site_url().'post/'.$related[$i]->id; ?>"><h6><?php echo $related[$i]->title; ?></h6></a>
                    <ul class="meta">
                      <li><a><span class="lnr lnr-calendar-full"></span><?php echo $related[$i]->date; ?></a></li>
                    </ul>
                  </div>
                </div>
              <?php } ?>
              </div>
            </div>
          </div>



          <div class="single-sidebar-widget social-network-widget">
            <h6 class="title">Social Networks</h6>
            <ul class="social-list">
              <li class="d-flex justify-content-between align-items-center fb">
                <div class="icons d-flex flex-row align-items-center">
                  <i class="fa fa-facebook" aria-hidden="true"></i>
                  <p>983 Likes</p>
                </div>
                <a href="#">Like our page</a>
              </li>
              <li class="d-flex justify-content-between align-items-center tw">
                <div class="icons d-flex flex-row align-items-center">
                  <i class="fa fa-twitter" aria-hidden="true"></i>
                  <p>983 Followers</p>
                </div>
                <a href="#">Follow Us</a>
              </li>
              <li class="d-flex justify-content-between align-items-center yt">
                <div class="icons d-flex flex-row align-items-center">
                  <i class="fa fa-youtube-play" aria-hidden="true"></i>
                  <p>983 Subscriber</p>
                </div>
                <a href="#">Subscribe</a>
              </li>
              <li class="d-flex justify-content-between align-items-center rs">
                <div class="icons d-flex flex-row align-items-center">
                  <i class="fa fa-rss" aria-hidden="true"></i>
                  <p>983 Subscribe</p>
                </div>
                <a href="#">Subscribe</a>
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
