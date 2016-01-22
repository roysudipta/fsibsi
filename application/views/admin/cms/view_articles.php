<?php
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
<link href="<?php echo base_url() . CONST_PATH_ASSETS_ADMIN_PLUGINS; ?>bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" >

<div class="row">
    <div class="col-md-12">
        <div id="general_alert"class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <div id="general_alert_msg"></div>
        </div>
        <div class="portlet box yellow-gold">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cube fa-lg"></i>Pages
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a class="btn yellow-gold" data-toggle="modal" href="#page_detail">
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
                            <th style="text-align: center;" style="width: 25%">Site</th>
                            <th style="text-align: center;" style="width: 35%">Page Heading</th>
                            <th style="text-align: center;" style="width: 20%">Page Slug</th>
                            <th style="text-align: center;" style="width: 10%">Status</th>                            
                            <th style="text-align: center;" style="width: 10%">Action</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($colleges)) {
                            $i = 1;
                            foreach ($colleges as $row) {
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i ?></td>
                                    <td><?php echo $row['college_name'] ?></td>
                                    <td style="text-align: center;">
                                        <a onclick="javascript:getDetails(<?php echo $row['id']; ?>)"data-toggle="modal" href="#page_detail"><i class="fa fa-edit"></i></a>
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
<div class="modal fade" id="page_detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Page Details</h4>
            </div>
            <form id="form_sample_1" class="form-horizontal">
                <div class="form-body">
                    <div class="modal-body">

                        <div id="modal_alert" class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            <div id="modal_alert_msg"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                <ul class="nav nav-tabs tabs-left">
                                    <li class="active">
                                        <a href="#tab_6_1" data-toggle="tab">Title / URL </a>
                                    </li>
                                    <li>
                                        <a href="#tab_6_2" data-toggle="tab">Content </a>
                                    </li>
                                    <li>
                                        <a href="#tab_6_3" data-toggle="tab">SEO Settings </a>
                                    </li>
                                    <li>
                                        <a href="#tab_6_4" data-toggle="tab">More </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-10 col-sm-10 col-xs-10">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_6_1">
                                        <div class="form-group">
                                            <label class="control-label col-md-1">Title <span class="required">* </span></label>
                                            <div class="col-md-11">
                                                <input type="text" name="page_name" class="form-control" required/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-1">URL <span class="required">* </span></label>
                                            <div class="col-md-11">
                                                <input type="text" name="page_slug" class="form-control" required/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-1">Page Type</label>
                                            <div class="col-md-11">
                                                <select class="form-control select2me" data-placeholder="Select..." name="payer_type" id="payer_type"> 
                                                    <?php
                                                    if (!empty($page_type)) {
                                                        foreach ($page_type  as $row) {
                                                            ?>
                                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>

                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab_6_2">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <div name="summernote" id="summernote_1">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab_6_3">
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Focus Keyword</label>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" name="focus_key_word"value="" placeholder="Keyword"/>
                                                <div class="help-block">Pick the main keyword or key phrase that this page is about</div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">SEO Title</label>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" name="seo_title"value="" placeholder="Snippest"/>
                                                <div class="help-block">The SEO title defaults to what is generated based on this sites title template.</div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Meta Description</label>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" name="meta_description"value="" placeholder="Meta Description"/>
                                                <div class="help-block">The meta description is often shown as the black text under the title in a search result. For this to work it has to contain the keyword that was searched for.</div>
                                                <div class="help-block text-danger">The meta description will be limited to 156 chars.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab_6_4">
<!--                                        <p>
                                            Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral, mustache readymade thundercats keffiyeh craft beer marfa ethical. Wolf salvia freegan, sartorial keffiyeh echo park vegan.
                                        </p>-->
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!--                        <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-2">Page Name <span class="required">* </span></label>
                                                            <div class="col-md-10">
                                                                <input type="text" name="page_name" class="form-control" required/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-2">Page Slug <span class="required">* </span></label>
                                                            <div class="col-md-10">
                                                                <input type="text" name="page_slug" class="form-control" required/>
                                                            </div>
                                                        </div>
                        
                                                        <div class="form-group">
                                                            <label class="control-label col-md-2">Page Body</label>
                                                            <div class="col-md-10">
                                                                <div name="summernote" id="summernote_1">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>-->
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
                            $('#page_detail').modal('hide');
                            $('#general_alert_msg').html(resp.message);
                            $('#general_alert').removeClass('display-hide');
                            $('#general_alert').removeClass('alert-danger');
                            $('#general_alert').addClass('alert-success');

                        } else {
                            $('#page_detail').modal('hide');
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