<!-- Main Column Start -->
<?php
$debug = 0;
if ($debug == CONST_ACTIVATE) {
    echo '<pre>';
    print_r($news);
    echo '</pre>';
}
?>
<link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
<link href="http://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN_PLUGINS; ?>bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" >
<div class="main_column">
    <div class="" id="issue_listing">
        <h2><?php echo ucfirst(stripslashes($get_id_by_slug_alias['category_title'])); ?></h2>
        <?php
        if (count($issue_listing_under_category) > 0) {
            foreach ($issue_listing_under_category as $row) { ?>
                <div class="list">
                    <?php if ($row['img_profile'] == '') { ?> 
                        <img width="50" height="50" class="item-pic" src="<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>profile_demo_picture.png">
                    <?php } else { ?>
                        <img width="50" height="50" class="item-pic" src="<?php echo base_url() . CONST_PATH_PROFILE_IMAGE . $row['img_profile'] ?>">
                    <?php } ?>
                    <h3><a href="<?php echo base_url() . FN_ISSUE_TICKET . $row['slug_alias']; ?>"><?php echo ucfirst(stripslashes($row['subject'])); ?></a></h3>
                    <?php if ($row['is_status'] == CONST_ACTIVATE) { ?>
                        <span class="item-status"><span class="badge badge-empty badge-success"></span> Open</span>
                    <?php } else { ?>
                        <span class="item-status"><span class="badge badge-empty badge-danger"></span> Closed</span>
                    <?php } ?>
                    <p><?php echo stripslashes($row['description']) ?></p>
                    <a href="javascript:void(0);" class=""><?php echo ucwords(stripslashes($row['user_name'])); ?></a>
                    <span class="item-label">on <?php echo date_format(new DateTime($row['created']), CONST_DATETIME_FORMAT_DMYHIS); ?></span><br>
                    <span class="text-muted"><?php echo stripslashes($row['user_email_id']) ?></span>

                </div>
                <?php
            }
        } else {
            ?>
            <div class="list issue_not_exists">
                <p>No record found.</p>
            </div>
        <?php } ?>
    </div>
    <div class="ticket_post">
        <form role="form" action="" id="form_sample_1">
            <link href="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN_PLUGINS; ?>bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" >
            <div class="row">    
                <div class="post-comment">
                    <div class="">
                        <div class="">
                            <span ><h3>Report an Issue</h3></span>
                        </div>
                    </div>
                    <div class="">
                        <div>
                            <div id="modal_alert" class="alert display-hide">
                                <button class="close" data-close="alert"></button>
                                <div id="modal_alert_msg"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Subject <span class="required">* </span></label>
                            <div class="">
                                <input type="text" name="subject" class="form-control" > 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Priority <span class="required">* </span></label>
                            <div class="">
                                <select class="form-control select2me" data-placeholder="Select..." name="priority" id="priority">
                                    <option value="">Choose one</option>
                                    <option value="<?php echo CONST_PRIORITY_LOW ?>">Low</option>
                                    <option value="<?php echo CONST_PRIORITY_MEDIUM ?>">Medium</option>
                                    <option value="<?php echo CONST_PRIORITY_HIGH ?>">High</option>
                                    <option value="<?php echo CONST_PRIORITY_URGENT ?>">Urgent</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Description <span class="required">* </span></label>
                            <div class="">
                                <div name="summernote" id="summernote_1"></div>
                            </div>
                        </div>

                        <div class="">
                            <input type="submit" class="margin-top-20 btn blue pull-right" id="Submit" value="Submit">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script> 
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN_PLUGINS; ?>bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN; ?>admin/pages/scripts/components-editors.js"></script>
<script>
    jQuery(document).ready(function () {

        ComponentsEditors.init();
    });
</script>
<script>


    function clearForm() {
        $('.note-editable').html('');
        $('input[name=subject]').val('');
        $('select[name=priority]').val('').trigger("change");
        
        //$('.note-editable').reset();
        // $('input[name=official_only]').attr('checked', false);
    }
    function stripslashes(str) {

        return (str + '').replace(/\\(.?)/g, function (s, n1) {
            switch (n1) {
                case '\\':
                    return '\\';
                case '0':
                    return '\u0000';
                case '':
                    return '';
                default:
                    return n1;
            }
        });
    }
    $(document).ready(function () {

        $('#form_sample_1').on('submit', function (e) {
            var description = $('.note-editable').html();
            var formdata_tmp = new FormData(this);
            formdata_tmp.append("description", description);
            formdata_tmp.append("category_id",<?php echo $get_id_by_slug_alias['category_id'] ?>);

            $.ajax({
                type: 'POST',
                data: formdata_tmp,
                contentType: false,
                cache: false,
                processData: false,
                url: '<?php echo base_url() . FN_FRONT_REPOST_AN_ISSUE; ?>',
                success: function (data) {
                    //alert(data);
                    if ($.trim(data).length) {
                        var resp = $.parseJSON(data);
                        if (resp.success) {
                            // alert(resp.data.id);
                            if ($('.issue_not_exists').hasClass("issue_not_exists")) {
                                $('.issue_not_exists').hide();
                            }
                            $('#issue_listing').append(resp.append_content);
                            $('#modal_alert_msg').html(resp.message);
                            $('#modal_alert').removeClass('display-hide');
                            $('#modal_alert').addClass('display-show');
                            $('#modal_alert').removeClass('alert-danger');
                            $('#modal_alert').addClass('alert-success');
                            clearForm();

                        } else {
                            $('#modal_alert').addClass('display-show');
                            $('#modal_alert').addClass('alert-danger');
                            $('#modal_alert_msg').html(resp.message);
                            $('#modal_alert').removeClass('display-hide');
                        }
                    } else {
                        $('#modal_alert').addClass('display-show');

                        $('#modal_alert_msg').html(<?php echo $this->lang->line("'" . MSG_ERR_AJAX_CALL_FAIL . "'") ?>);
                        $('#modal_alert').removeClass('display-hide');
                    }
                },
                error: function () {
                    $('#modal_alert_msg').html(<?php echo $this->lang->line("'" . MSG_ERR_AJAX_CALL_FAIL . "'") ?>);
                    $('#modal_alert').removeClass('display-hide');
                }
            });
            e.preventDefault();
        });
    });
</script>
<!-- Main Column End -->