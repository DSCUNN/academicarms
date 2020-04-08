<style>.faq-tabs .nav-link {
min-width: 100px;
padding: 1rem;
border: 1px dashed;
margin-bottom: 1rem;
background-color: #fff;
box-shadow: 0 1px 15px 1px rgba(62,57,107,.07);
}
.faq-tabs .nav-link.active {
color: #fff;
border-color: #2949ef;
background-color: #2949ef;
}
.faq-tabs .nav-link.active .faq-item-text {
color: rgba(255,255,255,.5)!important;
}
.faq-tabs .nav-link.active i {
color: #fff !important;
}
.faq-list>li {
padding: .75rem 0;
}
.faq-list>li>a {
display: block;
position: relative;
color: inherit;
font-weight: 500;
font-size: 16px;
}
.faq-list>li>a:after {
position: absolute;
right: 0;
top: 50%;
transform: translateY(-50%);
font-family: 'themify';
content: "\e61a";
speak: none;
font-style: normal;
font-weight: normal;
font-variant: normal;
text-transform: none;
line-height: 1;
-webkit-font-smoothing: antialiased;
}
.faq-list>li>a[aria-expanded=true] {
color: #2949ef;
}
.faq-list>li>a[aria-expanded=true]:after {
content: "\e622";
}
.faq-answer {
padding: 1rem 0;
margin-top: 1rem;
color: #6c757d;
}
</style>
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
                            <div class="col-lg-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="box-title">Categories</h5>
                                        <div class="card-fullwidth-block px-3">
                                            <div class="nav nav-pills flex-column faq-tabs" role="tablist">
                                                <?php
                                                foreach ($categories->result() as $category):
                                                    $question_num=$this->Organizer_model->get_category_question_num($category->Category_id);
                                                ?>
                                                    <a class="nav-link media align-items-center" data-toggle="pill" href="#faq-group-<?php echo htmlentities($category->Category_id);?>" role="tab"><i class="<?php echo htmlentities($category->Icon);?> text-muted font-26 mr-3"></i>
                                                    <div class="media-body">
                                                        <div class="mb-1 h6"><?php echo htmlentities($category->Name);?></div>
                                                        <div class="text-muted faq-item-text font-13"><?php echo htmlentities($question_num->num_rows());?> questions</div>
                                                    </div></a>
                                                <?php endforeach;?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="card">
                                     <!--SHOWING MESSAGE{SUCCESS OR FAILURE}-->
                                    <?php if ($this->session->flashdata('message') != null) {  ?>
                                      <?php echo $this->session->flashdata('message'); ?>              
                                    <?php } ?>
                                    <!--//SHOWING MESSAGE{SUCCESS OR FAILURE}--> 
                                    <div class="card-body">
                                        <div class="flexbox mb-4">
                                            <h5 class="mb-0">Frequently Asked Questions</h5><button class="btn btn-danger btn-rounded" data-toggle="modal" data-target="#new-question-dialog"><span class="btn-icon"><i class="ti-plus"></i>New Question</span></button>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active">
                                                    <ul class="list-unstyled faq-list">
                                                       <?php 
                                                       foreach ($faq->result() as $fa):?>
                                                        <li><a data-toggle="collapse" href="#faq2-<?php echo htmlentities($fa->Faq_id);?>"><?php echo htmlentities($fa->Question);?> </a>
                                                            <div class="collapse" id="faq2-<?php echo htmlentities($fa->Faq_id);?>">
                                                                <div class="faq-answer"><?php echo htmlentities($fa->Answer);?></div>
                                                            </div>
                                                        </li>
                                                       <?php endforeach;?>
                                                    </ul>
                                            </div>
                                            <?php 
                                            foreach ($categories->result() as $keys):
                                                $faqs=$this->Organizer_model->get_category_question_num($keys->Category_id);
                                            ?>
                                                <div class="tab-pane fade" id="faq-group-<?php echo htmlentities($keys->Category_id);?>">
                                                    <ul class="list-unstyled faq-list">
                                                       <?php 
                                                       foreach ($faqs->result() as $faq):?>
                                                        <li><a data-toggle="collapse" href="#faq2-<?php echo htmlentities($faq->Faq_id);?>"><?php echo htmlentities($faq->Question);?> </a>
                                                            <div class="collapse" id="faq2-<?php echo htmlentities($faq->Faq_id);?>">
                                                                <div class="faq-answer"><?php echo htmlentities($faq->Answer);?></div>
                                                            </div>
                                                        </li>
                                                       <?php endforeach;?>
                                                    </ul>
                                                </div>
                                            <?php endforeach;?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="new-question-dialog" aria-labelledby="new-question-dialog" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <?php echo form_open('teachers/faq/new_faq','class="modal-content"');?>
                                    <div class="modal-header p-4">
                                        <h5 class="modal-title">NEW QUESTION</h5><button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="form-group mb-4">
                                            <label class="text-muted mb-3">Category</label>
                                            <div>
                                                <?php
                                                foreach ($categories->result() as $vals):?>
                                                    <label class="radio radio-primary radio-inline check-single" data-toggle="tooltip" data-original-title="<?php echo $vals->Name;?>">
                                                        <input type="radio" name="category" value="<?php echo $vals->Category_id;?>"><span> <?php echo $vals->Name;?></span>
                                                    </label>
                                                <?php endforeach;?>
                                            </div>
                                        </div>
                                        <div class="md-form mb-4">
                                            <input class="md-form-control validate" type="text" name="question">
                                            <label>Question</label>
                                        </div>
                                        <div class="md-form mb-4">
                                            <textarea class="md-form-control auto-resize validate" name="answer"></textarea>
                                            <label>Answer of the question</label>
                                        </div>
                                        <button class="btn btn-primary btn-rounded mr-3" type="submit">Submit</button>
                                    </div>
                                <?php echo form_close();?>
                            </div>
                        </div>
                    </div><!-- END: Page content-->
                </div>