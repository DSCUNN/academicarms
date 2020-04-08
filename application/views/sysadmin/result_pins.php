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
                                            <option>Not Used</option>
                                            <option>In Use</option>
                                            <option>Already Used</option>
                                            <?php
                                            foreach ($schools->result() as $value):?>
                                            <option><?php echo htmlentities($value->School_name);?></option>
                                            <?php endforeach;?>
                                        </select></div>
                                    <div class="input-group-icon input-group-icon-right mr-3"><span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span><input class="form-control form-control-rounded" id="key-search" type="text" placeholder="Search ..."></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered w-100" id="dt-filter">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Organizer Name</th>
                                                <th>Organizer Email</th>
                                                <th>School</th>
                                                <th>Pin Number</th>
                                                <th>Serial Number</th>
                                                <th>Number of Times Used</th>
                                                <th>Status</th>
                                                <th class="no-sort"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $cnt=0;
                                            foreach ($result_pins->result() as $key):
                                            $user=$this->Admin_model->get_organizer_id($key->OrganizerId);
                                            $user=$user->row();
                                            $school=$this->Organizer_model->get_school_id($key->School_id,$key->OrganizerId);
                                            $school=$school->row();
                                            $pin_usage=$this->Admin_model->pin_usage($key->Pin_id);
                                            $cnt++;
                                            ?>
                                            <tr>
                                                <td><?php echo htmlentities($cnt);?></td>
                                                <td><?php echo htmlentities($user->Name);?></td>
                                                <td><?php echo htmlentities($user->Email);?></td>
                                                <td><span class="badge badge-primary badge-pill"><?php echo htmlentities($school->School_name);?></span></td>
                                                <td><?php echo htmlentities($key->Pin_number);?></td>
                                                <td><?php echo htmlentities($key->Serial_number);?></td>
                                                 <td><?php echo htmlentities($pin_usage->num_rows());?></td>
                                                <td>
                                                    <?php if ($key->Status==1):?>
                                                    <span class="badge badge-success badge-pill">Not Used</span>
                                                    <?php elseif ($key->Status==2):?>
                                                    <span class="badge badge-warning badge-pill">In Use</span>
                                                    <?php else:?>
                                                    <span class="badge badge-danger badge-pill">Already Used</span>
                                                    <?php endif;?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $status=$key->Status;
                                                    if ($status==1):?>
                                                        <a class=" font-16 btn btn-sm btn-info" href="<?php echo base_url();?>sysadmin/result_pins/set_status/<?php echo htmlentities($key->Pin_id);?>/2" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Set As In use"><i class="ti-lock"></i></a>
                                                        <a class=" font-16 btn btn-sm btn-warning" href="<?php echo base_url();?>sysadmin/result_pins/set_status/<?php echo htmlentities($key->Pin_id);?>/3" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Set As Used"><i class="ft-power"></i></a>
                                                    <?php elseif ($status==2):?>
                                                        <a class=" font-16 btn btn-sm btn-success" href="<?php echo base_url();?>sysadmin/result_pins/set_status/<?php echo htmlentities($key->Pin_id);?>/1" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Set As Not Used"><i class="ti-unlock"></i></a>
                                                        <a class=" font-16 btn btn-sm btn-warning" href="<?php echo base_url();?>sysadmin/result_pins/set_status/<?php echo htmlentities($key->Pin_id);?>/3" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Set As Used"><i class="ti-lock"></i></a>
                                                    <?php else:?>
                                                        <a class=" font-16 btn btn-sm btn-success" href="<?php echo base_url();?>sysadmin/result_pins/set_status/<?php echo htmlentities($key->Pin_id);?>/1" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Set As Not Used"><i class="ti-unlock"></i></a>
                                                        <a class=" font-16 btn btn-sm btn-warning" href="<?php echo base_url();?>sysadmin/result_pins/set_status/<?php echo htmlentities($key->Pin_id);?>/2" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Set As In Use"><i class="ti-lock"></i></a>
                                                    <?php endif;?>
                                                    <a class=" font-16 btn btn-sm btn-danger" href="<?php echo base_url();?>sysadmin/result_pins/delete/<?php echo htmlentities($key->Pin_id);?>" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Delete "><i class="ti-trash"></i></a>
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