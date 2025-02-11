<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD</h2>
        </div>

        <!-- Widgets -->
        <div class="row clearfix">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="info-box bg-pink hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">rss_feed</i>
                    </div>
                    <div class="content">
                        <div class="text"> Rss Feeds </div>
                        <div class="number count-to" data-from="0" data-to="" data-speed="15" data-fresh-interval="20"><?php echo $rssfeeds; ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="info-box bg-cyan hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons"> links</i>
                    </div>
                    <div class="content">
                        <div class="text">Rss Feeds Channels </div>
                        <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"><?php echo $rsslinks; ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="info-box bg-pink hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">video_library</i>
                    </div>
                    <div class="content">
                        <div class="text"> Youtube Rss Feeds</div>
                        <div class="number count-to" data-from="0" data-to="" data-speed="15" data-fresh-interval="20"><?php echo $youtubefeeds; ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="info-box bg-cyan hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">verified_user</i>
                    </div>
                    <div class="content">
                        <div class="text">Youtube Channels</div>
                        <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"><?php echo $youtubelinks; ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="info-box bg-pink hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">pages</i>
                    </div>
                    <div class="content">
                        <div class="text">Interests</div>
                        <div class="number count-to" data-from="0" data-to="" data-speed="15" data-fresh-interval="20"><?php echo $interests; ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="info-box bg-cyan hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">radio</i>
                    </div>
                    <div class="content">
                        <div class="text">Radio Channels</div>
                        <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"><?php echo $radio; ?></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
