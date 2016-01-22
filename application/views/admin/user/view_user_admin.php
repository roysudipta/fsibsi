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
<!-- BEGIN PAGE CONTENT-->
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
                    <i class="fa fa-cube fa-lg"></i>Users - Admin
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a class="btn yellow-gold" data-toggle="modal" href="#add_user">
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
                            <th style="text-align: center;">User Name</th>
                            <th style="text-align: center;">Email</th>
                            <th style="text-align: center;">Status</th>
                            <th style="text-align: center;">Action</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($users)) {
                            $i = 1;
                            foreach ($users as $row) {
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i ?></td>
                                    <td><?php echo $row['user_name'] ?></td>
                                    <td><?php echo $row['user_email_id'] ?></td>
                                    <td class="text-center"><?php echo $row['is_status'] == CONST_ACTIVATE ? 'Active' : 'Inactive' ?></td>
                                    <td style="text-align: center;">
                                        <a onclick="javascript:getDetails(<?php echo $row['id']; ?>)"data-toggle="modal" href="#user_detail"><i class="fa fa-edit"></i></a>
                                        |&nbsp;
                                        <a onclick="javascript:"><i class="fa fa-minus-circle" data-id="<?php echo $row['id']; ?>"></i></a>
                                        |&nbsp;
                                        <?php if ($row['is_status'] == CONST_ACTIVATE) { ?>
                                        <a onclick="javascript:"><i id="userLockStatus"class="fa fa-lock lockStatus" data-id="<?php echo $row['id']; ?>" data-is_status="<?php echo CONST_DEACTIVATE; ?>"></i></a>
                                        <?php } else { ?>
                                            <a onclick="javascript:"><i id="userLockStatus"class="fa fa-unlock lockStatus" data-id="<?php echo $row['id']; ?>" data-is_status="<?php echo CONST_ACTIVATE; ?>"></i></a>
                                        <?php } ?>
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
<!-- MODAL FORM -->
<div class="modal fade" id="add_user" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add New User</h4>
            </div>
            <form id="form_sample_1" class="form-horizontal">
                <div class="form-body">
                    <div class="modal-body">

                        <div id="modal_alert" class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            <div id="modal_alert_msg"></div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-4">User Name <span class="required">* </span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="new_user_name" class="form-control" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">User email <span class="required">* </span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="new_user_email" class="form-control" required/>
                                        <div class="help-block">System Will Send an email to this mail id for further process.</div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <input type="hidden" name="user_type" value="<?php echo CONST_USER_ADMIN; ?>">
                                    <button id="submit" type="button" class="btn green">Submit</button>
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
<!-- MODAL FORM -->
<div class="modal fade" id="user_detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">User Details</h4>
            </div>
            <form id="form_sample_1" class="form-horizontal">
                <div class="form-body">
                    <div class="modal-body">

                        <div id="modal_alert" class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            <div id="modal_alert_msg"></div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-4">User email <span class="required">* </span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="user_email" class="form-control" required/>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-md-4">User Name <span class="required">* </span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="user_name" class="form-control" required/>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <input type="hidden" name="user_id" value="">
                                    <input type="hidden" name="user_type" value="<?php echo CONST_USER_ADMIN; ?>">
                                    <button id="update" type="button" class="btn green">Submit</button>
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
<script>
    function getDetails(id) {
        if (id) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . FN_USER_GET_DETAILS; ?>" + id,
                success: function (data) {
                    if ($.trim(data).length) {
                        var resp = $.parseJSON(data);
                        if (resp.success) {
                            $('input[name=user_id]').val(resp.data.id);
                            $('input[name=user_email]').val(resp.data.user_email_id);
                            $('input[name=user_name]').val(resp.data.user_name);
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
        $(":input", form).each(function () {
            var type = this.type;
            var tag = this.tagName.toLowerCase();
            if (type === 'text') {
                this.value = "";
            }
        });
    }

    $(document).ready(function () {
        $('#update').click(function () {
            var user_id = $('input[name=user_id]').val();
            var user_email = $('input[name=user_email]').val();
            var user_name = $('input[name=user_name]').val();
            $.ajax({
                type: 'POST',
                data: 'user_id=' + user_id + '&user_email=' + user_email + '&user_name=' + user_name,
                url: '<?php echo base_url() . FN_USER_SAVE_DETAILS; ?>',
                success: function (data) {
                    if ($.trim(data).length) {
                        var resp = $.parseJSON(data);
                        if (resp.success) {
                            $('#user_detail').modal('hide');
                            $('#general_alert_msg').html(resp.message);
                            $('#general_alert').removeClass('display-hide');
                            $('#general_alert').removeClass('alert-danger');
                            $('#general_alert').addClass('alert-success');

                        } else {
                            $('#college_detail').modal('hide');
                            $('#general_alert_msg').html(resp.message);
                            $('#general_alert').removeClass('display-hide');
                        }
                    } else {
                        $('#modal_alert_msg').html(<?php echo $this->lang->line("'" . MSG_ERR_AJAX_CALL_FAIL . "'") ?>);
                        $('#modal_alert').removeClass('display-hide');
                    }
                },
                error: function () {
                    $('#modal_alert_msg').html(<?php echo $this->lang->line("'" . MSG_ERR_AJAX_CALL_FAIL . "'") ?>);
                    $('#modal_alert').removeClass('display-hide');
                }
            });
        });

        $('#submit').click(function () {

            var new_user_name = $('input[name=new_user_name]').val();
            var new_user_email = $('input[name=new_user_email]').val();
            $.ajax({
                type: 'POST',
                data: 'user_email=' + new_user_email + '&user_name=' + new_user_name,
                url: '<?php echo base_url() . FN_USER_SAVE_DETAILS; ?>',
                success: function (data) {
                    if ($.trim(data).length) {
                        var resp = $.parseJSON(data);
                        if (resp.success) {
                            $('#user_detail').modal('hide');
                            $('#general_alert_msg').html(resp.message);
                            $('#general_alert').removeClass('display-hide');
                            $('#general_alert').removeClass('alert-danger');
                            $('#general_alert').addClass('alert-success');

                        } else {
                            $('#college_detail').modal('hide');
                            $('#general_alert_msg').html(resp.message);
                            $('#general_alert').removeClass('display-hide');
                        }
                    } else {
                        $('#modal_alert_msg').html(<?php echo $this->lang->line("'" . MSG_ERR_AJAX_CALL_FAIL . "'") ?>);
                        $('#modal_alert').removeClass('display-hide');
                    }
                },
                error: function () {
                    $('#modal_alert_msg').html(<?php echo $this->lang->line("'" . MSG_ERR_AJAX_CALL_FAIL . "'") ?>);
                    $('#modal_alert').removeClass('display-hide');
                }
            });
        });

        var table1 = $('#sample_2').DataTable();

        $('#sample_2 tbody').on('click', '.fa-minus-circle', function () {
            var id = $(this).data('id');
            var parentTr = $(this).parents('tr');

            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . FN_USER_DELETE_DETAILS; ?>" + id,
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

        $('#sample_2 tbody').on('click', '.lockStatus', function () {
            var id = $(this).data('id');
            var status = $(this).data('is_status');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . FN_USER_CHANGE_STATUS; ?>" + id + '/' + status,
                success: function (data) {
                    if ($.trim(data).length) {
                        var resp = $.parseJSON(data);
                        if (resp.success) {
                            $('#general_alert').html(resp.message);
                            $('#general_alert').removeClass('display-hide');
                            $('#general_alert').removeClass('alert-danger');
                            $('#general_alert').addClass('alert-success');
                            if (status ==<?php echo CONST_ACTIVATE; ?>) {
                                $('#userLockStatus').removeClass('fa-lock');
                                $('#userLockStatus').addClass('fa-unlock');
                                $('#userLockStatus').data('is_status','<?php echo CONST_DEACTIVATE ?>');
                            } else {
                                $('#userLockStatus').removeClass('fa-unlock');
                                $('#userLockStatus').addClass('fa-lock');
                                $('#userLockStatus').data('is_status','<?php echo CONST_ACTIVATE ?>');

                            }
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