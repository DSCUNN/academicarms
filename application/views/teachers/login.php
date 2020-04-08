<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="<?php echo $general_settings->row()->Site_tag;?>">
    <title><?php echo $Site_name;?> || <?php echo $Page_name;?></title><!-- GLOBAL VENDORS-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700%7CRoboto:300,400,500,600,700" media="all">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/dashboard/vendors/%40fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/dashboard/vendors/themify-icons/themify-icons.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/dashboard/vendors/line-awesome/css/line-awesome.min.css" rel="stylesheet" /><!-- PAGE LEVEL VENDORS-->
    <!-- THEME STYLES-->
    <link href="<?php echo base_url();?>assets/dashboard/assets/css/app.min.css" rel="stylesheet" /><!-- PAGE LEVEL STYLES-->
    <link href="<?php echo base_url();?>assets/dashboard/vendors/toastr/build/toastr.min.css" rel="stylesheet" /><!-- THEME STYLES-->
    <link href="<?php echo base_url();?>assets/dashboard/vendors/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" />
    <style>body {
	background-color: #eff4ff;
}

.auth-wrapper {
	flex: 1 0 auto;
	display: flex;
	align-items: center;
	justify-content: center;
    padding: 50px 15px 30px 15px;
}

.auth-content {
	max-width: 400px;
	flex-basis: 400px;
    box-shadow: 0 5px 20px #d6dee4;
}
.home-link {
	position: absolute;
	left: 5px;
	top: 10px;
}
</style>
</head>

<body>
    <div class="page-wrapper">
        <div class="auth-wrapper">
            <div class="card auth-content mb-0">
                <div class="card-body py-5">
                    <?php 
                    if ($general_settings->row()->Maintenance==1):?>
                    <div class="alert alert-danger" role="alert">We are currently undergoing a site maintenance process and will be back shortly. Registration process is currentlly turned off.</div>
                    <?php endif;?>
                    <!--SHOWING MESSAGE{SUCCESS OR FAILURE}-->
                    <?php if ($this->session->flashdata('message') != null) {  ?>
                        <?php echo $this->session->flashdata('message'); ?>              
                    <?php } ?>
                    <!--//SHOWING MESSAGE{SUCCESS OR FAILURE}-->
                    <div class="text-center mb-5">
                        <h3 class="mb-3 text-primary"><img src="<?php echo base_url();?>assets/dashboard/logo/schools/<?php echo $school_exists->School_logo;?>"></h3>
                        <div class="font-18 text-center">Account Signin</div>
                    </div>
                    <?php echo form_open("$school_exists->School_url/teachers/login/authenticate",'id="register-form"');?>
                        <div class="mb-4">
                            <div class="md-form mb-0"><input class="md-form-control" type="email" name="email"><label>Email</label></div>
                        </div>
                        <div class="mb-4">
                            <div class="md-form mb-0"><input class="md-form-control" id="password" type="password" name="password"><label>Password</label></div>
                        </div>
                       <div class="flexbox mb-5"><label class="ui-switch switch-solid"><input type="checkbox" checked=""><span class="ml-0"></span> Remember Me</label><a href="<?php echo base_url();?>teachers/login/forgotpassword">Forgot password?</a></div><button class="btn btn-primary btn-rounded btn-block" type="submit">LOGIN</button>
                    <?php echo form_close();?>
                </div>
            </div><a class="btn btn-link home-link" href="<?php echo base_url();?>index"><span class="btn-icon"><i class="ti-arrow-left font-20"></i>Go Home</span></a>
        </div>
    </div><!-- BEGIN: Page backdrops-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div><!-- END: Page backdrops-->
    <!-- CORE PLUGINS-->
    <script src="<?php echo base_url();?>/assets/dashboard/vendors/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url();?>/assets/dashboard/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script><!-- PAGE LEVEL PLUGINS-->
    <script src="<?php echo base_url();?>/assets/dashboard/vendors/jquery-validation/dist/jquery.validate.min.js"></script><!-- CORE SCRIPTS-->
    <script src="<?php echo base_url();?>/assets/dashboard/assets/js/app.min.js"></script><!-- PAGE LEVEL SCRIPTS-->
    <script src="<?php echo base_url();?>/assets/dashboard/vendors/toastr/build/toastr.min.js"></script><!-- CORE SCRIPTS-->
    <script src="<?php echo base_url();?>/assets/dashboard/assets/js/app.min.js"></script><!-- PAGE LEVEL SCRIPTS-->
    <script>
        $(function() {
            $('#register-form').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                errorClass: 'invalid-feedback',
                validClass: 'valid-feedback',
                errorPlacement: function(error, element) {
                    if (element.hasClass('md-form-control')) {
                        error.insertAfter(element.closest('.md-form'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function(e) {
                    $(e).addClass("invalid").removeClass('valid');
                },
                unhighlight: function(e) {
                    $(e).removeClass("invalid").addClass('valid');
                },
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            toastr["info"]("Welcome back, please Signin to continue", "Login Message")
            toastr.options = {
              "closeButton": true,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-full-width",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "1000",
              "hideDuration": "1000",
              "timeOut": "10000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
        });
    </script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/sweetalert2/dist/sweetalert2.all.min.js"></script><!-- CORE SCRIPTS-->
    <script src="<?php echo base_url();?>assets/dashboard/assets/js/scripts/sweetalert-demo.js"></script>
    <?php if ($this->session->flashdata('message_success') != null) { 
        $mess=$this->session->flashdata('message_success');
    ?>
        <script type="text/javascript">
            $(function(){
                swal("SUCCESS", "<?php echo $mess;?>", "success");
            });
        </script>
    <?php } ?>
    <?php if ($this->session->flashdata('message_error') != null) {
        $mess=$this->session->flashdata('message_error');
    ?>
        <script type="text/javascript">
            $(function(){
                swal("Error", "<?php echo $mess;?>", "error");
            });
        </script>
    <?php } ?>
</body>
</html>