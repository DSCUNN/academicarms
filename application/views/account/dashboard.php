<div class="page-content fade-in-up">
                    <!-- BEGIN: Page heading-->
                    <div class="page-heading">
                        <div class="page-breadcrumb">
                            <h1 class="page-title"><?php echo $Page_name;?></h1>
                        </div>
                    </div><!-- BEGIN: Page content-->
                    <div>
                        <div class="row">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="mb-3 font-15 text-muted font-weight-normal">ACCOUNT BALANCE</h6>
                                        <div class="h2 mb-0 font-weight-normal"><?php echo number_format($organizer->Balance);?></div><i class="ti-money data-widget-icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="mb-3 font-15 text-muted font-weight-normal">TOTAL STUDENTS</h6>
                                        <div class="h2 mb-0 font-weight-normal"><?php echo number_format($total_students->num_rows());?></div><i class="ft-users data-widget-icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="mb-3 font-15 text-muted font-weight-normal">TOTAL CLASS</h6>
                                        <div class="h2 mb-0 font-weight-normal"><?php echo number_format($total_class->num_rows());?></div><i class="ft-grid data-widget-icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="mb-3 font-15 text-muted font-weight-normal"> TOTAL TEACHERS</h6>
                                        <div class="h2 mb-0 font-weight-normal"><?php echo number_format($total_teachers->num_rows());?></div><i class="ft-user data-widget-icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="mb-3 font-15 text-muted font-weight-normal">TOTAL RESULTS PUBLISHED</h6>
                                        <div class="h2 mb-0 font-weight-normal"><?php echo number_format($total_results_published->num_rows());?></div><i class="ft-activity data-widget-icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="mb-3 font-15 text-muted font-weight-normal">TOTAL UNPUBLISHED RESULTS</h6>
                                        <div class="h2 mb-0 font-weight-normal"><?php echo number_format($total_results_unpublished->num_rows());?></div><i class="ft-anchor data-widget-icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="mb-3 font-15 text-muted font-weight-normal">TOTAL RESULT PINS</h6>
                                        <div class="h2 mb-0 font-weight-normal"><?php echo number_format($total_result_pins->num_rows());?></div><i class="ft-layers data-widget-icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="mb-3 font-15 text-muted font-weight-normal">TOTAL UNUSED RESULT PINS</h6>
                                        <div class="h2 mb-0 font-weight-normal"><?php echo number_format($total_unused_pins->num_rows());?></div><i class="ft-package data-widget-icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="mb-3 font-15 text-muted font-weight-normal">TOTAL RESULTS USED</h6>
                                        <div class="h2 mb-0 font-weight-normal"><?php echo number_format($total_used_pins->num_rows());?></div><i class="ft-briefcase data-widget-icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="mb-3 font-15 text-muted font-weight-normal">TOTAL SUBJECTS</h6>
                                        <div class="h2 mb-0 font-weight-normal"><?php echo number_format($total_subjects->num_rows());?></div><i class="ft-book data-widget-icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="mb-3 font-15 text-muted font-weight-normal">TOTAL SCHOOLS</h6>
                                        <div class="h2 mb-0 font-weight-normal"><?php echo number_format($total_schools->num_rows());?></div><i class="ft-sliders data-widget-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- END: Page content-->
                </div>