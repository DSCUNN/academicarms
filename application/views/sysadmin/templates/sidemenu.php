    <div class="page-wrapper">
        <div class="content-wrapper">
            <!-- BEGIN: Sidebar-->
            <div class="page-sidebar custom-scroll" id="sidebar" >
                <div class="sidebar-header"><a class="sidebar-brand" href="<?php echo base_url();?>sysadmin/index"><img src="<?php echo base_url();?>assets/dashboard/logo/<?php echo $general_settings->row()->Site_logo;?>" style="width:150px;"></a><a class="sidebar-brand-mini" href="<?php echo base_url();?>sysadmin/index"><?php echo htmlentities($general_settings->row()->Site_shortname);?></a><span class="sidebar-points"><span class="badge badge-success badge-point mr-2"></span><span class="badge badge-danger badge-point mr-2"></span><span class="badge badge-warning badge-point"></span></span></div>
                <ul class="sidebar-menu metismenu">
                    <li class="heading"><span>DASHBOARDS</span></li>
                    <li><a href="<?php echo base_url();?>sysadmin/index"><i class="sidebar-item-icon ft-home"></i><span class="nav-label">Home</span></a></li>
                    <li><a href="javascript:;"><i class="sidebar-item-icon ft-trending-up"></i><span class="nav-label">Accounts</span><i class="arrow ti-angle-left"></i></a>
                        <ul class="nav-2-level">
                            <!-- 2-nd level-->
                            <li><a href="<?php echo base_url();?>sysadmin/organizers/">Organizers</a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label">Results</span><i class="arrow ti-angle-left"></i></a>
                        <ul class="nav-2-level">
                            <!-- 2-nd level-->
                            <li><a href="<?php echo base_url();?>sysadmin/result_pins">Result Pins</a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:;"><i class="sidebar-item-icon ft-layers"></i><span class="nav-label">Payments</span><i class="arrow ti-angle-left"></i></a>
                        <ul class="nav-2-level">
                            <!-- 2-nd level-->
                            <li><a href="<?php echo base_url();?>sysadmin/payments">All Payments</a></li>
                            <li><a href="<?php echo base_url();?>sysadmin/payment_methods">Payment Methods</a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:;"><i class="sidebar-item-icon ft-package"></i><span class="nav-label">Cms Settings</span><i class="arrow ti-angle-left"></i></a>
                        <ul class="nav-2-level">
                            <!-- 2-nd level-->
                            <li><a href="<?php echo base_url();?>sysadmin/faq_category">Faq Category</a></li>
                            <li><a href="<?php echo base_url();?>sysadmin/faq">Faq</a></li>
                            <li><a href="<?php echo base_url();?>sysadmin/faq_requests">Faq Requests</a></li>
                            <li><a href="<?php echo base_url();?>sysadmin/pricing">Pricing </a></li>
                            <li><a href="<?php echo base_url();?>sysadmin/general_settings">General Settings </a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:;"><i class="sidebar-item-icon ft-user"></i><span class="nav-label">Profile</span><i class="arrow ti-angle-left"></i></a>
                        <ul class="nav-2-level">
                            <!-- 2-nd level-->
                            <li><a href="<?php echo base_url();?>sysadmin/account">Account Settings</a></li>
                            <li><a href="<?php echo base_url();?>sysadmin/profile">Profile</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo base_url();?>sysadmin/logout"><i class="sidebar-item-icon ft-power"></i><span class="nav-label">Logout</span></a></li>
                </ul>
            </div><!-- END: Sidebar-->