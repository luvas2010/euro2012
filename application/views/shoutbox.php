<div id='shoutbox' class='container_12'>
<?php

foreach ($shouts as $shout)
{ ?>
    <div class='clear' id="shout<?php echo $shout['id']; ?>"></div>
	<div  class='shoutwrapper'>
        <?php
        $shout_account_details = $this->account_details_model->get_by_account_id($shout['account_id']);
        if (isset($shout_account_details->picture))
            {
                    $imgstring = "<img src='".base_url()."resource/user/profile/".$shout_account_details->picture."?t=".md5(time())."' alt='' style='float:left;' />";
            }
            else
            {
                    $imgstring = "<img src='".base_url()."resource/img/default-picture.gif' alt='' style='float:left;'/>";
            }
        ?>
        <div class="grid_12 alpha omega">
            <h6><?php echo sprintf(lang('shout_header'), $shout['username'],mdate("%d-%m-%Y",$shout['postedon']), mdate("%H:%i",$shout['postedon']) ); ?></h6>
            <div class="grid_2 alpha">
                <?php echo $imgstring; ?>
            </div>
            <div class="grid_8">
                <p><?php echo $shout['message']; ?></p>
            </div>
            <div class="grid_2 omega">
                <?php
                if ($shout['account_id'] == $this->session->userdata('account_id') || is_admin())
                { 
                    echo anchor('shoutbox/delete/'.$shout['id'].'/box',lang('delete_shout'), "class='button comment_delete'");
                }
                ?>
            </div>
        </div>
    </div>
<?php
}
?>
</div>