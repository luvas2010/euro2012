<?php
// fetch language file
$this->lang->load('welcome', language() );
?>

<p><?php echo $this->lang->line('intro');?> <?php echo $settings['poolname']; ?></p>
<p><?php echo anchor('login',$this->lang->line('login'));?></p>
<p><?php echo anchor('signup',$this->lang->line('create'));?></p>
