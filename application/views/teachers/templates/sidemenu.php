<div class="page-wrapper">
        <div class="content-wrapper">
            <!-- BEGIN: Sidebar-->
            <div class="page-sidebar custom-scroll" id="sidebar">
                <div class="sidebar-header"><a class="sidebar-brand" href="<?php echo base_url();?>teachers/account"><img src="<?php echo base_url();?>assets/dashboard/logo/schools/<?php echo htmlentities($school_exists->School_logo);?>" alt="<?php echo htmlentities($general_settings->row()->Site_name);?>" style="width:150px;"></a><a class="sidebar-brand-mini" href="<?php echo base_url();?>teachers/account"><?php echo htmlentities($general_settings->row()->Site_shortname);?></a><span class="sidebar-points"><span class="badge badge-success badge-point mr-2"></span><span class="badge badge-danger badge-point mr-2"></span><span class="badge badge-warning badge-point"></span></span></div>
                <ul class="sidebar-menu metismenu">
                    <li class="heading"><span>DASHBOARDS</span></li>
                    <li class="mm-active"><a href="javascript:;"><i class="sidebar-item-icon ft-home"></i><span class="nav-label">Dashboards</span><i class="arrow ti-angle-left"></i></a>
                        <ul class="nav-2-level">
                            <!-- 2-nd level-->
                            <li><a href="<?php echo base_url();?>teachers/account">Dashboard </a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label">Class</span><i class="arrow ti-angle-left"></i></a>
                        <ul class="nav-2-level">
                            <!-- 2-nd level-->
                            <li><a href="<?php echo base_url();?>teachers/students">Students</a></li>
                            <li><a href="<?php echo base_url();?>teachers/subjects">Subjects</a></li>
                            <li><a href="<?php echo base_url();?>teachers/subject_combination">Subject Combinations</a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:;"><i class="sidebar-item-icon ft-layers"></i><span class="nav-label">Results</span><i class="arrow ti-angle-left"></i></a>
                        <ul class="nav-2-level">
                            <!-- 2-nd level-->
                            <li><a href="<?php echo base_url();?>teachers/results">Results</a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:;"><i class="sidebar-item-icon ft-user"></i><span class="nav-label">Profiles</span><i class="arrow ti-angle-left"></i></a>
                        <ul class="nav-2-level">
                            <!-- 2-nd level-->
                            <li><a href="<?php echo base_url();?>teachers/profile">Profile</a></li>
                            <li><a href="<?php echo base_url();?>teachers/accounts">Account Settings</a></li>
                        </ul>
                    </li>
                    <!--<li><a href="<?php echo base_url();?>teachers/suppport"><i class="sidebar-item-icon ft-headphones"></i><span class="nav-label">Support</span></a></li>-->
                    <li><a href="<?php echo base_url();?>teachers/faq"><i class="sidebar-item-icon ft-help-circle"></i><span class="nav-label">FAQ</span></a></li>
                    <li><a href="<?php echo base_url();?>teachers/logout"><i class="sidebar-item-icon ft-power"></i><span class="nav-label">LOGOUT</span></a></li>
                    
                </ul>
            </div><!-- END: Sidebar-->