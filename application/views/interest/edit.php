<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Update Interest</h2>
        </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">

                        <div class="body">
                          <div class="card-inner">
                          <form method="POST" action="<?php echo base_url(); ?>editInterestData" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $interest->id; ?>">
                            <div class="input-group addon-line">

                                <div class="form-line">
                                    <input type="text" class="form-control" name="name" placeholder="Interest Name" required="" autofocus="" value="<?php echo $interest->name; ?>">
                                </div>
                            </div>

                              <div class="input-group addon-line">

                                  <div class="form-line">
                                      <input data-default-file="<?php echo $interest->thumbnail; ?>" type="file" name="thumbnail" data-allowed-file-extensions="png jpg jpeg PNG" class="dropify">
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
                               <button class="btn btn-primary waves-effect" type="submit">UPDATE INTEREST</button>
                            </div>

                          </form>
                        </div>
                      </div>
                    </div>
                </div>
    </div>
</section>
