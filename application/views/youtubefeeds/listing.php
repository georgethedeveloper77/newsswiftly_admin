<style>
.td_width{
  max-width:60px;
  overflow-wrap: break-word;
}
</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Youtube Feeds Listing</h2>
        </div>

            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">

                        <div class="body">
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
                          <div style="overflow-x:auto;">
                            <table id="youtube_table" class="table table-responsive table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                  <th>Id</th>
                                  <th>Feed Source</th>
                                  <th>Title</th>
                                  <th>Thumbnail</th>
                                  <th>Feed Link</th>
                                  <th>Video ID</th>
                                <!--  <th>Interest</th>
                                  <th>Language</th>
                                  <th>Location</th> -->
                                  <th>Date</th>
                                  <th class="text-center">Actions</th>
                                </tr>
                                </thead>

                            </table>
                          </div>
                    </div>
                </div>
            </div>
    </div>
</section>
