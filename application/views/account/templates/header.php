<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="<?php echo base_url();?>assets/dashboard/logo/<?php echo $general_settings->row()->Site_logo;?>" type="image/png">
    <meta name="keywords" content="<?php echo $general_settings->row()->Site_tag;?>">
    <title><?php echo $general_settings->row()->Site_name;?> || <?php echo $Page_name;?></title>
    <!-- GLOBAL VENDORS-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" media="all">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/dashboard/vendors/feather-icons/feather.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/dashboard/vendors/%40fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/dashboard/vendors/themify-icons/themify-icons.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/dashboard/vendors/line-awesome/css/line-awesome.min.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/dashboard/vendors/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" /><!-- PAGE LEVEL VENDORS-->
    <link href="<?php echo base_url();?>assets/dashboard/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/dashboard/vendors/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/dashboard/vendors/DataTables/datatables.min.css" rel="stylesheet" /><!-- THEME STYLES-->
    <link href="<?php echo base_url();?>assets/dashboard/assets/css/themes/app-sidebar-light.min.css" rel="stylesheet" /><!-- PAGE LEVEL STYLES-->
    <link href="<?php echo base_url();?>assets/dashboard/vendors/toastr/build/toastr.min.css" rel="stylesheet" /><!-- THEME STYLES-->
    <style>.data-widget-icon {
position: absolute;
top: 20px;
right: 20px;
font-size: 40px;
color: #6a89d7;
}
</style>
<style>.pricing-plan {
        text-align: center;
        background-color: #fff;
        border: 1px solid rgba(0, 0, 0, .1);
        padding: 0;
        margin-bottom: 30px;
}
.pricing-plan:not(.active) {
        border-top: 3px solid #d3d6d8;
}
.pricing-price {
        display: flex;
        justify-content: center;
        align-items: baseline;
}
.pricing-price sup {
        font-size: 60%;
        margin-right: 2px;
}
.pricing-features .not-available {
        color: #b4bcc8;
        text-decoration: line-through;
}
.pricing-plan.active {
        box-shadow: 0 5px 20px #d6dee4;
        z-index: 2;
        transform: scale(1.05);
}
sup {
        font-size: 60%;
        margin-right: 2px;
}</style>
</head>
<body>