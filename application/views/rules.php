<div class="container_12">

	<div id="home" class="grid_6 alpha">
        <h2><?php echo lang('nav_rules'); ?></h2>
		<?php echo sprintf(lang('welcometext'), anchor('predictions/editgroup/QF', lang('QF')),
												anchor('predictions/editgroup/SF', lang('SF')),
												anchor('predictions/editgroup/F', lang('F')),
												anchor('predictions/extra', lang('total_goals_pred')),
												anchor('predictions/extra', lang('champion_pred'))); ?>
	
        
	</div>
	<div id="rules" class="grid_6 omega">
        <?php echo sprintf(lang('points_awarded'), $this->config->item("pred_points_goals"),
                                                $this->config->item("pred_points_result"),
                                                $this->config->item("pred_points_qf_team"),
                                                $this->config->item("pred_points_sf_team"),
                                                $this->config->item("pred_points_f_team"),
                                                $this->config->item('pred_points_bonus'),
                                                $this->config->item('pred_points_bonus'),
                                                $this->config->item('pred_points_champion')); ?>
		<div class='errorstay'><?php echo lang('result_rules'); ?></div>
	</div>
    <div class='clear'></div>
</div>


