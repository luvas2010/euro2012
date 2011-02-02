<?php
/* haal taalbestand op */
$this->lang->load('welcome', 'nederlands');
/* Dit moet nog aangepast worden*/
?>

<p><?php echo $this->lang->line('intro');?> <?php echo $settings['poolname']; ?>
<p>
<p><?php echo anchor('login',$this->lang->line('login'));?></p>
<p><?php echo anchor('signup',$this->lang->line('create'));?>
