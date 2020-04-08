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
                                        <button class="btn btn-danger" style="margin-right:4px;" data-toggle="modal" data-target="#deleteall"><i class="ti-trash"></i> Delete All</button>
                                    </div>
                                    <div class="input-group-icon input-group-icon-right mr-3"><span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span><input class="form-control form-control-rounded" id="key-search" type="text" placeholder="Search ..."></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered w-100" id="dt-filter">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>School Type</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th class="no-sort"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $cnt=0;
                                        foreach ($school_types->result() as $school_type):
                                        $cnt++;
                                        ?>
                                            <tr>
                                                <td><?php echo $cnt;?></td>
                                                <td><?php echo htmlentities($school_type->School_type_name);?></td>
                                                <td>
                                                    <?php if ($school_type->Status==1):?>
                                                    <span class="badge badge-success badge-pill">Active</span>
                                                    <?php else:?>
                                                    <span class="badge badge-danger badge-pill">Deactivated</span>
                                                    <?php endif;?>
                                                </td>
                                                <td><?php echo date('d-m-Y h:i:s a',$school_type->Date_created);?></td>
                                                <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-secondary dropdown-toggle" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                        <a class="dropdown-item" data-toggle="modal" data-target="#edit_schooltype" data-value="<?php echo htmlentities($school_type->School_type_id);?>">Edit</a>
                                                        <a class="dropdown-item" data-toggle="modal" data-target="#delete_schooltype" data-value="<?php echo htmlentities($school_type->School_type_id);?>">Delete</a>
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
                                        <?php echo form_open('account/school_type/new_school_type');?>
                                            <div class="row">
                                                <div class="col-sm-12 form-group mb-4"><label>Name</label><input class="form-control" type="text" placeholder="Type" name="name"></div>
                                            </div>
                                            <div class="form-group"><button class="btn btn-primary mr-2" type="submit">Submit</button><button class="btn btn-light" type="reset">Clear</button></div>
                                        <?php echo form_close();?>
                                    </div>
                                    <div class="modal-footer"><button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button></div>
                                </div>
                            </div>
                        </div>
                <!--////////////////////////////////////////////////////////////////////////////-->
                <div class="modal fade" id="deleteall" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5><button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php echo form_open('account/school_type/delete_school_type_all');?>
                                            <div class="row" style="display: none;">
                                                 <div class="col-sm-12 form-group mb-4"><label>Id</label><input class="form-control" type="text"  name="id">
                                                 </div>
                                            </div>
                                            <p class="text-danger" style="font-size:20px;">Do you really want to delete Every Data, it cannot be undone?</p>
                                            <div class="modal-footer"><button class="btn btn-secondary" type="submit">Yes</button><button class="btn btn-danger" type="button" data-dismiss="modal">No</button></div>
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
                                        <?php echo form_open('account/school_type/delete_school_type');?>
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
                         <!--////////////////////////////////////////////////////////////////////////////-->
                <div class="modal fade" id="edit_schooltype" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5><button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php echo form_open('account/school_type/update_school_type');?>
                                            <div class="row">
                                                 <div class="col-sm-12 form-group mb-4" style="display: none;"><label>Id</label><input class="form-control" type="text"  name="id"></div>
                                                <div class="col-sm-12 form-group mb-4"><label>Name</label><input class="form-control" type="text" placeholder="Type" name="name"></div>
                                                 <div class="col-sm-12 form-group mb-4"><label>Status</label>
                                                    <select class="form-control" type="text" placeholder="Type" name="status">
                                                        <option>Select Status</option>
                                                        <option value="1" selected="">Active</option>
                                                        <option value="2">Deactivated</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group"><button class="btn btn-primary mr-2" type="submit">Submit</button><button class="btn btn-light" type="reset">Clear</button></div>
                                        <?php echo form_close();?>
                                    </div>
                                </div>
                            </div>
                        </div>