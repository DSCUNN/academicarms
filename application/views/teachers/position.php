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
                                        <button class="btn btn-secondary" style="margin-right:4px;" data-toggle="modal" data-target="#addschooltype"><i class="ti-plus"></i> Add</button>
                                    </div>
                                    <div class="input-group-icon input-group-icon-right mr-3"><span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span><input class="form-control form-control-rounded" id="key-search" type="text" placeholder="Search ..."></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered w-100" id="dt-filter">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>School</th>
                                                <th>School Mark</th>
                                                <th class="no-sort"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $cnt=0;
                                            foreach ($positions->result() as $type):
                                            $cnt++;
                                            $sch=$this->Organizer_model->get_school_id($type->School_id,$type->OrganizerId);
                                            ?>
                                            <tr>
                                                <td><?php echo $cnt;?></td>
                                                <td><?php echo htmlentities($sch->row()->School_name);?></td>
                                                <td><?php echo htmlentities($sch->row()->School_mark);?></td>
                                                <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-secondary dropdown-toggle" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                        <a class="dropdown-item" href="<?php echo base_url();?>teachers/position/school/<?php echo htmlentities($sch->row()->School_mark);?>">View Positon</a>
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
                <div class="modal fade" id="addschooltype" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5><button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php echo form_open_multipart('teachers/position/create');?>
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
                                                    <label>Class</label>
                                                    <select class="form-control" type="text"  name="class">
                                                        <option value="">Select Class</option>

                                                    </select>
                                                </div>
                                                <div class="col-sm-12 form-group mb-4">
                                                    <label>Student</label>
                                                    <select class="form-control" type="text"  name="student">
                                                        <option value="">Select Student</option>

                                                    </select>
                                                </div>
                                                <div class="col-sm-12 form-group mb-4">
                                                    <label>Academic Session</label>
                                                    <select class="form-control" type="text"  name="aca_session">
                                                        <option value="">Select Academic Session</option>

                                                    </select>
                                                </div>
                                                <div class="col-sm-12 form-group mb-4">
                                                    <label>Semester/Term</label>
                                                    <select class="form-control" type="text"  name="term">
                                                        <option value="">Select Semester/Term</option>

                                                    </select>
                                                </div>
                                                <div class="col-sm-12 form-group mb-4">
                                                    <label>Result Type</label>
                                                    <select class="form-control" type="text"  name="result_type">
                                                        <option value="">Select Result Type</option>

                                                    </select>
                                                </div>
                                                <div class="col-sm-12 form-group mb-4">
                                                    <input class="form-control" type="text" placeholder="Position E.g First,Second,1st,2nd etc" name="name">
                                                </div>
                                                <div class="col-sm-12 form-group mb-4">
                                                    <textarea class="form-control" placeholder="Teacher's Comment" name="teacher"></textarea>
                                                </div>
                                                <div class="col-sm-12 form-group mb-4">
                                                    <textarea class="form-control" placeholder="Principal's Comment" name="principal"></textarea>
                                                </div>
                                                <div class="col-sm-12 form-group mb-4">
                                                    <textarea class="form-control" placeholder="Head Teacher's Comment" name="headteacher"></textarea>
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