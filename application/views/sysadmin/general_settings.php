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
                                                <li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#pill1-1">Basic</a></li>
                                                <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#pill1-2">Security & Others</a></li>
                                                <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#pill1-3">Logo</a></li>
                                            </ul>
                                            <div class="tab-content mt-4">
                                                <div class="tab-pane fade show active" id="pill1-1">
                                                    <?php echo form_open('sysadmin/general_settings/basic');?>
                                                        <div class="row">
                                                            <div class="col-sm-6 form-group mb-4">
                                                                <label>Site Name</label>
                                                                <input class="form-control input-lg" type="text" placeholder="Site Name" name="site_name" value="<?php echo htmlentities($general_settings->row()->Site_name);?>">
                                                            </div>
                                                            <div class="col-sm-6 form-group mb-4">
                                                                <label>Site Email</label>
                                                                <input class="form-control input-lg" type="text" placeholder="Site Email" name="site_email" value="<?php echo htmlentities($general_settings->row()->Site_email);?>">
                                                            </div>
                                                             <div class="col-sm-6 form-group mb-4">
                                                                <label>Site Description</label>
                                                                <textarea class="form-control input-lg" type="text" placeholder="Site Description" name="site_description"><?php echo htmlentities($general_settings->row()->Site_description);?></textarea>
                                                            </div>
                                                             <div class="col-sm-6 form-group mb-4">
                                                                <label>Site Tag</label>
                                                                <textarea class="form-control input-lg" type="text" placeholder="Site Tag" name="site_tag"><?php echo htmlentities($general_settings->row()->Site_tag);?></textarea>
                                                            </div>
                                                             <div class="col-sm-6 form-group mb-4">
                                                                <label>Site Support Email</label>
                                                                <input class="form-control input-lg" type="text" placeholder="Site Support Email" name="site_supportemail" value="<?php echo htmlentities($general_settings->row()->Site_supportemail);?>">
                                                            </div>
                                                             <div class="col-sm-6 form-group mb-4">
                                                                <label>Site Shortname</label>
                                                                <input class="form-control input-lg" type="text" placeholder="Site Shortname" name="site_shortname" value="<?php echo htmlentities($general_settings->row()->Site_shortname);?>">
                                                            </div>
                                                             <div class="col-sm-6 form-group mb-4">
                                                                <label>Footer About</label>
                                                                <textarea class="form-control input-lg" type="text" placeholder="Footer About" name="footer_about" id="summernote"><?php echo htmlentities($general_settings->row()->Footer_about);?></textarea>
                                                            </div>
                                                            <div class="col-sm-6 form-group mb-4">
                                                                <label>Footer Text</label>
                                                                <textarea class="form-control input-lg" type="text" placeholder="Copyright Text" name="footer_text" id="summernote1"><?php echo htmlentities($general_settings->row()->footer_text);?></textarea>
                                                            </div>
                                                            <div class="col-sm-6 form-group mb-4">
                                                                <label>Site Address</label>
                                                                <input class="form-control input-lg" type="text" placeholder="Site Address" name="site_address" value="<?php echo htmlentities($general_settings->row()->Site_address);?>">
                                                            </div>
                                                            <div class="col-sm-6 form-group mb-4">
                                                                <label>Site Country</label>
                                                                <input class="form-control input-lg" type="text" placeholder="Site Country" name="site_country" value="<?php echo htmlentities($general_settings->row()->Site_country);?>">
                                                            </div>
                                                            <div class="col-sm-6 form-group mb-4">
                                                                <label>Site State</label>
                                                                <input class="form-control input-lg" type="text" placeholder="Site State" name="site_state" value="<?php echo htmlentities($general_settings->row()->Site_state);?>">
                                                            </div>
                                                            <div class="col-sm-6 form-group mb-4">
                                                                <label>Site Phone</label>
                                                                <input class="form-control input-lg" type="text" placeholder="Site Phone" name="site_phone" value="<?php echo htmlentities($general_settings->row()->Site_phone);?>">
                                                            </div>
                                                            <div class="col-sm-6 form-group mb-4">
                                                                <label>Site Currency</label>
                                                                <input class="form-control input-lg" type="text" placeholder="Site Currency" name="currency" value="<?php echo htmlentities($general_settings->row()->Currency);?>">
                                                            </div>
                                                            <div class="col-sm-6 form-group mb-4">
                                                                <label>Site Currency Sign</label>
                                                                <input class="form-control input-lg" type="text" placeholder="Site Currency Sign" name="currency_sign" value="<?php echo htmlentities($general_settings->row()->Currency_sign);?>">
                                                            </div>
                                                            <div class="col-sm-6 form-group mb-4">
                                                                <label>Site Maintenance</label>
                                                                <div>
                                                                    <?php
                                                                    if ($general_settings->row()->Maintenance==1):?>
                                                                        <label class="radio radio-inline radio-primary">
                                                                            <input type="radio" name="site_maintenance"  value="1" checked=""><span>ON</span>
                                                                        </label>
                                                                        <label class="radio radio-inline radio-primary">
                                                                            <input type="radio" name="site_maintenance" value="2" ><span>OFF</span>
                                                                        </label>
                                                                    <?php else:?>
                                                                        <label class="radio radio-inline radio-primary">
                                                                            <input type="radio" name="site_maintenance"  value="1"><span>ON</span>
                                                                        </label>
                                                                        <label class="radio radio-inline radio-primary">
                                                                            <input type="radio" name="site_maintenance" value="2" checked=""><span>OFF</span>
                                                                        </label>
                                                                    <?php endif;?>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 form-group mb-4">
                                                                <label>Site Notification</label>
                                                                <div>
                                                                    <?php
                                                                    if ($general_settings->row()->Site_notification==1):?>
                                                                        <label class="radio radio-inline radio-primary">
                                                                            <input type="radio" name="site_notification" checked="" value="1"><span>ON</span>
                                                                        </label>
                                                                        <label class="radio radio-inline radio-primary">
                                                                            <input type="radio" name="site_notification" value="2"><span>OFF</span>
                                                                        </label>
                                                                    <?php else:?>
                                                                        <label class="radio radio-inline radio-primary">
                                                                            <input type="radio" name="site_notification" value="1"><span>ON</span>
                                                                        </label>
                                                                        <label class="radio radio-inline radio-primary">
                                                                            <input type="radio" name="site_notification" value="2" checked=""><span>OFF</span>
                                                                        </label>
                                                                    <?php endif;?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group"><button class="btn btn-primary mr-2" type="submit">Submit</button><button class="btn btn-light" type="reset">Clear</button></div>
                                                    <?php echo form_close();?>
                                                </div>
                                                <div class="tab-pane fade" id="pill1-2">
                                                    <?php echo form_open('sysadmin/general_settings/security_others');?>
                                                        <div class="row">
                                                             <div class="col-sm-6 form-group mb-4">
                                                                <label>Two Factor Authentication</label>
                                                                <div>
                                                                    <?php
                                                                    if ($general_settings->row()->Site_twoway==1):?>
                                                                        <label class="radio radio-inline radio-primary">
                                                                            <input type="radio" name="twoway"  value="1" checked=""><span>ON</span>
                                                                        </label>
                                                                        <label class="radio radio-inline radio-primary">
                                                                            <input type="radio" name="twoway" value="2" ><span>OFF</span>
                                                                        </label>
                                                                    <?php else:?>
                                                                        <label class="radio radio-inline radio-primary">
                                                                            <input type="radio" name="twoway"  value="1"><span>ON</span>
                                                                        </label>
                                                                        <label class="radio radio-inline radio-primary">
                                                                            <input type="radio" name="twoway" value="2" checked=""><span>OFF</span>
                                                                        </label>
                                                                    <?php endif;?>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 form-group mb-4">
                                                                <label>Email Verification</label>
                                                                <div>
                                                                    <?php
                                                                    if ($general_settings->row()->Email_verification==1):?>
                                                                        <label class="radio radio-inline radio-primary">
                                                                            <input type="radio" name="email_verification"  value="2"><span>ON</span>
                                                                        </label>
                                                                        <label class="radio radio-inline radio-primary">
                                                                            <input type="radio" name="email_verification" value="1" checked=""><span>OFF</span>
                                                                        </label>
                                                                    <?php else:?>
                                                                        <label class="radio radio-inline radio-primary">
                                                                            <input type="radio" name="email_verification" value="2" checked=""><span>ON</span>
                                                                        </label>
                                                                        <label class="radio radio-inline radio-primary">
                                                                            <input type="radio" name="email_verification" value="1" ><span>OFF</span>
                                                                        </label>
                                                                    <?php endif;?>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 form-group mb-4">
                                                                <label>Site Registration</label>
                                                                <div>
                                                                    <?php
                                                                    if ($general_settings->row()->Site_registration==1):?>
                                                                        <label class="radio radio-inline radio-primary">
                                                                            <input type="radio" name="registration"  value="1" checked=""><span>ON</span>
                                                                        </label>
                                                                        <label class="radio radio-inline radio-primary">
                                                                            <input type="radio" name="registration" value="2" ><span>OFF</span>
                                                                        </label>
                                                                    <?php else:?>
                                                                        <label class="radio radio-inline radio-primary">
                                                                            <input type="radio" name="registration"  value="1"><span>ON</span>
                                                                        </label>
                                                                        <label class="radio radio-inline radio-primary">
                                                                            <input type="radio" name="registration" value="2" checked=""><span>OFF</span>
                                                                        </label>
                                                                    <?php endif;?>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 form-group mb-4">
                                                                <label>Allow Newsletter</label>
                                                                <div>
                                                                    <?php
                                                                    if ($general_settings->row()->Allow_newsletter==1):?>
                                                                        <label class="radio radio-inline radio-primary">
                                                                            <input type="radio" name="newsletter"  value="1" checked=""><span>ON</span>
                                                                        </label>
                                                                        <label class="radio radio-inline radio-primary">
                                                                            <input type="radio" name="newsletter" value="2" ><span>OFF</span>
                                                                        </label>
                                                                    <?php else:?>
                                                                        <label class="radio radio-inline radio-primary">
                                                                            <input type="radio" name="newsletter"  value="1"><span>ON</span>
                                                                        </label>
                                                                        <label class="radio radio-inline radio-primary">
                                                                            <input type="radio" name="newsletter" value="2" checked=""><span>OFF</span>
                                                                        </label>
                                                                    <?php endif;?>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 form-group mb-4">
                                                                <label>Mastercode Length</label>
                                                                <input class="form-control input-lg" type="text" placeholder="Mastercode Length" name="mastercode" value="<?php echo htmlentities($general_settings->row()->Mastercode_length);?>">
                                                            </div>
                                                            <div class="col-sm-6 form-group mb-4">
                                                                <label>Securitycode Length</label>
                                                                <input class="form-control input-lg" type="text" placeholder="Security Length" name="securitycode" value="<?php echo htmlentities($general_settings->row()->Securitycode_length);?>">
                                                            </div>
                                                            <div class="col-sm-6 form-group mb-4">
                                                                <label>Result pin Length</label>
                                                                <input class="form-control input-lg" type="text" placeholder="Result pin Length" name="resultpin" value="<?php echo htmlentities($general_settings->row()->Resultpin_length);?>">
                                                            </div>
                                                            <div class="col-sm-6 form-group mb-4">
                                                                <label>Serial Pin Length</label>
                                                                <input class="form-control input-lg" type="text" placeholder="Serial Pin Length" name="serialpin" value="<?php echo htmlentities($general_settings->row()->Serialpin_length);?>">
                                                            </div>
                                                            <div class="col-sm-6 form-group mb-4">
                                                                <label>Pin Usage</label>
                                                                <input class="form-control input-lg" type="text" placeholder="Pin Usage" name="pin_usage" value="<?php echo htmlentities($general_settings->row()->Pin_usage);?>">
                                                            </div>
                                                            <div class="col-sm-6 form-group mb-4">
                                                                <label>Result System</label>
                                                                <div class="input-group-icon input-group-icon-left"><span class="input-icon input-icon-left"><i class="ti-lock"></i></span>
                                                                        <select class="form-control" name="result_type">
                                                                            <option value="">Select Option</option>
                                                                        <?php if ($general_settings->row()->Result_type==1):?>
                                                                            <option value="1" selected="">POSITION SYSTEM</option>
                                                                            <option value="2">GRADE POINT SYSTEM</option>
                                                                        <?php else:?>
                                                                            <option value="1">POSITION SYSTEM</option>
                                                                            <option value="2" selected="">GRADE POINT SYSTEM</option>
                                                                        <?php endif;?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div  class="col-sm-6 form-group mb-4">
                                                                <label>Allow Teachers Add Students</label>
                                                                <div class="input-group-icon input-group-icon-left"><span class="input-icon input-icon-left"><i class="ti-lock"></i></span>
                                                                    <select class="form-control" name="addstudents">
                                                                            <option value="">Select Option</option>
                                                                        <?php if ($general_settings->row()->Teacher_add_students==1):?>
                                                                            <option value="1" selected="">YES</option>
                                                                            <option value="2">NO</option>
                                                                        <?php else:?>
                                                                            <option value="1">YES</option>
                                                                            <option value="2" selected="">NO</option>
                                                                        <?php endif;?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-4 col-sm-6">
                                                                <label>Allow Teachers Add Result</label>
                                                                <div class="input-group-icon input-group-icon-left"><span class="input-icon input-icon-left"><i class="ti-lock"></i></span>
                                                                    <select class="form-control" name="addresults">
                                                                            <option value="">Select Option</option>
                                                                        <?php if ($general_settings->row()->Teacher_add_result==1):?>
                                                                            <option value="1" selected="">YES</option>
                                                                            <option value="2">NO</option>
                                                                        <?php else:?>
                                                                            <option value="1">YES</option>
                                                                            <option value="2" selected="">NO</option>
                                                                        <?php endif;?>
                                                                    </select>
                                                                </div>
                                                            </div> 
                                                            <div class="form-group mb-4 col-sm-6">
                                                                <label>Show Testmonials</label>
                                                                <div class="input-group-icon input-group-icon-left"><span class="input-icon input-icon-left"><i class="ti-lock"></i></span>
                                                                    <select class="form-control" name="testmonials">
                                                                            <option value="">Select Option</option>
                                                                        <?php if ($general_settings->row()->show_testmonials==1):?>
                                                                            <option value="1" selected="">YES</option>
                                                                            <option value="2">NO</option>
                                                                        <?php else:?>
                                                                            <option value="1">YES</option>
                                                                            <option value="2" selected="">NO</option>
                                                                        <?php endif;?>
                                                                    </select>
                                                                </div>
                                                            </div> 
                                                            <div class="col-sm-6 form-group mb-4">
                                                                <label>Newsletter Link</label>
                                                                <input class="form-control input-lg" type="text" placeholder="Newsletter Link" name="newsletter_link" value="<?php echo ($general_settings->row()->Link);?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group"><button class="btn btn-primary mr-2" type="submit">Submit</button><button class="btn btn-light" type="reset">Clear</button></div>
                                                    <?php echo form_close();?>
                                                </div>
                                                <div class="tab-pane fade" id="pill1-3">
                                                   <?php echo form_open_multipart('sysadmin/general_settings/logo');?>
                                                            <div class="col-sm-12 form-group mb-4">
                                                                <input class="form-control input-lg" type="file" name="photo">
                                                            </div>
                                                            <div class="form-group"><button class="btn btn-primary mr-2" type="submit">Submit</button><button class="btn btn-light" type="reset">Clear</button></div>
                                                    <?php echo form_close();?>
                                                </div>
                                                <div class="tab-pane fade" id="pill1-4">disabled content</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- END: Page content-->
                </div>