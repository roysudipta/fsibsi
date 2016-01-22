<?php
$user = $this->session->userdata('session_user');
// echo '<pre>';
// print_r($user);
// echo '</pre>';exit;
?>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <div class="page-sidebar navbar-collapse collapse">
            <!-- BEGIN SIDEBAR MENU -->
            <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
            <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
            <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
            <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
            <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
            <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
            <ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                <li class="sidebar-toggler-wrapper">
                    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                    <div class="sidebar-toggler">
                    </div>
                    <!-- END SIDEBAR TOGGLER BUTTON -->
                </li>
                <li>
                    <a href="javascript:;">
                        <i class="icon-home"></i>
                        <span class="title">Dashboard</span>
                        <span class="selected"></span>
                        <span class="arrow"></span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        <i class="icon-users"></i>
                        <span class="title">User Management</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="<?php echo base_url() . FN_LIST_USER_ADMIN; ?>"><i class="icon-bar-chart"></i>Admin</a></li>
                        <li><a href="<?php echo base_url() . FN_LIST_USER_OFFICIAL; ?>"><i class="icon-bar-chart"></i>Officials</a></li>
                        <li><a href="<?php echo base_url() . FN_LIST_USER_TEAM; ?>"><i class="icon-bar-chart"></i>Teams</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo base_url() . FN_LIST_COLLEGES; ?>">
                        <i class="fa fa-building-o"></i>
                        <span class="title">College Management</span>
                        <span class="arrow "></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url() . FN_LIST_TEAMS; ?>">
                        <i class="fa fa-building-o"></i>
                        <span class="title">Team Management</span>
                        <span class="arrow "></span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        <i class="icon-calendar"></i>
                        <span class="title">Event Management</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url() . FN_LIST_EVENTS; ?>">Events</a>
                        </li>
                        <li>
                            <a href="layout_horizontal_menu1.html">Dead Lines</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;">
                        <i class="icon-film"></i>
                        <span class="title">Invoice Management</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="<?php echo base_url() . FN_LIST_INVOICE_SETTINGS; ?>">Settings</a></li>
                        <li><a href="<?php echo base_url() . FN_LIST_INVOICE_INVOICES; ?>">Invoices</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;">
                        <i class="icon-docs"></i>
                        <span class="title">File Management</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="<?php echo base_url() . FN_LIST_FILE_TYPES; ?>">File Types</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;">
                        <i class="icon-puzzle"></i>
                        <span class="title">Quiz Management</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="components_pickers.html">Event Management</a></li>
                        <li><a href="components_context_menu.html">Reports</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;">
                        <i class="icon-speech"></i>
                        <span class="title">Ticket Management</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="<?php echo base_url() . FN_LIST_TICKET_CATEGORY; ?>">Category</a></li>
                        <li><a href="<?php echo base_url() . FN_LIST_OPEN_TICKET; ?>">List of open tickets</a></li>
                        <li><a href="<?php echo base_url() . FN_LIST_CLOSED_TICKET; ?>">List of closed tickets</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;">
                        <i class="icon-book-open"></i>
                        <span class="title">Content Management</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="<?php echo base_url() . FN_LIST_PAGES; ?>">Pages</a></li>
                        <li><a href="<?php echo base_url() . FN_LIST_NEWS; ?>">News</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo base_url() . FN_LIST_GALLERY; ?>">
                        <i class="icon-picture"></i>
                        <span class="title">Gallery Management</span>
                        <span class="arrow "></span>
                    </a>

                </li>
            </ul>
            <!-- END SIDEBAR MENU -->
        </div>
    </div>
    <!-- END SIDEBAR -->
