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
    print_r($colleges);
    echo '</pre>';
}
?>
<!-- BEGIN PAGE CONTENT-->
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN; ?>admin/pages/scripts/table-managed.js"></script>
<div class="row">
    <div class="col-md-12">
        <div id="general_alert"class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <div id="general_alert_msg"></div>
        </div>
        <div class="portlet box yellow-gold">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cube fa-lg"></i>Event Participation Charges Settings
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a class="btn yellow-gold" data-toggle="modal" href="#college_detail">
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
                            <th style="text-align: center;">Event</th>
                            <th style="text-align: center;">Registration Fee</th>
                            <th style="text-align: center;">Service Tax</th>
                            <th style="text-align: center;">Action</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($settings)) {
                            $i = 1;
                            foreach ($settings as $row) {
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i ?></td>
                                    <td><?php echo $row['event_name'] ?></td>
                                    <td><?php echo $row['rate'] ?></td>
                                    <td><?php echo $row['service_tax'] ?></td>
                                    <td style="text-align: center;">
                                        <a onclick="javascript:getDetails(<?php echo $row['id']; ?>)"data-toggle="modal" href="#college_detail"><i class="fa fa-edit"></i></a>
                                        <i class="fa fa-minus-circle" data-id="<?php echo $row['id']; ?>"></i>
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
<div class="modal fade" id="college_detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Participation Charges Details</h4>
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
                                <div class="form-group">
                                    <label class="control-label col-md-4">Registration Charges <span class="required">* </span></label>
                                    <div class="col-md-8">
                                        <input name="location" id="location" type="text" class="form-control" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Service Tax <span class="required">* </span></label>
                                    <div class="col-md-8">
                                        <input name="service_tax_rate" id="service_tax_rate"type="text" class="form-control" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Maximum Team Member</label>
                                    <div class="col-md-8">
                                        <input name="team_member_limit" id="team_member_limit" type="text" class="form-control" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Chargeable Amount Per Member</label>
                                    <div class="col-md-8">
                                        <input name="member_paricipation_fee" id="member_paricipation_fee" type="text" class="form-control" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-md-4">Last Date For Payment</label>
                                    <div class="col-xs-12 col-md-4">

                                        <div class="input-group input-medium date date-picker" data-date="12-02-2012" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                                            <input type="text" class="form-control" readonly>
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                            </span>
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
                                    <input type="hidden" name="college_id" value="">
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

        $('#sample_2 tbody').on('click', '.fa-minus-circle', function () {
            var id = $(this).data('id');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . FN_COLLEGE_DELETE_DETAILS; ?>" + id,
                success: function (data) {
                    if ($.trim(data).length) {
                        var resp = $.parseJSON(data);
                        if (resp.success) {
                            var table1 = $('#sample_2').DataTable();
                            table1.row($(this).parents('tr')).remove();//.draw(false);
                            console.log($(this).parents('tr'));
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