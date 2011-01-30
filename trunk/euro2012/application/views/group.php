	<h3>Matches Group <?php echo strtoupper($group); ?>
    <?php if (logged_in()): ?>
        &nbsp;&nbsp;<?php echo anchor('user_predictions_'.$group,'Check my predictions for Group '.strtoupper($group));?>
    <?php endif; ?>
    <?php if (admin()): ?>
        &nbsp;&nbsp;<?php echo anchor('group'.$group.'_admin','Group '.strtoupper($group).' Results Administration', 'class="adminlink"'); ?>
    <?php endif; ?>    
    </h3>
	<table class='match_table'>
        <thead>
			<tr>
				<th class='th-left'>Match</th>
				<th class='th-left' colspan="2">Home</th>
				<th class='th-left' colspan="2">Away</th>
				<th>Result</th>
				<th class='th-left'>Venue</th>
				<th>Time</th>
				<?php if (admin()): ?>
				<th>Admin</th>
				<?php endif; ?>
			</tr>
		</thead>
        <tbody>
        <?php foreach($matches as $match): ?>
			<tr>
				<td><?php echo $match->match_name; ?></td>
				<td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $match->TeamHome->flag;?>" alt="" /></td>
				<td><?php echo $match->TeamHome->name; ?></td>
				<td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $match->TeamAway->flag;?>" alt="" /></td>
				<td><?php echo $match->TeamAway->name; ?></td>
				<td class='td-center'><?php echo $match->home_goals." - ".$match->away_goals; ?></td>
				<td><?php echo $match->Venue->name; ?></td>
				<td class='td-center'><?php echo $match->match_time; ?></td>
				<?php if (admin()): ?>
				<td class='td-center'><?php echo anchor('match/details/'.$match->match_number,'Edit', 'class="adminlink"'); ?></td>
				<?php endif; ?>
			</tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Standings Group <?php echo strtoupper($group); ?></h3>
    <table>
        <thead>
			<tr>
				<th class='th-left' colspan="2">Team</th>
				<th>Played</th>
				<th>Won</th>
				<th>Lost</th>
				<th>Tie</th>
				<th>Points</th>
				<th>Goals for</th>
				<th>Goals against</th>
                <?php if (admin()): ?>
                <th>Admin</th>
                <?php endif; ?>
			</tr>
		</thead>
        <tbody>
        <?php foreach($results as $result): ?>
        <tr>
                <td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $result->flag; ?>" alt="<?php echo $result->name; ?>" ></td>				
				<td><?php echo $result->name; ?></td>
				<td class='td-center'><?php echo $result->played; ?></td>    
				<td class='td-center'><?php echo $result->won; ?></td>    
				<td class='td-center'><?php echo $result->lost; ?></td>    
				<td class='td-center'><?php echo $result->tie; ?></td>    
				<td class='td-center'><?php echo $result->points; ?></td>    
				<td class='td-center'><?php echo $result->goals_for; ?></td>    
				<td class='td-center'><?php echo $result->goals_against; ?></td>
                <?php if (admin()): ?>
                <td><?php echo anchor('team/edit/'.$result->id,'Edit team', 'class="adminlink"'); ?></th>
                <?php endif; ?>
		</tr>
		<?php endforeach; ?>
        </tbody>
    </table>
