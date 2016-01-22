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
<script>
    $(document).ready(function (e) {
        $('input[name=resolve_day]').on('keypress', function (event) {
            if (event.keyCode < 48 || event.keyCode > 57)
                return false;
        });
        $('input[name=resolve_day]').bind("cut copy paste", function (e) {
            e.preventDefault();
        });
    });
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
                    <i class="fa fa-cube fa-lg"></i>Ticket Category
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a class="btn yellow-gold" onclick="javascript:clearForm('form_sample_1')" data-toggle="modal" href="#category_details">
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
                            <th style="text-align: center;">Category Title</th>
                            <th style="text-align: center;">Responsible Person</th>
                            <th style="text-align: center;">Resolve Day</th>
                            <th style="text-align: center;">Publish Date</th>
                            <th style="text-align: center;">Status</th>
                            <th style="text-align: center;">Action</th>                            
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php
                        if (!empty($ticket_category)) {
                            $i = 1;
                            foreach ($ticket_category as $row) {
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i ?></td>
                                    <td class="text-center" id="category_title_<?php echo $row['category_id']; ?>"><?php echo ucwords(stripslashes($row['category_title'])); ?></td>
                                    <td class="text-center" id="user_name_<?php echo $row['category_id']; ?>"><?php echo stripslashes($row['user_name']); ?></td>
                                    <td class="text-center" id="resolve_day_<?php echo $row['category_id']; ?>"><?php echo stripslashes($row['resolve_day']); ?></td>

                                    <td class="text-center" id="created_<?php echo $row['category_id']; ?>"><?php echo date_format(new DateTime($row['created_on']), CONST_DATE_FORMAT_DMY); ?></td>
                                    <td class="text-center" id="is_status_<?php echo $row['category_id']; ?>"><?php echo $row['status'] == CONST_ACTIVATE ? 'Active' : 'Inactive' ?></td>
                                    <td style="text-align: center;">
                                        <a onclick="javascript:getDetails(<?php echo $row['category_id']; ?>)"data-toggle="modal" href="#category_details"><i class="fa fa-edit"></i></a>
                                        |&nbsp;
                                        <a onclick="javascript:void(0);"><i class="fa fa-minus-circle" data-id="<?php echo $row['category_id']; ?>"></i></a>
                                        |&nbsp;
                                        <a onclick="javascript:void(0);"><i class="fa fa-wrench" data-id="<?php echo $row['category_id']; ?>"></i></a>
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
<div class="modal fade" id="category_details" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" id="title">Add Ticket Category</h4>
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
                                        <label class="control-label col-md-2">Category Title <span class="required">* </span></label>
                                        <div class="col-md-10">
                                            <input type="text" name="category_title" class="form-control" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Responsible Person <span class="required">* </span></label>
                                        <div class="col-md-10">
                                            <select class="form-control select2me" data-placeholder="Select..." name="responsible_person" id="responsible_person">
                                                <?php
                                                if (count($listofOfficialMembers) > 0) {
                                                    ?>
                                                    <option value="">Choose one</option>
                                                    <?php foreach ($listofOfficialMembers as $row) {
                                                        ?>
                                                        <option value="<?php echo $row['id'] ?>"><?php echo ucwords(stripslashes($row['user_name'])); ?></option>

                                                    <?php }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-2">Resolve day <span class="required">* </span></label>
                                        <div class="col-md-2">
                                            <input type="text" name="resolve_day" id="resolve_day" class="form-control" required/>
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
                                    <input type="hidden" name="category_id" value="">
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
            $('#title').text('Edit Catgeory');
            $('#submit').val('Update');
            // alert(id);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . FN_TICKET_CATEGORY_GET_DETAILS; ?>" + id,
                success: function (data) {
                    // alert(data);
                    if ($.trim(data).length) {
                        var resp = $.parseJSON(data);
                        //alert(resp.data.is_type);
                        if (resp.success) {
                            $('input[name=category_title]').val(resp.data.category_title);
                            $('input[name=category_id]').val(resp.data.category_id);
                            $('select[name="responsible_person"]').val(resp.data.responsible_person).trigger("change");
                            $('input[name=resolve_day]').val(stripslashes(resp.data.resolve_day));

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
        $('#title').text('Add Catgeory');
        $('#submit').val('Submit');
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


            var category_id = $('input[name=category_id]').val();
            var responsible_person = $('#responsible_person').val();
            var responsible_person_text = $("#responsible_person option:selected").text();

            var category_title = $('input[name=category_title]').val();
            var resolve_day = $('input[name=resolve_day]').val();
            var formdata_tmp = new FormData(this);

            $.ajax({
                type: 'POST',
                data: formdata_tmp,
                contentType: false,
                cache: false,
                processData: false,
                url: '<?php echo base_url() . FN_TICKET_CATEGORY_SAVE_DETAILS; ?>',
                success: function (data) {
                   // alert(data);
                    if ($.trim(data).length) {
                        var resp = $.parseJSON(data);
                        if (resp.success) {
                            // alert(resp.data.id);

                            $('#modal_alert_msg').html(resp.message);
                            $('#modal_alert').removeClass('display-hide');
                            $('#modal_alert').addClass('display-show');
                            $('#modal_alert').removeClass('alert-danger');
                            $('#modal_alert').addClass('alert-success');
                            $('#title').text('Add Ticket Category');
                            $('#submit').val('Submit');
                            $('#category_title_' + category_id).html(stripslashes(category_title));
                            $('#user_name_' + category_id).html(stripslashes(responsible_person_text));
                            $('#resolve_day_' + category_id).html(stripslashes(resolve_day));

                            setTimeout(function () {
                                $('#category_details').modal('hide');
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
                url: "<?php echo base_url() . FN_TICKET_CATEGORY_DELETE_DETAILS; ?>" + id,
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
                url: "<?php echo base_url() . FN_TICKET_CATEGORY_STATUS_UPDATE; ?>" + id,
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
