<div class="page-content fade-in-up">
                    <!-- BEGIN: Page heading-->
                    <div class="page-heading">
                        <div class="page-breadcrumb">
                            <h1 class="page-title page-title-sep"><?php echo $Page_name;?></h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url();?>account/index"><i class="ft-home font-20"></i></a></li>
                                <li class="breadcrumb-item"><?php echo $Page_name;?></li>
                            </ol>
                        </div>
                    </div><!-- BEGIN: Page content-->
                    <div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-fullheight">
                                    <div class="card-body">
                                        <h5 class="box-title text-primary"><?php echo $Page_name;?></h5>
                                        <?php
                                        if ($payment_method->MethodId==1):?>
                                            <?php echo form_open('account/result_pins/authenticate_paystacks');?>
                                        <?php elseif ($payment_method->MethodId==2):?>
                                            <?php echo form_open('account/flutterwave/create_transaction');?>
                                        <?php elseif ($payment_method->MethodId==3):?>
                                            <?php echo form_open('account/result_pins/account_balance');?>
                                        <?php endif;?>
                                            <div class="md-form"><input class="md-form-control" type="text" name="name" value="<?php echo htmlentities($organizer->Name);?>" readonly><label>Name</label></div>
                                            <div class="md-form"><input class="md-form-control" type="email" name="email" value="<?php echo htmlentities($organizer->Email);?>" readonly><label>Email</label></div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="md-form"><input class="md-form-control" type="text" name="number_of_pin" value="<?php echo htmlentities($this->session->userdata('Number_of_pin'));?>" readonly><label>Number of Pin</label></div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="md-form"><input class="md-form-control" type="text" name="amount" value="<?php echo htmlentities($this->session->userdata('Amount_to_pay'));?>" readonly><label>Amount</label></div>
                                                </div>
                                            </div>                                            <div class="form-group"><button class="btn btn-primary mr-2" type="submit">Submit</button><button class="btn btn-light" type="reset">Clear</button></div>
                                        <?php echo form_close();?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- END: Page content-->
                </div>