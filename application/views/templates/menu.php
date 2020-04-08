	<!--================Header Menu Area =================-->
	<header class="header_area">
		<div class="main_menu">
			<nav class="navbar navbar-expand-lg navbar-light">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<a class="navbar-brand logo_h" href="index"><img src="<?php echo base_url();?>assets/dashboard/logo/<?php echo $general_settings->row()->Site_logo;?>" alt=""></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
						<ul class="nav navbar-nav menu_nav justify-content-center">
							<li class="nav-item active"><a class="nav-link" href="<?php echo base_url();?>index">Home</a></li>
							<li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
							<li class="nav-item"><a class="nav-link" href="#pricing">Pricing</a></li>
							<li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
							<li class="nav-item"><a class="nav-link" href="<?php echo base_url();?>register">Register</a></li>
							<li class="nav-item"><a class="nav-link" href="<?php echo base_url();?>login">Login</a></li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
	</header>
	<!--================Header Menu Area =================-->