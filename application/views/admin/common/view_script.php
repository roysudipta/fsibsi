<!-- BEGIN CORE PLUGINS -->
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN_PLUGINS; ?>jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN_PLUGINS; ?>jquery-migrate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN_PLUGINS; ?>jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN_PLUGINS; ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN_PLUGINS; ?>bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN_PLUGINS; ?>jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN_PLUGINS; ?>jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN_PLUGINS; ?>jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN_PLUGINS; ?>uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN_PLUGINS; ?>bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN_PLUGINS; ?>datatables/media/js/jquery.dataTables.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN_PLUGINS; ?>datatables/plugins/bootstrap/dataTables.bootstrap.js" type="text/javascript" ></script>
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN_PLUGINS;?>bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN_PLUGINS;?>bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN_PLUGINS;?>select2/select2.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN; ?>global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN; ?>admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN; ?>admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN; ?>admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN; ?>admin/pages/scripts/index.js" type="text/javascript"></script>
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN; ?>admin/pages/scripts/tasks.js" type="text/javascript"></script>
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN; ?>admin/pages/scripts/components-pickers.js"></script>


<script>
    jQuery(document).ready(function () {
        Metronic.init(); // init metronic core componets
        Layout.init(); // init layout
        QuickSidebar.init(); // init quick sidebar
        Demo.init(); // init demo features
        Index.init();
        Index.initDashboardDaterange();
        Index.initJQVMAP(); // init index page's custom scripts
        Index.initCalendar(); // init index page's custom scripts
        Index.initCharts(); // init index page's custom scripts
        Index.initChat();
        Index.initMiniCharts();
        Tasks.initDashboardWidget();
        ComponentsPickers.init();
    });
</script>
<!-- END JAVASCRIPTS -->