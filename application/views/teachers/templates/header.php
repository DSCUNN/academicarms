<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="<?php echo $general_settings->row()->Site_tag;?>">
    <title><?php echo htmlentities($Site_name);?>|<?php echo htmlentities($Page_name);?></title><!-- GLOBAL VENDORS-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" media="all">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link rel="icon" href="<?php echo base_url();?>assets/dashboard/logo/schools/<?php echo htmlentities($school_exists->School_logo);?>" type="image/png">
    <meta name="description" content="<?php echo htmlentities($school_exists->School_description);?>">
    <link href="<?php echo base_url();?>assets/dashboard/vendors/feather-icons/feather.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/dashboard/vendors/%40fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/dashboard/vendors/themify-icons/themify-icons.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/dashboard/vendors/line-awesome/css/line-awesome.min.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/dashboard/vendors/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" /><!-- PAGE LEVEL VENDORS-->
    <link href="<?php echo base_url();?>assets/dashboard/vendors/DataTables/datatables.min.css" rel="stylesheet" /><!-- THEME STYLES-->
    <link href="<?php echo base_url();?>assets/dashboard/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" /><!-- THEME STYLES-->
    <link href="<?php echo base_url();?>assets/dashboard/assets/css/app.min.css" rel="stylesheet" /><!-- PAGE LEVEL STYLES-->
    <link href="<?php echo base_url();?>assets/dashboard/vendors/toastr/build/toastr.min.css" rel="stylesheet" /><!-- THEME STYLES-->
    <style>.tasks-list>li {
padding-right: 0;
padding-left: 0;
padding: .8rem 1.5rem;
}
.task-actions {
display: none;
position: absolute;
right: 20px;
top: 50%;
margin-top: -15px;
}
.task-actions>a.dropdown-toggle {
color: #aaa;
height: 30px;
width: 30px;
display: inline-flex;
align-items: center;
justify-content: center;
}
.task-info {
padding-left: 34px;
}
.tasks-list>li .checkbox input:checked~span {
text-decoration: line-through;
}
.tasks-list>li:hover .task-actions {
display: block
}
</style>
</head>

<body>