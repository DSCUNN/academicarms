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
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body text-center"><span class="position-relative d-inline-block my-4"><img class="rounded-circle" src="<?php echo base_url();?>/assets/dashboard/assets/img/users/admin-image.png" alt="image" width="120" /><span class="badge-point badge-success avatar-badge" style="bottom: 5px;right: 14px;height: 14px;width: 14px;"></span></span>
                                        <div class="h4"><?php echo htmlentities($organizer->Name);?></div>
                                        <div class="text-muted mb-4"><?php echo htmlentities($organizer->Position);?></div>
                                        <p class="text-muted"><?php echo htmlentities($organizer->About);?></p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-4">
                                            <h5 class="box-title mb-0">Information</h5><a href="#" data-toggle="modal" data-target="#accesspage"><i class="ti-pencil"></i> Edit</a>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6 text-muted">Name:</div>
                                            <div class="col-6"><?php echo htmlentities($organizer->Name);?></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6 text-muted">Email:</div>
                                            <div class="col-6"><?php echo htmlentities($organizer->Email);?></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6 text-muted">Username:</div>
                                            <div class="col-6"><?php echo htmlentities($organizer->Username);?></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6 text-muted">Position:</div>
                                            <div class="col-6"><?php echo htmlentities($organizer->Position);?></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6 text-muted">City:</div>
                                            <div class="col-6"><?php echo htmlentities($organizer->City);?></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6 text-muted">State:</div>
                                            <div class="col-6"><?php echo htmlentities($organizer->State);?></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6 text-muted">Zip Code:</div>
                                            <div class="col-6"><?php echo htmlentities($organizer->Zip);?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="flexbox mb-5">
                                            <h5 class="box-title mb-0">Schools</h5><button class="btn btn-primary btn-sm btn-rounded" data-toggle="modal" data-target="#accesspage">Access User Page</button>
                                        </div>
                                        <div class="row">
                                            <div class="table-responsive">
                                                <table class="table table-bordered w-100" id="dt-filter">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <tr>
                                                            <th>#</th>
                                                            <th>School Name</th>
                                                            <th>School Mark</th>
                                                            <th>School Description</th>
                                                            <th>Status</th>
                                                            <th>School Type</th>
                                                            <th>School Url</th>
                                                            <th>School Logo</th>
                                                            <th>Date</th>
                                                        </tr>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        $cnt=0;
                                                        foreach ($schools->result() as $school):
                                                        $cnt++;
                                                        $school_type=$this->Organizer_model->get_schooltype_id($school->School_type,$school->OrganizerId);
                                                        $school_type=$school_type->row();
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $cnt;?></td>
                                                            <td><?php echo htmlentities($school->School_name);?></td>
                                                            <td><?php echo htmlentities($school->School_mark);?></td>
                                                            <td><?php echo htmlentities($school->School_description);?></td>
                                                            <td>
                                                                <?php if ($school->School_status==1):?>
                                                                <span class="badge badge-success badge-pill">Active</span>
                                                                <?php else:?>
                                                                <span class="badge badge-danger badge-pill">Deactivated</span>
                                                                <?php endif;?>
                                                            </td>
                                                            <td><span class="badge badge-primary"><?php echo htmlentities($school_type->School_type_name);?></span></td>
                                                            <td><a href="<?php echo base_url();?>schools/<?php echo htmlentities($school->School_url);?>" target="_blank"><span class="badge badge-info"><?php echo base_url();?>schools/<?php echo htmlentities($school->School_url);?></span></a></td>
                                                            <td><img src="<?php echo base_url();?>assets/dashboard/logo/schools/<?php echo htmlentities($school->School_logo);?>" style="width:100px;height:50px;"></td>
                                                            <td><?php echo date('d-m-Y h:i:s a',$school->Date_created);?></td>
                                                        </tr>
                                                        <?php endforeach;?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- END: Page content-->
                </div>


                <!--////////////////////////////////////////////////////////////////////////////-->
                <div class="modal fade" id="accesspage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Access User Page</h5><button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php echo form_open('sysadmin/organizers/access_user');?>
                                            <div class="row" style="display: none;">
                                                 <div class="col-sm-12 form-group mb-4"><label>Id</label><input class="form-control" type="text"  name="id" value="<?php echo htmlentities($organizer->OrganizerId);?>">
                                                 </div>
                                            </div>
                                            <div class="row">
                                                 <div class="col-sm-12 form-group mb-4"><label>Security Code</label><input class="form-control" type="password"  name="passcode">
                                                 </div>
                                            </div>
                                            <div class="modal-footer"><button class="btn btn-secondary" type="submit">Proceed</button><button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button></div>
                                        <?php echo form_close();?>
                                    </div>
                                </div>
                            </div>
                        </div>