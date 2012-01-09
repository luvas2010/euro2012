<div class="container_12">
     <div id="row1" class="grid_12 alpha omega">
        <?php if ($this->authentication->is_signed_in()) { ?>
        <div class="grid_3 alpha">
            <h3><?php echo sprintf(lang('website_welcome_username'), '<strong>'.$account_details->firstname.'</strong>'); ?></h3>
            <p><?php echo sprintf(lang('user_points'), get_user_points($account->id)); ?></p><p><?php echo anchor('standings#me',lang('check_user_pos')); ?></p>
			<?php if ($account->payed == 0 && $this->config->item('play_for_money') == 1)
			  {?>
			<div class='error'><?php echo lang('not_payed_yet');?></div>
				<?php } ?>
			<?php
            if (!get_total_goals($account->id)) {
            ?>
            <div class='error'><?php echo lang('total_goals_missing'); ?><br/>
			<?php echo anchor('predictions/extra',lang('nav_extra')); ?> 
			</div>
			<?php echo get_missing_teams_list(array(
							'heading'   => "<div class='error'><p>%heading%</p>",
							'pre'       => "<ul class='matchlist'>",
							'post'      => "</ul></div>",
							'listitem'  => "<li>%matchlink%</li>")
							); ?>
            <?php } ?>
		</div>
		<div class="grid_3">
			<h3><?php echo lang('top_10');?></h3>
			<?php $this->load->library('pool');
				  $topusers = $this->pool->get_top_ranking(10);
				  foreach ($topusers as $user)
				  {
						echo "<span class='boldtext'>".$user['username'].": </span>".$user['points_total']." ".lang('points')."<br/>";
				  }
				  echo "<br/>".anchor('charts/top/10',lang('see_top_ten'), 'class="button"');;
			?>
			
		</div>
		<div class="grid_3">
			<h3><?php echo lang('nav_champ_graph');?></h3>
		</div>
		<div class="grid_3 omega">
		<h3><?php echo lang('next_matches'); ?></h3>
            <?php
            // get_next_matches( number_of_matches, format = "<li>%matchtime%: %home% - %away% (%prediction%)</li>"
            echo get_next_matches(2,"<h4>%matchtime%</h4><h4>%group%</h4><p class='centertext'>%home% - %away%<br/>(%prediction%)</p>");
            ?>
		</div>	
	</div>
	<div class="clear"></div>
	<div id="row2" class="grid_12 alpha omega">

            <?php echo get_missing_result_list(array(
                                        'heading'   => "<h4 class='to_do'>%heading%</h4>",
                                        'pre'       => "<ul class='matchlist'>",
                                        'post'      => "</ul>",
                                        'listitem'  => "<li>%matchlink%</li>")
                                        ); ?>
        <?php } ?>
    </div>
	<div class="clear"></div>
        <?php if ($this->authentication->is_signed_in()) { ?>
            <div id="home" class="grid_8 omega">
        <?php } else { ?>
            <div id="home" class="grid_12 alpha omega">
        <?php } ?>
        <?php if (base_url() == 'http://johnschop.nl/euro2012/' || base_url() == 'http://voetbalpool2012.nl/pool')
                { ?>
        <img src="<?php echo base_url();?>images/VoetbalPool2012_trans.png" style="float:right" />
        <div class='clear'></div>
        <?php } else { ?>
        <h2><?php echo sprintf(lang('welcome_maintext'), $this->config->item('pool_name')); ?></h2>
        <?php } ?>
        <?php echo sprintf(lang('welcometext'), $this->config->item("pool_name"),
                                                $this->config->item("pred_points_goals"),
                                                $this->config->item("pred_points_result"),
                                                $this->config->item("pred_points_qf_team"),
                                                $this->config->item("pred_points_sf_team"),
                                                $this->config->item("pred_points_f_team"),
                                                $this->config->item('pred_points_bonus'),
                                                $this->config->item('pred_points_bonus'),
                                                $this->config->item('pred_points_champion')); ?>
    </div>
    <div class='clear'></div>
    <div id="charts"></div>
</div>


