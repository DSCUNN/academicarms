<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $pagename;?> || <?php echo $Site_name;?></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, maximum-scale=1, minimum-scale=1">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/home/home/css/default.css" media="all">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/home/home/css/flexslider.css">
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=PT+Sans">
<script src="<?php echo base_url();?>assets/home/home/js/jquery-1.7.2.min.js"></script>
<script src="<?php echo base_url();?>assets/home/home/js/jquery.flexslider.js"></script>
<script src="<?php echo base_url();?>assets/home/home/js/default.js"></script>
<!--[if lt IE 9]>
<script src="js/html5.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->
</head>
<body>
<div id="pagewidth">
  <div id="content">
    <section class="row grey">
      <div class="center">
        <h2><img src="<?php echo base_url();?>assets/dashboard/logo/schools/<?php echo htmlentities($school->School_logo);?>"></h2>
      </div>
    </section>
    <section class="row">
      <div class="center">
        <h1>Welcome to <?php echo $Site_name;?></h1>
        <strong class="subHeading">Click any of the Button Below to proceed</strong>
        <div class="buttons"> <a href="<?php echo base_url();?>schools/<?php echo htmlentities($school->School_url);?>/teachers" class="btn btnGreen"><span>Teacher Login</span></a> <span><em>or</em></span> <a href="<?php echo base_url();?>schools/<?php echo htmlentities($school->School_url);?>/checkresult" class="btn btnBlue"><span>Check Result</span></a> </div>
      </div>
    </section>
    
  </div>
  <footer id="footer" align="center">
    <div class="center"><p><?php echo $general_settings->row()->footer_text;?></p></div>
  </footer>
</div>
</body>
</html>