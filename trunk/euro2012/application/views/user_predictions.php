	<h3><?php echo $predictions[0]->User->nickname; ?>&nbsp;-&nbsp;<?php echo $title; ?> </h3>
	<table class="match_table">
        <thead>
            <tr>
                <th class="th-left">Match</th>
                <th>Group</th>
                <th>Result</th>
                <th>Prediction</th>
                <th>Points earned</th>
                <th>Closing time</th>
                <th>Action</th>
            </tr>
		</thead>
        <tbody>
       
        <?php foreach($predictions as $prediction): ?>
        <?php $num = $prediction->Match->match_number; ?>
			<tr>
				<td><?php echo $prediction->Match->TeamHome->name." - ".$prediction->Match->TeamAway->name; ?></td>
                <td class="td-center"><?php echo $prediction->Match->match_group; ?></td>
				<td class="td-center"><?php echo $prediction->Match->home_goals." - ".$prediction->Match->away_goals; ?></td>
				<td class="td-center"><?php echo $prediction->home_goals." - ".$prediction->away_goals; ?></td>
                <td class="td-center"><?php echo $prediction->points_total_this_match; ?></td>
                <?php if ($prediction['calculated']): ?>
                <td class="td-center"><span class="red bold">Closed</span></td>
                <td class="td-center"><?php echo anchor('matchstats/score/'.$num,'Check scores'); ?></td>
                <?php elseif (!$closed[$num] && !$prediction['calculated'] ): ?>
                    <td class="td-center"><?php echo $prediction->Match->time_close; ?></td>
                    <td class="td-center"><?php echo anchor('prediction/edit/'.$num,'Edit prediction'); ?></td>
                <?php elseif ($closed[$num] && !$prediction['calculated']): ?>
                    <td class="td-center"><span class="red bold">Closed</span></td>
                    <td><span class="green bold">Pending Calculation</span></td>
                <?php endif; ?>
			</tr>
        <?php endforeach; ?>
        </tbody>
    </table> 
