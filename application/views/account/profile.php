<div class="page-content fade-in-up">
                    <!-- BEGIN: Page heading-->
                    <div class="page-heading">
                        <div class="page-breadcrumb">
                            <h1 class="page-title page-title-sep"><?php echo $Page_name;?></h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url();?>account/index"><i class="ti-home font-20"></i></a></li>
                                <li class="breadcrumb-item"><?php echo $Page_name;?></li>
                            </ol>
                        </div>
                    </div><!-- BEGIN: Page content-->
                    <div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body text-center"><span class="position-relative d-inline-block my-4"><img class="rounded-circle" src="<?php echo base_url();?>assets/dashboard/assets/img/users/admin-image.png" alt="image" width="120" /><span class="badge-point badge-success avatar-badge" style="bottom: 5px;right: 14px;height: 14px;width: 14px;"></span></span>
                                        <div class="h4"><?php echo htmlentities($organizer->Name);?></div>
                                        <div class="text-muted mb-4"><?php echo htmlentities($organizer->Position);?></div>
                                        <p class="text-muted"><?php echo htmlentities($organizer->About);?></p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-4">
                                            <h5 class="box-title mb-0">Information</h5><a href="<?php echo base_url();?>account/account"><i class="ti-pencil"></i> Edit</a>
                                        </div>
                                        <?php 
                                        $name=$organizer->Name;
                                        $names=explode(' ', $name);?>
                                        <div class="row mb-2">
                                            <div class="col-6 text-muted">First Name:</div>
                                            <div class="col-6"><?php echo $names[0];?></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6 text-muted">Last Name:</div>
                                            <div class="col-6"><?php echo $names[1];?></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6 text-muted">Email:</div>
                                            <div class="col-6"><?php echo htmlentities($organizer->Email);?></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6 text-muted">Position:</div>
                                            <div class="col-6"><?php echo htmlentities($organizer->Position);?></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6 text-muted">Country:</div>
                                            <div class="col-6"><?php echo htmlentities($organizer->Country);?></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6 text-muted">State:</div>
                                            <div class="col-6"><?php echo htmlentities($organizer->State);?></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6 text-muted">City:</div>
                                            <div class="col-6"><?php echo htmlentities($organizer->City);?></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6 text-muted">Zip Code:</div>
                                            <div class="col-6"><?php echo htmlentities($organizer->Zip);?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between mb-4">
                                                    <h5 class="box-title mb-0">Security</h5><a class="text-muted font-18" href="<?php echo base_url();?>account/account" data-toggle="tooltip" title="Set Up Security"><i class="ti-plus"></i></a>
                                                </div>
                                                <ul class="list-unstyled media-list-divider">
                                                    <li class="media py-3 align-items-center"><a class="btn btn-sm btn-facebook btn-floating mr-3" href="#"><i class="ti-lock"></i></a>
                                                        <div class="media-body flexbox">
                                                            <div>
                                                                <h6>Two Way Authentication</h6>
                                                                <div class="text-muted">Profile John Due</div>
                                                            </div>
                                                            <label class="ui-switch switch-solid">
                                                                <?php if ($organizer->Twoway==1):?>
                                                                    <input type="checkbox" checked="" disabled="" ><span data-toggle="tooltip" title="Activated"></span>
                                                                <?php else:?>
                                                                    <input type="checkbox" disabled=""><span data-toggle="tooltip" title="Deactivated"></span>
                                                                <?php endif;?>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li class="media py-3 align-items-center"><a class="btn btn-sm btn-dribbble btn-floating mr-3" href="#"><i class="ti-cloud"></i></a>
                                                        <div class="media-body flexbox">
                                                            <div>
                                                                <h6>Master Code</h6>
                                                                <div class="text-muted">Profile John Due</div>
                                                            </div>
                                                            <label class="ui-switch switch-solid">
                                                                <?php if ($organizer->MasterCode!=''):?>
                                                                    <input type="checkbox" checked="" disabled="" ><span data-toggle="tooltip" title="Active"></span>
                                                                <?php else:?>
                                                                    <input type="checkbox" disabled=""><span data-toggle="tooltip" title="Deactivated"></span>
                                                                <?php endif;?>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li class="media py-3 align-items-center"><a class="btn btn-sm btn-twitter btn-floating mr-3" href="#"><i class="ti-key"></i></a>
                                                        <div class="media-body flexbox">
                                                            <div>
                                                                <h6>Security Code</h6>
                                                                <div class="text-muted">Profile John Due</div>
                                                            </div>
                                                             <label class="ui-switch switch-solid">
                                                                <?php if ($organizer->SecurityCode!=''):?>
                                                                    <input type="checkbox" checked="" disabled="" ><span data-toggle="tooltip" title="Active"></span>
                                                                <?php else:?>
                                                                    <input type="checkbox" disabled=""><span data-toggle="tooltip" title="Deactivated"></span>
                                                                <?php endif;?>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li class="media py-3 align-items-center"><a class="btn btn-sm btn-linkedin btn-floating mr-3" href="#"><i class="ti-envelope"></i></a>
                                                        <div class="media-body flexbox">
                                                            <div>
                                                                <h6>Notification</h6>
                                                                <div class="text-muted">Profile John Due</div>
                                                            </div>
                                                             <label class="ui-switch switch-solid">
                                                                <?php if ($organizer->Notifyme==1):?>
                                                                    <input type="checkbox" checked="" disabled="" ><span data-toggle="tooltip" title="Active"></span>
                                                                <?php else:?>
                                                                    <input type="checkbox" disabled=""><span data-toggle="tooltip" title="Deactivated"></span>
                                                                <?php endif;?>
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li class="media py-3 align-items-center"><a class="btn btn-sm btn-youtube btn-floating mr-3" href="#"><i class="ti-check"></i></a>
                                                        <div class="media-body flexbox">
                                                            <div>
                                                                <h6>Email Verification</h6>
                                                                <div class="text-muted">Profile John Due</div>
                                                            </div>
                                                             <label class="ui-switch switch-solid">
                                                                <?php if ($organizer->EmailVerify==1):?>
                                                                    <input type="checkbox" checked="" disabled="" ><span data-toggle="tooltip" title="Active"></span>
                                                                <?php else:?>
                                                                    <input type="checkbox" disabled=""><span data-toggle="tooltip" title="Deactivated"></span>
                                                                <?php endif;?>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- END: Page content-->
                </div>