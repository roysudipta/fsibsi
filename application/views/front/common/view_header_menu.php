<?php
if (!empty($this->uri->segment(1))) {
    $class = 'style="background-color: #f5ff12;"';
} else {
    $class = '';
}
?>                                
<nav <?php echo $class; ?>>
    <ul class="clearfix">
        <?php if (empty($this->session_variable['id'])) { ?>
            <li><a href="<?php echo CONST_APP_SITE_LINK; ?>">Home</a></li>
            <?php
        } else {
            if ($this->session_variable['is_type'] == CONST_USER_ADMIN) {
                ?>
                <li><a href="<?php echo base_url() . FN_ADMIN_DASHBOARD; ?>">Dashboard</a></li>
            <?php } else { ?>
                <li><a href="<?php echo base_url() . FN_CAPTAIN_DASHBOARD; ?>">Dashboard</a></li>
                <?php
            }
        }
        ?>
        <li><a href="#">Events</a></li>
        <li><a href="#">Gallery</a></li>
        <?php if (empty($this->session_variable['id'])) { ?>
            <li><a href="<?php echo CONST_FSI_LINK; ?>">Formula Student India™</a></li>
            <li><a href="<?php echo CONST_BSI_LINK; ?>">Baja Student India™</a></li>
        <?php } ?>
        <?php if (!empty($this->session_variable['id'])) { ?>   
            <li><a href="<?php echo base_url() . FN_LIST_REPORT_TOPICS; ?>">Issues</a></li>
            <li><a href="<?php echo '#' ?>">File Submission</a></li>
            <li><a href="#">Contact Us</a></li>
            <li><a href="<?php echo base_url() . FN_LOGOUT ?>">Logout</a></li>
        <?php } ?>

        <?php if (empty($this->session_variable['id'])) { ?>
            <li><a href="#">Contact Us</a></li>
            <li><a href="<?php echo base_url() . FN_LOGIN ?>">Login</a></li>
            <li><a href="<?php echo base_url() . FN_REGISTRATION; ?>">Register</a></li>

        <?php } ?>
    </ul>
</nav>
</div>
</header>
<!-- Header End -->