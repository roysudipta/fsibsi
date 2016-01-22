<div class="caption reply_div" id="reply_<?php echo $reply_details['reply_id'] ?>">
    <div class="media">
        <div class="portlet-body">
            <div class="general-item-list">
                <div class="item">
                    <div class="item-head"><a href="javascript:void();" class="item-status"><i class="fa fa-minus-circle" data-id="<?php echo $reply_details['reply_id']; ?>"></i> </a>
                        <div class="item-details">
                            <?php if ($reply_details['img_profile'] == '') { ?> 
                                <img class="item-pic" src="<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>profile_demo_picture.png">
                            <?php } else { ?>
                                <img class="item-pic" src="<?php echo base_url() . CONST_PATH_PROFILE_IMAGE . $reply_details['img_profile'] ?>">
                            <?php } ?>

                            <a href="javascript:void(0);" class="item-name primary-link"><?php echo ucwords(stripslashes($reply_details['user_name'])); ?></a>
                            <span class="item-label">on <?php echo date_format(new DateTime($reply_details['created']), CONST_DATETIME_FORMAT_DMYHIS); ?></span><br>
                            <span class="text-muted" style="float: left; margin: -14px 0px -1px 48px;"><?php echo stripslashes($reply_details['user_email_id']) ?></span>
                        </div>
                    </div>
                    <div class="media-body">
                        <?php echo ucfirst(stripslashes($reply_details['reply_content'])); ?>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    </div>
</div>