<div class="page-content fade-in-up">
                    <!-- BEGIN: Page heading-->
                    <div class="page-heading">
                        <div class="page-breadcrumb">
                            <h1 class="page-title page-title-sep"><?php echo $Page_name;?></h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url();?>account/schools"><i class="ti-home font-20"></i></a></li>
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
                                            <div class="tab-content mt-4">
                                                <div class="tab-pane fade show active" id="pill-link-1">
                                                    <?php echo form_open('account/schools/settings');?>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-4"><label>School Name</label><input class="form-control" type="text" placeholder="Enter Full Name" name="name" value="<?php echo htmlentities($school->School_name);?>" disabled></div>
                                                                <div class="form-group mb-4"><label>Result Pin Length</label><input class="form-control" type="text"  name="resultpin" value="<?php echo htmlentities($school->Resultpin_length);?>"></div>
                                                                <div class="form-group mb-4"><label>Serial Pin Length</label><input class="form-control" type="text"  name="serialpin" value="<?php echo htmlentities($school->Serialpin_length);?>"></div>
                                                                <div class="form-group mb-4"><label>Pin Usage</label><input class="form-control" type="text"  name="usage" value="<?php echo htmlentities($school->Pin_usage);?>"></div>
                                                                <div class="form-group mb-4"><label>Default Password</label><input class="form-control" disabled="" type="text" value="<?php echo htmlentities($general_settings->row()->Default_password);?>"></div>
                                                                 <div class="form-group mb-4"><label>Round CGPA off to(Decimal Place)</label><input class="form-control"  type="number" value="<?php echo htmlentities($school->Round_to);?>" name="round_to"></div>
                                                                <div class="form-group mb-4"><label>School Email</label>
                                                                    <div class="input-group-icon input-group-icon-left"><span class="input-icon input-icon-left"><i class="ti-envelope font-16"></i></span><input class="form-control" type="email" placeholder="Enter Email" name="email" value="<?php echo htmlentities($school->Email);?>"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-4"><label>School Id</label>
                                                                    <div class="input-group-icon input-group-icon-left"><span class="input-icon input-icon-left"><i class="ti-location-pin font-16"></i></span><input class="form-control" readonly="" type="text" placeholder="Enter Country" name="id" value="<?php echo htmlentities($school->School_mark);?>"></div>
                                                                </div>
                                                                <div class="form-group mb-4"><label>Allow Teachers Add Result</label>
                                                                    <div class="input-group-icon input-group-icon-left"><span class="input-icon input-icon-left"><i class="ti-lock"></i></span>
                                                                         <select class="form-control" name="addresults">
                                                                            <option value="">Select Option</option>
                                                                        <?php if ($school->Teacher_add_result==1):?>
                                                                            <option value="1" selected="">YES</option>
                                                                            <option value="2">NO</option>
                                                                        <?php else:?>
                                                                            <option value="1">YES</option>
                                                                            <option value="2" selected="">NO</option>
                                                                        <?php endif;?>
                                                                    </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group mb-4"><label>Allow Teachers Add Students</label>
                                                                    <div class="input-group-icon input-group-icon-left"><span class="input-icon input-icon-left"><i class="ti-lock"></i></span>
                                                                         <select class="form-control" name="addstudents">
                                                                            <option value="">Select Option</option>
                                                                        <?php if ($school->Teacher_add_students==1):?>
                                                                            <option value="1" selected="">YES</option>
                                                                            <option value="2">NO</option>
                                                                        <?php else:?>
                                                                            <option value="1">YES</option>
                                                                            <option value="2" selected="">NO</option>
                                                                        <?php endif;?>
                                                                    </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group mb-4"><label>Result System</label>
                                                                    <div class="input-group-icon input-group-icon-left"><span class="input-icon input-icon-left"><i class="ti-lock"></i></span>
                                                                         <select class="form-control" name="result_type">
                                                                            <option value="">Select Option</option>
                                                                        <?php if ($school->Result_type==1):?>
                                                                            <option value="1" selected="">POSITION SYSTEM</option>
                                                                            <option value="2">GRADE POINT SYSTEM</option>
                                                                        <?php else:?>
                                                                            <option value="1">POSITION SYSTEM</option>
                                                                            <option value="2" selected="">GRADE POINT SYSTEM</option>
                                                                        <?php endif;?>
                                                                    </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group mb-4"><label>School Phone</label>
                                                                    <div class="input-group-icon input-group-icon-left"><span class="input-icon input-icon-left"><i class="ti-telephone font-16"></i></span><input class="form-control" type="text" placeholder="Enter Phone" name="phone" value="<?php echo htmlentities($school->Phone);?>"></div>
                                                                </div>
                                                                <div class="form-group mb-4">
                                                                    <label>School Address</label>
                                                                    <div class="input-group-icon input-group-icon-left"><span class="input-icon input-icon-left"><i class="ti-location-pin font-16"></i></span><textarea class="form-control" placeholder="Enter Address" name="address"><?php echo htmlentities($school->Address);?></textarea></div>
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