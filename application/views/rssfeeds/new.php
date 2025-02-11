<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Add New Rss Feed</h2>
        </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">

                        <div class="body">
                          <div class="card-inner">
                          <form method="POST" action="<?php echo base_url(); ?>saveNewRssFeed">
                            <div class="input-group addon-line">
                                 <label>Feed Date</label>
                                <div class="form-line">
                                    <input type="date" class="form-control" name="date" placeholder="Feed Date" required="">
                                </div>
                            </div>

                            <div class="addon-line">

                                <div class="form-line">
                                    <select id="source" class="form-control" name="source" required="" autofocus="">
                                      <option data-interest="" data-location="" data-lang="" value="">select rss feed source</option>
                                      <?php foreach ($source as $res) { ?>
                                        <option data-location="<?php echo $res->location; ?>" data-lang="<?php echo $res->lang; ?>" data-interest="<?php echo $res->category; ?>" value="<?php echo $res->id; ?>"><?php echo $res->source; ?></option>
                                      <?php  } ?>
                                    </select>
                                </div>
                                <input type="hidden" name="interest" id="interest">
                                <input type="hidden" name="location" id="location">
                                <input type="hidden" name="lang" id="lang">
                            </div>
                            <div class="input-group addon-line" style="margin-top:15px;">

                                <div class="form-line">
                                    <input type="text" class="form-control"  name="thumbnail" placeholder="Feed thumbnail Link" required>
                                </div>
                            </div>

                            <div class="input-group addon-line">

                                <div class="form-line">
                                    <input type="text" class="form-control" name="link" placeholder="Feed Link" required="">
                                </div>
                            </div>
                              <div class="input-group addon-line" style="margin-top:15px;">

                                  <div class="form-line">
                                      <textarea type="text" class="form-control" name="title" placeholder="Title" required="" autofocus=""></textarea>
                                  </div>
                              </div>
                              <div class="input-group addon-line" style="margin-top:15px;">

                                  <div class="form-line">
                                      <textarea type="text" class="form-control" name="content" rows="10" placeholder="Content" required="" autofocus=""></textarea>
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
                               <button class="btn btn-primary waves-effect" type="submit">SAVE NEW RSS FEED</button>
                            </div>

                          </form>
                        </div>
                      </div>
                </div>
            </div>
    </div>
</section>
