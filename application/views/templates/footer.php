	<?php
	if ($general_settings->row()->Allow_newsletter==1) 
	{
		$div1="col-lg-5 col-sm-6";
		$div2="col-lg-5 col-sm-6";
		$div3="col-lg-2 col-sm-6";
	}
	else
	{
		$div1="col-lg-10 col-sm-6";
		$div2="col-lg-4 col-sm-6";
		$div3="col-lg-2 col-sm-6";
	}?>
	<!--================Footer Area =================-->
	<footer class="footer_area">
		<div class="container">
			<div class="row footer_inner">
				<div class="<?php echo $div1;?>">
					<aside class="f_widget ab_widget">
						<div class="f_title">
							<h3>About Us</h3>
						</div>
						<p><?php echo $general_settings->row()->Footer_about;?>,</p>
						<p><?php echo $general_settings->row()->footer_text;?></p>
					</aside>
				</div>
				<?php
				if ($general_settings->row()->Allow_newsletter==1):?>
				<div class="<?php echo $div2;?>">
					<aside class="f_widget news_widget">
						<div class="f_title">
							<h3>Newsletter</h3>
						</div>
						<p>Stay updated with our latest trends</p>
						<div id="mc_embed_signup">
							<form target="_blank" action="<?php echo $general_settings->row()->Link;?>"
							 method="get" class="subscribe_form relative">
								<div class="input-group d-flex flex-row">
									<input name="EMAIL" placeholder="Enter email address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address '"
									 required="" type="email">
									<button class="btn sub-btn"><span class="lnr lnr-arrow-right"></span></button>
								</div>
								<div class="mt-10 info"></div>
							</form>
						</div>
					</aside>
				</div>
				<?php endif;?>
				<div class="<?php echo $div3;?>">
					<aside class="f_widget social_widget">
						<div class="f_title">
							<h3>Follow Me</h3>
						</div>
						<p>Let us be social</p>
						<ul class="list">
							<li><a href="#"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#"><i class="fa fa-twitter"></i></a></li>
							<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
							<li><a href="#"><i class="fa fa-behance"></i></a></li>
						</ul>
					</aside>
				</div>
			</div>
		</div>
	</footer>
	<!--================End Footer Area =================-->

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="<?php echo base_url();?>assets/home/js/jquery-3.2.1.min.js"></script>
	<script src="<?php echo base_url();?>assets/home/js/popper.js"></script>
	<script src="<?php echo base_url();?>assets/home/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>assets/home/js/stellar.js"></script>
	<script src="<?php echo base_url();?>assets/home/js/jquery.magnific-popup.min.js"></script>
	<script src="<?php echo base_url();?>assets/home/vendors/nice-select/js/jquery.nice-select.min.js"></script>
	<script src="<?php echo base_url();?>assets/home/vendors/isotope/imagesloaded.pkgd.min.js"></script>
	<script src="<?php echo base_url();?>assets/home/vendors/isotope/isotope-min.js"></script>
	<script src="<?php echo base_url();?>assets/home/vendors/owl-carousel/owl.carousel.min.js"></script>
	<script src="<?php echo base_url();?>assets/home/js/jquery.ajaxchimp.min.js"></script>
	<script src="<?php echo base_url();?>assets/home/vendors/counter-up/jquery.waypoints.min.js"></script>
	<script src="<?php echo base_url();?>assets/home/vendors/counter-up/jquery.counterup.min.js"></script>
	<script src="<?php echo base_url();?>assets/home/js/mail-script.js"></script>
	<!--gmaps Js-->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
	<script src="<?php echo base_url();?>assets/home/js/gmaps.min.js"></script>
	<script src="<?php echo base_url();?>assets/home/js/theme.js"></script>
    <script src="<?php echo base_url();?>assets/dashboard/vendors/sweetalert2/dist/sweetalert2.all.min.js"></script><!-- CORE SCRIPTS-->
    <script src="<?php echo base_url();?>assets/dashboard/assets/js/scripts/sweetalert-demo.js"></script>
	<?php if ($this->session->flashdata('message_success') != null) { 
		$mess=$this->session->flashdata('message_success');
	?>
	    <script type="text/javascript">
	    	$(function(){
	    		swal("Message Sent", "<?php echo $mess;?>", "success");
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