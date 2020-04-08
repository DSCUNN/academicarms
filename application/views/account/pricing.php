                <div class="page-content fade-in-up">
                    <!-- BEGIN: Page heading-->
                    <div class="page-heading">
                        <div class="page-breadcrumb">
                            <h1 class="page-title page-title-sep"><?php echo $Page_name;?></h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url();?>account/index"><i class="ti-home font-20"></i></a></li>
                            </ol>
                        </div>
                    </div><!-- BEGIN: Page content-->
                    <div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <!--SHOWING MESSAGE{SUCCESS OR FAILURE}-->
                                    <?php if ($this->session->flashdata('message') != null) {  ?>
                                      <?php echo $this->session->flashdata('message'); ?>              
                                    <?php } ?>
                                    <!--//SHOWING MESSAGE{SUCCESS OR FAILURE}-->   
                                    <?php if ($packages->num_rows()<1): ?>  
                                    <div class="mx-auto text-center mb-5" style="max-width: 700px">
                                        <h3 class="text-primary mb-4 mt-3">No Package Plan Available</h3>
                                        <p>Looks like there is no package available for use</p>
                                    </div>
                                    <?php else:?>
                                    <?php foreach ($packages->result() as $package):?>
                                    <div class="col-md-4 pricing-plan active">
                                        <?php if ($package->Recommended==1):?>
                                        <div class="bg-primary text-center text-white py-2 px-3 h5 mb-0"><?php echo htmlentities($package->Recommend_text);?></div>
                                        <?php endif;?>
                                        <div class="text-center p-4">
                                            <h3 class="mb-4"><?php echo htmlentities($package->PackageName);?></h3>
                                            <p class="text-muted"><?php echo ($package->Description);?></p>
                                            <hr class="my-4">
                                            <div class="pricing-price py-3"><b><span class="h3 text-dangerx m-0 mr-2"><sup>$</sup><?php echo htmlentities($package->Amount);?></span></b></div>
                                            <div class="pricing-features py-4">
                                                <p>Add upto <?php echo ($package->Number_of_schools);?> schools</p>
                                                <?php echo ($package->Features);?>
                                                    <button class="btn btn-danger btn-rounded mt-3" data-toggle="modal" data-target="#deposit_fund" data-value="<?php echo $package->Package_id;?>" data-using="<?php echo $package->PackageName;?>">SUBSCRIBE</button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                                <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div><!-- END: Page content-->
                </div>

                <!-- ////////////////////////////////////////////////////////////////////////////-->

    <div class="modal fade text-left" id="deposit_fund" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">New message</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <?php echo form_open('account/pricing/subscribe');?>
              <div class="form-group" style="display: none;">
                <label for="recipient-name" class="col-form-label">Recipient:</label>
                <input type="text" class="form-control" name="id" id="recipient-name">
              </div>
              <p>You will only be charged at the point of generating result pins</p>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Subscribe</button>
              </div>
            <?php echo form_close();?>
          </div>
        </div>
      </div>
    </div>