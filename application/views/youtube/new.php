<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Add New Youtube Channel</h2>
        </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">

                        <div class="body">
                          <div class="card-inner">
                          <form method="POST" action="<?php echo base_url(); ?>saveNewYoutubeRssLink">
                            <div class="addon-line" style="margin-top:15px;">
                                <div class="form-line">
                                  <label>Select rss country(only users from selected country will be able to pull feeds from this youtube channel)</label>
                                  <select class="form-control" name="location" required="" autofocus="">
                                    <option value="wo">World</option>
                                    <?php foreach ($countries as $res) { ?>
                                      <option value="<?php echo $res->code; ?>"><?php echo $res->name; ?></option>
                                    <?php  } ?>
                                  </select>
                                </div>
                            </div>
                            <div class="addon-line" style="margin-top:15px;">
                                <div class="form-line">
                                  <label>Set Youtube Channel Interest</label>
                                    <select class="form-control" name="category" required="" autofocus="">
                                      <option value="">select youtube rss link interest</option>
                                      <?php foreach ($interests as $res) { ?>
                                        <option value="<?php echo $res->name; ?>"><?php echo $res->name; ?></option>
                                      <?php  } ?>
                                    </select>
                                </div>
                            </div>
                              <div class="input-group addon-line" style="margin-top:15px;">

                                  <div class="form-line">
                                      <input type="text" class="form-control" name="source" placeholder="Title" required="" autofocus="">
                                  </div>
                              </div>
                              <div class="input-group addon-line">

                                  <div class="form-line">
                                      <input type="text" class="form-control" name="url" placeholder="Youtube Channel ID" required="">
                                  </div>
                              </div>
                              <div class="addon-line" style="margin-top:15px;">
                                  <div class="form-line">
                                    <label>Feed Language</label>
                                    <select class="form-control form-control-sm" name="lang" required="" autofocus="">
                                      <option value="">Select Language</option>
                                      <?php foreach ($languages as $res) { ?>
                                        <option value="<?php echo $res->name; ?>"><?php echo $res->name; ?></option>
                                      <?php  } ?>
                                    </select>
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
                               <button class="btn btn-primary waves-effect" type="submit">SAVE NEW YOUTUBE CHANNEL</button>
                            </div>

                          </form>
                        </div>
                      </div>
                </div>
            </div>
    </div>
</section>
