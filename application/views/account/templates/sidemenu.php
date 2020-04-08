<div class="page-wrapper">
        <div class="content-wrapper">
            <!-- BEGIN: Sidebar-->
            <div class="page-sidebar custom-scroll" id="sidebar">
                <div class="sidebar-header"><a class="sidebar-brand" href="<?php echo base_url();?>account/index"><img src="<?php echo base_url();?>assets/dashboard/logo/<?php echo htmlentities($general_settings->row()->Site_logo);?>" alt="<?php echo htmlentities($general_settings->row()->Site_name);?>" style="width:150px;"></a><a class="sidebar-brand-mini" href="<?php echo base_url();?>account/index"><?php echo htmlentities($general_settings->row()->Site_shortname);?></a><span class="sidebar-points"><span class="badge badge-success badge-point mr-2"></span><span class="badge badge-danger badge-point mr-2"></span><span class="badge badge-warning badge-point"></span></span></div>
                <ul class="sidebar-menu metismenu">
                    <li class="heading"><span>DASHBOARDS</span></li>
                    <li class="mm-active"><a href="javascript:;"><i class="sidebar-item-icon ft-home"></i><span class="nav-label">Dashboards</span><i class="arrow ti-angle-left"></i></a>
                        <ul class="nav-2-level">
                            <!-- 2-nd level-->
                            <li><a href="<?php echo base_url();?>account/index">Dashboard </a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label">Class</span><i class="arrow ti-angle-left"></i></a>
                        <ul class="nav-2-level">
                            <!-- 2-nd level-->
                            <li><a href="<?php echo base_url();?>account/classes">Class</a></li>
                            <li><a href="<?php echo base_url();?>account/teachers">Teachers</a></li>
                            <li><a href="<?php echo base_url();?>account/subjects">Subjects</a></li>
                            <li><a href="<?php echo base_url();?>account/subject_combination">Subject Combinations</a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:;"><i class="sidebar-item-icon ft-users"></i><span class="nav-label">Students</span><i class="arrow ti-angle-left"></i></a>
                        <ul class="nav-2-level">
                            <!-- 2-nd level-->
                            <li><a href="<?php echo base_url();?>account/students">Students</a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:;"><i class="sidebar-item-icon ft-layers"></i><span class="nav-label">Results</span><i class="arrow ti-angle-left"></i></a>
                        <ul class="nav-2-level">
                            <!-- 2-nd level-->
                            <li><a href="<?php echo base_url();?>account/results">Results</a></li>
                            <li><a href="<?php echo base_url();?>account/grade">Grades</a></li>
                            <li><a href="<?php echo base_url();?>account/result_pins">Result Pins</a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:;"><i class="sidebar-item-icon ft-package"></i><span class="nav-label">Schools</span><i class="arrow ti-angle-left"></i></a>
                        <ul class="nav-2-level">
                            <!-- 2-nd level-->
                            <li><a href="<?php echo base_url();?>account/schools">Schools</a></li>
                            <li><a href="<?php echo base_url();?>account/school_type">School Type</a></li>
                            <li><a href="<?php echo base_url();?>account/academic_sessions">Sessions</a></li>
                            <li><a href="<?php echo base_url();?>account/semester">Semester/Term</a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:;"><i class="sidebar-item-icon ft-sliders"></i><span class="nav-label">Pricing</span><i class="arrow ti-angle-left"></i></a>
                        <ul class="nav-2-level">
                            <!-- 2-nd level-->
                            <li><a href="<?php echo base_url();?>account/pricing">Pricing</a></li>
                            <li><a href="<?php echo base_url();?>account/payments">Payments</a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:;"><i class="sidebar-item-icon ft-user"></i><span class="nav-label">Profiles</span><i class="arrow ti-angle-left"></i></a>
                        <ul class="nav-2-level">
                            <!-- 2-nd level-->
                            <li><a href="<?php echo base_url();?>account/profile">Profile</a></li>
                            <li><a href="<?php echo base_url();?>account/account">Account Settings</a></li>
                        </ul>
                    </li>
                    <!--<li><a href="<?php echo base_url();?>account/suppport"><i class="sidebar-item-icon ft-headphones"></i><span class="nav-label">Support</span></a></li>-->
                    <li><a href="<?php echo base_url();?>account/faq"><i class="sidebar-item-icon ft-help-circle"></i><span class="nav-label">FAQ</span></a></li>
                    <li><a href="<?php echo base_url();?>account/documentation"><i class="sidebar-item-icon ft-briefcase"></i><span class="nav-label">Documentation</span></a></li>
                    <li><a href="<?php echo base_url();?>logout"><i class="sidebar-item-icon ft-power"></i><span class="nav-label">Logout</span></a></li>
                </ul>
            </div><!-- END: Sidebar-->