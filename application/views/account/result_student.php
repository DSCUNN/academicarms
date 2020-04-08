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
                                        <a href="<?php echo base_url();?>account/results"><button class="btn btn-secondary" style="margin-right:4px;"><i class="ti-plus"></i> Add</button></a>
                                         <button class="btn btn-danger" style="margin-right:4px;" data-toggle="modal" data-target="#delete_schooltype" data-value="<?php echo htmlentities($results->row()->Student);?>" data-session="<?php echo htmlentities($results->row()->Session);?>" data-term="<?php echo htmlentities($results->row()->Semester);?>"><i class="ti-trash"></i> Delete</button>
                                    </div>
                                    <div class="input-group-icon input-group-icon-right mr-3"><span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span><input class="form-control form-control-rounded" id="key-search" type="text" placeholder="Search ..."></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered w-100" id="dt-filter">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Student</th>
                                                <th>Reg.No/Username</th>
                                                <th>Class</th>
                                                <th>Class Reference</th>
                                                <th>School</th>
                                                <th>Session</th>
                                                <th>Semester/Term</th>
                                                <th>Subject</th>
                                                <th>Subject Code</th>
                                                <th>Exam Score</th>
                                                <th>Test Score</th>
                                                <th>Total Score</th>
                                                <th>Grade</th>
                                                <th>Unit Load</th>
                                                <th>Grade Point</th>
                                                <th>Total Point</th>
                                                <th>Status</th>
                                                <th class="no-sort"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php 
                                        	$cnt=0;
                                        	foreach ($results->result() as $result):
                                                $result_num=$this->db->select('*')->from('Result')->where('OrganizerId',$result->OrganizerId)->where('Semester',$result->Semester)->where('Session',$result->Session)->where('Class',$result->Class)->where('School_id',$result->School_id)->get()->num_rows();
                                                $student=$this->Organizer_model->get_student_id($result->Student,$result->OrganizerId);
                                                $sub=$this->Organizer_model->get_subject_id($result->Subject,$result->OrganizerId);
                                                $class=$this->Organizer_model->get_class_id($result->Class,$result->OrganizerId);
                                                $schooln=$this->Organizer_model->get_School_id($result->School_id,$result->OrganizerId);
                                                $semes=$this->Organizer_model->get_semester_id($result->Semester,$result->OrganizerId);
                                                $sess=$this->Organizer_model->get_session_id($result->Session,$result->OrganizerId);
                                        	$cnt++;
                                        	?>
                                            <tr>
                                                <td><?php echo $cnt;?></td>
                                                <td><?php echo htmlentities($student->row()->Name);?></td>
                                                <td><?php echo htmlentities($student->row()->Reg_no);?></td>
                                                <td><?php echo htmlentities($class->row()->Name);?></td>
                                                <td><?php echo htmlentities($class->row()->ClassRef);?></td>
                                                <td><?php echo htmlentities($schooln->row()->School_name);?></td>
                                                <td><?php echo htmlentities($sess->row()->Name);?></td>
                                                <td><?php echo htmlentities($semes->row()->Name);?></td>
                                                <td><?php echo htmlentities($sub->row()->Subject_name);?></td>
                                                <td><?php echo htmlentities($sub->row()->Subject_code);?></td>
                                                <td><?php echo htmlentities($result->Exam_score);?></td>
                                                <td><?php echo htmlentities($result->Test_score);?></td>
                                                <td><?php echo htmlentities($result->Total_score);?></td>
                                                <td><?php echo htmlentities($result->Grade);?></td>
                                                <td><?php echo htmlentities($result->Unit_load);?></td>
                                                <td><?php echo htmlentities($result->Gradepoint);?></td>
                                                <td><?php echo htmlentities(($result->Unit_load)*($result->Gradepoint));?></td>
                                                <td>
                                                    <?php 
                                                    if ($result->Status==1):?>
                                                        <span class="badge badge-success badge-pill">Published</span>
                                                    <?php else:?>
                                                        <span class="badge badge-danger badge-pill">Unpublished</span>
                                                    <?php endif;?>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button class="btn btn-secondary dropdown-toggle" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                            <a class="dropdown-item" data-toggle="modal" data-target="#edit_schooltype" data-value="<?php echo htmlentities($result->Result_id);?>">Edit Record</a>
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
                                        <h5 class="modal-title" id="edit_schooltype">Modal title</h5><button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php echo form_open_multipart('account/results/edit_result');?>
                                            <div class="row" id="form">
                                                <div class="col-sm-12 form-group mb-4" style="display: none;">
                                                    <input class="form-control" type="text" placeholder="school" name="school" value="<?php echo htmlentities($schooln->row()->School_mark);?>">
                                                </div>
                                                <div class="col-sm-12 form-group mb-4" style="display: none;">
                                                    <input class="form-control" type="text" placeholder="result id" name="id">
                                                </div>
                                                <div class="col-sm-12 form-group mb-4">
                                                    <input class="form-control" type="text" placeholder="Subject" name="name" >
                                                </div>
                                                <div class="col-sm-12 form-group mb-4">
                                                    <input class="form-control" type="text" placeholder="Exam Score" name="exam">
                                                </div>
                                                <div class="col-sm-12 form-group mb-4">
                                                    <input class="form-control" type="text" placeholder="Test Score" name="test">
                                                </div>
                                            </div>
                                            <div class="row" id="form">
                                                <div class="col-sm-12 form-group mb-4">
                                                    <select class="form-control" type="text" placeholder="Type" name="status">
                                                        <option>Select Status</option>
                                                        <option value="1" selected="">Published</option>
                                                        <option value="2">Unpublished</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-primary mr-2" type="submit">Submit</button>
                                                <button class="btn btn-light" type="reset">Clear</button>
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
                                        <h5 class="modal-title" id="exampleModalLabel">Delete</h5><button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php echo form_open('account/result/delete_result');?>
                                            <div class="row" style="display: none;">
                                                 <div class="col-sm-12 form-group mb-4"><label>Id</label><input class="form-control" type="text"  name="id">
                                                 </div>
                                            </div>
                                            <div class="row" style="display: none;">
                                                 <div class="col-sm-12 form-group mb-4"><label>term</label><input class="form-control" type="text"  name="term">
                                                 </div>
                                            </div>
                                            <div class="row" style="display: none;">
                                                 <div class="col-sm-12 form-group mb-4"><label>session</label><input class="form-control" type="text"  name="session">
                                                 </div>
                                            </div>
                                            <p class="text-danger" style="font-size:20px;">Do you really want to delete Every Data, it cannot be undone?</p>
                                            <div class="modal-footer"><button class="btn btn-secondary" type="submit">Yes</button><button class="btn btn-danger" type="button" data-dismiss="modal">No</button></div>
                                        <?php echo form_close();?>
                                    </div>
                                </div>
                            </div>
                        </div>