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
                                                <th>Number Of Results</th>
                                                <th class="no-sort"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php 
                                        	$cnt=0;
                                        	foreach ($results->result() as $result):
                                                $result_num=$this->db->select('*')->from('Result')->where('OrganizerId',$result->OrganizerId)->where('Semester',$result->Semester)->where('Session',$result->Session)->where('Class',$result->Class)->where('School_id',$result->School_id)->get()->num_rows();
                                                $student=$this->Organizer_model->get_student_id($result->Student,$result->OrganizerId);
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
                                                <td><?php echo htmlentities($result_num);?></td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button class="btn btn-secondary dropdown-toggle" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                            <a class="dropdown-item" href="<?php echo base_url();?>account/results/student/<?php echo htmlentities($schools->row()->School_mark);?>/<?php echo htmlentities($result->Session);?>/<?php echo htmlentities($result->Semester);?>/<?php echo htmlentities($result->Class);?>/<?php echo htmlentities($result->Student);?>">View Results</a>
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