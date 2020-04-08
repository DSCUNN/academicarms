<div class="page-content fade-in-up">
                    <!-- BEGIN: Page heading-->
                    <div class="page-heading">
                        <div class="page-breadcrumb">
                            <h1 class="page-title"><?php echo $Page_name;?></h1>
                        </div>
                        
                    </div><!-- BEGIN: Page content-->
                    <div>
                        <div class="card">
                            <div class="card-body">
                                <!--SHOWING MESSAGE{SUCCESS OR FAILURE}-->
                                <?php if ($this->session->flashdata('message') != null) {  ?>
                                    <?php echo $this->session->flashdata('message'); ?>              
                                <?php } ?>
                                <!--//SHOWING MESSAGE{SUCCESS OR FAILURE}-->
                                <h5 class="box-title"><?php echo $Page_name;?></h5>
                                <p><button class="btn btn-primary btn-sm btn-rounded" data-toggle="modal" data-target="#add_faq_category">Add New Plan</button></p>
                                <div class="flexbox mb-4">
                                    <div class="flexbox"><label class="mb-0 mr-2">Status:</label><select class="selectpicker form-control show-tick" id="type-filter" title="Please select" data-width="150px">
                                            <option value="">All</option>
                                            <option value="Active">Active</option>
                                            <option>Inactive</option>
                                        </select></div>
                                    <div class="input-group-icon input-group-icon-right mr-3"><span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span><input class="form-control form-control-rounded" id="key-search" type="text" placeholder="Search ..."></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered w-100" id="dt-filter">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Package Name</th>
                                                <th>Description</th>
                                                <th>Old Price</th>
                                                <th>New Price</th>
                                                <th>Number of Schools</th>
                                                <th>Recommend</th>
                                                <th>Recommendation Text</th>
                                                <th>Features</th>
                                                <th>Is Free</th>
                                                <th >Status</th>
                                                <th class="no-sort"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $cnt=0;
                                            foreach ($pricing->result() as $key):
                                            $cnt++;
                                            ?>
                                            <tr>
                                                <td><?php echo htmlentities($cnt);?></td>
                                                <td><?php echo htmlentities($key->PackageName);?></td>
                                                <td><?php echo character_limiter($key->Description,50);?></td>
                                                <td><?php echo htmlentities($key->Old_price);?></td>
                                                <td><?php echo htmlentities($key->New_price);?></td>
                                                <td><?php echo htmlentities($key->Number_of_schools);?></td>
                                                <td>
                                                    <?php if ($key->Recommended==1):?>
                                                    <span class="badge badge-success badge-pill">Yes</span>
                                                    <?php else:?>
                                                    <span class="badge badge-danger badge-pill">No</span>
                                                    <?php endif;?>
                                                </td>
                                                <td><?php echo htmlentities($key->Recommend_text);?></td>
                                                <td><?php echo character_limiter($key->Features,10);?></td>
                                                <td>
                                                    <?php if ($key->Is_free==1):?>
                                                    <span class="badge badge-success badge-pill">Yes</span>
                                                    <?php else:?>
                                                    <span class="badge badge-danger badge-pill">No</span>
                                                    <?php endif;?>
                                                </td>
                                                <td>
                                                    <?php if ($key->Status==1):?>
                                                    <span class="badge badge-success badge-pill">Active</span>
                                                    <?php else:?>
                                                    <span class="badge badge-danger badge-pill">Inactive</span>
                                                    <?php endif;?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $status=$key->Status;
                                                    if ($status==1):?>
                                                        <a class=" font-16 btn btn-sm btn-warning" href="<?php echo base_url();?>sysadmin/pricing/set_status/<?php echo htmlentities($key->Package_id);?>/2" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Deactivate"><i class="ti-lock"></i> Deactivate</a>
                                                    <?php else:?>
                                                        <a class=" font-16 btn btn-sm btn-success" href="<?php echo base_url();?>sysadmin/pricing/set_status/<?php echo htmlentities($key->Package_id);?>/1" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Activate"><i class="ti-unlock"></i> Activate</a>
                                                    <?php endif;?>
                                                    <a class=" font-16 btn btn-sm btn-secondary" data-toggle="modal" data-target="#edit_plan" title="Edit" data-value="<?php echo htmlentities($key->Package_id);?>"><i class="ti-pencil"></i> Edit</a>
                                                    <a class=" font-16 btn btn-sm btn-danger" href="<?php echo base_url();?>sysadmin/pricing/delete/<?php echo htmlentities($key->Package_id);?>" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Delete "><i class="ti-trash"></i> Delete</a>
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
                <div class="modal fade" id="add_faq_category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Create New Plan</h5><button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php echo form_open('sysadmin/pricing/create');?>
                                            <div class="row">
                                                 <div class="col-sm-12 form-group mb-4"><label>Name</label><input class="form-control" type="text"  name="name">
                                                 </div>
                                            </div>
                                            <div class="row">
                                                 <div class="col-sm-12 form-group mb-4"><label>Description</label><textarea class="form-control" type="text"  name="description" rows="5"></textarea>
                                                 </div>
                                            </div>
                                            <div class="row">
                                                 <div class="col-sm-12 form-group mb-4"><label>Old Price</label><input class="form-control" type="number"  name="old_price">
                                                 </div>
                                            </div>
                                            <div class="row">
                                                 <div class="col-sm-12 form-group mb-4"><label>New Price</label><input class="form-control" type="number"  name="new_price">
                                                 </div>
                                            </div>
                                            <div class="row">
                                                 <div class="col-sm-12 form-group mb-4"><label>Number of School</label><input class="form-control" type="number"  name="number_of_school">
                                                 </div>
                                            </div>
                                            <div class="row">
                                                 <div class="col-sm-12 form-group mb-4">
                                                    <label>Is Recommended</label><br>
                                                    <label class="radio radio-primary radio-inline"><input type="radio" name="is_recommended" value="1"><span>Yes</span></label>
                                                    <label class="radio radio-primary radio-inline"><input type="radio" name="is_recommended" value="2"><span>No</span></label>
                                                 </div>
                                            </div>
                                            <div class="row">
                                                 <div class="col-sm-12 form-group mb-4"><label>Recommendation Text</label><input class="form-control" type="text"  name="recommend_text">
                                                 </div>
                                            </div>
                                            <div class="row">
                                                 <div class="col-sm-12 form-group mb-4"><label>Features</label><textarea class="form-control" type="text"  name="features" rows="5"  id="summernote"></textarea>
                                                 </div>
                                            </div>
                                            <div class="row">
                                                 <div class="col-sm-12 form-group mb-4">
                                                    <label>Is Free</label><br>
                                                    <label class="radio radio-primary radio-inline"><input type="radio" name="is_free" value="1"><span>Yes</span></label>
                                                    <label class="radio radio-primary radio-inline"><input type="radio" name="is_free" value="2"><span>No</span></label>
                                                 </div>
                                            </div>
                                            <div class="modal-footer"><button class="btn btn-secondary" type="submit">Proceed</button><button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button></div>
                                        <?php echo form_close();?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--////////////////////////////////////////////////////////////////////////////-->
                <div class="modal fade" id="edit_plan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Create New Category</h5><button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php echo form_open('sysadmin/pricing/edit');?>
                                             <div class="row">
                                                 <div class="col-sm-12 form-group mb-4"><label>Name</label><input class="form-control" type="text"  name="name">
                                                 </div>
                                            </div>
                                            <div class="row">
                                                 <div class="col-sm-12 form-group mb-4"><label>Description</label><textarea class="form-control" type="text"  name="description" rows="5"></textarea>
                                                 </div>
                                            </div>
                                            <div class="row">
                                                 <div class="col-sm-12 form-group mb-4"><label>Old Price</label><input class="form-control" type="number"  name="old_price">
                                                 </div>
                                            </div>
                                            <div class="row">
                                                 <div class="col-sm-12 form-group mb-4"><label>New Price</label><input class="form-control" type="number"  name="new_price">
                                                 </div>
                                            </div>
                                            <div class="row">
                                                 <div class="col-sm-12 form-group mb-4"><label>Number of School</label><input class="form-control" type="number"  name="number_of_school">
                                                 </div>
                                            </div>
                                            <div class="row">
                                                 <div class="col-sm-12 form-group mb-4">
                                                    <label>Is Recommended</label><br>
                                                    <label class="radio radio-primary radio-inline"><input type="radio" name="is_recommended" value="1"><span>Yes</span></label>
                                                    <label class="radio radio-primary radio-inline"><input type="radio" name="is_recommended" value="2"><span>No</span></label>
                                                 </div>
                                            </div>
                                            <div class="row">
                                                 <div class="col-sm-12 form-group mb-4"><label>Recommendation Text</label><input class="form-control" type="text"  name="recommend_text">
                                                 </div>
                                            </div>
                                            <div class="row">
                                                 <div class="col-sm-12 form-group mb-4"><label>Features</label><textarea class="form-control" type="text"  name="features" rows="5"  id="summernote1"></textarea>
                                                 </div>
                                            </div>
                                            <div class="row">
                                                 <div class="col-sm-12 form-group mb-4">
                                                    <label>Is Free</label><br>
                                                    <label class="radio radio-primary radio-inline"><input type="radio" name="is_free" value="1"><span>Yes</span></label>
                                                    <label class="radio radio-primary radio-inline"><input type="radio" name="is_free" value="2"><span>No</span></label>
                                                 </div>
                                            </div>
                                            <div class="row" style="display: none;">
                                                 <div class="col-sm-12 form-group mb-4"><label>Id</label><input class="form-control" type="text"  name="id">
                                                 </div>
                                            </div>
                                            <div class="modal-footer"><button class="btn btn-secondary" type="submit">Proceed</button><button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button></div>
                                        <?php echo form_close();?>
                                    </div>
                                </div>
                            </div>
                        </div>