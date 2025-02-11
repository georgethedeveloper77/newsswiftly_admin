<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Update Settings</h2>
        </div>
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="container-fluid">

          <div class="row clearfix">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="card">

                      <div class="body">
                        <div class="card-inner">
                        <form method="POST" action="<?php echo base_url(); ?>updateSettings">
                          <div class="input-group addon-line">
                              <label>Site Name</label>
                              <div class="form-line">
                                  <input type="text" class="form-control" name="site_name" placeholder="" required="" autofocus="" value="<?php echo $settings->site_name; ?>">
                              </div>
                          </div>
                          <div class="input-group addon-line">
                              <label>Youtube Api Key</label>
                              <div class="form-line">
                                  <input type="text" class="form-control" name="youtube_api_key" placeholder="" autofocus="" value="<?php echo $settings->youtube_api_key; ?>">
                              </div>
                          </div>
                          <div class="input-group addon-line">
                              <label>Firebase Server Key</label>
                              <div class="form-line">
                                  <input type="text" class="form-control" name="fcm_server_key" placeholder="" autofocus="" value="<?php echo $settings->fcm_server_key; ?>">
                              </div>
                          </div>
                          <h4 style="margin-top:40px;">SMTP & mail configuration(The fields below will be used to send mail to users)</h4>

                          <div class="input-group addon-line" style="margin-top:10px;">
                              <label>SMTP username</label>
                              <div class="form-line">
                                  <input type="text" class="form-control" name="mail_username" placeholder="" required="" autofocus="" value="<?php echo $settings->mail_username; ?>">
                              </div>
                          </div>
                          <div class="input-group addon-line">
                              <label>SMTP password</label>
                              <div class="form-line">
                                  <input type="text" class="form-control" name="mail_password" placeholder="" autofocus="" value="<?php echo $settings->mail_password; ?>">
                              </div>
                          </div>


                          <div class="input-group addon-line">
                              <label>SMTP HOST</label>
                              <div class="form-line">
                                  <input type="text" class="form-control" name="mail_smtp_host" placeholder="" autofocus="" value="<?php echo $settings->mail_smtp_host; ?>">
                              </div>
                          </div>

                          <div class="input-group addon-line col-md-6">
                              <label>SMTP Protocol</label>
                              <div class="form-line">
                                  <input type="text" class="form-control" name="mail_protocol" placeholder="" autofocus="" value="<?php echo $settings->mail_protocol; ?>">
                              </div>
                          </div>

                          <div class="input-group addon-line col-md-6">
                              <label>TCP port to connect to</label>
                              <div class="form-line">
                                  <input type="text" class="form-control" name="mail_port" placeholder="" autofocus="" value="<?php echo $settings->mail_port; ?>">
                              </div>
                          </div>
                          <div class="input-group addon-line">
                              <label>Banner 728 by 90 Ad(Place AD html here)</label>
                              <div class="form-line">
                                  <textarea type="text" class="form-control" name="top_banner_big_ad" placeholder="" autofocus=""><?php echo $settings->top_banner_big_ad; ?></textarea>
                              </div>
                          </div>

                          <div class="input-group addon-line">
                              <label>Feed 728 by 90 Ad(Place AD html here)</label>
                              <div class="form-line">
                                  <textarea type="text" class="form-control" name="feed_big_ad" placeholder="" autofocus=""><?php echo $settings->feed_big_ad; ?></textarea>
                              </div>
                          </div>

                          <div class="input-group addon-line">
                              <label>SideBAr 300 by 250 Ad(Place AD html here)</label>
                              <div class="form-line">
                                  <textarea type="text" class="form-control" name="side_bar_small_ad" placeholder="" autofocus=""><?php echo $settings->side_bar_small_ad; ?></textarea>
                              </div>
                          </div>



                          <div class="input-group addon-line">
                              <label>Disqus Server Path</label>
                              <div class="form-line">
                                  <input type="text" class="form-control" name="disqus_server_url" placeholder="" autofocus="" value="<?php echo $settings->disqus_server_url; ?>">
                              </div>
                          </div>

                          <div class="input-group addon-line col-md-6">
                              <label>Facebook Page Url</label>
                              <div class="form-line">
                                  <input type="text" class="form-control" name="facebook_page_url" placeholder="" autofocus="" value="<?php echo $settings->facebook_page_url; ?>">
                              </div>
                          </div>

                          <div class="input-group addon-line col-md-6">
                              <label>Twitter Page Url</label>
                              <div class="form-line">
                                  <input type="text" class="form-control" name="twitter_page_url" placeholder="" autofocus="" value="<?php echo $settings->twitter_page_url; ?>">
                              </div>
                          </div>

                          <div class="input-group addon-line">
                              <label>About Page(Write a short note about your site)</label>
                              <div class="form-line">
                                  <textarea type="text" class="form-control" name="about"><?php echo $settings->about; ?></textarea>
                              </div>
                          </div>

                          <div class="input-group addon-line">
                              <label>App Terms(Site terms and conditions, you can include html here)</label>
                              <div class="form-line">
                                  <textarea type="text" class="form-control" name="terms"><?php echo $settings->terms; ?></textarea>
                              </div>
                          </div>

                          <div class="input-group addon-line">
                              <label>App Privacy Policy(Site Privacy Policy, you can include html here)</label>
                              <div class="form-line">
                                  <textarea type="text" class="form-control" name="privacy"><?php echo $settings->privacy; ?></textarea>
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

                          <div class="box-footer text-center">
                             <button class="btn btn-primary waves-effect" type="submit">UPDATE SETTINGS</button>
                          </div>

                        </form>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
  </div>
</div>
</section>
