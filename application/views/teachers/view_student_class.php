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
                                                <th>Class</th>
                                                <th>Class Reference</th>
                                                <th class="no-sort"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $cnt=0;
                                            foreach ($students->result() as $student):
                                            $cnt++;
                                            $class=$this->Organizer_model->get_class_id($student->Class,$student->OrganizerId);
                                            ?>
                                            <tr>
                                                <td><?php echo $cnt;?></td>
                                                <td><?php echo htmlentities($class->row()->Name);?></td>
                                                <td><?php echo htmlentities($class->row()->ClassRef);?></td>
                                                <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-secondary dropdown-toggle" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                        <a class="dropdown-item" href="<?php echo base_url();?>teachers/students/view_students/<?php echo htmlentities($class->row()->ClassRef);?>">View Students</a>
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