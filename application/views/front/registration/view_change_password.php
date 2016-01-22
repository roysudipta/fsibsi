<?php if($getDetailsByNonce>0)
{?>
<script>
$(document).ready(function(){
    $('#passwordChange').on('submit',function(e) {
        $('.field-error').removeClass('field-error');
        $('.error-input').remove();
              
        var user_pwd = $('#user_pwd').val();
        var cpwd = $('#cpwd').val();

            $.ajax({
                    type: "POST",
                    data: {user_pwd:user_pwd,cpwd: cpwd,nonce:'<?php echo $nonce?>'},
                    url: "<?php echo base_url() . FN_USER_CHANGE_PASSWORD; ?>",
                    success: function (data) {
                        var result = data.split("~");
                        if(result[0] == 'success')
                        {
                            $( '#alert' ).html(result[1]);
                            $('#user_pwd').val('');
                            $('#cpwd').val('');
                        }
                        else
                        {
                    		$('#alert').html('');  
                            $('#'+result[0]).addClass('field-error');
                            $("<span class='error-input'>"+result[1]+"</span>").insertAfter('#'+result[0]);     
                        }
                    }
                });
     e.preventDefault();   
 });
});
</script>
		<div id="alert"></div>
          
            <form action="" method="post" id="passwordChange"> 
                <div>
                    <label>New Password</label>
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
    echo '<p>The link has been expired.</p>';
}           