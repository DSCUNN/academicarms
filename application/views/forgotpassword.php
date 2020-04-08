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
    <link href="<?php echo base_url();?>/assets/dashboard/vendors/%40fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>/assets/dashboard/vendors/themify-icons/themify-icons.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>/assets/dashboard/vendors/line-awesome/css/line-awesome.min.css" rel="stylesheet" /><!-- PAGE LEVEL VENDORS-->
    <!-- THEME STYLES-->
    <link href="<?php echo base_url();?>/assets/dashboard/assets/css/app.min.css" rel="stylesheet" /><!-- PAGE LEVEL STYLES-->
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
.auth-wrapper .card {
		max-width: 400px;
		flex-basis: 400px;
		box-shadow: 0 5px 20px #d6dee4;
}
.auth-head-icon {
		position: relative;
		height: 60px;
		width: 60px;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		font-size: 30px;
		background-color: #fff;
		box-shadow: 0 5px 20px #d6dee4;
		border-radius: 50%;
		transform: translateY(-50%);
		z-index: 2;
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
            <div>
                <div class="card">
                    <div class="text-center"><span class="auth-head-icon text-primary"><img src="<?php echo base_url();?>assets/dashboard/logo/<?php echo $general_settings->row()->Site_logo;?>"></span></div>
                    <div class="card-body pt-1">
                        <h4 class="text-center mb-4"><?php echo $Page_name;?></h4>
                        <p class="mb-4 text-center">Enter your email address below and we'll send you password reset instructions.</p>
                        <?php echo form_open('',' id="reset-password-form"');?>
                    <!--SHOWING MESSAGE{SUCCESS OR FAILURE}-->
                    <?php if ($this->session->flashdata('message') != null) {  ?>
                        <?php echo $this->session->flashdata('message'); ?>              
                    <?php } ?>
                    <!--//SHOWING MESSAGE{SUCCESS OR FAILURE}-->
                            <div class="md-form mb-0"><input class="md-form-control" type="email" name="email"><label>Email</label></div><button class="btn btn-primary btn-rounded btn-block mt-4">SUBMIT</button>
                        <?php echo form_close();?>
                    </div>
                </div>
                <div class="text-center text-muted font-13"><?php echo $general_settings->row()->footer_text;?></div>
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
    <script>
        $(function() {
            $('#reset-password-form').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
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