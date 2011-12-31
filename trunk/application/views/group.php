	<h2><?php echo sprintf(lang('group_name_overview'), $group); ?></h2>
    <h3><?php echo sprintf(lang('matches_in_group'), $group); ?></h3>
    <div class='buttons'><?php echo anchor('/predictions/editgroup/'.$group, sprintf(lang('predictions_for_group'), $group), 'class="button"'); ?></div>
    <div class='clear'></div>
    <table class="stripeMe">
		<tr>
			<th><?php echo lang('match_number'); ?></th>
            <th><?php echo lang('group'); ?></th>
            <th><?php echo lang('home'); ?> - <?php echo lang('away'); ?></th>
            <th><?php echo lang('prediction'); ?></th>
            <th><?php echo lang('result'); ?></th>
            <th><?php echo lang('match_time'); ?></th>
            <th></th>
            <?php if (is_admin()) { ?>
            <th>Admin</th>
            <?php } ?>
		</tr>
		<?php foreach($matches as $match) { ?>
		<tr>
			<td><?php echo $match['match_uid'];?></td>
            <td><?php echo $match['match_group'];?></td>
            <td><?php echo get_team_name($match['home_team']); ?> - <?php echo get_team_name($match['away_team']);?></td>
            <td><?php echo $match['pred_home_goals']." - ".$match['pred_away_goals']; ?></td>
            <td><?php echo $match['home_goals']." - ".$match['away_goals'];?></td>
            <td><?php echo unix_to_human($match['timestamp'],FALSE,'eu'); ?></td>
            <td><?php echo anchor('matches/edit_prediction/'.$match['match_uid'],lang('predict_match'), 'class="button small"'); ?></td>
            <?php if (is_admin()) { ?>
            <td><?php echo anchor('matches/result/'.$match['match_uid'], lang('edit_match_result'), 'class="adminlink"'); ?></td>
            <?php } ?>
		</tr>
		<?php } ?>	
	</table>
   
    <h3><?php echo sprintf(lang('standings_in_group'), $group); ?></h3> 
    <table class="stripeMe">
		<tr>
			<th><?php echo lang('position'); ?></th>
            <th><?php echo lang('team'); ?></th>
            <th><?php echo lang('played'); ?></th>
            <th><?php echo lang('won'); ?></th>
            <th><?php echo lang('tie'); ?></th>
            <th><?php echo lang('lost'); ?></th>
            <th><?php echo lang('points'); ?></th>
            <th><?php echo lang('goals'); ?></th>
		</tr>

        <?php $pos = 1; ?>
		<?php foreach($results as $result) { ?>
		<tr>
			<td><?php echo $pos;?></td>
            <td><?php echo $result['team_name']; ?></td>
            <td><?php echo $result['played'];?></td>
            <td><?php echo $result['won'];?></td>
            <td><?php echo $result['tie'];?></td>
            <td><?php echo $result['lost'];?></td>
            <td><?php echo $result['points'];?></td>
            <td><?php echo $result['goals_for']." - ".$result['goals_against'];?></td>
		</tr>
		<?php $pos++; } ?>	
	</table>

    <h3><?php echo sprintf(lang('pred_standings_in_group'), $group); ?></h3> 
    <table class="stripeMe">
		<tr>
			<th><?php echo lang('position'); ?></th>
            <th><?php echo lang('team'); ?></th>
            <th><?php echo lang('played'); ?></th>
            <th><?php echo lang('won'); ?></th>
            <th><?php echo lang('tie'); ?></th>
            <th><?php echo lang('lost'); ?></th>
            <th><?php echo lang('points'); ?></th>
            <th><?php echo lang('goals'); ?></th>
		</tr>

        <?php $pos = 1; ?>
		<?php foreach($pred_results as $pred_result) { ?>
		<tr>
			<td><?php echo $pos;?></td>
            <td><?php echo $pred_result['team_name']; ?></td>
            <td><?php echo $pred_result['played'];?></td>
            <td><?php echo $pred_result['won'];?></td>
            <td><?php echo $pred_result['tie'];?></td>
            <td><?php echo $pred_result['lost'];?></td>
            <td><?php echo $pred_result['points'];?></td>
            <td><?php echo $pred_result['goals_for']." - ".$pred_result['goals_against'];?></td>
		</tr>
		<?php $pos++; } ?>	
	</table>
