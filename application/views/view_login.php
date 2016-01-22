<div id="alert"></div>
<form action="" id="loginForm" method="post" >
    <div>
        <label>User ID</label>
        <input type="text" name="uid" id="uid" />
        <a href="<?php echo base_url() . CONTROLLER_AUTH ?>forgot_email">Forgot Email</a>
    </div>

    <div>
        <label>Password</label>
        <input type="password" name="pwd" id="pwd" />
        <a href="<?php echo base_url() . CONTROLLER_AUTH ?>forgot_password">Forgot Password</a>
    </div>  
    <input type="submit" id="submit" name="submit" value="Submit">
</form>


<script>
    function isValidEmailAddress(emailAddress) {
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        return pattern.test(emailAddress);
    }
    ;
    $(document).ready(function () {
        $('#loginForm').on('submit', function (e) {
            $('.field-error').removeClass('field-error');
            $('.error-input').remove();
            $('#alert').html('');
            var uid = $('#uid').val();
            var pwd = $('#pwd').val();
            if (uid == '') {
                $('#uid').addClass('field-error');
                $("<span class='error-input'>User ID can not be blank.</span>").insertAfter('#uid');
            } else if (!isValidEmailAddress(uid)) {
                $('#uid').addClass('field-error');
                $("<span class='error-input'>Please enter a valid email address.</span>").insertAfter('#uid');
            } else if (pwd == '') {
                $('#pwd').addClass('field-error');
                $("<span class='error-input'>Password can not be blank.</span>").insertAfter('#pwd');
            } else {
                $.ajax({
                    type: "POST",
                    data: 'uid=' + uid + '&pwd=' + pwd,
                    url: "<?php echo base_url() . FN_USER_AUTHENTICATE; ?>",
                    success: function (data) {
                        var result = data.split("~");
                        if (result[0] == 'success')
                        {
                            $('#alert').html(result[1]).delay(2000);
                            window.location = result[2];
                        } else
                        {
                            if (result[0] == 'alert')
                            {
                                $('#alert').html('<div class="error_msg">' + result[1] + '</div>');
                            } else
                            {
                                $('#'.result[0]).addClass('field-error');
                                $("<span class='error-input'>" + result[1] + "</span>").insertAfter('#' + result[0]);
                            }
                        }

                    }

                });
            }
            e.preventDefault();
        });
    });
</script>
