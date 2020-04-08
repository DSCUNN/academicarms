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
                                <h5 class="box-title"><?php echo $Page_name;?></h5>
                                <!--SHOWING MESSAGE{SUCCESS OR FAILURE}-->
                                    <?php if ($this->session->flashdata('message') != null) {  ?>
                                      <?php echo $this->session->flashdata('message'); ?>              
                                    <?php } ?>
                                    <!--//SHOWING MESSAGE{SUCCESS OR FAILURE}-->    
                                <div class="flexbox mb-4">
                                    <div class="flexbox">
                                       <?php
                                        if ($school_exists->Teacher_add_students==1):?>
                                        <a href="<?php echo base_url();?>teachers/students"><button class="btn btn-secondary" style="margin-right:4px;" data-toggle="modal" data-target="#addschooltype"><i class="ti-plus"></i> Add</button></a>
                                        <?php endif;?>
                                    </div>
                                    <div class="input-group-icon input-group-icon-right mr-3"><span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span><input class="form-control form-control-rounded" id="key-search" type="text" placeholder="Search ..."></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered w-100" id="dt-filter">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Registration Number</th>
                                                <th>Class</th>
                                                <th>School</th>
                                                <th>Status</th>
                                                <th class="no-sort"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php 
                                        	$cnt=0;
                                        	foreach ($students->result() as $student):
                                        	$cnt++;
                                        	$class=$this->db->select('*')->from('Classes')->where('Class_id',$student->Class)->where('School',$student->School_id)->where('OrganizerId',$student->OrganizerId)->get();
                                            $sch=$this->Organizer_model->get_school_id($student->School_id,$student->OrganizerId);
                                            $class=$class->row();
                                        	?>
                                            <tr>
                                                <td><?php echo $cnt;?></td>
                                                <td><?php echo htmlentities($student->Name);?></td>
                                                <td><?php echo htmlentities($student->Reg_no);?></td>
                                                <td><?php echo htmlentities($class->Name);?></td>
                                                <td><?php echo htmlentities($sch->row()->School_name);?></td>
                                                <td>
                                                    <?php if ($student->Status==1):?>
                                                    <span class="badge badge-success badge-pill">Active</span>
                                                    <?php else:?>
                                                    <span class="badge badge-danger badge-pill">Deactivated</span>
                                                    <?php endif;?>
                                                </td>
                                                <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-secondary dropdown-toggle" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                        <a class="dropdown-item" data-toggle="modal" data-target="#edit_schooltype" data-value="<?php echo htmlentities($student->Student_id);?>">Edit</a>
                                                        <a class="dropdown-item" data-toggle="modal" data-target="#delete_schooltype" data-value="<?php echo htmlentities($student->Student_id);?>">Delete</a>
                                                    </div>
                                                </div>
                                                </td>
                                            </tr>
                                        	<?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><!-- END: Page content-->
                </div>
                <!--////////////////////////////////////////////////////////////////////////////-->
                <div class="modal fade" id="edit_schooltype" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5><button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php echo form_open_multipart('teachers/students/edit_student');?>
                                            <div class="row" id="form">
                                                <div class="col-sm-12 form-group mb-4">
                                                    <label>School</label>
                                                    <select class="form-control" type="text"  name="school">
                                                        <option value="">Select School</option>
                                                        <?php 
                                                        foreach ($schools->result() as $school):?>
                                                        <option value="<?php echo htmlentities($school->School_id);?>"><?php echo htmlentities($school->School_name);?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-12 form-group mb-4">
                                                    <select class="form-control" type="text"  name="class">
                                                        <option value="">Select Class</option>

                                                    </select>
                                                </div>
                                                <div class="col-sm-12 form-group mb-4">
                                                    <input class="form-control" type="text" placeholder="Student Name" name="name">
                                                </div>
                                                <div class="col-sm-12 form-group mb-4">
                                                    <input class="form-control" type="text" placeholder="Reg Number" name="username">
                                                </div>
                                                <div class="col-sm-12 form-group mb-4" style="display: none;">
                                                    <input class="form-control" type="text" placeholder="Student Id" name="id">
                                                </div>
                                                <div class="col-sm-12 form-group mb-4">
                                                    <select class="form-control" type="text" placeholder="Type" name="status">
                                                        <option>Select Status</option>
                                                        <option value="1" selected="">Active</option>
                                                        <option value="2">Deactivated</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-primary mr-2" type="submit">Submit</button>
                                                <button class="btn btn-danger" type="reset" data-dismiss="modal">Cancel</button>
                                            </div>
                                        <?php echo form_close();?>
                                    </div>
                                </div>
                            </div>
                        </div>
                <!--////////////////////////////////////////////////////////////////////////////-->
                <div class="modal fade" id="delete_schooltype" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5><button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php echo form_open('teachers/students/delete_student');?>
                                            <div class="row" style="display: none;">
                                                 <div class="col-sm-12 form-group mb-4"><label>Id</label><input class="form-control" type="text"  name="id">
                                                 </div>
                                            </div>
                                            <p class="text-danger" style="font-size:20px;">Do you really want to delete this data, it cannot be undone?</p>
                                            <div class="modal-footer"><button class="btn btn-secondary" type="submit">Yes</button><button class="btn btn-danger" type="button" data-dismiss="modal">No</button></div>
                                        <?php echo form_close();?>
                                    </div>
                                </div>
                            </div>
                        </div>