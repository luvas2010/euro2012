<?php
// fetch language file
$this->lang->load('welcome', language() );
?>

	<?php if (logged_in()) { ?>
		<h3><?php echo lang('greetings');?> <em><?php echo Current_User::user()->nickname; ?></em>.</h3>
		<?php echo anchor('home',lang('home')); ?>&nbsp;&nbsp;
        <?php echo anchor('logout',lang('logout')); ?>&nbsp;&nbsp;
        <?php echo anchor('user_predictions/view/'.Current_User::user()->id,lang('see_my_predictions')); ?>&nbsp;&nbsp;
        <?php echo anchor('user_predictions/edit/',lang('edit_my_predictions')); ?>&nbsp;&nbsp;
        <?php echo anchor('user_info',lang('account_info')); ?>
        <?php if (language() == 'nederlands') {
                echo anchor('user_info/switch_language/english', '<img src="'.base_url().'images/flags/16/uk.png" />', 'title="Switch to English"');
                }
              else {
                echo anchor('user_info/switch_language/nederlands', '<img src="'.base_url().'images/flags/16/nl.png" />', 'title="Nederlands"');
                } 
        ?>
        <?php
            if (admin()) {
                echo "<p class='buttons'>".anchor('settings_admin','<img src="'.base_url().'images/icons/wrench.png" alt="" />'.lang('edit_settings')).anchor('admin_functions','<img src="'.base_url().'images/icons/star.png" alt="" />'.lang('admin_functions'))."</p>";
                }
        }
        else {
        ?>
		<h3><?php echo lang('new_user');?>: <?php echo anchor('signup',lang('create')); ?>.</h3>
		<h3><?php echo lang('members');?>: <?php echo anchor('login',lang('login')); ?>.</h3>
	<?php } ?>
