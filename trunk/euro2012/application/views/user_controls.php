<?php
// fetch language file
$this->lang->load('welcome', language() );
?>

	<?php if (logged_in()) { ?>
		<h3><?php echo $this->lang->line('greetings');?> <em><?php echo Current_User::user()->nickname; ?></em>.</h3>
		<?php echo anchor('home',$this->lang->line('home')); ?>&nbsp;&nbsp;
        <?php echo anchor('logout',$this->lang->line('logout')); ?>&nbsp;&nbsp;
        <?php echo anchor('user_predictions/view/'.Current_User::user()->id,$this->lang->line('see_my_predictions')); ?>&nbsp;&nbsp;
        <?php echo anchor('user_predictions/edit/',$this->lang->line('edit_my_predictions')); ?>&nbsp;&nbsp;
        <?php echo anchor('user_info',$this->lang->line('account_info')); ?>
        <?php
            if (admin()) {
                echo "<p class='buttons'>".anchor('settings_admin','<img src="'.base_url().'images/icons/wrench.png" alt="" />'.$this->lang->line('edit_settings')).anchor('admin_functions','<img src="'.base_url().'images/icons/star.png" alt="" />'.$this->lang->line('admin_functions'))."</p>";
                }
        }
        else {
        ?>
		<h3><?php echo $this->lang->line('new_user');?>: <?php echo anchor('signup',$this->lang->line('create')); ?>.</h3>
		<h3><?php echo $this->lang->line('members');?>: <?php echo anchor('login',$this->lang->line('login')); ?>.</h3>
	<?php } ?>
