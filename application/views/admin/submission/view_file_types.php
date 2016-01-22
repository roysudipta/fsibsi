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

<script type="text/javascript" src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN_PLUGINS; ?>bootstrap-select/bootstrap-select.min.js"></script>
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN ?>admin/pages/scripts/components-dropdowns.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN_PLUGINS; ?>jquery-multi-select/css/multi-select.css"/>
<script type="text/javascript" src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN_PLUGINS; ?>jquery-multi-select/js/jquery.multi-select.js"></script>
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN; ?>admin/pages/scripts/table-managed.js"></script>
<link href="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN_PLUGINS; ?>bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" >
<style>
    .button-disable {
        position: relative;
    }
    .button-disable::before {
        content:"";
        width:100%;
        height: 32px;
        display: block;
        position: absolute;
        left: 0;
        top: 0;
        z-index: 9999;
    }

    .button-disable .form-control .select2-choice {
        background:#f4f4f4;
    }
    .button-disable .select2-container .select2-choice .select2-arrow {
        border-left: none;
        background:#f4f4f4;
    }
</style>

<script>
    function select_type(type_value,parent_category) {
        //alert(parent_category);
        //$('#type_value').val(type_value);
        if (type_value ==<?php echo CONST_ACTIVATE ?>) {
            $("#for_file_type").find("input").prop('disabled', false);
            $("#for_file_type").find("select").prop('disabled', false);
            $("#for_category_type").find("input").prop('disabled', true);
            $("#for_category_type").find("select").prop('disabled', true);
            //$('#parent_category').select2().val(parent_category).trigger("change");  
            
        } else {
            $("#for_file_type").find("input").prop('disabled', true);
            $("#for_file_type").find("select").prop('disabled', true);
            $("#for_category_type").find("input").prop('disabled', false);
            $("#for_category_type").find("select").prop('disabled', false);
            //$('#parent_category').select2().val(parent_category).trigger("change");  
        }
     //alert('select');
            //$('#parent_category').select2().val(parent_category).trigger("change");  
        
    }
    function getDetails(id) {
        if (id) {
            $('#title').text('Edit File Type');
            $('#submit').val('Update');
            $.ajax({
                type: "post",
                url: "<?php echo base_url() . FN_FILE_TYPES; ?>" + id,
                success: function (data) {
                    if ($.trim(data).length) {
                        var resp = $.parseJSON(data);
                        if (resp.success) {
                            $('input:radio[name="type"][value="' + resp.data.is_category + '"]').attr('checked', true);
//                            if(resp.data.is_category==<?php echo CONST_ACTIVATE?>){
//                              $('#parent_category').select2().val(resp.data.parent_category).trigger("change");  
//                            }
//alert(resp.data.is_category);
                            var type = stripslashes(resp.data.file_type).split(",");
                            var myJsonString = JSON.parse(JSON.stringify(type));
                            $("#event_id").select2().val(resp.data.event_id).trigger("change");
                            update_category_and_deadline(resp.data.event_id, resp.data.deadline,resp.data.parent_category);
                            
                            $('#file_type').val(stripslashes(resp.data.file_type));
                            $('#caption').val(stripslashes(resp.data.caption));
                            $('#file_size_limit').val(stripslashes(resp.data.file_size_limit));
                            $('#file_extensions').val('<?php echo CONST_ALLOWED_EXTENSIONS ?>');
                            $('.radio-status').addClass('button-disable');
                            $('#event_disable').addClass('button-disable');
                            
                            $('.checked').removeClass('checked');
                            $('input[name="type"][value="' + resp.data.is_category + '"]').parent('span').addClass('checked');
                            $('.note-editable').html(stripslashes(resp.data.file_description));
                            $("#select2_sample2").select2().val(myJsonString).trigger("change");
                            $('#id').val(resp.data.id);
                             //$("#event_id").select2().val(resp.data.event_id).trigger("change");
                             select_type(resp.data.is_category,resp.data.parent_category);
                            
                           
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
</script>
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
                    <i class="fa fa-cube fa-lg"></i>File Type
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a class="btn yellow-gold" onclick="javascript:clearForm()" data-toggle="modal" href="#file_detail">
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
                            <th style="text-align: center;">Event Name</th>
                            <th style="text-align: center;">Caption/File Type</th>
                            <th style="text-align: center;">Category</th>
                            <th style="text-align: center;">File Extension</th>
                            <th style="text-align: center;">File Size</th>
                            <th style="text-align: center;">Description</th>
                            <th style="text-align: center;">Deadline</th>
                            <th style="text-align: center;">Status</th>
                            <th style="text-align: center;">Actions</th>                          
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php
                        if (!empty($file_types)) {
                            $i = 1;
                            foreach ($file_types as $row) {
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i ?></td>
                                    <td class="text-center" id="event_name_<?php echo $row['id'] ?>"><?php echo ucfirst(stripslashes($row['event_name'])); ?></td>
                                    <td class="text-center" id="caption_<?php echo $row['id'] ?>"><?php echo ucfirst(stripslashes($row['caption'])); ?></td>
                                    <td class="text-center" id="parent_category_<?php echo $row['id'] ?>">
                                        <?php echo $row['parent_category'] == '0' ? 'Parent Category' : ucfirst(stripslashes($row['Parent_cat_caption'])); ?>
                                    </td>

                                    <td class="text-center" id="file_type_<?php echo $row['id'] ?>"><?php echo stripslashes($row['file_type']); ?></td>
                                    <td class="text-center" id="file_size_limit_<?php echo $row['id'] ?>"><?php echo stripslashes($row['file_size_limit']); ?></td>
                                    <td class="text-center" id="file_description_<?php echo $row['id'] ?>">
                                        <?php
                                        if (!empty($row['file_description'])) {
                                            echo ucfirst(stripslashes($row['file_description']));
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center" id="deadline_<?php echo $row['id'] ?>"><?php echo stripslashes($row['title']); ?></td>
                                    <td class="text-center" id="is_status_<?php echo $row['id'] ?>"><?php echo $row['is_status'] == CONST_ACTIVATE ? 'Active' : 'Inactive' ?></td>
                                    <td class="text-center">
                                        <a data-toggle="modal" data-toggle href="#file_detail" onclick="javascript:getDetails(<?php echo $row['id']; ?>)"><i class="fa fa-edit"></i></a>
                                        |&nbsp;
                                        <a onclick="javascript:void(0);"><i class="fa fa-minus-circle" data-id="<?php echo $row['id']; ?>"></i></a>
                                        |&nbsp;
                                        <a onclick="javascript:void(0);"><i class="fa fa-wrench" data-id="<?php echo $row['id']; ?>"></i></a>
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
<div class="modal fade" id="file_detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="title">Add File Type</h4>
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
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Event <span class="required">* </span></label>
                                        <div class="col-md-9" id="event_disable">
                                            <script>
                                                function update_category_and_deadline(event_id, deadline,parent_category) {
                                                    if (event_id != '' && event_id > 0)
                                                    {
                                                        $.ajax({
                                                            type: 'POST',
                                                            url: '<?php echo base_url() . FN_FATCH_CATEGORIES_BY_EVENT_ID; ?>',
                                                            data: {event_id: event_id},
                                                            success: function (data) {
                                                                //alert('update_cat if');
                                                                if ($.trim(data).length) {
                                                                    var resp = $.parseJSON(data);
                                                                    if (resp.success) {
                                                                       //alert(parent_category);
                                                                        var parent_category_selected = $("#parent_category option:selected").val();
                                                                        var type_selected = $("input[name='type']:checked").val();
                                                                        //alert(parent_category_selected);
                                                                        $("#parent_category").select2().empty();
                                                                        $(resp.category).appendTo('#parent_category');
                                                                        $("#deadline").select2().empty();
                                                                        $(resp.deadline).appendTo('#deadline');
                                                                        if (deadline != '') {
                                                                            $("#deadline").select2().val(deadline).trigger("change");
                                                                            //select_type(<?php echo CONST_ACTIVATE ?>,parent_category);
                                                                        }
//                                                                        select_type(type,parent_category);
                                                                        if(parent_category_selected=='' ){
                                                                            $('#parent_category').select2().val(parent_category).trigger("change");  
                                                                        }
                                                                        else if(parent_category_selected!='' && type_selected==<?php echo CONST_DEACTIVATE?>){
                                                                            $('#parent_category').select2().val('').trigger("change");
                                                                        } else if(parent_category_selected!='' && type_selected==<?php echo CONST_ACTIVATE?>){
                                                                            $('#parent_category').select2().val(parent_category_selected).trigger("change");
                                                                        }
                                                                    }
                                                                }


                                                            },
                                                            error: function () {
                                                                $('#modal_alert_msg').html(<?php echo $this->lang->line("'" . MSG_ERR_AJAX_CALL_FAIL . "'") ?>);
                                                                $('#modal_alert').removeClass('display-hide');
                                                            }
                                                        });
                                                    } else {
                                                    alert('update_cat else');
                                                        //alert(event_id);
                                                        $("#parent_category").select2().empty();
                                                        $('<option value="">Choose one</option>').appendTo('#parent_category');
                                                        $("#deadline").select2().empty();
                                                        $('<option value="">Choose one</option>').appendTo('#deadline');
                                                    }
                                                }
                                            </script>

                                            <select class="form-control select2me" data-placeholder="Select..." name="event_id" id="event_id" onchange="update_category_and_deadline(this.value, '','');">
                                                <?php if (count($ListEvent) > 0) {
                                                    ?>
                                                    <option value="">Choose one</option>
                                                    <?php foreach ($ListEvent as $row) { ?>
                                                        <option value="<?php echo $row['id'] ?>"><?php echo ucfirst(stripslashes($row['event_name'])) ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>  
                                            </select>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Category/File Type <span class="required">* </span></label>
                                        <div class="col-md-9">
                                            <input type="text" name="caption" id="caption" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Type</label>
                                        <div class="col-md-9 radio-status">
                                            <label><input type="radio" name="type" value="<?php echo CONST_DEACTIVATE ?>"  onclick="select_type(<?php echo CONST_DEACTIVATE ?>,'');" checked  > Category</label>
                                            <label><input type="radio" name="type" value="<?php echo CONST_ACTIVATE ?>"  onclick="select_type(<?php echo CONST_ACTIVATE ?>,'');" > File Type </label>

                                        </div>
                                    </div>
                                    <div id="for_file_type" class="display-hide1" >
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Category <span class="required">* </span></label>
                                            <div class="col-md-9" id="category_dropdown">
                                                <select class="form-control select2me" data-placeholder="Select..." name="parent_category" id="parent_category" disabled>
                                                    <?php if (count($category_or_file_type_lists) > 0) {
                                                        ?>
                                                        <option value="">Choose one</option>
                                                        <?php foreach ($category_or_file_type_lists as $row) { ?>
                                                            <option value="<?php echo $row['id'] ?>"><?php echo ucfirst(stripslashes($row['caption'])) ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>  
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">File Type <span class="required">* </span></label>
                                            <div class="col-md-9">
                                                <?php $tmp_extensions = explode('|', CONST_ALLOWED_EXTENSIONS); ?> 

                                                <select id="select2_sample2" class="form-control select2" name="file_type[]" disabled multiple>
                                                    <?php for ($i = 0; $i < count($tmp_extensions); $i++) {
                                                        ?>
                                                        <option value="<?php echo $tmp_extensions[$i]; ?>"><?php echo $tmp_extensions[$i]; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3">File Size <span class="required">* </span></label>
                                            <div class="col-md-9">
                                                <input type="text" name="file_size_limit" id="file_size_limit" class="form-control" placeholder="File Size in KB" disabled>
                                            </div>  
                                        </div> 

                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Allowed Extensions </label>
                                        <div class="col-md-9">
                                            <input type="text" name="file_extensions" id="file_extensions" value="" class="form-control" value="" disabled/>
                                        </div>
                                    </div>
                                    <div id="for_category_type">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Set Deadline <span class="required">* </span></label>
                                            <div class="col-md-9">
                                                <select class="form-control select2me" data-placeholder="Select..." name="deadline" id="deadline" >

                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-7" >
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Description</label>
                                        <div class="col-md-9">
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
                                    <input type="hidden" id="id" name="id" value=""/>
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
                                                $(document).ready(function () {

                                                    ComponentsEditors.init();
                                                    ComponentsDropdowns.init();


                                                });
</script>
<script>
    function clearForm() {

        //update_category_and_deadline();
        $('input[name=file_extensions]').val('<?php echo CONST_ALLOWED_EXTENSIONS ?>');
        $('.radio-status').removeClass('button-disable');
        $('#event_disable').removeClass('button-disable');
        $("#file_extensions").attr('disabled', 'disabled');
        $("#parent_category").select2().empty();
        $("#deadline").select2().empty();
        select_type(<?php echo CONST_DEACTIVATE ?>,'');
        $('input[name="id"]').val('');
        $('#file_size_limit').val('');
        $('#title').text('Add File Type');
        $('#submit').val('Submit');
        $("#deadline").val('').trigger("change");
        $("#select2_sample2").select2().val('').trigger("change");
        $("#event_id").select2().val('').trigger("change");
        $('.note-editable').html('');
        $('.checked').removeClass('checked');
        $('input[name="caption"]').val('');
        $('input[name="type"][value="<?php echo CONST_DEACTIVATE ?>"]').parent('span').addClass('checked');
        var event_id_val = $("#event_id option:selected").val();
        if (event_id_val != '') {
            update_category_and_deadline(event_id_val, '','');
        } else {
            update_category_and_deadline('');
        }

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
        var table1 = $('#sample_2').DataTable();
        $('#form_sample_1').on('submit', function (e) {
            var id = $('input[name=id]').val();
            var caption = $('input[name=caption]').val();
            var type = $("input[name='type']:checked").val();
            var parent_category = $("#parent_category option:selected").val();
            var parent_category_text = $("#parent_category option:selected").text();
            var event_name_text = $("#event_id option:selected").text();
            var deadline_text = $("#deadline option:selected").text();
            var file_type = $("#select2_sample2").val();
            var file_size_limit = $('#file_size_limit').val();
            var description = $('.note-editable').html();
            var formdata_tmp = new FormData(this);
            formdata_tmp.append("description", description);
            formdata_tmp.append("file_type_text", file_type);
            $.ajax({
                type: 'POST',
                data: formdata_tmp,
                contentType: false,
                cache: false,
                processData: false,
                url: '<?php echo base_url() . FN_FILE_TYPE_SAVE_DETAILS; ?>',
                success: function (data) {
                    // alert(data);
                    if ($.trim(data).length) {
                        var resp = $.parseJSON(data);
                        if (resp.success) {
                            $('#modal_alert_msg').html(resp.message);
                            $('#modal_alert').removeClass('display-hide');
                            $('#modal_alert').addClass('display-show');
                            $('#modal_alert').removeClass('alert-danger');
                            $('#modal_alert').addClass('alert-success');
                            $('#title').text('Add File Type');
                            $('#submit').val('Submit');
                            if (type == <?php echo CONST_ACTIVATE ?>) {
                                $('#file_type_' + id).text(file_type);
                                $('#parent_category_' + id).html(stripslashes(parent_category_text));
                                $('#file_size_limit_' + id).html(stripslashes(file_size_limit));
                            } else {
                                $('#deadline_' + id).html(stripslashes(deadline_text));

                            }
                            $('#file_description_' + id).html(stripslashes(description));
                            $('#caption_' + id).html(stripslashes(caption));
                            $('#event_name_' + id).html(stripslashes(event_name_text));

                            setTimeout(function () {
                                $('#file_detail').modal('hide');
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
        $('#sample_2 tbody').on('click', '.fa-minus-circle', function () {
            var id = $(this).data('id');
            var parentTr = $(this).parents('tr');
            // alert(id);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . FN_FILE_TYPE_DELETE_DETAILS; ?>" + id,
                success: function (data) {
                    //alert(data);
                    if ($.trim(data).length) {
                        var resp = $.parseJSON(data);
                        if (resp.success) {
                            table1.row(parentTr).remove().draw();
                            $('#general_alert').html(resp.message);
                            $('#general_alert').removeClass('display-hide');
                            $('#general_alert').removeClass('alert-danger');
                            $('#general_alert').addClass('alert-success');
                            select_type(<?php echo CONST_DEACTIVATE ?>,'');
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
        $('#sample_2 tbody').on('click', '.fa-wrench', function () {
            var id = $(this).data('id');
            var parentTr = $(this).parents('tr');
            //alert('fdfg');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . FN_FILE_TYPE_STATUS_UPDATE; ?>" + id,
                success: function (data) {
                    if ($.trim(data).length) {
                        var resp = $.parseJSON(data);

                        if (resp.success) {
                            $('#is_status_' + id).html(resp.data);
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
