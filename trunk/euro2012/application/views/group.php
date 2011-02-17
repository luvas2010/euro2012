<?php $this->lang->load('match', language()); ?> 
	<h3><?php echo lang('matches');?> <?php echo lang('group');?> <?php echo strtoupper($group); ?>
    <?php if (logged_in()): ?>
        &nbsp;&nbsp;<?php echo anchor('group/predictions/'.$group,lang('check').' '.lang('my_predictions').lang('for').lang('group').' '.strtoupper($group));?>
    <?php endif; ?>
    <?php if (admin()): ?>
        &nbsp;&nbsp;<?php echo anchor('group/admin/'.$group,lang('group').' '.strtoupper($group).lang('results_administration'), 'class="adminlink"'); ?>
    <?php endif; ?>    
    </h3>
	<table class='match_table'>
        <thead>
			<tr>
				<th class='th-left'><?php echo lang('match');?></th>
				<th class='th-left' colspan="2"><?php echo lang('home');?></th>
				<th class='th-left' colspan="2"><?php echo lang('away');?></th>
				<th><?php echo lang('result');?></th>
				<th class='th-left'><?php echo lang('venue');?></th>
				<th><?php echo lang('time');?></th>
				<?php if (admin()): ?>
				<th><?php echo lang('admin');?></th>
				<?php endif; ?>
			</tr>
		</thead>
        <tbody>
        <?php foreach($matches as $match): ?>
			<tr>
				<td><?php echo $match['match_name']; ?></td>
				<td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $match['TeamHome']['flag'];?>" alt="" /></td>
				<td><?php echo $match['TeamHome']['name']; ?></td>
				<td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $match['TeamAway']['flag'];?>" alt="" /></td>
				<td><?php echo $match['TeamAway']['name']; ?></td>
				<td class='td-center'><?php echo $match['home_goals']." - ".$match['away_goals']; ?></td>
				<td><?php echo $match['Venue']['name']; ?><br /><?php echo $match['Venue']['city'];?></td>
				<td class='td-center'><?php echo mdate("%d %M, %H:%i",mysql_to_unix($match['match_time']) - $match['Venue']['time_offset_utc'] + $settings['server_time_offset_utc']); ?></td>
				<?php if (admin()): ?>
				<td class='td-center'><?php echo anchor('match/details/'.$match['match_number'],lang('edit'), 'class="adminlink"'); ?></td>
				<?php endif; ?>
			</tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h3><?php echo lang('standings');?> <?php echo lang('group');?> <?php echo strtoupper($group); ?></h3>
    <table>
        <thead>
			<tr>
				<th class='th-left' colspan="2"><?php echo lang('team');?></th>
				<th><?php echo lang('played');?></th>
				<th><?php echo lang('won');?></th>
				<th><?php echo lang('lost');?></th>
				<th><?php echo lang('tie');?></th>
				<th><?php echo lang('points');?></th>
				<th><?php echo lang('goals_for');?></th>
				<th><?php echo lang('goals_against');?></th>
                <?php if (admin()): ?>
                <th><?php echo lang('admin');?></th>
                <?php endif; ?>
			</tr>
		</thead>
        <tbody>
        <?php foreach($results as $result): ?>
        <tr>
                <td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $result['flag']; ?>" alt="<?php echo $result['name']; ?>" ></td>				
				<td><?php echo $result['name']; ?></td>
				<td class='td-center'><?php echo $result['played']; ?></td>    
				<td class='td-center'><?php echo $result['won']; ?></td>    
				<td class='td-center'><?php echo $result['lost']; ?></td>    
				<td class='td-center'><?php echo $result['tie']; ?></td>    
				<td class='td-center'><?php echo $result['points']; ?></td>    
				<td class='td-center'><?php echo $result['goals_for']; ?></td>    
				<td class='td-center'><?php echo $result['goals_against']; ?></td>
                <?php if (admin()): ?>
                <td><?php echo anchor('team/edit/'.$result['id'],lang('edit').' '.lang('team'), 'class="adminlink"'); ?></th>
                <?php endif; ?>
		</tr>
		<?php endforeach; ?>
        </tbody>
    </table>
    
