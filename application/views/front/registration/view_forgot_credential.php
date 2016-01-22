<?php $pageName = $this->uri->segment(2); ?>
<script>
    $(function () {
        $("#date_of_birth").datepicker();
    });
</script>
<?php if ($pageName === 'forgot_email') {
    ?>
    <script>
        $(document).ready(function () {
            $('#emailForgot').on('submit', function (e) {
                $('.field-error').removeClass('field-error');
                $('.error-input').remove();

                var date_of_birth = $('#date_of_birth').val();
                var question1 = $('#question1').val();
                var answer1 = $('#answer1').val();
                var question2 = $('#question2').val();
                var answer2 = $('#answer2').val();

                $.ajax({
                    type: "POST",
                    data: {date_of_birth: date_of_birth, question1: question1, answer1: answer1, question2: question2, answer2: answer2, type: 'emailRecover'},
                    url: "<?php echo base_url() . FN_USER_RECOVER_CREDENTIAl; ?>",
                    success: function (data) {
                        var result = data.split("~");
                        if (result[0] == 'success')
                        {
                            $('#alert').html('Email ID recovering process is being started. Please wait..');
                            setTimeout(function () {
                                $('#alert').hide();
                                $('#emailRecoverForm').html(result[1]);
                            }, 3000);

                        } else
                        {
                            if (result[0] == 'alert')
                            {
                                $('#alert').html('<div class="error_msg">' + result[1] + '</div>');
                            } else
                            {

                                $('#alert').html('');
                                $('#' + result[0]).addClass('field-error');
                                $("<span class='error-input'>" + result[1] + "</span>").insertAfter('#' + result[0]);
                            }
                        }
                    }
                });
                e.preventDefault();
            });
        });
    </script>
    <div id="alert"></div>
    <div id="emailRecoverForm">
        <form action="" method="post" id="emailForgot"> 
            <div>
                <label>Date of Birth</label>
                <input type="text" name="date_of_birth" id="date_of_birth" />
            </div>
            <div>
                <label>Security Question 1</label>
                <select name="question1" id="question1">
                    <option value="0">Choose One</option>
    <?php foreach ($securityQuestions as $values) { ?>
                        <option value="<?php echo $values->ID ?>"><?php echo $values->question ?></option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <label>Answer</label>
                <input type="text" name="answer1" id="answer1" />
            </div>
            <div>
                <label>Security Question 2</label>
                <select name="question2" id="question2">
                    <option value="0">Choose One</option>
    <?php foreach ($securityQuestions as $values) { ?>
                        <option value="<?php echo $values->ID ?>"><?php echo $values->question ?></option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <label>Answer</label>
                <input type="text" name="answer2" id="answer2" />
            </div>
            <input type="submit" id="submit" name="submit" value="Submit">
        </form>
    </div>	
<?php
} else if ($pageName === 'forgot_password') {
    ?>
    <script>
        $(document).ready(function () {
            $('#forgotPassword').on('submit', function (e) {
                $('.field-error').removeClass('field-error');
                $('.error-input').remove();
                var user_email_id = $('#user_email_id').val();
                $.ajax({
                    type: "POST",
                    data: {user_email_id: user_email_id, type: 'passwordRecover'},
                    url: "<?php echo base_url() . FN_USER_RECOVER_CREDENTIAl; ?>",
                    success: function (data) {
                        //alert(data);
                        var result = data.split("~");
                        if (result[0] == 'success')
                        {
                            $('#alert').html(result[1]);
                            $('#user_email_id').val('');
                        } else
                        {
                            if (result[0] == 'alert')
                            {
                                $('#user_email_id').addClass('field-error');
                                $('#alert').html('<div class="error">' + result[1] + '</div>');
                            } else
                            {
                                $('#alert').html('');
                                $('#' + result[0]).addClass('field-error');
                                $("<span class='error-input'>" + result[1] + "</span>").insertAfter('#' + result[0]);
                            }
                        }
                    }
                });
                e.preventDefault();
            });
        });
    </script>	
    <div id="alert"></div>
    <div id="passwordRecoverForm">
        <form action="" method="post" id="forgotPassword"> 
            <div>
                <label>Email ID</label>
                <input type="text" name="user_email_id" id="user_email_id" />
            </div>
            <input type="submit" id="submit" name="submit" value="Submit">
        </form>
    </div>
<?php }
?>