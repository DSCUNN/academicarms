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
                                        <a href="<?php echo base_url();?>account/subject_combination"><button class="btn btn-secondary" style="margin-right:4px;"><i class="ti-plus"></i> Add</button></a>
                                    </div>
                                    <div class="input-group-icon input-group-icon-right mr-3"><span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span><input class="form-control form-control-rounded" id="key-search" type="text" placeholder="Search ..."></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered w-100" id="dt-filter">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Subject</th>
                                                <th>Subject Code</th>
                                                <th>Unit Load</th>
                                                <th>School</th>
                                                <th>Status</th>
                                                <th class="no-sort"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php 
                                        	$cnt=0;
                                        	foreach ($combinations->result() as $combination):
                                        	$cnt++;
                                        	$subjects=$this->db->select('*')->from('Subject')->where('Subject_id',$combination->Subject)->where('School_id',$combination->School_id)->where('OrganizerId',$combination->OrganizerId)->get();
                                            $sch=$this->Organizer_model->get_school_id($combination->School_id,$combination->OrganizerId);
                                            $subject=$subjects->row();
                                        	?>
                                            <tr>
                                                <td><?php echo $cnt;?></td>
                                                <td><?php echo htmlentities($subject->Subject_name);?></td>
                                                <td><?php echo htmlentities($subject->Subject_code);?></td>
                                                <td><?php echo htmlentities($subject->Unit_load);?></td>
                                                <td><?php echo htmlentities($sch->row()->School_name);?></td>
                                                <td>
                                                    <?php if ($subject->Status==1):?>
                                                    <span class="badge badge-success badge-pill">Active</span>
                                                    <?php else:?>
                                                    <span class="badge badge-danger badge-pill">Deactivated</span>
                                                    <?php endif;?>
                                                </td>
                                                <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-secondary dropdown-toggle" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"  data-toggle="tooltip" data-title="Editing is disabled on this system. To make changes to subjects do that from the subjects page.">
                                                        <a class="dropdown-item" data-toggle="modal" data-target="#delete_schooltype" data-value="<?php echo htmlentities($combination->Combination_id);?>">Delete</a>
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
                <div class="modal fade" id="delete_schooltype" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5><button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php echo form_open('account/subject_combination/delete_combination');?>
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