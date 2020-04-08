<div class="page-content fade-in-up">
                    <!-- BEGIN: Page heading-->
                   <!-- BEGIN: Page content-->
                    <div>
                        <div class="card">
                            <div class="card-body invoice px-sm-5">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h1 class="text-muted font-40 mb-5"><img src="<?php echo base_url();?>assets/dashboard/logo/schools/<?php echo htmlentities($school->School_logo);?>" style="width:100px;height:50px;"></h1>
                                    </div>
                                    <div class="col-md-6 text-left text-sm-right">
                                        <h2 class="text-danger mb-3"><?php echo htmlentities($school->School_name);?></h2>
                                        <div class="font-15 text-muted">
                                            <div><?php echo htmlentities($school->Address);?></div>
                                            <div>Phone:<?php echo htmlentities($school->Phone);?></div>
                                            <div>Email: <?php echo htmlentities($school->Email);?></div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-5">
                                <div class="row mb-5">

                                    <div class="col-md-4 mb-4">
                                        <h5 class="text-primary mb-3">FROM</h5>
                                        <div class="font-15 text-muted">
                                            <div><?php echo htmlentities($school->School_name);?></div>
                                            <div><?php echo htmlentities($school->Address);?></div>
                                            <div>Phone: <?php echo htmlentities($school->Phone);?></div>
                                            <div>Email: <?php echo htmlentities($school->Email);?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <h5 class="text-primary mb-3">TO</h5>
                                        <div class="font-15 text-muted">
                                            <div>Name: <b><?php echo htmlentities($student->row()->Name);?></b></div>
                                            <div>Reg.No: <b><?php echo htmlentities($student->row()->Reg_no);?></b></div>
                                            <div>Class: <b><?php echo htmlentities($class->row()->Name);?></b></div>
                                            <div>Teacher: <b><?php echo htmlentities($teacher->row()->Name);?></b></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <h5 class="text-primary mb-3"> </h5><br>
                                        <div class="font-15 text-muted">
                                            <div>Academic ession: <b><?php echo htmlentities($session->row()->Name);?></b></div>
                                            <div>Semester/Term: <b><?php echo htmlentities($semester->row()->Name);?></b></div>
                                            <div>Date Printed: <b><?php echo date('d-M-Y h:i:s a');?></b></div> 
                                            <div>Pin Usage: <b><?php echo htmlentities($pin_use+1);?> of <?php echo htmlentities($school->Pin_usage);?></b></div>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-fullwidth-block mx-sm-0">
                                    <div class="table-responsive">
                                        <table class="table invoice-table">
                                            <thead class="thead-light">
                                                <tr>
                                                  <th>S/N</th>
                                                  <th>Subject</th>
                                                  <th>Subject Code</th>
                                                  <th>Test Score</th>
                                                  <th>Exam Score</th>
                                                  <th>Total Score</th>
                                                  <th>Grade</th>
                                                  <?php 
                                                  if ($school->Result_type!=1):?>
                                                  <th>Unit Load</th>
                                                  <th>Grade Point</th>
                                                  <th>Unit Point</th>
                                                  <?php endif;?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $unitload=0;
                                                $unitpoint=0;
                                                $scores=0;
                                                $cnt=0;
                                                foreach ($sresults->result() as $sresult):
                                                  $cnt++;
                                                  $unitload+=$sresult->Unit_load;
                                                  $unitpoint+=($sresult->Unit_load*$sresult->Gradepoint);
                                                  $scores+=$sresult->Total_score;
                                                ?>
                                                <tr>
                                                  <td><?php echo htmlentities($cnt);?></td>
                                                  <td><?php echo htmlentities($sresult->Subject_name);?></td>
                                                  <td><?php echo htmlentities($sresult->Subject_code);?></td>
                                                  <td><?php echo htmlentities($sresult->Test_score);?></td>
                                                  <td><?php echo htmlentities($sresult->Exam_score);?></td>
                                                  <td><?php echo htmlentities($sresult->Total_score);?></td>
                                                  <td><?php echo htmlentities($sresult->Grade);?></td>
                                                  <?php 
                                                  if ($school->Result_type!=1):?>
                                                  <td><?php echo htmlentities($sresult->Unit_load);?></td>
                                                  <td><?php echo htmlentities($sresult->Gradepoint);?></td>
                                                  <td><?php echo htmlentities($sresult->Unit_load*$sresult->Gradepoint);?></td>
                                                  <?php endif;?>
                                                </tr>
                                              <?php endforeach;?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="10"></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                <?php 
                                if ($school->Result_type!=1):?>
                                <div class="d-flex justify-content-end">
                                    <div class="text-right mr-3" style="width:300px;">
                                        <div class="row mb-2">
                                            <div class="col-6">Total Unit Load</div>
                                            <div class="col-6"><?php echo htmlentities($unitload);?></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">Total Unit Point</div>
                                            <div class="col-6"><?php echo htmlentities($unitpoint);?></div>
                                        </div>
                                        <div class="row font-weight-strong font-20 align-items-center text-primary">
                                            <div class="col-6">CGPA</div>
                                            <div class="col-6">
                                                <div class="h3 mb-0"><?php echo round($unitpoint/$unitload,$school->Round_to);?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif;?>
                                <?php 
                                if ($school->Result_type==1):?>
                                <div class="d-flex justify-content-end">
                                    <div class="text-right mr-3" style="width:300px;">
                                        <div class="row mb-2">
                                            <div class="col-6">Aggregate Score</div>
                                            <div class="col-6"><?php echo htmlentities($scores);?></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">Average</div>
                                            <div class="col-6"><?php echo htmlentities($scores/$cnt);?></div>
                                        </div>
                                        <div class="row font-weight-strong font-20 align-items-center text-primary">
                                            <div class="col-6">Position</div>
                                            <div class="col-6">
                                                <div class="h3 mb-0"><span style="font-size: 20px;"> <?php echo htmlentities($position->row()->Position);?></span> Out Of <strong style="font-size: 20px;"><?php echo htmlentities($num_students->num_rows());?></strong></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif;?>

                            </div>
                        </div>
                    </div><!-- END: Page content-->
                </div>