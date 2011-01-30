	<?php if (logged_in()) { ?>
		<h3>Hello <em><?php echo Current_User::user()->nickname; ?></em>.</h3>
		<?php echo anchor('home','Home'); ?>&nbsp;&nbsp;
        <?php echo anchor('logout','Logout'); ?>&nbsp;&nbsp;
        <?php echo anchor('user_predictions/view/'.Current_User::user()->id,'See My Predictions'); ?>&nbsp;&nbsp;
        <?php echo anchor('user_predictions/edit/','Edit My Predictions'); ?>&nbsp;&nbsp;
        <?php echo anchor('user_info','Account info'); ?>
        <?php
            if (admin()) {
                echo "<p class='buttons'>".anchor('settings_admin','<img src="'.base_url().'images/icons/wrench.png" alt="" />Edit settings').anchor('admin_functions','<img src="'.base_url().'images/icons/star.png" alt="" />Admin Functions')."</p>";
                }
        }
        else {
        ?>
		<h3>New Users: <?php echo anchor('signup','Create an Account'); ?>.</h3>
		<h3>Members: <?php echo anchor('login','Login'); ?>.</h3>
	<?php } ?>
