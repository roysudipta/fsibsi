<div class="row">
    <div class="col-md-12">
        <script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN; ?>admin/pages/scripts/table-managed.js"></script>
        <div id="general_alert" class="" style="display:none;">
            <button class="close" data-close="alert"></button>
            <div id="general_alert_msg"></div>
        </div>
        <div class="portlet light">
            <!-- PROJECT HEAD -->
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bar-chart font-green-sharp hide"></i>
                    <span class="caption-helper"><span class="caption-subject font-green-sharp bold uppercase">Gallery Management</span><img class="gallery_loader" style="display:none;" src="<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>loading.gif" ></span>
                </div>

            </div>
            <!-- end PROJECT HEAD -->

            <script>
                function getChildElements(main_event, parent_id, level) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url() . FN_GALLERY_ALBUMS ?>",
                        data: {main_event: main_event, parent_id: parent_id, level: level},
                        beforeSend: function () {
                            $('.gallery_loader').show();
                        },
                        success: function (data) {

                            //alert(data);
                            $('#get_content').html(data);
                        },
                        complete: function () {
                            $('.gallery_loader').hide();
                        }
                    });
                }
            </script>

            <div class="portlet-body" >

                <div class="row">

                    <div id="get_content">
                        <span class="caption-subject font-green-sharp bold ">Gallery</span><br>

                        <div class="col-xs-12 col-md-6">
                            <a href="javascript:void(0);" class="parent_album" onclick="getChildElements('<?php echo CONST_FSI_SHORT ?>', 0, 0);"><img src="<?php echo base_url() . CONST_PATH_LOGO . CONST_FSI_LOGO; ?>" alt="" class="img-responsive"><span><?php echo ucwords(CONST_FSI_SHORT) ?></span></a>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <a href="javascript:void(0);" class="parent_album" onclick="getChildElements('<?php echo CONST_BSI_SHORT ?>', 0, 0);"><img src="<?php echo base_url() . CONST_PATH_LOGO . CONST_BSI_LOGO; ?>" alt="" class="img-responsive"><span><?php echo ucwords(CONST_BSI_SHORT) ?></span></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
