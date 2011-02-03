<?php
// fetch language file
$this->lang->load('welcome', language() );
?>

<p><?php echo lang('intro');?> <?php echo $settings['poolname']; ?></p>
<p><?php echo anchor('login',lang('login'));?></p>
<p><?php echo anchor('signup',lang('create'));?></p>
