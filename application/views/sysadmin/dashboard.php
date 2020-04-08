<div class="page-content fade-in-up">
                    <!-- BEGIN: Page heading-->
                    <div class="page-heading">
                        <div class="page-breadcrumb">
                            <h1 class="page-title"><?php echo $Page_name;?></h1>
                        </div>
                        <div class="subheader_daterange" id="subheader_daterange"><span class="subheader-daterange-label"><span class="subheader-daterange-title"></span><span class="subheader-daterange-date"></span></span><button class="btn btn-floating btn-sm rounded-0" type="button"><i class="ti-calendar"></i></button></div>
                    </div><!-- BEGIN: Page content-->
                    <div>
                        <div class="row">
                            <div class="col-lg-3 col-xs-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="mb-3 font-15 text-muted font-weight-normal">ORGANIZERS</h6>
                                        <div class="h2 mb-0 font-weight-normal">+310</div><i class="ft-user data-widget-icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-xs-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="mb-3 font-15 text-muted font-weight-normal">SALES</h6>
                                        <div class="h2 mb-0 font-weight-normal">$7450</div><i class="ft-dollar-sign data-widget-icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-xs-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="mb-3 font-15 text-muted font-weight-normal">SCHOOLS</h6>
                                        <div class="h2 mb-0 font-weight-normal">+740</div><i class="ft-briefcase data-widget-icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-xs-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="mb-3 font-15 text-muted font-weight-normal">RESULTS</h6>
                                        <div class="h2 mb-0 font-weight-normal">45%</div><i class="ft-activity data-widget-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="box-title">Latest Orders</h5>
                                <div class="flexbox mb-4">
                                    <div class="flexbox"><label class="mb-0 mr-2">Type:</label><select class="selectpicker form-control show-tick" id="type-filter" title="Please select" data-width="150px">
                                            <option value="">All</option>
                                            <option >Successful</option>
                                            <option>Cancelled</option>
                                            <option>Failed</option>
                                        </select></div>
                                    <div class="input-group-icon input-group-icon-right mr-3"><span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span><input class="form-control form-control-rounded" id="key-search" type="text" placeholder="Search ..."></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered w-100" id="dt-filter">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Payment Reference</th>
                                                <th>Transaction Id</th>
                                                <th>Amount</th>
                                                <th>Payment Method</th>
                                                <th>Date of Payment</th>
                                                <th>Status</th>
                                                <th class="no-sort"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $cnt=0;
                                            foreach ($payments->result() as $key):
                                            $payement_method=$this->Admin_model->get_payment_method_id($key->Payment_method);
                                            $organizer=$this->Admin_model->get_organizer_id($key->OrganizerId);
                                            $cnt++;
                                            ?>
                                            <tr>
                                                <td><?php echo htmlentities($cnt);?></td>
                                                <td><?php echo htmlentities($organizer->row()->Name);?></td>
                                                <td><span class="badge badge-primary badge-pill"><?php echo htmlentities($key->Payment_Ref);?></span></td>
                                                <td><span class="badge badge-info badge-pill"><?php echo htmlentities($key->Transaction_id);?></span></td>
                                                <td><?php echo htmlentities($key->Amount_paid);?></td>
                                                <td><span class="badge badge-primary badge-pill"><?php echo ($payement_method->row()->MethodName);?></span></td>
                                                <td><?php echo date('d-m-Y H:i:s', $key->Date_payment);?></td>
                                                <td>
                                                    <?php if ($key->Payment_Status==1):?>
                                                    <span class="badge badge-success badge-pill">Successful</span>
                                                    <?php elseif ($key->Payment_Status==2):?>
                                                    <span class="badge badge-secondary badge-pill">Cancelled</span>
                                                    <?php else:?>
                                                    <span class="badge badge-danger badge-pill">Failed</span>
                                                    <?php endif;?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $status=$key->Payment_Status;
                                                    if ($status==1):?>
                                                        <a class=" font-16 btn btn-sm btn-warning" href="<?php echo base_url();?>sysadmin/payments/set_status/<?php echo htmlentities($key->Payment_id);?>/2" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Deactivate"><i class="ti-lock"></i></a>
                                                    <?php else:?>
                                                        <a class=" font-16 btn btn-sm btn-success" href="<?php echo base_url();?>sysadmin/payments/set_status/<?php echo htmlentities($key->Payment_id);?>/1" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Mark Successful"><i class="ti-unlock"></i></a>
                                                    <?php endif;?>
                                                </td>
                                            </tr>
                                            <?php endforeach;?>
                                        </tbody>
                                    </table>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><!-- END: Page content-->
                </div>