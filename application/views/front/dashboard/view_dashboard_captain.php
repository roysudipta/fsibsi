<style type="text/css">
    .field-error { border: 1px solid #921010 ;}
    .error-input{ color: #CA3232;}
    .success-input{ color: #0F0;}
    .edit{background: url("<?php echo base_url(); ?>assets/front/images/edit.png");}
</style>
<?php //print_r( $isCarNumberSelected['event_id']);die; ?>
<?php
if ($isCarNumberSelected['car_id'] == '') {
    ?>
    <script>
        $(document).ready(function () {
            $("#selectCarNo").dialog();
            $('#carNoSelectForm').on('submit', function (e) {
                var car_no = $('#car_no').val();
    //                var event_id = $('#event_id').val();
                var event_id = $('input[name=eventid]').val();
                $('.loader_for_car_no_selection').show();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . FN_TEAM_CAR_SELECTION ?>",
                    data: {car_no: car_no, event_id: event_id, ajax_type: 'submit'},
                    success: function (data) {
                        //alert(data) ;
                        var result = data.split("~");
                        if (result[1] == 'success')
                        {

                            $('.loader_for_car_no_selection').hide();
                            $('#errMsg').hide();
                            $('#CarNoAddSuccess').html('<div class="success">The car number has been successfully added for your team.');

                            setTimeout(function () {
                                $('#selectCarNo').dialog('close');
                            }, 2000);

                        } else
                        {
                            $('.loader_for_car_no_selection').hide();
                            $('#errMsg').html(data);
                        }

                    }
                });
                e.preventDefault();
            });
        });
    </script>
    <div id="selectCarNo"  style="display:none;" title="Car Number Selection">
        <script type="text/javascript">
            $(function () {

                var specialKeys = new Array();
                specialKeys.push(8);
                $("#car_no").bind("keypress", function (e) {
                    var keyCode = e.which ? e.which : e.keyCode
                    var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
                    return ret;
                });
                $("#car_no").bind("paste", function (e) {
                    return false;
                });
                $("#car_no").bind("drop", function (e) {
                    return false;
                });
            });

            function checkCarNoExisting()
            {
                var car_no = $('#car_no').val();
                // var event_id = $('#event_id').val();
                var event_id = $('input[name=eventid]').val();
               // alert(event_id);
                var xhr = null;
                if (xhr && xhr.readystate != 4) {
                    xhr.abort();
                }
                xhr = $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . FN_TEAM_CAR_SELECTION ?>",
                    data: {car_no: car_no, event_id: event_id, ajax_type: 'validation'},
                    success: function (data) {
                        alert(data);
                        $('#errMsg').html(data);
                    }
                });
            }

        </script>

        <form id="carNoSelectForm" method="post">
            <div id="CarNoAddSuccess"></div>
            <div>

                <label>Car No.</label>
                <input type="text" id="car_no" name="car_no" onkeyup="checkCarNoExisting();" autocomplete="off"><div id="errMsg"></div>
                <input type="hidden" id="eventid" name="eventid" value="<?php echo $isCarNumberSelected['event_id'] ?>">
            </div>
            <div>
                <input type="submit" name="submit" value="Submit"><img class="loader_for_car_no_selection" style="display:none;" src="<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>loading.gif" >
            </div>	
        </form>
    </div>
<?php } ?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#set_cover_pic").click(function () {
            $('#blah').attr('src', '<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>noimage.png');
            $('.field-error').removeClass('field-error');
            $('.success-msg').remove();
            $("#img_cover").val("");
            $('.error-input').remove();
            $("#cover_pic_content").dialog({
                height: 400,
                width: 360
            });

        });
        $("#set_profile_pic").click(function () {
            $('#blah_profile').attr('src', '<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>noimage.png');
            $('.field-error').removeClass('field-error');
            $("#img_profile").val("");
            $('.error-input').remove();
            $('.success-msg').remove();
            $("#profile_pic_content").dialog({
                height: 400,
                width: 360
            });

        });

        $("#set_team_logo").click(function () {
            $('#blah_team_logo').attr('src', '<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>noimage.png');
            $('.field-error').removeClass('field-error');
            $("#team_logo").val("");
            $('.error-input').remove();
            $('.success-msg').remove();
            $("#team_logo_content").dialog({
                height: 400,
                width: 360
            });

        });
    });
</script>
<?php $session_user = $this->session->userdata('session_user'); ?>
<div>
    <a href="javascript:void(0);" id="set_cover_pic">
        <?php if ($session_user['cover_pic'] == '') { ?> 
            <img id="new_uploaded_img" src="<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>profile_demo_cover_picture.png">
        <?php } else { ?>
            <img id="new_uploaded_img" src="<?php echo base_url() . CONST_PATH_PROFILE_COVER_IMAGE . $session_user['cover_pic'] ?>">
        <?php } ?></a>
</div>
<script type="text/javascript">
    $(document).ready(function (e) {
        var _URL = window.URL || window.webkitURL;
        $("#img_cover").change(function (e) {
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
        $("#uploadForm").on('submit', (function (e) {
            e.preventDefault();
            $('#cover_pic_content :input[type=submit]').attr('disabled', true);
            //$("#img_cover").attr('disabled','disabled');

            $.ajax({
                url: "<?php echo base_url() . FN_USER_SET_COVER_PICTURE ?>",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    $('.loader').show();
                },
                success: function (data) {

                    $('#cover_pic_content :input[type=submit]').attr('disabled', false);
                    var result = data.split("~");
                    $('.field-error').removeClass('field-error');
                    $('.error-input').remove();
                    if (result[0] === 'success')
                    {
                        $('#new_uploaded_img').attr('src', result[1]);
                        $('#success_cover_pic_upload').html('<div class="success-msg">Your cover picture has been successfully uploaded.</div>');
                        setTimeout(function () {
                            $('#cover_pic_content').dialog('close');
                        }, 2000);
                    } else
                    {
                        $('#' + result[0]).addClass('field-error');
                        $("<span class='error-input'>" + result[1] + "</span>").insertAfter('#' + result[0]);
                    }
                },
                complete: function () {
                    $('.loader').hide();
                }
            });
        }));
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var file_extension = $('#img_cover').val().split('.').pop().toLowerCase();
            if (file_extension === 'jpg' || file_extension === 'jpeg' || file_extension === 'gif' || file_extension === 'png')
            {
                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                };
            } else
            {
                $("#img_cover").val("");
                $('#blah').attr('src', '<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>noimage.png');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<div id="cover_pic_content" style="display:none;" title="Choose cover picture">

    <form id="uploadForm" action="<?php echo base_url() . FN_USER_SET_COVER_PICTURE ?>" method="post" enctype="multipart/form-data">
        <label>Upload Image File:</label>
        <input type="hidden"  name="width"  id="width"  />
        <input type="hidden"  name="height"  id="height"  />
        <div>
            <img id="blah" src="<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>noimage.png" alt="Preview" width="150" height="150" />
        </div>
        <div id="success_cover_pic_upload"></div>
        <div>
            <input type="file"  name="img_cover" class="img_cover" id="img_cover" onchange="readURL(this);" />
        </div>

        <div>
            <input type="submit" value="Submit" class="btnSubmit" /><img class="loader" style="display:none;" src="<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>loading.gif" >
        </div>
    </form>
</div>


<div>
    <a href="javascript:void(0);" id="set_profile_pic">
        <?php if ($session_user['profile_pic'] == '') { ?> 
            <img id="new_uploaded_img_profile" src="<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>profile_demo_picture.png">
        <?php } else { ?>
            <img id="new_uploaded_img_profile" src="<?php echo base_url() . CONST_PATH_PROFILE_IMAGE . $session_user['profile_pic'] ?>">
        <?php } ?></a>
</div>
<script type="text/javascript">
    $(document).ready(function (e) {
        var _URL = window.URL || window.webkitURL;

        $("#img_profile").change(function (e) {
            var image, file;
            if ((file = this.files[0])) {
                image = new Image();
                image.onload = function () {
                    $('#width_profile').val(this.width);
                    $('#height_profile').val(this.height);
                };

                image.src = _URL.createObjectURL(file);

            }

        });
        $("#uploadForm_profile").on('submit', (function (e) {
            e.preventDefault();
            $('#profile_pic_content :input[type=submit]').attr('disabled', true);
            $.ajax({
                url: "<?php echo base_url() . FN_USER_SET_PROFILE_PICTURE ?>",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    $('.loader_profile').show();
                },
                success: function (data) {
                    //alert(data);
                    $('#profile_pic_content :input[type=submit]').attr('disabled', false);
                    var result = data.split("~");
                    $('.field-error').removeClass('field-error');
                    $('.error-input').remove();
                    if (result[0] === 'success')
                    {

                        $('#new_uploaded_img_profile').attr('src', result[1]);
                        $('#profile_img_<?php echo $session_user["id"] ?>').attr('src', result[1]);
                        $('#success_profile_pic_upload').html('<div class="success-msg">Your cover picture has been successfully uploaded.</div>');
                        setTimeout(function () {
                            $('#profile_pic_content').dialog('close');
                        }, 2000);

                    } else
                    {
                        $('#' + result[0]).addClass('field-error');
                        $("<span class='error-input'>" + result[1] + "</span>").insertAfter('#' + result[0]);
                    }
                    // $("#set_cover_pic").html(data);
                },
                complete: function () {
                    $('.loader_profile').hide();
                }
            });
        }));
    });
    function readURLprofile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            var file_extension = $('#img_profile').val().split('.').pop().toLowerCase();
            if (file_extension === 'jpg' || file_extension === 'jpeg' || file_extension === 'gif' || file_extension === 'png')
            {
                reader.onload = function (e) {
                    $('#blah_profile').attr('src', e.target.result);
                };
            } else
            {
                $("#img_profile").val("");
                $('#blah_profile').attr('src', '<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>noimage.png');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<div id="profile_pic_content" style="display:none;" title="Choose profile picture">

    <form id="uploadForm_profile" action="<?php echo base_url() . FN_USER_SET_PROFILE_PICTURE ?>" method="post" enctype="multipart/form-data">
        <label>Upload Image File:</label>
        <input type="hidden"  name="width"  id="width_profile"  />
        <input type="hidden"  name="height"  id="height_profile"  />
        <div>
            <img id="blah_profile" src="<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>noimage.png" alt="Preview" width="150" height="150" />
        </div>
        <div id="success_profile_pic_upload"></div>
        <div>
            <input type="file"  name="img_profile" class="img_profile" id="img_profile" onchange="readURLprofile(this);" />
        </div>

        <div>
            <input type="submit" value="Submit" class="btnSubmit" /><img class="loader_profile" style="display:none;" src="<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>loading.gif" >
        </div>
    </form>
</div>

<?php
$session = $this->session->userdata('session_user');
$url = '';
switch ($session['is_type']) {

    case CONST_USER_ADMIN:
        $url = base_url() . FN_ADMIN_DASHBOARD;
        break;
    case CONST_USER_CAPTAIN:
        $url = base_url() . FN_CAPTAIN_DASHBOARD;
        break;
    case CONST_USER_OFFICIAL:
        $url = base_url() . FN_OFFICIAL_DASHBOARD;
        break;
    case CONST_USER_VICECAPTAIN:
        $url = base_url() . FN_CAPTAIN_DASHBOARD;
        break;
    case CONST_USER_TEAMMEMBER:
        $url = base_url() . FN_CAPTAIN_DASHBOARD;
        break;
    case CONST_USER_FACULTY:
        $url = base_url() . FN_CAPTAIN_DASHBOARD;
        break;
}
?>
<script type="text/javascript">
    function pageSelection(datas)
    {
        if (datas === 1)
        {
            window.location.href = '<?php echo $url ?>';
        } else if (datas === 2)
        {
            window.location.href = '<?php echo base_url() ?>';
        } else if (datas === 3)
        {
            window.location.href = '<?php echo base_url() ?>';
        } else if (datas === 4)
        {
            window.location.href = '<?php echo base_url() ?>';
        }

    }
</script>

<select id="selectPage" onchange="pageSelection(this.value);">
    <option value="1">Dashboard</option>
    <option value="2">File Upload</option>
    <option value="3">Forum</option>
    <option value="4">Report</option>	
</select>
<a href="javascript:void(0);" id="member_add_link">Add Member</a>
<script>
    $(document).ready(function () {
        $("#member_add_link").click(function () {
            $("#add_member_content").dialog();
            $('#memberAddSuccess').html('');
            $('input:not(input[type=submit])').val('');
        });

        $('#memberAdd').on('submit', function (e) {

            var user_type = $('#user_type').val();
            var user_name = $('#user_name').val();
            var user_email_id = $('#user_email_id').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . FN_USER_ADD_MEMBER ?>",
                data: {user_type: user_type, user_name: user_name, user_email_id: user_email_id, team_id:<?php echo $session["team_id"] ?>},
                beforeSend: function () {
                    $('.loader_for_add_member').show();
                },
                success: function (data) {

                    var result = data.split("~");
                    $('.field-error').removeClass('field-error');
                    $('.error-input').remove();

                    if (result[0] === 'success')
                    {

                        $('#memberAddSuccess').html(result[1]);
                        setTimeout(function () {
                            $('#add_member_content').dialog('close');
                        }, 2000);

                    } else
                    {
                        $('#' + result[0]).addClass('field-error');
                        $("<span class='error-input'>" + result[1] + "</span>").insertAfter('#' + result[0]);
                    }

                },
                complete: function () {
                    $('.loader_for_add_member').hide();
                }
            });
            e.preventDefault();
        });
    });
</script>
<div id="add_member_content" style="display:none;" title="Member Registration">
    <div id="memberAddSuccess"></div>
    <form id="memberAdd" method="post">
        <select id="user_type" name="user_type">
            <option value="<?php echo CONST_USER_TEAMMEMBER ?>">Team Member</option>
            <option value="<?php echo CONST_USER_VICECAPTAIN ?>">Vice Captain</option>
            <option value="<?php echo CONST_USER_FACULTY ?>">Faculty</option>
        </select>
        <div>
            <label>Name</label>
            <input type="text" id="user_name" name="user_name" >
        </div>
        <div>
            <label>Email Address</label>
            <input type="text" id="user_email_id" name="user_email_id" >
        </div>
        <div>
            <input type="submit" name="submit" value="Submit"><img class="loader_for_add_member" style="display:none;" src="<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>loading.gif" >
        </div>	
    </form>
</div>
<div class="memberListing">
    <script>
        function edit_member_details($id)
        {
            $('.field-error').removeClass('field-error');
            $('.error-input').remove();
            $('#success-input').remove();

            $('.text' + $id).toggle();
            $('.input' + $id).toggle();
            var is_type_value = '<?php echo $session['is_type'] ?>';
            var captain_type = '<?php echo CONST_USER_CAPTAIN ?>';

            var hidden_type = $('#hidden_type' + $id).val();
            var type_dropdown_text = 'Catptain';

            if ((hidden_type != captain_type) && is_type_value == captain_type)
            {
                $('.text_is_type' + $id).toggle();
                $('.input_is_type' + $id).toggle();
                hidden_type = $('#changed_is_type' + $id).val();
                type_dropdown_text = $("#changed_is_type" + $id + " option:selected").text();
            }



            if ($('.input' + $id).css('display') == 'none')
            {
                var user_name = $('#changed_user_name' + $id).val();
                var user_email_id = $('#changed_user_email_id' + $id).val();

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . FN_USER_CHANGE_DETAILS ?>",
                    data: {user_name: user_name, user_email_id: user_email_id, is_type: hidden_type, id: $id, team_id:<?php echo $session['team_id'] ?>},
                    beforeSend: function () {
                        $('.loader_for_member_details_update' + $id).show();
                    },
                    success: function (data) {
                        $('.field-error').removeClass('field-error');
                        $('.error-input').remove();
                        $('#success-input').remove();
                        var result = data.split("~");
                        //alert(data);
                        if (result[0] == 'success')
                        {

                            $('#user_name_span' + $id).html(user_name);
                            $('#user_email_id_span' + $id).html(user_email_id);
                            $('#is_type_span' + $id).html(type_dropdown_text);
                            $("#edit" + $id).toggleClass("save").toggleClass("edit");
                            $("<span class='success-input'>" + result[2] + "</span>").insertAfter('#' + result[1]);
                            setTimeout(function () {

                                $('.success-input').remove();
                                window.location.reload();
                            }, 3000);
                        } else if (result[0] == 'success_mail')
                        {
                            $('#user_name_span' + $id).html(user_name);
                            $('#user_email_id_span' + $id).html(user_email_id);
                            $('#verification_' + $id).html('Not Verified');
                            $('#is_type_span' + $id).html(type_dropdown_text);
                            $("#edit" + $id).toggleClass("save").toggleClass("edit");
                            $("<span class='success-input'>" + result[2] + "</span>").insertAfter('#' + result[1]);
                            setTimeout(function () {
                                $('.success-input').remove();
                                window.location.reload();
                            }, 3000);
                        } else
                        {
                            $('.text' + $id).hide();
                            $('.input' + $id).show();
                            $('.text_is_type' + $id).hide();
                            if ((hidden_type != captain_type) && is_type_value == captain_type)
                            {
                                $('.input_is_type' + $id).show();
                                $('#is_type_span' + $id).html(type_dropdown_text);
                            }
                            $('#' + result[1]).addClass('field-error');
                            $("<span class='error-input'>" + result[2] + "</span>").insertAfter('#' + result[0]);
                            setTimeout(function () {
                                $('.error-input').remove();
                            }, 3000);
                        }
                    },
                    complete: function () {
                        $('.loader_for_member_details_update' + $id).hide();
                    }
                });
            } else
            {
                $("#edit" + $id).toggleClass("save").toggleClass("edit");
            }

        }
    </script>
    <table>
        <tr>
            <th>ID</th>
            <th>Profile Picture</th>
            <th>Name</th>
            <th>Email ID</th>
            <th>Type</th>
            <th>Status</th>
            <th>Action</th>
            <th></th>
        </tr>

        <?php
        if (count($member_list) > 0) {
            $serial_no = 1;
            foreach ($member_list as $row_member_list) {
                ?>
                <tr id="row_<?php echo $row_member_list['id'] ?>">
                    <td><?php echo $serial_no ?></td>
                    <td>
                        <?php if ($row_member_list['img_profile'] == '') { ?> 
                            <img id="profile_img_<?php echo $row_member_list['id'] ?>" src="<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>profile_demo_picture.png" width="50" height="50"></a>
                        <?php } else { ?>
                            <img id="profile_img_<?php echo $row_member_list['id'] ?>" src="<?php echo base_url() . CONST_PATH_PROFILE_IMAGE . $row_member_list['img_profile'] ?>" width="50" height="50"></a> 
                        <?php } ?>
                    </td>
                    <td class="text<?php echo $row_member_list['id'] ?>"><span id="user_name_span<?php echo $row_member_list['id'] ?>"><?php echo stripslashes($row_member_list['user_name']) ?></span></td>
                    <td class="input<?php echo $row_member_list['id'] ?>" style="display:none;"><input type="text" name="user_name" id="changed_user_name<?php echo $row_member_list['id'] ?>" class="edit-input" value="<?php echo stripslashes($row_member_list['user_name']) ?>"/></td>
                    <td class="text<?php echo $row_member_list['id'] ?>"><span id="user_email_id_span<?php echo $row_member_list['id'] ?>"><?php echo stripslashes($row_member_list['user_email_id']) ?></span></td>
                    <td class="input<?php echo $row_member_list['id'] ?>" style="display:none;"><input type="text" name="user_email_id" id="changed_user_email_id<?php echo $row_member_list['id'] ?>" class="edit-input" value="<?php echo stripslashes($row_member_list['user_email_id']) ?>"/></td>
                    <td class="text_is_type<?php echo $row_member_list['id'] ?>"><span id="is_type_span<?php echo $row_member_list['id'] ?>">
                            <?php
                            if ($row_member_list['is_type'] == CONST_USER_CAPTAIN) {
                                echo 'Captain';
                            } elseif ($row_member_list['is_type'] == CONST_USER_VICECAPTAIN) {
                                echo 'Vice Captain';
                            } elseif ($row_member_list['is_type'] == CONST_USER_TEAMMEMBER) {
                                echo 'Team Member';
                            } elseif ($row_member_list['is_type '] == CONST_USER_FACULTY) {
                                echo 'Faculty';
                            }
                            ?></span>
                    </td>
                <script>
                    function delete_user_record($table_name, $id)
                    {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url() . FN_DELETE_TEAM_MEMBER ?>",
                            data: {table_name: $table_name, id: $id},
                            beforeSend: function () {
                                $('.loader_for_member_details_update' + $id).show();
                            },
                            success: function (data) {
                                var result = data.split("~");
                                if (result[0] == 'success')
                                {
                                    $("<span class='success-msg' id='success'" + $id + ">" + result[1] + "</span>").insertAfter('#action_' + $id);
                                    setTimeout(function () {
                                        $('#success' + $id).hide();
                                        $('#row_' + $id).hide();
                                    }, 2000);
                                } else
                                {
                                    $('#' + result[0]).addClass('field-error');
                                    $("<span class='error-input'>" + result[1] + "</span>").insertAfter('#' + result[0]);
                                }

                            },
                            complete: function () {
                                $('.loader_for_member_details_update' + $id).hide();
                            }
                        });
                    }
                </script>
                <td class="input_is_type<?php echo $row_member_list['id'] ?>" style="display:none;">
                    <select id="changed_is_type<?php echo $row_member_list['id'] ?>" name="is_type"  class="edit-input" >
                        <option value="<?php echo CONST_USER_TEAMMEMBER ?>" <?php
                    if ($row_member_list['is_type'] == CONST_USER_TEAMMEMBER) {
                        echo 'selected';
                    }
                            ?>>Team Member</option>
                        <option value="<?php echo CONST_USER_VICECAPTAIN ?>" <?php
                        if ($row_member_list['is_type'] == CONST_USER_VICECAPTAIN) {
                            echo 'selected';
                        }
                            ?>>Vice Captain</option>
                        <option value="<?php echo CONST_USER_FACULTY ?>" <?php
                        if ($row_member_list['is_type'] == CONST_USER_FACULTY) {
                            echo 'selected';
                        }
                            ?>>Faculty</option>
                    </select>
                    <input type="hidden" id="hidden_type<?php echo $row_member_list['id'] ?>"  value="<?php echo $row_member_list['is_type'] ?>">	
                </td>
                <td><span  id="verification_<?php echo $row_member_list['id'] ?>">
                        <?php
                        if ($row_member_list['is_verified'] == CONST_VERIFICATION_ACTIVATE) {
                            echo 'Verified';
                        } else {
                            echo 'Not Verified';
                        }
                        ?> </span>
                </td>
                <td id="action_<?php echo $row_member_list['id'] ?>"><?php if (($session['id'] == $row_member_list['id']) || $session['is_type'] == CONST_USER_CAPTAIN) { ?><a class="edit" id="edit<?php echo $row_member_list['id'] ?>" href="javascript:void(0);"  onclick="edit_member_details(<?php echo $row_member_list['id'] ?>);">Edit</a><?php } ?>
                    <?php if (($session['is_type'] != $row_member_list['is_type']) && $session['is_type'] == CONST_USER_CAPTAIN) { ?> <a href="javascript:void(0);" onclick="delete_user_record('users',<?php echo $row_member_list['id'] ?>)">Delete</a><?php } ?><img class="loader_for_member_details_update<?php echo $row_member_list['id'] ?>" style="display:none;" src="<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>loading.gif" ></td>
                <td></td>

                </tr>
                <?php
                $serial_no++;
            }
        }
        ?>

    </table>
</div>
<div class="address_detail">
    <h3>Address Details</h3>
    <script type="text/javascript">
        function editUserAddress()
        {
            $('#address_in_text').toggle();
            $('#address_in_input').toggle();
            $('#closeAddress').toggle();
            var user_address = $('#user_address').val();
            var country_id = $('#country_id').val();
            var state_id = $('#state_id').val();
            var city_id = $('#city_id').val();
            var pin = $('#pin').val();
            var country_id_text = $("#country_id option:selected").text();
            var state_id_text = $("#state_id option:selected").text();
            var city_id_text = $("#city_id option:selected").text();

            if ($('#address_in_input').css('display') == 'none')
            {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . FN_USER_CHANGE_ADDRESS_DETAILS ?>",
                    data: {user_address: user_address, country_id: country_id, state_id: state_id, city_id: city_id, pin: pin, id:<?php echo $session['id'] ?>},
                    beforeSend: function () {
                        $('.address_loader').show();
                    },
                    success: function (data) {

                        $('.field-error').removeClass('field-error');
                        $('.error-input').remove();
                        $('#address_edit_success').html('');

                        var result = data.split("~");

                        if (result[0] == 'success')
                        {

                            $('#address_in_text').show();
                            $('#address_in_input').hide();
                            $('#address_edit_success').html(result[1]);
                            setTimeout(function () {
                                $('#address_edit_success').html('');
                            }, 3000);
                            $("#editAddress").toggleClass("save").toggleClass("edit");
                            $('#user_address_span').html(user_address);
                            $('#country_id_span').html(country_id_text);
                            $('#state_id_span').html(state_id_text);
                            $('#city_id_span').html(city_id_text);
                            $('#pin_span').html(pin);
                        } else
                        {
                            $('#address_in_text').hide();
                            $('#address_in_input').show();
                            $('#closeAddress').show();
                            $('#' + result[0]).addClass('field-error');
                            $("<span class='error-input'>" + result[1] + "</span>").insertAfter('#' + result[0]);

                        }

                    },
                    complete: function () {
                        $('.address_loader').hide();
                    }
                });
            } else
            {
                $("#editAddress").toggleClass("save").toggleClass("edit");
                $('#address_in_text').hide();
                $('#address_in_input').show();
                $('#closeAddress').show();
            }
        }
        function closeUserAddress()
        {
            $('#address_in_text').toggle();
            $('#address_in_input').toggle();
            $('#closeAddress').toggle();
            $("#editAddress").toggleClass("save").toggleClass("edit");
        }
    </script>
    <a href="javascript:void(0)" id="editAddress" class="edit" onclick="editUserAddress();">Edit</a>
    <a href="javascript:void(0)" id="closeAddress" class="close" onclick="closeUserAddress();" style="display:none;">Close</a>
    <img class="address_loader" style="display:none;" src="<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>loading.gif" >
    <div id="address_edit_success"></div>
    <input type="hidden" id="checkErrorForAddress" value="0">
    <div id="address_in_text">	
        <div><label>Address: </label><span id="user_address_span"><?php echo stripslashes($member_details['user_address']); ?></span></div>
        <div><label>Country: </label><span id="country_id_span"><?php echo stripslashes($getMemberCountryName['country_name']); ?></span></div>
        <div><label>State: </label><span id="state_id_span"><?php echo stripslashes($getMemberStateName['state_name']); ?></span></div>
        <div><label>City: </label><span id="city_id_span"><?php echo stripslashes($getMemberCityName['city_name']); ?></span></div>
        <div><label>Zip Code: </label><span id="pin_span"><?php echo stripslashes($member_details['pin']); ?></span></div>
    </div>
    <div id="address_in_input" style="display:none;">

        <div>
            <label>Address: </label>
            <input type="text" name="user_address" id="user_address" value="<?php echo stripslashes($member_details['user_address']); ?>">
        </div>    	
        <div>
            <label>Country: </label>
            <select name="country_id" id="country_id">
                <option value="0">Select Country</option>
                <?php foreach ($listCountry as $values) { ?>
                    <option value="<?php echo $values['country_id'] ?>" <?php
                if ($values['country_id'] == $getMemberCountryName['country_id']) {
                    echo 'selected';
                }
                    ?>><?php echo $values['country_name'] ?> </option>
                        <?php } ?>
            </select>
        </div>
        <div>
            <label>State: </label>

            <select name="state_id" id="state_id">
                <option value="0">Select State</option>
                <?php foreach ($listState as $values) { ?>
                    <option value="<?php echo $values['state_id'] ?>" <?php
                if ($values['state_id'] == $getMemberStateName['state_id']) {
                    echo 'selected';
                }
                    ?>><?php echo $values['state_name'] ?> </option>
                        <?php } ?>
            </select>
        </div>
        <div>
            <label>City: </label>
            <select name="city_id" id="city_id">
                <option value="0">Select City</option>
                <?php foreach ($listCity as $values) { ?>
                    <option value="<?php echo $values['city_id'] ?>" <?php
                if ($values['city_id'] == $getMemberCityName['city_id']) {
                    echo 'selected';
                }
                    ?>><?php echo $values['city_name'] ?> </option>
                        <?php } ?>
            </select>
        </div>
        <div>
            <label>Pin Code: </label>
            <input type="text" name="pin" id="pin" value="<?php echo stripslashes($member_details['pin']); ?>" />
        </div>

    </div>
</div>
<script type="text/javascript">
    function editTeamDetails()
    {//alert('a');
        $('#team_details_text').toggle();
        $('#team_details_input').toggle();
        $('#closeTeamDetails').toggle();

        //var event_id = $('#event_id').val();
        var event_id = $('input[name=event_id]').val();
        var team_name = $('#team_name').val();
        var college_id = $('#college_id').val();
        var checkError = $('#checkError').val();
        //alert(checkError);
        var event_id_text = $("#event_id option:selected").text();
        var college_id_text = $("#college_id option:selected").text();


        if ($('#team_details_input').css('display') == 'none' && checkError == 0)
        {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . FN_USER_CHANGE_TEAM_DETAILS ?>",
                data: {event_id: event_id, team_name: team_name, college_id: college_id, team_id:<?php echo $session['team_id'] ?>},
                beforeSend: function () {
                    $('.team_details_loader').show();
                },
                success: function (data) {
                    var result = data.split("~");
                    if (result[0] == 'success')
                    {
                        $('#team_details_text').show();
                        $('#team_details_input').hide();
                        $('#team_details_edit_success').html(result[1]);
                        $("#editTeamDetails").toggleClass("save").toggleClass("edit");
                        $('#event_id_text').html(event_id_text);
                        $('#team_name_text').html(team_name);
                        $('#college_id_text').html(college_id_text);
                        setTimeout(function () {
                            $('#team_details_edit_success').html('');
                        }, 3000);

                    } else
                    {
                        $('#team_details_text').hide();
                        $('#team_details_input').show();
                        $('#closeTeamDetails').show();
                    }
                },
                complete: function () {
                    $('.team_details_loader').hide();
                }
            });
        } else if (checkError == 1)
        {
            $("#editTeamDetails").toggleClass("save").toggleClass("edit");
            $('#team_details_text').hide();
            $('#team_details_input').show();
            $('#closeTeamDetails').show();

        }
    }
    function closeTeamDetails()
    {
        $('#team_details_text').toggle();
        $('#team_details_input').toggle();
        $('#closeTeamDetails').toggle();
        $("#editTeamDetails").toggleClass("save").toggleClass("edit");
    }
</script>
<script type="text/javascript">
    function isUniqueTeam()
    {
        //alert('ok');
        var xhr = null;
       // var event_id = $('#event_id').val();
        var event_id = $('input[name=event_id]').val();
        var team_name = $('#team_name').val();
        var college_id = $('#college_id').val();

        if (xhr && xhr.readystate != 4) {
            xhr.abort();
        }

        xhr = $.ajax({
            type: "POST",
            url: "<?php echo base_url() . FN_USER_UNIQUE_TEAM_FOR_EDIT ?>",
            data: {event_id: event_id, team_name: team_name, college_id: college_id, team_id:<?php echo $session['team_id'] ?>},
            success: function (data) {
                //alert(data);
                var result = data.split("~");
                if (result[0] !== 'success')
                {
                    $('#' + result[0]).addClass('field-error');

                    $('#checkError').val(1);
                    $("<span class='error-input'>" + result[1] + "</span>").insertAfter('#' + result[0]);

                } else
                {
                    $('.field-error').removeClass('field-error');
                    $('.error-input').remove();
                    $('#checkError').val(0);
                }

            }
        });

    }

</script>
<div class="team_details">
    <div>
        <h3>Team Logo</h3>

        <?php if ($session['is_type'] == CONST_USER_CAPTAIN) { ?>
            <script type="text/javascript">
                $(document).ready(function (e) {
                    var _URL = window.URL || window.webkitURL;

                    $("#team_logo").change(function (e) {
                        var image, file;
                        if ((file = this.files[0])) {
                            image = new Image();
                            image.onload = function () {
                                $('#width_team_logo').val(this.width);
                                $('#height_team_logo').val(this.height);
                            };
                            image.src = _URL.createObjectURL(file);
                        }

                    });
                    $("#uploadForm_team_logo").on('submit', (function (e) {
                        e.preventDefault();
                        $('#team_logo_content :input[type=submit]').attr('disabled', true);
                        $.ajax({
                            url: "<?php echo base_url() . FN_USER_SET_TEAM_LOGO ?>",
                            type: "POST",
                            data: new FormData(this),
                            contentType: false,
                            cache: false,
                            processData: false,
                            beforeSend: function () {
                                $('.loader_team_logo').show()
                            },
                            success: function (data) {
                                $('#team_logo_content :input[type=submit]').attr('disabled', false);
                                var result = data.split("~");
                                $('.field-error').removeClass('field-error');
                                $('.error-input').remove();

                                if (result[0] == 'success')
                                {
                                    $('#new_uploaded_team_logo').attr('src', result[1]);
                                    $('#team_logo_<?php echo $session_user["id"] ?>').attr('src', result[1]);
                                    $('#success_team_logo_upload').html('<div class="success-msg">Team logo has been successfully updated.</div>');
                                    setTimeout(function () {
                                        $('#team_logo_content').dialog('close');
                                        $('#success_team_logo_upload').html('');
                                    }, 2000);
                                } else
                                {
                                    $('#' + result[0]).addClass('field-error');
                                    $("<span class='error-input'>" + result[1] + "</span>").insertAfter('#' + result[0]);
                                }
                            },
                            complete: function () {
                                $('.loader_team_logo').hide();
                            }
                        });
                    }));
                });
                function readURLteam_logo(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        var file_extension = $('#team_logo').val().split('.').pop().toLowerCase();
                        if (file_extension == 'jpg' || file_extension == 'jpeg' || file_extension == 'gif' || file_extension == 'png')
                        {
                            reader.onload = function (e) {
                                $('#blah_team_logo').attr('src', e.target.result);
                            };
                            reader.readAsDataURL(input.files[0]);
                        } else
                        {
                            $("#team_logo").val("");
                            $('#blah_team_logo').attr('src', '<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>noimage.png');
                        }

                    }
                }
            </script>
            <div id="team_logo_content" style="display:none;" title="Choose Team Logo">

                <form id="uploadForm_team_logo" action="<?php echo base_url() . FN_USER_SET_TEAM_LOGO ?>" method="post" enctype="multipart/form-data">
                    <label>Upload Image File:</label>
                    <input type="hidden"  name="width"  id="width_team_logo"  />
                    <input type="hidden"  name="height"  id="height_team_logo"  />
                    <input type="hidden"  name="team_Logo_image"  id="team_Logo_image" value="<?php echo $get_team_event_college_details['img_logo']; ?>" />
                    <div>
                        <img id="blah_team_logo" src="<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>noimage.png" alt="Preview" width="150" height="150" />
                    </div>
                    <div id="success_team_logo_upload"></div>
                    <div>
                        <input type="file"  name="team_logo" class="team_logo" id="team_logo" onchange="readURLteam_logo(this);" />
                    </div>

                    <div>
                        <input type="submit" value="Submit" class="btnSubmit" /><img class="loader_team_logo" style="display:none;" src="<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>loading.gif" >
                    </div>
                </form>
            </div>
            <a href="javascript:void(0);" id="set_team_logo">
                <?php if (empty($get_team_event_college_details['img_logo'])) { ?> 
                    <img id="new_uploaded_team_logo" src="<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>profile_demo_picture.png">
                <?php } else { ?>
                    <img id="new_uploaded_team_logo" src="<?php echo base_url() . CONST_PATH_TEAM_LOGO . $get_team_event_college_details['img_logo'] ?>">
                <?php } ?>
            </a>
            <?php
        } else {
            if (empty($get_team_event_college_details['img_logo'])) {
                ?> 
                <img id="new_uploaded_team_logo" src="<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>profile_demo_picture.png">
            <?php } else { ?>
                <img id="new_uploaded_team_logo" src="<?php echo base_url() . CONST_PATH_TEAM_LOGO . $get_team_event_college_details['img_logo'] ?>">
            <?php } ?>
        <?php } ?> 

    </div>

    <div>
        <h2>Team Details</h2>
        <?php if ($session['is_type'] == CONST_USER_CAPTAIN) { ?>
            <a href="javascript:void(0)" id="editTeamDetails" class="edit" onclick="editTeamDetails();">Edit</a>
            <a href="javascript:void(0)" id="closeTeamDetails" class="close" onclick="closeTeamDetails();" style="display:none;">Close</a>
            <img class="team_details_loader" style="display:none;" src="<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>loading.gif">
        <?php } ?>    
        <div id="team_details_edit_success"></div>
        <input type="hidden" id="checkError" value="0">
        <div id="team_details_text">  
            <div>
                <label>Entended Event: </label> 
                <span id="event_id_text" ><?php echo $get_team_event_college_details['event_name']; ?></span> 
            </div>
            <div>
                <label>Team Name: </label>
                <span id="team_name_text" ><?php echo $get_team_event_college_details['team_name']; ?></span> 

            </div>
            <div>
                <label>College Name: </label>
                <span id="college_id_text" ><?php echo $get_team_event_college_details['college_name']; ?></span> 
            </div>   
        </div>
        <div id="team_details_input" style="display:none;">  
            <div>
                <label>Entended Event</label>
                <select name="event_id" id="event_id" onchange="isUniqueTeam()"> 
                    <?php foreach ($ListEvent as $values) { ?>
                        <option value="<?php echo $values['id'] ?>" <?php
                    if ($values['id'] == $get_team_event_college_details['event_id']) {
                        echo 'selected';
                    }
                        ?>><?php echo $values['event_name'] ?></option>
                            <?php } ?>
                </select> 

            </div>
            <div>
                <label>Team Name</label>
                <input type="text" name="team_name" id="team_name" onkeyup="isUniqueTeam()" value="<?php echo $get_team_event_college_details['team_name']; ?>" />

            </div>
            <div>
                <label>College Name</label>
                <select name="college_id" id="college_id" onchange="isUniqueTeam()">
                    <option value="0">Choose One</option>
                    <?php foreach ($listColleges as $values) { ?>
                        <option value="<?php echo $values['id']; ?>" <?php
                    if ($values['id'] == $get_team_event_college_details['college_id']) {
                        echo 'selected';
                    }
                        ?>><?php echo $values['college_name']; ?></option>
                            <?php } ?>

                </select>

            </div>   
        </div>
    </div>
</div>
<div>
    <h2>Activity</h2>
</div>