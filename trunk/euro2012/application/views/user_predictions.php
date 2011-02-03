<?php $this->lang->load('user', language());?>	
	<h3><?php echo $predictions[0]['User']['nickname']; ?>&nbsp;-&nbsp;<?php echo $title; ?> </h3>
	<table class="match_table">
        <thead>
            <tr>
                <th class="th-left"><?php echo $this->lang->line('Match');?></th>
                <th colspan="2" class="th-left"><?php echo $this->lang->line('Home');?></th>
                <th colspan="2" class="th-left"><?php echo $this->lang->line('Away');?></th>
                <th><?php echo $this->lang->line('Prediction');?></th>
                <th><?php echo $this->lang->line('Points_earmed');?></th>
                <th><?php echo $this->lang->line('Closing_Time');?></th>
                <th><?php echo $this->lang->line('Action');?></th>
            </tr>
		</thead>
        <tbody>
       
        <?php foreach($predictions as $prediction): ?>
        <?php $num = $prediction['Match']['match_number']; ?>
			<tr>
                <td><?php echo $prediction['Match']['match_name']; ?></td>
                <?php if ($prediction['Match']['type_id'] == 6): ?>
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
                <td class="td-center"><span class="red bold"><?php echo $this->lang->line('Closed');?></span></td>
                <td class="td-center"><?php echo anchor('matchstats/score/'.$num,$this->lang->line('Check_scores')); ?></td>
                <?php elseif (!$closed[$num] && !$prediction['calculated'] ): ?>
                    <td class="td-center"><?php echo $prediction['Match']['time_close']; ?></td>
                    <td class="td-center"><?php echo anchor('prediction/edit/'.$num,$this->lang->line('Edit_prediction')); ?></td>
                <?php elseif ($closed[$num] && !$prediction['calculated']): ?>
                    <td class="td-center"><span class="red bold"><?php echo $this->lang->line('Closed');?></span></td>
                    <td><span class="green bold"><?php echo $this->lang->line('Pending_Calculation');?></span></td>
                <?php endif; ?>
			</tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ($warning): ?>
    <p class='error'>
   <?php echo $this->lang->line('warning_1').anchor('user_predictions/edit', $this->lang->line('Edit_my_predictions')); ?>
    </p>
    <?php endif; ?>