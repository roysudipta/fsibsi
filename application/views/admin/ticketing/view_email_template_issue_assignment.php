<html>
    <head>
    </head>
    <body>
        <?php if ($purpose == 'reply') { ?>

            <div>
                <p>Hello <?php echo ucwords(stripslashes($user_name)); ?>,</p>
                <p>A new reply has been posted against <strong>'<?php echo ucfirst(stripslashes($subject)) ?>'</strong> and the reply is as follows<br> </p>
                <p><?php echo ucfirst(stripslashes($reply_content)) ?></p>
            </div>
        <?php }
        elseif ($purpose == 'responsible_person_changed_mail_to_user') {
            ?>

            <div>
                <p>Hello <?php echo ucwords(stripslashes($user_name)); ?>,</p>
                <p>Responsible person of your posted issue ticket named <strong>'<?php echo ucfirst(stripslashes($subject)) ?>'</strong> has been changed by admin to <strong><?php echo ucfirst(stripslashes($responsible_person)) ?>.
                </p>
                
            </div>
        <?php } 
       elseif ($purpose == 'responsible_person_changed_mail_to_official') {
            ?>

            <div>
                <p>Hello <?php echo ucwords(stripslashes($responsible_person)); ?>,</p>
                <p>You are selected to take care of the ticket named '<strong><?php echo ucfirst(stripslashes($subject)) ?></strong>' by admin.</p>
                
            </div>
        <?php }       
        else {
            ?>
            <div>
                <p>Hello <?php echo ucwords(stripslashes($user_name)); ?>,</p>
                <p>You are selected by Admin to resolve all issues under "<?php echo ucwords(stripslashes($category_title)) ?>" Ticket Category </p>
            </div>
<?php } ?>     
    </body>
</html>

