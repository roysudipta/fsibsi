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
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box yellow-gold">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cube fa-lg"></i>Users - Official
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a class="btn yellow-gold" data-toggle="modal" href="#user_detail">
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
                                    <td><?php echo $row['is_status'] ?></td>
                                    <td style="text-align: center;">
                                        <a onclick="javascript:getDetails(<?php echo $row['id']; ?>)"data-toggle="modal" href="#college_detail"><i class="fa fa-edit"></i></a>
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
<!-- MODAL FORM -->
<div class="modal fade" id="user_detail" tabindex="-1" role="dialog" aria-hidden="true">
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
                                    <label class="control-label col-md-4">User email <span class="required">* </span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="college_name" class="form-control" required/>

                                        <div class="help-block">System Will Send an email to this mail id for further process.</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-4">Event</label>
                                    <div class="col-xs-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                            </span>
                                            <select class="form-control select2me" data-placeholder="Select..." name="event_id" id="event_id">
                                                <option value="">Select An Event</option>
                                                <?php
                                                if (!empty($events)) {
                                                    foreach ($events as $row) {
                                                        ?>
                                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['event_name']; ?></option>

                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
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
                                    <input type="hidden" name="user_type" value="<?php echo CONST_USER_OFFICIAL;?>">
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
<script>
    function getDetails(id) {
        if (id) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . FN_COLLEGE_GET_DETAILS; ?>" + id,
                success: function (data) {
                    if ($.trim(data).length) {
                        var resp = $.parseJSON(data);
                        if (resp.success) {
                            $('input[name=college_id]').val(resp.data.id);
                            $('input[name=college_name]').val(resp.data.college_name);
                            $('input[name=college_address]').val(resp.data.address);
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
        $('#submit').click(function () {
            var college_id = $('input[name=college_id]').val();
            var college_name = $('input[name=college_name]').val();
            var college_address = $('textarea[name=college_address]').val();
            $.ajax({
                type: 'POST',
                data: 'college_id=' + college_id + '&college_name=' + college_name + '&college_address=' + college_address,
                url: '<?php echo base_url() . FN_COLLEGE_SAVE_DETAILS; ?>',
                success: function (data) {
                    if ($.trim(data).length) {
                        var resp = $.parseJSON(data);
                        if (resp.success) {
                            $('#college_detail').modal('hide');
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
                url: "<?php echo base_url() . FN_COLLEGE_DELETE_DETAILS; ?>" + id,
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