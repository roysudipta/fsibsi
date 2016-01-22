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
    
        <div class="" id="reply_listing">
            <h2><?php echo ucfirst(stripslashes($get_id_by_slug_alias['subject'])); ?></h2>
            <?php
            if (count($reply_listing_under_ticket) > 0) {
                foreach ($reply_listing_under_ticket as $row) {
                    //$get_all_replies = $this->Ticketing_model->get_all_replies($row->ticket_id)
                    ?>
                    <div class="reply_list" id="reply_div">
                        <?php if ($row['img_profile'] == '') { ?> 
                            <img width="50" height="50" class="item-pic" src="<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>profile_demo_picture.png">
                        <?php } else { ?>
                            <img width="50" height="50" class="item-pic" src="<?php echo base_url() . CONST_PATH_PROFILE_IMAGE . $row['img_profile'] ?>">
                        <?php } ?>

                        <p><?php echo ucfirst(stripslashes($row['reply_content'])) ?></p>
                        <a href="javascript:void(0);" class=""><?php echo ucwords(stripslashes($row['user_name'])); ?></a>
                        <span class="item-label">on <?php echo date_format(new DateTime($row['created']), CONST_DATETIME_FORMAT_DMYHIS); ?></span><br>
                        <span class="text-muted"><?php echo stripslashes($row['user_email_id']) ?></span>

                    </div>
                    <hr>
                    <?php
                }
            } else {
                ?>
                <div class="reply_lists reply_not_exists">
                    <p>No record found.</p>
                </div>
            <?php } ?>
        </div>
    
<?php if($get_id_by_slug_alias['is_status']==CONST_ACTIVATE){?>
    
        <form role="form" action="" id="form_sample_1">
            <link href="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN_PLUGINS; ?>bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" >
            <div class="row">    
                <div class="post-comment">
                    <div class="col-md-12">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <span class="pull-left"><h3>Leave a Reply</h3></span>
                            
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">        
                            <div class="col-md-10" style="padding-left: 28px; width: 82%;">
                                <div id="modal_alert" class="alert display-hide">
                                    <button class="close" data-close="alert"></button>
                                    <div id="modal_alert_msg"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <div name="summernote" id="summernote_1"></div>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <input type="submit" class="margin-top-20 btn blue pull-right" id="Submit" value="Give a Reply">
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
     
<?php }?>
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

            //$(".reply_div").clone().insertAfter("div.reply_div:last");


            var reply_content = $('.note-editable').html();

            var formdata_tmp = new FormData(this);
            formdata_tmp.append("reply_content", reply_content);
            formdata_tmp.append("ticket_id",<?php echo $get_id_by_slug_alias['ticket_id'] ?>);

            $.ajax({
                type: 'POST',
                data: formdata_tmp,
                contentType: false,
                cache: false,
                processData: false,
                url: '<?php echo base_url() . FN_FRONT_POST_REPLY; ?>',
                success: function (data) {
                    //alert(data);
                    if ($.trim(data).length) {
                        var resp = $.parseJSON(data);
                        if (resp.success) {
                            // alert(resp.data.id);
                            if ($('.reply_not_exists').hasClass("reply_not_exists")) {
                                $('.reply_not_exists').hide();

                            }

                            $('#reply_listing').append(resp.append_content);
                            $('#modal_alert_msg').html(resp.message);
                            $('#modal_alert').removeClass('display-hide');
                            $('#modal_alert').addClass('display-show');
                            $('#modal_alert').removeClass('alert-danger');
                            $('#modal_alert').addClass('alert-success');

                            //$(append_content).appendTo($( "#reply_listing>div.reply_div:last" ) );

                            // alert(append_content);
                            //$(append_content).insertAfter($("#reply_listing"));
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


        $('body').on('click', '.fa-minus-circle', function () {
            var id = $(this).data('id');

            // var parentTr = $(this).parents('div');
            //alert('fdfg');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . FN_TICKET_REPLY_DELETE_DETAILS; ?>" + id,
                success: function (data) {
                    if ($.trim(data).length) {
                        var resp = $.parseJSON(data);

                        if (resp.success) {
                            $('.reply_delete_text').html(resp.message);
                            $('.reply_delete_alert').removeClass('display-hide');
                            $('.reply_delete_alert').removeClass('alert-danger');
                            $('.reply_delete_alert').addClass('alert-success');
                            $('#reply_' + id).remove();
                            if ($('.reply_div').hasClass("reply_div")) {
                                $('.reply_not_exists').hide();
                            } else
                            {
                                if ($('.reply_not_exists').hasClass("reply_not_exists")) {
                                    $('.reply_not_exists').show();
                                } else
                                {
                                    var html_content = '<div class="caption reply_not_exists" ><div class="media"><div class="portlet-body"><div class="general-item-list"><div class="item"><div class="item-body"><p>There is no reply posted yet.</p></div></div></div></div></div></div>';
                                    $('#reply_listing').append(html_content);
                                    $('.reply_not_exists').show();
                                }


                            }

                        } else {
                            $('.reply_delete_alert').html(resp.message);
                            $('.reply_delete_alert').removeClass('display-hide');
                        }
                    } else {
                        $('.reply_delete_text').html(<?php echo $this->lang->line("'" . MSG_ERR_AJAX_CALL_FAIL . "'") ?>);
                        $('.reply_delete_alert').removeClass('display-hide');
                    }
                },
                error: function () {
                    $('.reply_delete_text').html(<?php echo $this->lang->line("'" . MSG_ERR_AJAX_CALL_FAIL . "'") ?>);
                    $('.reply_delete_alert').removeClass('display-hide');
                }
            });
        });



    });
</script>
<!-- Main Column End -->