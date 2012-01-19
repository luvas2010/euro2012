<div class='container_12'>
<?php

foreach ($shouts as $shout)
{
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
	<?php echo $imgstring."<p>".$shout['message']."</p>"; ?>
	</div>
<?php
}
?>
</div>