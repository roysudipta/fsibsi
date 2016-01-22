<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//$user_data = $this->session->userdata('session_user');
$debug = false;
//$debug = TRUE;

if ($debug == TRUE) {
    /* echo '<pre>';
      print_r($users);
      echo '</pre>'; */
}
?>

<!-- BEGIN PAGE CONTENT-->
<link href="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN_PLUGINS; ?>bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" >
<div class="row">
    <div class="col-xs-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <?php
                    $priority = '';
                    switch ($TicketDetails['priority']) {
                        case CONST_PRIORITY_LOW:
                            $priority = 'Low';
                            break;
                        case CONST_PRIORITY_MEDIUM:
                            $priority = 'Medium';
                            break;
                        case CONST_PRIORITY_HIGH:
                            $priority = 'High';
                            break;
                        case CONST_PRIORITY_URGENT:
                            $priority = 'Urgent';
                            break;
                    }
                    ?>
                    <i class="icon-tag"></i><?php echo ucfirst(stripslashes($TicketDetails['subject'])); ?>
                    <span class="text-muted help-block">
                        <h6>
                            <strong>Category :</strong>&nbsp<?php echo ucwords(stripslashes($TicketDetails['category_title'])); ?>&nbsp;&nbsp;
                            <strong class="text-danger">Priority :</strong>&nbsp<?php echo $priority; ?>
                        </h6>
                    </span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="general-item-list">
                    <div class="item">
                        <div class="item-head">
                            <div class="item-details">

                                <?php if ($TicketDetails['img_profile'] == '') { ?> 
                                    <img class="item-pic"  src="<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>profile_demo_picture.png">
                                <?php } else { ?>
                                    <img class="item-pic" src="<?php echo base_url() . CONST_PATH_PROFILE_IMAGE . $TicketDetails['img_profile'] ?>">
                                <?php } ?>

                                <a href="javascript:void(0);" class="item-name primary-link"><?php echo ucwords(stripslashes($TicketDetails['user_name'])); ?></a>

                                <span class="item-label">on <?php echo date_format(new DateTime($TicketDetails['created']), CONST_DATETIME_FORMAT_DMYHIS); ?></span><br>

                                <span class="text-muted" style="float: left; margin: -14px 0px -1px 48px;"><?php echo stripslashes($TicketDetails['user_email_id']); ?></span>
                            </div>
                            <?php if ($TicketDetails['is_status'] == CONST_ACTIVATE) { ?>
                                <span class="item-status"><span class="badge badge-empty badge-success"></span> Open</span>
                            <?php } else { ?>
                                <span class="item-status"><span class="badge badge-empty badge-danger"></span> Closed</span>
                            <?php } ?>
                        </div>
                        <div class="item-body">
                            <?php echo ucfirst(stripslashes(trim($TicketDetails['description']))); ?>
                        </div>
                    </div>  
                </div>
            </div>  
        </div>
        <div class="portlet light">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-12" >
                    <div id="modal_alert"  class="reply_delete_alert alert display-hide">
                        <button class="close" data-close="alert"></button>
                        <div id="modal_alert_msg" class="reply_delete_text"></div>
                    </div>
                </div>
                    <div class="col-md-11" id="reply_listing">

                    <?php
                    if (count($listofTicketReplies) > 0) {
                        foreach ($listofTicketReplies as $row) {
                            ?>    
                            <div class="caption reply_div" id="reply_<?php echo $row['reply_id'] ?>">
                                <div class="media">
                                    <div class="portlet-body">
                                        <div class="general-item-list">
                                            <div class="item">
                                                <div class="item-head"><a href="javascript:void();" class="item-status"><i class="fa fa-minus-circle" data-id="<?php echo $row['reply_id']; ?>"></i> </a>
                                                    <div class="item-details">
                                                        <?php if ($row['img_profile'] == '') { ?> 
                                                            <img class="item-pic" src="<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>profile_demo_picture.png">
                                                        <?php } else { ?>
                                                            <img class="item-pic" src="<?php echo base_url() . CONST_PATH_PROFILE_IMAGE . $row['img_profile'] ?>">
                                                        <?php } ?>

                                                        <a href="javascript:void(0);" class="item-name primary-link"><?php echo ucwords(stripslashes($row['user_name'])); ?></a>
                                                        <span class="item-label">on <?php echo date_format(new DateTime($row['created']), CONST_DATETIME_FORMAT_DMYHIS); ?></span><br>
                                                        <span class="text-muted" style="float: left; margin: -14px 0px -1px 48px;"><?php echo stripslashes($row['user_email_id']) ?></span>
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <?php echo ucfirst(stripslashes($row['reply_content'])); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="caption reply_not_exists" >
                            <div class="media">
                                <div class="portlet-body">
                                    <div class="general-item-list">
                                        <div class="item">
                                            <div class="item-body">
                                                <p>There is no reply posted yet.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                        </div>
                    <?php } ?>

                </div>
                <?php if ($TicketDetails['is_status'] == CONST_ACTIVATE) { ?>   
                    <div class="row">
                        <form role="form" action="" id="form_sample_1">
                            <div class="post-comment">
                                <div class="col-md-12">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-10">
                                        <span class="pull-left"><h3>Leave a Reply</h3></span>
                                        <span class="text-danger pull-right">Mark this reply for Official only<input class="icheckbox" type="checkbox" name="official_only" value="<?php echo CONST_ACTIVATE?>"></span>
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
                        </form>
                    </div> 
                <?php } ?>
            </div>
        </div>
    </div>
</div>


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
        $('input[name=official_only]').attr('checked',false);
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
            formdata_tmp.append("ticket_id",<?php echo $TicketDetails['ticket_id'] ?>);

            $.ajax({
                type: 'POST',
                data: formdata_tmp,
                contentType: false,
                cache: false,
                processData: false,
                url: '<?php echo base_url() . FN_POST_REPLY; ?>',
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
