<div class="reply_list" id="reply_div">
    <div class="item-details">
        <?php if ($reply_details['img_profile'] == '') { ?> 
            <img width="50" height="50" class="item-pic" src="<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>profile_demo_picture.png">
        <?php } else { ?>
            <img width="50" height="50" class="item-pic" src="<?php echo base_url() . CONST_PATH_PROFILE_IMAGE . $reply_details['img_profile'] ?>">
        <?php } ?>
        <p><?php echo ucfirst(stripslashes($reply_details['reply_content'])) ?></p>

        <a href="javascript:void(0);" class=""><?php echo ucwords(stripslashes($reply_details['user_name'])); ?></a>
        <span class="item-label">on <?php echo date_format(new DateTime($reply_details['created']), CONST_DATETIME_FORMAT_DMYHIS); ?></span><br>
        <span class="text-muted"><?php echo stripslashes($reply_details['user_email_id']) ?></span>
    </div>
</div>
<hr>  