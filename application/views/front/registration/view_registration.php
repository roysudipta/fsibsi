
<script>
    $(document).ready(function () {
    $( "#date_of_birth" ).datepicker();
  
         $('#registration_from').on('submit',function(e) {
            $('.field-error').removeClass('field-error');
            $('.error-input').remove();
            $('#success').removeClass('success_msg');
            var event_id = $('#event_id').val();
            var team_name = $('#team_name').val();
            var college_id = $('#college_id').val();
            var user_name = $('#user_name').val();

            var user_email_id = $('#user_email_id').val();
            var date_of_birth = $('#date_of_birth').val();
            var question1 = $('#question1').val();
            var answer1 = $('#answer1').val();
            var question2 = $('#question2').val();
            var answer2 = $('#answer2').val();
            var user_pwd = $('#user_pwd').val();
            var cpwd = $('#cpwd').val();
            var user_address = $('#user_address').val();
            var country_id = $('#country_id').val();
            var state_id = $('#state_id').val();
            var city_id = $('#city_id').val();
            var pin = $('#pin').val();

            $.ajax({
                type: "POST",
                url: "<?php echo base_url().FN_USER_FORM_REGISTRATION ?>",
                data: {event_id: event_id, team_name: team_name,college_id:college_id, user_email_id: user_email_id,date_of_birth:date_of_birth,user_name:user_name, question1: question1, answer1: answer1, question2: question2, answer2: answer2, user_pwd: user_pwd, cpwd: cpwd, user_address: user_address, country_id: country_id, state_id: state_id, city_id: city_id,pin:pin },
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
                        $('#college_id option[value=0]').attr('selected','selected');
                        $('#event_id option[value=0]').attr('selected','selected');
                        $('#country_id option[value=0]').attr('selected','selected');
                        $('#state_id option[value=0]').attr('selected','selected');
                        $('#city_id option[value=0]').attr('selected','selected');
                        $('#question option[value=0]').attr('selected','selected');
                        $('#question2 option[value=0]').attr('selected','selected');
                        $('#success').html('Congrats! You have been successfully submitted your details. An activation mail has been sent to your email address.');
                    }


                }
            });
            e.preventDefault();

        });
        
    });
</script>
<script type="text/javascript">
    function isUniqueTeam()
        {
            var xhr = null;
            var event_id = $('#event_id').val();
            var team_name = $('#team_name').val();
            $('.field-error').removeClass('field-error');
            $('.error-input').remove();
            $('#success').removeClass('success_msg');
            var user_email_id = $('#user_email_id').val();

            if (xhr && xhr.readystate != 4) {
                 xhr.abort();
            }
            //re.stopImmediatePropagation();
           xhr = $.ajax({
                type: "POST",
                url: "<?php echo base_url() .FN_USER_UNIQUE_TEAM?>",
                data: {event_id: event_id, team_name: team_name},
                success: function (data) {
                   // alert(data);
                    var result = data.split("~");
                    if(result[0]!=='success')
                    {
                        $('#'+result[0]).addClass('field-error');
                        $('.field-error').removeClass('field-error');
                        $('.error-input').remove();
                        $("<span class='error-input'>"+result[1]+"</span>").insertAfter('#'+result[0]);
                    }



                }
            });

        }

</script>

<div id="success" ></div>
<form action="" method="post" id="registration_from">
    <div>
        <label>Entended Event</label>
        <select name="event_id" id="event_id" onchange="isUniqueTeam()"> 
            <?php foreach ($ListEvent as $values) { ?>
                <option value="<?php echo $values['id'] ?>"><?php echo $values['event_name'] ?></option>
            <?php } ?>
        </select>	
       
    </div>
    <div>
        <label>Team Name</label>
        <input type="text" name="team_name" id="team_name" onkeyup="isUniqueTeam()"/>
       
    </div>
    <div>
        <label>College Name</label>
        <select name="college_id" id="college_id">
            <option value="0">Choose One</option>
            <?php foreach ($listColleges as $values) { ?>
                <option value="<?php echo $values['id'] ;?>"><?php echo $values['college_name'] ;?></option>
            <?php } ?>

        </select>
       
    </div>
    <div>
        <label>Username</label>
        <input type="text" name="user_name" id="user_name" />
       
    </div>
    <div>
        <label>Email</label>
        <input type="text" name="user_email_id" id="user_email_id" />
       
    </div>
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
    <div>
        <label>Address</label>
        <input type="text" name="user_address" id="user_address" />
       
    </div>
    <div>
        <label>Country</label>
        <select name="country_id" id="country_id">
            <option value="0">Select Country</option>
            <?php foreach ($countries as $values) { ?>
                <option value=<?php echo $values['country_id'] ?>><?php echo $values['country_name'] ?> </option>
            <?php } ?>
        </select>
       
    </div>
    <div>
        <label>State</label>

        <select name="state_id" id="state_id">
            <option value="0">Select State</option>
        </select>
       

    </div>
    <div>
        <label>City</label>
        <select name="city_id" id="city_id">
            <option value="0">Select City</option>
        </select>
       
    </div>
    <div>
        <label>Pin Code</label>
        <input type="text" name="pin" id="pin" />
    </div>
    <input type="submit" id="submit" name="submit" value="Submit">
</form>
