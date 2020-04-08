<div class="page-content fade-in-up">
                    <!-- BEGIN: Page heading-->
                    <div class="page-heading">
                        <div class="page-breadcrumb">
                            <h1 class="page-title page-title-sep"><?php echo $Page_name;?></h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url();?>teachers/index"><i class="ti-home font-20"></i></a></li>
                                <li class="breadcrumb-item"><?php echo $Page_name;?></li>
                            </ol>
                        </div>
                    </div><!-- BEGIN: Page content-->
                    <div>
                        <div class="row">   
                            <div class="col-lg-12">

                                    <!--SHOWING MESSAGE{SUCCESS OR FAILURE}-->
                                    <?php if ($this->session->flashdata('message') != null) {  ?>
                                      <?php echo $this->session->flashdata('message'); ?>              
                                    <?php } ?>
                                    <!--//SHOWING MESSAGE{SUCCESS OR FAILURE}-->
                                <div class="card  card-fullheight">
                                    <div class="card-body">
                                        <h5 class="box-title"><?php echo $Page_name;?></h5>
                                        <div>
                                            <ul class="nav nav-pills nav-pills-solid">
                                                <li class="nav-item mr-2"><a class="nav-link active" data-toggle="pill" href="#pill-link-1">Profile</a></li>
                                                <li class="nav-item mr-2"><a class="nav-link" data-toggle="pill" href="#pill-link-2">Login</a></li>
                                                <!--<li class="nav-item"><a class="nav-link" data-toggle="pill" href="#pill-link-3">Support & Security</a></li>-->
                                            </ul>
                                            <div class="tab-content mt-4">
                                                <div class="tab-pane fade show active" id="pill-link-1">
                                                    <?php echo form_open_multipart('teachers/accounts/profile_image');?>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group mb-4"><label>Profile Image</label><input class="form-control" type="file" placeholder="Enter Full Name" name="photo"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group"><button class="btn btn-primary mr-2" type="submit">Submit</button><button class="btn btn-light" type="reset">Clear</button></div>
                                                    <?php echo form_close();?>
                                                </div>
                                                <div class="tab-pane fade" id="pill-link-2">
                                                   <?php echo form_open('teachers/accounts/login');?>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group mb-4"><label>Old Password</label><input class="form-control" type="password" placeholder="Enter Old Password" name="old_password"></div>
                                                                <div class="form-group mb-4"><label>New Password</label><input class="form-control" type="password" placeholder="Enter New Password" name="new_password"></div>
                                                                <div class="form-group mb-4"><label>Confirm Password</label><input class="form-control" type="password" placeholder="Repeat Password" name="confirm_password"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group"><button class="btn btn-primary mr-2" type="submit">Submit</button><button class="btn btn-light" type="reset">Clear</button></div>
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