<div class="list">
    <?php if ($ticket_details['img_profile'] == '') { ?> 
        <img width="50" height="50" class="item-pic" src="<?php echo base_url() . CONST_PATH_DEMO_IMAGE ?>profile_demo_picture.png">
    <?php } else { ?>
        <img width="50" height="50" class="item-pic" src="<?php echo base_url() . CONST_PATH_PROFILE_IMAGE . $ticket_details['img_profile'] ?>">
    <?php } ?>
    <h3><a href="<?php echo base_url() . FN_ISSUE_TICKET . $ticket_details['slug_alias']; ?>"><?php echo ucfirst(stripslashes($ticket_details['subject'])); ?></a></h3>
    <?php if ($ticket_details['is_status'] == CONST_ACTIVATE) { ?>
        <span class="item-status"><span class="badge badge-empty badge-success"></span> Open</span>
    <?php } else { ?>
        <span class="item-status"><span class="badge badge-empty badge-danger"></span> Closed</span>
    <?php } ?>
    <p><?php echo stripslashes($ticket_details['description']) ?></p>
    <a href="javascript:void(0);" class=""><?php echo ucwords(stripslashes($ticket_details['user_name'])); ?></a>
    <span class="item-label">on <?php echo date_format(new DateTime($ticket_details['created']), CONST_DATETIME_FORMAT_DMYHIS); ?></span><br>
    <span class="text-muted"><?php echo stripslashes($ticket_details['user_email_id']) ?></span>

</div>