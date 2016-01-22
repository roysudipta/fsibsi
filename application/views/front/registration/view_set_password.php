<?php if($getDetailsByNonce!=NULL)
{?>

<script>
    $(document).ready(function () {
    $( "#date_of_birth" ).datepicker();
  
         $('#registration_from').on('submit',function(e) {
            $('.field-error').removeClass('field-error');
            $('.error-input').remove();
            $('#success').removeClass('success_msg');
           
            var date_of_birth = $('#date_of_birth').val();
            var question1 = $('#question1').val();
            var answer1 = $('#answer1').val();
            var question2 = $('#question2').val();
            var answer2 = $('#answer2').val();
            var user_pwd = $('#user_pwd').val();
            var cpwd = $('#cpwd').val();

            $.ajax({
                type: "POST",
                url: "<?php echo base_url().FN_TEAM_DETAILS_SET ?>",
                data: $( this ).serialize() ,
                success: function (data) {
                   
                     $('.field-error').removeClass('field-error');
                     $('.error-input').remove();
                     $('#success').removeClass('success_msg');
                    var result = data.split("~");
                    if(result[0]!=='success')
                    {
                        $('#'+result[0]).addClass('field-error');
                        $("<span class='error-input'>"+result[1]+"</span>").insertAfter('#'+result[0]);
                        
                       
                    }
                    else
                    {   
                        $('.field-error').removeClass('field-error');
                        $('.error-input').remove();
                        $('#success').addClass('success_msg');
                        $('input:not(input[type=submit])').val('');
                        
                        $('#question option[value=0]').attr('selected','selected');
                        $('#question2 option[value=0]').attr('selected','selected');
                        $('#success').html(result[1]);
                        setTimeout(function(){
                             window.location.href ='<?php echo base_url().FN_LOGIN?>';
                        },2000);
                    }


                }
            });
            e.preventDefault();

        });
        
    });
</script>
<div id="success" ></div>
<form action="" method="post" id="registration_from">
   <input type="hidden" name="nonce" value="<?php echo $nonce?>"> 
    <div>
        <label>Captain's DOB</label>
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
    <div>
        <label>Password</label>
        <input type="password" name="user_pwd" id="user_pwd" />
       
    </div>
    <div>
        <label>Confirm Password</label>
        <input type="password" name="cpwd" id="cpwd" />
       
    </div>
    <input type="submit" id="submit" name="submit" value="Submit">
</form>
<?php }
else
{
    echo '<p>Link has been expired.</p>';
}?>