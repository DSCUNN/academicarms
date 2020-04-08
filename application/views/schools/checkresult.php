
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $pagename;?> || <?php echo $Site_name;?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="<?php echo base_url();?>assets/home/checkingresult/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/home/checkingresult/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/home/checkingresult/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/home/checkingresult/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/home/checkingresult/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/home/checkingresult/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/home/checkingresult/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/home/checkingresult/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/home/checkingresult/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/home/checkingresult/vendor/noui/nouislider.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/home/checkingresult/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/home/checkingresult/css/main.css">
	<link href="<?php echo base_url();?>assets/dashboard/vendors/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" />
<!--===============================================================================================-->
</head>
<body>


	<div class="container-contact100">
		<div class="wrap-contact100">
			<?php echo form_open("schools/$school->School_url/checkresult/authenticate",'class="contact100-form validate-form"');?>
				<span class="contact100-form-title">
					<?php echo $pagename;?>
				</span>
					<!--SHOWING MESSAGE{SUCCESS OR FAILURE}-->
                    <?php if ($this->session->flashdata('message') != null) {  ?>                            
                        <?php echo $this->session->flashdata('message'); ?>                                  
                    <?php } ?>
                    <!--//SHOWING MESSAGE{SUCCESS OR FAILURE}-->
				<div class="wrap-input100 validate-input bg1" data-validate="Enter Your Result Pin Code">
					<span class="label-input100">Pin Number *</span>
					<input class="input100" type="password" name="pin" placeholder="Enter Your Result Pin">
				</div>

				<div class="wrap-input100 validate-input bg1" data-validate="Enter Your Serial Code">
					<span class="label-input100">Serial Number *</span>
					<input class="input100" type="text" name="serial" placeholder="Enter Your Serial Code">
				</div>

				<div class="wrap-input100 validate-input bg1 rs1-wrap-input100" data-validate = "Select An Academic Session">
					<span class="label-input100">Academic Session*</span>
					<select class="js-select2" name="session">
						<option value="">Please choose</option>
						<?php 
						foreach ($sessions->result() as $session):?>
						<option value="<?php echo htmlentities($session->Session_id);?>"><?php echo htmlentities($session->Name);?></option>
						<?php endforeach;?>
					</select>
					<div class="dropDownSelect2"></div>
				</div>

				<div class="wrap-input100 validate-input bg1 rs1-wrap-input100" data-validate = "Select A Semester/Term">
					<span class="label-input100">Semester/Term*</span>
					<select class="js-select2" name="semester">
						<option value="">Please choose</option>
						<?php 
						foreach ($semesters->result() as $semester):?>
						<option value="<?php echo htmlentities($semester->Semester_id);?>"><?php echo htmlentities($semester->Name);?></option>
						<?php endforeach;?>
					</select>
					<div class="dropDownSelect2"></div>
				</div>


				<div class="wrap-input100 input100-select bg1" data-validate = "Select A Class">
					<span class="label-input100">Select Class *</span>
					<div>
						<select class="js-select2" name="class">
							<option value="">Please choose</option>
							<?php 
							foreach ($classes->result() as $class):?>
							<option value="<?php echo htmlentities($class->Class_id);?>"><?php echo htmlentities($class->Name);?></option>
							<?php endforeach;?>
						</select>
						<div class="dropDownSelect2"></div>
					</div>
				</div>
				<?php 
				if ($general_settings->row()->Result_type==2) {?>
				<div class="wrap-input100 input100-select bg1" data-validate = "Select A Result Tye">
					<span class="label-input100">Select Result Type *</span>
					<div>
						<select class="js-select2" name="result_typ">
							<option value="">Please choose</option>
							<?php 
							foreach ($result_types->result() as $type):?>
							<option value="<?php echo htmlentities($type->Type_id);?>"><?php echo htmlentities($type->Name);?></option>
							<?php endforeach;?>
						</select>
						<div class="dropDownSelect2"></div>
					</div>
				</div>
				<?php }?>
				<div class="wrap-input100 validate-input bg1" data-validate="Enter Your Username">
					<span class="label-input100">Username *</span>
					<input class="input100" type="text" name="username" placeholder="Enter Your Username">
				</div>

				<div class="container-contact100-form-btn">
					<button class="contact100-form-btn">
						<span>
							Submit
							<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
						</span>
					</button>
				</div>
			<?php echo form_close();?>
		</div>
	</div>



<!--===============================================================================================-->
	<script src="<?php echo base_url();?>assets/home/checkingresult/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url();?>assets/home/checkingresult/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url();?>assets/home/checkingresult/vendor/bootstrap/js/popper.js"></script>
	<script src="<?php echo base_url();?>assets/home/checkingresult/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url();?>assets/home/checkingresult/vendor/select2/select2.min.js"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});


			$(".js-select2").each(function(){
				$(this).on('select2:close', function (e){
					if($(this).val() == "Please chooses") {
						$('.js-show-service').slideUp();
					}
					else {
						$('.js-show-service').slideUp();
						$('.js-show-service').slideDown();
					}
				});
			});
		})
	</script>
<!--===============================================================================================-->
	<script src="<?php echo base_url();?>assets/home/checkingresult/vendor/daterangepicker/moment.min.js"></script>
	<script src="<?php echo base_url();?>assets/home/checkingresult/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url();?>assets/home/checkingresult/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url();?>assets/home/checkingresult/vendor/noui/nouislider.min.js"></script>
	<script>
	    var filterBar = document.getElementById('filter-bar');

	    noUiSlider.create(filterBar, {
	        start: [ 1500, 3900 ],
	        connect: true,
	        range: {
	            'min': 1500,
	            'max': 7500
	        }
	    });

	    var skipValues = [
	    document.getElementById('value-lower'),
	    document.getElementById('value-upper')
	    ];

	    filterBar.noUiSlider.on('update', function( values, handle ) {
	        skipValues[handle].innerHTML = Math.round(values[handle]);
	        $('.contact100-form-range-value input[name="from-value"]').val($('#value-lower').html());
	        $('.contact100-form-range-value input[name="to-value"]').val($('#value-upper').html());
	    });
	</script>
<!--===============================================================================================-->
	<script src="<?php echo base_url();?>assets/home/checkingresult/js/main.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
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
