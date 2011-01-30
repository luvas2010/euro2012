	<h3>Matches Knockout Phase</h3>
	<table>
        <thead>
			<tr>
				<th class='th-left'>Match</th>
				<th class='th-left'>Home</th>
				<th class='th-left'>Away</th>
				<th>Result</th>
				<th class='th-left'>Venue</th>
				<th>Time</th>
			</tr>
		</thead>
        <tbody>
        <?php foreach($matches as $match): ?>
			<tr>
				<td><?php echo $match->match_name; ?></td>
				<td><?php echo $match->TeamHome->name; ?></td>
				<td><?php echo $match->TeamAway->name; ?></td>
				<td class='td-center'><?php echo $match->home_goals." - ".$match->away_goals; ?></td>
				<td><?php echo $match->Venue->name; ?></td>
				<td class='td-center'><?php echo $match->match_time; ?></td>
			</tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    
    <?php if(Current_User::user()): ?>
        <?php if(Current_User::user()->admin): ?>
        <div id="admintools" class="buttons">
            <?php echo anchor('knockoutphase_admin','<img src="images/icons/table_edit.png" alt="" />Knockout Phase Administration'); ?>    
        </div>
        <?php  endif; ?>
    <?php  endif; ?>
