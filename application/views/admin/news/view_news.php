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
    echo '<pre>';
    print_r($users);
    echo '</pre>';
}
?>
<script type="text/javascript">
    $(document).ready(function (e) {
        var _URL = window.URL || window.webkitURL;
        $("#img_file").change(function (e) {
            var image, file;
            if ((file = this.files[0])) {
                image = new Image();
                image.onload = function () {
                    $('#width').val(this.width);
                    $('#height').val(this.height);
                };

                image.src = _URL.createObjectURL(file);
            }

        });
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var file_extension = $('#img_file').val().split('.').pop().toLowerCase();
            if (file_extension == 'jpg' || file_extension == 'jpeg' || file_extension == 'gif' || file_extension == 'png')
            {
                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                }
            } else
            {
                $("#img_file").val("")
                $('#blah').attr('src', '<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>noimage.png');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<!-- BEGIN PAGE CONTENT-->
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN; ?>admin/pages/scripts/table-managed.js"></script>
<link href="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN_PLUGINS; ?>bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" >
<div class="row">
    <div class="col-md-12">
        <div id="general_alert"class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <div id="general_alert_msg"></div>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box yellow-gold">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cube fa-lg"></i>News
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a class="btn yellow-gold" onclick="javascript:clearForm('form_sample_1')" data-toggle="modal" href="#news_details">
                                    Add New <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">

                        </div>
                    </div>
                </div>
                <table class="table dataTable table-striped table-bordered table-hover" id="sample_2">
                    <thead>
                        <tr>
                            <th style="text-align: center;">#</th>
                            <th style="text-align: center;">Type</th>
                            <th style="text-align: center;">Event</th>
                            <th style="text-align: center;">Picture</th>
                            <th style="text-align: center;">News Headline</th>
                            <th style="text-align: center;">News Details</th>
                            <th style="text-align: center;">Publish Date</th>
                            <th style="text-align: center;">Status</th>
                            <th style="text-align: center;">Action</th>                            
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php
                        if (!empty($news)) {
                            $i = 1;
                            foreach ($news as $row) {
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i ?></td>
                                    <td class="text-center" id="is_type_<?php echo $row['id']; ?>">
                                        <?php
                                        if ($row['is_type'] == CONST_PR_NEWS) {
                                            echo CONST_PR_NEWS_TEXT;
                                        } elseif ($row['is_type'] == CONST_PR_ACHIEVEMENT) {
                                            echo CONST_PR_ACHIEVEMENT_TEXT;
                                        } elseif ($row['is_type'] == CONST_PR_PRESS_RELEASE) {
                                            echo CONST_PR_PRESS_RELEASE_TEXT;
                                        } elseif ($row['is_type'] == CONST_PR_EVENT) {
                                            echo CONST_PR_EVENT_TEXT;
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center" id="event_name_<?php echo $row['id']; ?>"><?php echo ucfirst(stripslashes($row['event_name'])); ?></td>
                                    <td class="text-center" id="imgfile<?php echo $row['id']; ?>"><img id="img_file<?php echo $row['id']; ?>" width="50" height="50" src="<?php echo base_url() . CONST_PATH_NEWS_IMAGE . $row['img_file'] ?>"></td>
                                    <td class="text-center" id="heading_<?php echo $row['id']; ?>"><?php echo stripslashes($row['heading']); ?></td>
                                    <td class="text-center" id="news_description_<?php echo $row['id']; ?>"><?php echo stripslashes($row['news_description']); ?></td>
                                    <td class="text-center" id="created_<?php echo $row['id']; ?>"><?php echo date_format(new DateTime($row['created']), CONST_DATE_FORMAT_DMY); ?></td>
                                    <td class="text-center"><?php echo $row['is_status'] == CONST_ACTIVATE ? 'Active' : 'Inactive' ?></td>
                                    <td style="text-align: center;">
                                        <a onclick="javascript:getDetails(<?php echo $row['id']; ?>)"data-toggle="modal" href="#news_details"><i class="fa fa-edit"></i></a>
                                        |&nbsp;
                                        <a onclick="javascript:"><i class="fa fa-minus-circle" data-id="<?php echo $row['id']; ?>"></i></a>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- MODAL FORM FOR EDIT SECTION-->
<div class="modal fade" id="news_details" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="title">Add News</h4>
            </div>
            <form id="form_sample_1" class="form-horizontal" enctype="multipart/form-data" method="post" action="">
                <div class="form-body">
                    <div class="modal-body">

                        <div id="modal_alert" class="alert display-hide">
                            <button class="close" data-close="alert"></button>
                            <div id="modal_alert_msg"></div>
                        </div>
                        <div class="row">
                            <div class="tab-content">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Type <span class="required">* </span></label>
                                        <div class="col-md-10">
                                            <select class="form-control select2me" name="is_type" id="is_type">
                                                <option value="">Choose one</option>
                                                <option value="<?php echo CONST_PR_NEWS ?>"><?php echo CONST_PR_NEWS_TEXT ?></option>
                                                <option value="<?php echo CONST_PR_ACHIEVEMENT ?>"><?php echo CONST_PR_ACHIEVEMENT_TEXT ?></option>
                                                <option value="<?php echo CONST_PR_PRESS_RELEASE ?>"><?php echo CONST_PR_PRESS_RELEASE_TEXT ?></option>
                                                <option value="<?php echo CONST_PR_EVENT ?>"><?php echo CONST_PR_EVENT_TEXT ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Event <span class="required">* </span></label>
                                        <div class="col-md-10">
                                            <select name="event_id" id="event_id" class="form-control select2me">
                                                <option value="">Choose one</option> 
                                                <?php
                                                if (count($ListEvent) > 0) {
                                                    foreach ($ListEvent as $values) {
                                                        ?>
                                                        <option value="<?php echo $values['id'] ?>" ><?php echo $values['event_name'] ?></option>
    <?php }
}
?>
                                            </select> 
                                        </div>
                                    </div>	
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Heading <span class="required">* </span></label>
                                        <div class="col-md-10">
                                            <input type="text" name="heading" class="form-control" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Image <span class="required">* </span></label>
                                        <div class="col-md-10">
                                            <input type="hidden"  name="width"  id="width"  />
                                            <input type="hidden"  name="height"  id="height"  />
                                            <div>

                                                <img id="blah" src="<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>noimage.png" alt="Preview" width="219" height="150" />
                                            </div>
                                            <div id="success_cover_pic_upload"></div>
                                            <div>
                                                <input type="file"  name="img_file" class="form-control" id="img_file" onchange="readURL(this);"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Description <span class="required">* </span></label>
                                        <div class="col-md-10">
                                            <div name="summernote" id="summernote_1">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <input type="hidden" name="news_id" value="">
                                    <input id="submit" type="submit" class="btn green" value="Submit">
                                    <button id="cancel" type="button" class="btn default"data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
<!-- /. MODAL FORM -->

<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN_PLUGINS; ?>bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN; ?>admin/pages/scripts/components-editors.js"></script>
<script>
                                                    jQuery(document).ready(function () {

                                                        ComponentsEditors.init();
                                                    });
</script>
<script>
    function getDetails(id) {

        if (id) {
            $('#title').text('Edit News');
            $('#submit').val('Update');

            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . FN_NEWS_GET_DETAILS; ?>" + id,
                success: function (data) {

                    if ($.trim(data).length) {
                        var resp = $.parseJSON(data);
                        //alert(resp.data.event_name);
                        if (resp.success) {
                            $('input[name=news_id]').val(resp.data.id);
                            $('select[name="is_type"]').val(resp.data.is_type).trigger("change");
                            $('select[name="event_id"]').val(resp.data.eventID).trigger("change");
                            $('input[name=heading]').val(stripslashes(resp.data.heading));
                            $('.note-editable').html(stripslashes(resp.data.news_description));
                            $('#blah').attr('src', '<?php echo base_url() . CONST_PATH_NEWS_IMAGE ?>' + stripslashes(resp.data.img_file));

                        } else {
                            $('#general_alert').html(resp.message);
                        }
                    } else {
                        $('#modal_alert').html(<?php echo $this->lang->line("'" . MSG_ERR_AJAX_CALL_FAIL . "'") ?>);
                    }
                },
                error: function () {
                    $('#modal_alert').html(<?php echo $this->lang->line("'" . MSG_ERR_AJAX_CALL_FAIL . "'") ?>);
                }
            });
        }
    }

    function clearForm(form) {
        $('input[name=news_id]').val('');
        $('select[name="is_type"]').val('').trigger("change");
        $('select[name="event_id"]').val('').trigger("change");
        $('input[name=heading]').val('');
        $('.note-editable').html('');
        $('#img_file').val('');
        $('#blah').attr('src', '<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>noimage.png');

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


            var news_id = $('input[name=news_id]').val();
            var is_type = $('#is_type').val();
            var is_type_text = $("#is_type option:selected").text();
            var event_id = $("#event_id option:selected").val();
            var event_id_text = $("#event_id option:selected").text();

            var heading = $('input[name=heading]').val();
            var news_description = $('.note-editable').html();
            // alert(news_description);
            var formdata_tmp = new FormData(this);
            formdata_tmp.append("news_description", news_description);
            $.ajax({
                type: 'POST',
                data: formdata_tmp,
                contentType: false,
                cache: false,
                processData: false,
                url: '<?php echo base_url() . FN_NEWS_SAVE_DETAILS; ?>',
                success: function (data) {
                    //alert(data);
                    if ($.trim(data).length) {
                        var resp = $.parseJSON(data);
                        if (resp.success) {
                            // alert(resp.data.id);

                            $('#modal_alert_msg').html(resp.message);
                            $('#modal_alert').removeClass('display-hide');
                            $('#modal_alert').addClass('display-show');
                            $('#modal_alert').removeClass('alert-danger');
                            $('#modal_alert').addClass('alert-success');
                            $('#title').text('Add News');
                            $('#submit').text('Submit');
                            $('#heading_' + news_id).html(stripslashes(heading));
                            $('#event_name_' + news_id).html(stripslashes(event_id_text));
                            $('#is_type_' + news_id).html(stripslashes(is_type_text));
                            $('#news_description_' + news_id).html(stripslashes(news_description));
                            if (resp.data.img_file != null)
                            {
                                $('#img_file' + news_id).attr('src', '<?php echo base_url() . CONST_PATH_NEWS_IMAGE ?>' + (resp.data.img_file));
                            }

                            // alert(resp.data.length);
                            if (resp.data != null)
                            {
                                var row = $('#sample_2 tr').length + 1;
                                var istype = '';
                                if (resp.data.is_type ==<?php echo CONST_PR_NEWS ?>) {
                                    istype = '<?php echo CONST_PR_NEWS_TEXT ?>';
                                } else if (resp.data.is_type ==<?php echo CONST_PR_ACHIEVEMENT ?>) {
                                    istype = '<?php echo CONST_PR_ACHIEVEMENT_TEXT ?>';
                                } else if (resp.data.is_type ==<?php echo CONST_PR_PRESS_RELEASE ?>) {
                                    istype = '<?php echo CONST_PR_PRESS_RELEASE_TEXT ?>';
                                } else if (resp.data.is_type ==<?php echo CONST_PR_EVENT ?>) {
                                    istype = '<?php echo CONST_PR_EVENT_TEXT ?>';
                                }
                                var tmp_status = '';
                                /*var table = $('#sample_2').DataTable();*/


                                // table.row.add( [ row, istype, resp.data.heading, resp.data.news_description , 'Edinburgh', 'Active', '<a onclick="javascript:getDetails('+resp.data.id+')"data-toggle="modal" href="#news_details"><i class="fa fa-edit"></i></a>|&nbsp;<a onclick="javascript:"><i class="fa fa-minus-circle" data-id="'+resp.data.id+'"></i></a>']).draw().node();
                            }
                            setTimeout(function () {
                                $('#news_details').modal('hide');
                                $('#modal_alert').addClass('display-hide');
                            }, 2000);

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
        var table1 = $('#sample_2').DataTable();

        $('#sample_2 tbody').on('click', '.fa-minus-circle', function () {
            var id = $(this).data('id');
            var parentTr = $(this).parents('tr');
            //alert('fdfg');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . FN_NEWS_DELETE_DETAILS; ?>" + id,
                success: function (data) {
                    if ($.trim(data).length) {
                        var resp = $.parseJSON(data);

                        if (resp.success) {
                            table1.row(parentTr).remove().draw();
                            $('#general_alert').html(resp.message);
                            $('#general_alert').removeClass('display-hide');
                            $('#general_alert').removeClass('alert-danger');
                            $('#general_alert').addClass('alert-success');
                        } else {
                            $('#general_alert').html(resp.message);
                            $('#general_alert').removeClass('display-hide');
                        }
                    } else {
                        $('#modal_alert').html(<?php echo $this->lang->line("'" . MSG_ERR_AJAX_CALL_FAIL . "'") ?>);
                        $('#general_alert').removeClass('display-hide');
                    }
                },
                error: function () {
                    $('#modal_alert').html(<?php echo $this->lang->line("'" . MSG_ERR_AJAX_CALL_FAIL . "'") ?>);
                    $('#general_alert').removeClass('display-hide');
                }
            });
        });


    });
</script>
<script>
    TableManaged.init();
</script>