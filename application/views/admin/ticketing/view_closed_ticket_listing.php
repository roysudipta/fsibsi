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
<script src="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN; ?>admin/pages/scripts/table-managed.js"></script>

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
                    <i class="fa fa-cube fa-lg"></i>Ticket Listing
                </div>
            </div>
            <div class="portlet-body">

                <table class="table dataTable table-striped table-bordered table-hover" id="sample_2">
                    <thead>
                        <tr>
                            <th style="text-align: center;">#</th>
                            <th style="text-align: center;">Name</th>
                            <th style="text-align: center;">Priority</th>
                            <th style="text-align: center;">Catgeory</th>
                            <th style="text-align: center;">Subject</th>
                            <th style="text-align: center;">Posted Date</th>
                            <th style="text-align: center;">Status</th>
                            <th style="text-align: center;">Replies</th>
                            <th style="text-align: center;">Action</th>                            
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php
                        if (!empty($listofTickets)) {
                            $i = 1;
                            foreach ($listofTickets as $row) {
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i ?></td>
                                    <td class="text-center" id="user_name_<?php echo $row['ticket_id']; ?>"><?php echo ucwords(stripslashes($row['user_name'])); ?></td>
                                    <td class="text-center" id="priority_<?php echo $row['ticket_id']; ?>">
                                        <?php
                                        switch ($row['priority']) {
                                            case CONST_PRIORITY_LOW:
                                                echo 'Low';
                                                break;
                                            case CONST_PRIORITY_MEDIUM:
                                                echo 'Medium';
                                                break;
                                            case CONST_PRIORITY_HIGH:
                                                echo 'High';
                                                break;
                                            case CONST_PRIORITY_URGENT:
                                                echo 'Urgent';
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center" id="category_title_<?php echo $row['ticket_id']; ?>"><?php echo ucwords(stripslashes($row['category_title'])); ?></td>
                                    <td class="text-center" id="subject_<?php echo $row['ticket_id']; ?>"><?php echo stripslashes($row['subject']); ?></td>
                                    <td class="text-center" id="created_<?php echo $row['ticket_id']; ?>"><?php echo date_format(new DateTime($row['created']), CONST_DATE_FORMAT_DMY); ?></td>
                                    <td class="text-center" id="is_status_<?php echo $row['ticket_id']; ?>"><?php echo $row['is_status'] == CONST_ACTIVATE ? 'Open' : 'Closed' ?></td>
                                    <td class="text-center" ><a href="<?php echo base_url() . FN_LIST_TICKET_REPLY . '/' . $row['ticket_id']; ?>"><i class="fa fa-reply" ></i></a></td>
                                    <td style="text-align: center;">

                                        <a onclick="javascript:void(0);"><i class="fa fa-minus-circle" data-id="<?php echo $row['ticket_id']; ?>"></i></a>
                                        |&nbsp;
                                        <a onclick="javascript:void(0);"><i class="fa fa-wrench" data-id="<?php echo $row['ticket_id']; ?>"></i></a>
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
<div class="modal fade" id="ticket_details" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="title">Change Priority</h4>
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
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Priority<span class="required">* </span></label>
                                        <div class="col-md-10">
                                            <select class="form-control select2me" data-placeholder="Select..." name="priority" id="priority">
                                                <option value="<?php echo CONST_PRIORITY_LOW ?>" seleted>Low</option>
                                                <option value="<?php echo CONST_PRIORITY_MEDIUM ?>">Medium</option>
                                                <option value="<?php echo CONST_PRIORITY_HIGH ?>">High</option>
                                                <option value="<?php echo CONST_PRIORITY_URGENT ?>">Urgent</option>
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
                                    <input type="hidden" name="ticket_id" value="">
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


<script>
    function getDetails(id) {

        if (id) {
            $('#title').text('Edit Ticket Details');
            $('#submit').val('Update');
            // alert(id);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . FN_TICKET_GET_DETAILS; ?>" + id,
                success: function (data) {
                    // alert(data);
                    if ($.trim(data).length) {
                        var resp = $.parseJSON(data);
                        //alert(resp.data.is_type);
                        if (resp.success) {
                            $('input[name=ticket_id]').val(resp.data.ticket_id);
                            $('select[name="priority"]').val(resp.data.priority).trigger("change");
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
        $('input[name=category_id]').val('');
        $('select[name="responsible_person"]').val('').trigger("change");
        $('input[name=category_title]').val('');
        $('input[name=resolve_day]').val();
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

        $('#sample_2 tbody').on('click', '.fa-minus-circle', function () {
            var id = $(this).data('id');
            var parentTr = $(this).parents('tr');
            //alert('fdfg');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . FN_TICKET_DELETE_DETAILS; ?>" + id,
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
        $('#sample_2 tbody').on('click', '.fa-wrench', function () {
            var id = $(this).data('id');
            var parentTr = $(this).parents('tr');
            //alert('fdfg');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . FN_TICKET_STATUS_UPDATE; ?>" + id,
                success: function (data) {
                    if ($.trim(data).length) {
                        var resp = $.parseJSON(data);

                        if (resp.success) {
                            table1.row(parentTr).remove().draw();
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
