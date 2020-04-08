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
                                            </tr>
                                            <?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><!-- END: Page content-->
                </div>