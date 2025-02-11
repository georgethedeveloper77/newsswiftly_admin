<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Send Notification to users</h2>
        </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">

                        <div class="body">
                          <div class="card-inner">
                          <form method="POST" action="<?php echo base_url(); ?>sendNotification">
                            <div class="input-group addon-line">
                                <label>Title</label>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="title" placeholder="" required="" autofocus="">
                                </div>
                            </div>
                            <div class="input-group addon-line">
                                <label>Message</label>
                                <div class="form-line">
                                    <textarea cols="100" type="text" class="form-control" name="message" placeholder="" required="" autofocus=""></textarea>
                                </div>
                            </div>
                            <div class="addon-line">
                                <div class="form-line">
                                  <label>Select Users to send Notification to</label>
                                  <select class="form-control" name="location[]" autofocus="" data-live-search="true" multiple>
                                    <option value="">All Users</option>
                                    <?php foreach ($countries as $res) { ?>
                                      <option value="<?php echo $res->code; ?>"><?php echo $res->name; ?></option>
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
                               <button class="btn btn-primary waves-effect" type="submit">SEND NOTIFICATION</button>
                            </div>

                          </form>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
    </div>
</section>
