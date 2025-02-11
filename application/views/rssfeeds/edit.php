<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Update Rss Feed</h2>
        </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">

                        <div class="body">
                          <div class="card-inner">
                          <form method="POST" action="<?php echo base_url(); ?>editRssFeedData">
                            <div class="input-group addon-line">
                                 <label>Feed Date</label>
                                <div class="form-line">
                                    <input type="date" class="form-control" name="date" placeholder="Feed Date" required="" value="<?php echo $feed->date; ?>">
                                </div>
                            </div>

                            <div class="addon-line">

                                <div class="form-line">
                                    <select id="source" class="form-control" name="source" required="" autofocus="">
                                      <?php foreach ($source as $res) { ?>
                                        <option <?php echo $feed->channel==$res->source?"selected":""; ?> data-location="<?php echo $res->location; ?>" data-lang="<?php echo $res->lang; ?>" data-interest="<?php echo $res->category; ?>" value="<?php echo $res->id; ?>"><?php echo $res->source; ?></option>
                                      <?php  } ?>
                                    </select>
                                </div>
                                <input type="hidden" name="id" value="<?php echo $feed->id; ?>">
                                <input type="hidden" name="interest" id="interest" value="<?php echo $feed->interest; ?>">
                                <input type="hidden" name="location" id="location" value="<?php echo $feed->location; ?>">
                                <input type="hidden" name="lang" id="lang" value="<?php echo $feed->lang; ?>">
                            </div>
                            <div class="input-group addon-line" style="margin-top:15px;">

                                <div class="form-line">
                                    <input type="text" class="form-control"  name="thumbnail" placeholder="Feed thumbnail Link" required value="<?php echo $feed->thumbnail; ?>">
                                </div>
                            </div>

                            <div class="input-group addon-line">

                                <div class="form-line">
                                    <input type="text" class="form-control" name="link" placeholder="Feed Link" required="" value="<?php echo $feed->link; ?>">
                                </div>
                            </div>
                              <div class="input-group addon-line" style="margin-top:15px;">

                                  <div class="form-line">
                                      <textarea type="text" class="form-control" name="title" placeholder="Title" required="" autofocus=""><?php echo $feed->title; ?></textarea>
                                  </div>
                              </div>
                              <div class="input-group addon-line" style="margin-top:15px;">

                                  <div class="form-line">
                                      <textarea type="text" class="form-control" name="content" rows="10" placeholder="Content" required="" autofocus=""><?php echo $feed->content; ?></textarea>
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
                               <button class="btn btn-primary waves-effect" type="submit">UPDATE RSS FEED</button>
                            </div>

                          </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</section>
