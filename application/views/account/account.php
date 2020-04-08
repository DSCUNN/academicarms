<div class="page-content fade-in-up">
                    <!-- BEGIN: Page heading-->
                    <div class="page-heading">
                        <div class="page-breadcrumb">
                            <h1 class="page-title page-title-sep"><?php echo $Page_name;?></h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url();?>account/index"><i class="ti-home font-20"></i></a></li>
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
                                                <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#pill-link-3">Support & Security</a></li>
                                            </ul>
                                            <div class="tab-content mt-4">
                                                <div class="tab-pane fade show active" id="pill-link-1">
                                                    <?php echo form_open('account/account/profile');?>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-4"><label>Full Name</label><input class="form-control" type="text" placeholder="Enter Full Name" name="name" value="<?php echo htmlentities($organizer->Name);?>"></div>
                                                                <div class="form-group mb-4"><label>Email</label><input class="form-control" type="text" placeholder="Enter Email" name="email" value="<?php echo htmlentities($organizer->Email);?>"></div>
                                                                <div class="form-group mb-4"><label>About</label><textarea class="form-control" type="text" placeholder="Enter Something" name="about"><?php echo htmlentities($organizer->About);?></textarea></div>
                                                                <div class="form-group mb-4"><label>Position</label><input class="form-control" type="text" placeholder="Enter Occupation or Position In Company" name="position" value="<?php echo htmlentities($organizer->Position);?>"></div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-4"><label>Country</label>
                                                                    <div class="input-group-icon input-group-icon-left"><span class="input-icon input-icon-left"><i class="ti-location-pin font-16"></i></span><input class="form-control" type="text" placeholder="Enter Country" name="country" value="<?php echo htmlentities($organizer->Country);?>"></div>
                                                                </div>
                                                                <div class="form-group mb-4"><label>State</label>
                                                                    <div class="input-group-icon input-group-icon-left"><span class="input-icon input-icon-left"><i class="ti-lock"></i></span><input class="form-control" type="text" placeholder="Enter State" name="state" value="<?php echo htmlentities($organizer->State);?>"></div>
                                                                </div>
                                                                <div class="form-group mb-4"><label>City</label>
                                                                    <div class="input-group-icon input-group-icon-left"><span class="input-icon input-icon-left"><i class="ti-lock"></i></span><input class="form-control" type="text" placeholder="Enter City" name="city" value="<?php echo htmlentities($organizer->City);?>"></div>
                                                                </div>
                                                                <div class="form-group mb-4"><label>Zip Code</label>
                                                                    <div class="input-group-icon input-group-icon-left"><span class="input-icon input-icon-left"><i class="ti-lock"></i></span><input class="form-control" type="zip" placeholder="Enter Zip Code" value="<?php echo htmlentities($organizer->Zip);?>" name="zip"></div>
                                                                </div>
                                                            </div>
                                                             <div class="col-md-12">
                                                                <div class="form-group mb-4"><label>Passcode</label><input class="form-control" type="password" placeholder="Enter Password Or Master Code" name="passcode"></div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group"><button class="btn btn-primary mr-2" type="submit">Submit</button><button class="btn btn-light" type="reset">Clear</button></div>
                                                    <?php echo form_close();?>
                                                </div>
                                                <div class="tab-pane fade" id="pill-link-2">
                                                   <?php echo form_open('account/account/login');?>
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
                                                <div class="tab-pane fade" id="pill-link-3">
                                                    <p class="muted-text text-center text-warning">Neither your security code nor Master code can be changed. Your security code is automatically updated every ten minutes to avoid site compromise. Always check your last updated sequence before sending your security code to a staff.</p>
                                                    <?php echo form_open('account/account/security');?>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group mb-4"><label>Security Code</label><input class="form-control" type="text" placeholder="Enter Full Name" name="name" value="<?php echo htmlentities($organizer->SecurityCode);?>" disabled></div>
                                                                <div class="form-group mb-4"><label>Two Way</label>
                                                                    <select class="form-control" name="twoway">
                                                                            <option value="">Select Option</option>
                                                                        <?php if ($organizer->Twoway==1):?>
                                                                            <option value="1" selected="">ON</option>
                                                                            <option value="2">OFF</option>
                                                                        <?php else:?>
                                                                            <option value="1">ON</option>
                                                                            <option value="2" selected="">OFF</option>
                                                                        <?php endif;?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group mb-4"><label>Notification</label>
                                                                    <select class="form-control" name="notifyme">
                                                                            <option value="">Select Option</option>
                                                                        <?php if ($organizer->Notifyme==1):?>
                                                                            <option value="1" selected="">ON</option>
                                                                            <option value="2">OFF</option>
                                                                        <?php else:?>
                                                                            <option value="1">ON</option>
                                                                            <option value="2" selected="">OFF</option>
                                                                        <?php endif;?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                             <div class="col-md-12">
                                                                <div class="form-group mb-4"><label>Passcode</label><input class="form-control" type="password" placeholder="Enter Password Or Master Code" name="passcode"></div>
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