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
                                <h5 class="box-title"><?php echo $Page_name;?></h5>
                                <div class="flexbox mb-4">
                                    <div class="flexbox"><label class="mb-0 mr-2">Status:</label><select class="selectpicker form-control show-tick" id="type-filter" title="Please select" data-width="150px">
                                            <option value="">All</option>
                                            <option>Active</option>
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
                                                <th>Email</th>
                                                <th>Active Package</th>
                                                <th>Country</th>
                                                <th>Position</th>
                                                <th>Status</th>
                                                <th class="no-sort"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $cnt=0;
                                            foreach ($organizers->result() as $key):
                                            $Package=$this->Admin_model->get_pricing_plan_id($key->Active_package);
                                            $cnt++;
                                            ?>
                                            <tr>
                                                <td><?php echo htmlentities($cnt);?></td>
                                                <td><?php echo htmlentities($key->Name);?></td>
                                                <td><?php echo htmlentities($key->Email);?></td>
                                                <td><span class="badge badge-primary badge-pill"><?php echo htmlentities($Package->row()->PackageName);?></span></td>
                                                <td><?php echo htmlentities($key->Country);?></td>
                                                <td><?php echo htmlentities($key->Position);?></td>
                                                <td>
                                                    <?php 
                                                    if ($key->Status==1):?>
                                                        <span class="badge badge-success badge-pill">Active</span>
                                                    <?php else:?>
                                                        <span class="badge badge-danger badge-pill">Inactive</span>
                                                    <?php endif;?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $status=$key->Status;
                                                    if ($status!=1):?>
                                                    <a class=" font-16 btn btn-sm btn-success" href="<?php echo base_url();?>sysadmin/organizers/activate/<?php echo htmlentities($key->OrganizerId);?>" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Activate User"><i class="ti-unlock"></i></a>
                                                    <?php else:?>
                                                    <a class=" font-16 btn btn-sm btn-warning" href="<?php echo base_url();?>sysadmin/organizers/deactivate/<?php echo htmlentities($key->OrganizerId);?>" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Deactivate User"><i class="ti-lock"></i></a>
                                                    <?php endif;?>
                                                    <a class=" font-16 btn btn-sm btn-danger" href="<?php echo base_url();?>sysadmin/organizers/delete/<?php echo htmlentities($key->OrganizerId);?>" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Delete User"><i class="ti-trash"></i></a>
                                                    <a class=" font-16 btn btn-sm btn-primary" href="<?php echo base_url();?>sysadmin/organizers/view/<?php echo htmlentities($key->OrganizerId);?>" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="View User"><i class="ti-eye"></i></a>
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