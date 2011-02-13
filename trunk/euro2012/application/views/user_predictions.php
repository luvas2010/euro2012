<?php $this->lang->load('user', language());?>	
	<h3><?php echo $predictions[0]['User']['nickname']; ?>&nbsp;-&nbsp;<?php echo $title; ?> </h3>
	<table class="match_table">
        <thead>
            <tr>
                <th class="th-left"><?php echo lang('Match');?></th>
                <th colspan="2" class="th-left"><?php echo lang('Home');?></th>
                <th colspan="2" class="th-left"><?php echo lang('Away');?></th>
                <th><?php echo lang('Prediction');?></th>
                <th><?php echo lang('Points_earned');?></th>
                <th><?php echo lang('Closing_Time');?></th>
                <th><?php echo lang('Action');?></th>
            </tr>
		</thead>
        <tbody>
       
        <?php foreach($predictions as $prediction): ?>
        <?php $num = $prediction['Match']['match_number']; ?>
			<tr>
                <td><?php echo $prediction['Match']['match_name']; ?></td>
                <?php if ($prediction['Match']['type_id'] == 6): ?>
                <?php $warning = 0; ?>
                    <td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['Match']['TeamHome']['flag'];?>" alt="" /></td>
                    <td><?php echo $prediction['Match']['TeamHome']['name'];?></td>
                    <td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['Match']['TeamAway']['flag'];?>" alt="" /></td>
                    <td><?php echo $prediction['Match']['TeamAway']['name']; ?></td>
                <?php else: ?>
                    <?php if (($prediction['TeamHome']['team_id_home'] == 0) || ($prediction['TeamAway']['team_id_home'] == 0)) { $warning = 1;} ?>
                    <td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['TeamHome']['flag'];?>" alt="" /></td>
                    <td><?php echo $prediction['TeamHome']['name'];?></td>
                    <td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['TeamAway']['flag'];?>" alt="" /></td>
                    <td><?php echo $prediction['TeamAway']['name']; ?></td>
                <?php endif; ?>
                <td class="td-center"><?php echo $prediction['home_goals']." - ".$prediction['away_goals']; ?></td>
                <td class="td-center"><?php echo $prediction['points_total_this_match']; ?></td>
                <?php if ($prediction['calculated']): ?>
                <td class="td-center"><span class="red bold"><?php echo lang('Closed');?></span></td>
                <td class="td-center"><?php echo anchor('matchstats/score/'.$num,lang('Check_scores')); ?></td>
                <?php elseif (!$closed[$num] && !$prediction['calculated'] ): ?>
                    <td class="td-center"><?php echo mdate("%d %M, %H:%i",mysql_to_unix($prediction['Match']['time_close']) - $prediction['Match']['Venue']['time_offset_utc'] + $settings['server_time_offset_utc']); ?></td>
                    <td class="td-center"><?php echo anchor('user_predictions/edit_single/'.$num,lang('Edit_prediction')); ?></td>
                <?php elseif ($closed[$num] && !$prediction['calculated']): ?>
                    <td class="td-center"><span class="red bold"><?php echo lang('Closed');?></span></td>
                    <td><span class="green bold"><?php echo lang('Pending_Calculation');?></span></td>
                <?php endif; ?>
			</tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ($warning): ?>
    <p class='error'>
   <?php echo lang('warning_1').anchor('user_predictions/edit', lang('Edit_my_predictions')); ?>
    </p>
    <?php endif; ?>
