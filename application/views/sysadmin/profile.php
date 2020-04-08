<div class="page-content fade-in-up">
                    <!-- BEGIN: Page heading-->
                    <div class="page-heading">
                        <div class="page-breadcrumb">
                            <h1 class="page-title page-title-sep"><?php echo $Page_name;?></h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url();?>sysadmin/index"><i class="ft-home font-20"></i></a></li>
                                <li class="breadcrumb-item"><?php echo $Page_name;?></li>
                            </ol>
                        </div>
                    </div><!-- BEGIN: Page content-->
                    <div>
                        <!--SHOWING MESSAGE{SUCCESS OR FAILURE}-->
                                <?php if ($this->session->flashdata('message') != null) {  ?>
                                    <?php echo $this->session->flashdata('message'); ?>              
                                <?php } ?>
                                <!--//SHOWING MESSAGE{SUCCESS OR FAILURE}-->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card  card-fullheight">
                                    <div class="card-body">
                                        <h5 class="box-title"><?php echo $Page_name;?></h5>
                                        <div>
                                            <ul class="nav nav-pills">
                                                <li class="nav-item"><a class="nav-link active" href="<?php echo base_url();?>sysadmin/account">Edit Profile</a></li>
                                            </ul>
                                            <div class="tab-content mt-4">
                                                <div class="tab-pane fade show active" id="pill1-1">
                                                    <?php echo form_open();?>
                                                        <div class="row">
                                                            <div class="col-sm-6 form-group mb-4">
                                                                <label>Name</label>
                                                                <input class="form-control input-lg" type="text" placeholder=" Name"  value="<?php echo htmlentities($admin->Name);?>" disabled>
                                                            </div>
                                                            <div class="col-sm-6 form-group mb-4">
                                                                <label>Email</label>
                                                                <input class="form-control input-lg" type="text" placeholder="Email"  value="<?php echo htmlentities($admin->Email);?>" disabled>
                                                            </div>
                                                            <div  class="col-sm-6 form-group mb-4">
                                                                <label>Two Way Authentication</label>
                                                                <div class="input-group-icon input-group-icon-left"><span class="input-icon input-icon-left"><i class="ti-lock"></i></span>
                                                                    <select class="form-control" disabled="">
                                                                            <option value="">Select Option</option>
                                                                        <?php if ($admin->Twoway==1):?>
                                                                            <option value="1" selected="">ON</option>
                                                                            <option value="2">OFF</option>
                                                                        <?php else:?>
                                                                            <option value="1">ON</option>
                                                                            <option value="2" selected="">OFF</option>
                                                                        <?php endif;?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div  class="col-sm-6 form-group mb-4">
                                                                <label>Notification System</label>
                                                                <div class="input-group-icon input-group-icon-left"><span class="input-icon input-icon-left"><i class="ti-email"></i></span>
                                                                    <select class="form-control" disabled="">
                                                                            <option value="">Select Option</option>
                                                                        <?php if ($admin->Notifyme==1):?>
                                                                            <option value="1" selected="">ON</option>
                                                                            <option value="2">OFF</option>
                                                                        <?php else:?>
                                                                            <option value="1">ON</option>
                                                                            <option value="2" selected="">OFF</option>
                                                                        <?php endif;?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php echo form_close();?>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- END: Page content-->
                </div>