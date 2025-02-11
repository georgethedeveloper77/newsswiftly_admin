<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Update Radio</h2>
        </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">

                        <div class="body">
                          <div class="card-inner">
                          <form method="POST" action="<?php echo base_url(); ?>editRadioLinkData">
                            <div class="addon-line" style="margin-top:15px;">
                                <div class="form-line">
                                  <label>Select radio country(only users from selected country will be able to listen to this radio)</label>
                                  <select class="form-control" name="location" required="" autofocus="">
                                    <option value="wo" <?php $radio->location=="wo"?"selected":""; ?>>World</option>
                                    <?php foreach ($countries as $res) { ?>
                                      <option value="<?php echo $res->code; ?>" <?php echo $radio->location==$res->code?"selected":""; ?>><?php echo $res->name; ?></option>
                                    <?php  } ?>
                                  </select>
                                </div>
                            </div>

                            <div class="input-group addon-line" style="margin-top:15px;">
                              <input type="hidden" name="id" value="<?php echo $radio->id; ?>">
                              <div class=" form-line">
                                  <input type="text" class="form-control" name="interest" placeholder="Category" required="" autofocus="" value="<?php echo $radio->interest; ?>">
                              </div>
                            </div>
                              <div class="input-group addon-line" style="margin-top:15px;">

                                  <div class="form-line">
                                      <input type="text" class="form-control" name="title" placeholder="Title" required="" autofocus="" value="<?php echo $radio->title; ?>">
                                  </div>
                              </div>
                              <div class="input-group addon-line" style="margin-top:15px;">

                                  <div class="form-line">
                                      <input type="text" class="form-control" name="thumbnail" placeholder="Thumbnail" required="" autofocus="" value="<?php echo $radio->thumbnail; ?>">
                                  </div>
                              </div>
                              <div class="input-group addon-line">

                                  <div class="form-line">
                                      <input type="text" class="form-control" name="link" placeholder="Stream Url" required="" value="<?php echo $radio->link; ?>">
                                  </div>
                              </div>
                              <div class="addon-line" style="margin-top:15px;">
                                  <div class="form-line">
                                      <label>Requires Subscription?(do users need to subscribe to stream this radio)</label>
                                      <select class="form-control" name="isSubscribe" required="" autofocus="">
                                        <option value="0" <?php echo $link->$radio==0?"selected":""; ?>>YES</option>
                                        <option value="1" <?php echo $link->$radio==1?"selected":""; ?>>NO</option>
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
                               <button class="btn btn-primary waves-effect" type="submit">UPDATE RADIO CHANNEL</button>
                            </div>

                          </form>
                        </div>
                      </div>
                </div>
            </div>
    </div>
</section>
