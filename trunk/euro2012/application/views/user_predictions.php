	<h3><?php echo $predictions[0]['User']['nickname']; ?>&nbsp;-&nbsp;<?php echo $title; ?> </h3>
	<table class="match_table">
        <thead>
            <tr>
                <th class="th-left">Match</th>
                <th colspan="2" class="th-left">Home</th>
                <th colspan="2" class="th-left">Away</th>
                <th>Prediction</th>
                <th>Points earned</th>
                <th>Closing time</th>
                <th>Action</th>
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
                <td class="td-center"><span class="red bold">Closed</span></td>
                <td class="td-center"><?php echo anchor('matchstats/score/'.$num,'Check scores'); ?></td>
                <?php elseif (!$closed[$num] && !$prediction['calculated'] ): ?>
                    <td class="td-center"><?php echo $prediction['Match']['time_close']; ?></td>
                    <td class="td-center"><?php echo anchor('prediction/edit/'.$num,'Edit prediction'); ?></td>
                <?php elseif ($closed[$num] && !$prediction['calculated']): ?>
                    <td class="td-center"><span class="red bold">Closed</span></td>
                    <td><span class="green bold">Pending Calculation</span></td>
                <?php endif; ?>
			</tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ($warning): ?>
    <p class='error'>
        You have not filled out all the teams for the final matches. You have to do this before the tournament starts! Click on 'Edit prediction' for any Quarter Final, Semi final or the Final match to do it, or go to '<?php echo anchor('user_predictions/edit', 'Edit My Predictions'); ?>'.
    </p>
    <?php endif; ?>