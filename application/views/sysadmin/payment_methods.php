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
                                <p> </p>
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
                                                <th>Name</th>
                                                <th>Merchant Id</th>
                                                <th>Private/Secret Key</th>
                                                <th>Public Key</th>
                                                <th>Url</th>
                                                <th>Status</th>
                                                <th class="no-sort"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $cnt=0;
                                            foreach ($payment_methods->result() as $key):
                                            $cnt++;
                                            ?>
                                            <tr>
                                                <td><?php echo htmlentities($cnt);?></td>
                                                <td><?php echo htmlentities($key->MethodName);?></td>
                                                <td><?php echo htmlentities($key->Merchant_id);?></td>
                                                <td><?php echo htmlentities($key->Private_key);?></td>
                                                <td><?php echo htmlentities($key->Public_key);?></td>
                                                <td><span class="badge badge-primary badge-pill"><?php echo ($key->Web_Hook);?></span></td>
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
                                                        <a class=" font-16 btn btn-sm btn-warning" href="<?php echo base_url();?>sysadmin/payment_methods/set_status/<?php echo htmlentities($key->MethodId);?>/2" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Deactivate"><i class="ti-lock"></i></a>
                                                    <?php else:?>
                                                        <a class=" font-16 btn btn-sm btn-success" href="<?php echo base_url();?>sysadmin/payment_methods/set_status/<?php echo htmlentities($key->MethodId);?>/1" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Activate"><i class="ti-unlock"></i></a>
                                                    <?php endif;?>
                                                    <a class=" font-16 btn btn-sm btn-secondary" data-toggle="modal" data-target="#edit_method" title="Edit" data-value="<?php echo htmlentities($key->MethodId);?>"><i class="ti-pencil"></i></a>
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
                <div class="modal fade" id="edit_method" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Payment Method</h5><button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php echo form_open('sysadmin/payment_methods/edit');?>
                                            <div class="row">
                                                 <div class="col-sm-12 form-group mb-4"><label>Name</label><input class="form-control" type="text"  name="name">
                                                 </div>
                                            </div>
                                            <div class="row">
                                                 <div class="col-sm-12 form-group mb-4"><label>Merchant Id</label><input class="form-control" type="text"  name="merchant_id">
                                                 </div>
                                            </div>
                                            <div class="row">
                                                 <div class="col-sm-12 form-group mb-4"><label>Public Key</label><input class="form-control" type="text"  name="public_key">
                                                 </div>
                                            </div>
                                            <div class="row">
                                                 <div class="col-sm-12 form-group mb-4"><label>Private/Secret key</label><input class="form-control" type="text"  name="private_key">
                                                 </div>
                                            </div>
                                            <div class="row">
                                                 <div class="col-sm-12 form-group mb-4"><label>Url</label><input class="form-control" type="text"  name="url">
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