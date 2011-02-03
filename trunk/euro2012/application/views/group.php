<?php $this->lang->load('match', language()); ?> 
	<h3><?php echo $this->lang->line('matches');?> <?php echo $this->lang->line('group');?> <?php echo strtoupper($group); ?>
    <?php if (logged_in()): ?>
        &nbsp;&nbsp;<?php echo anchor('user_predictions_'.$group,$this->lang->line('check').' '.$this->lang->line('my_predictions').$this->lang->line('for').$this->lang->line('group').' '.strtoupper($group));?>
    <?php endif; ?>
    <?php if (admin()): ?>
        &nbsp;&nbsp;<?php echo anchor('group'.$group.'_admin',$this->lang->line('group').' '.strtoupper($group).$this->lang->line('results_administration'), 'class="adminlink"'); ?>
    <?php endif; ?>    
    </h3>
	<table class='match_table'>
        <thead>
			<tr>
				<th class='th-left'><?php echo $this->lang->line('match');?></th>
				<th class='th-left' colspan="2"><?php echo $this->lang->line('home');?></th>
				<th class='th-left' colspan="2"><?php echo $this->lang->line('away');?></th>
				<th><?php echo $this->lang->line('result');?></th>
				<th class='th-left'><?php echo $this->lang->line('venue');?></th>
				<th><?php echo $this->lang->line('time');?></th>
				<?php if (admin()): ?>
				<th><?php echo $this->lang->line('admin');?></th>
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
				<td class='td-center'><?php echo anchor('match/details/'.$match->match_number,$this->lang->line('edit'), 'class="adminlink"'); ?></td>
				<?php endif; ?>
			</tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h3><?php echo $this->lang->line('standings');?> <?php echo $this->lang->line('group');?> <?php echo strtoupper($group); ?></h3>
    <table>
        <thead>
			<tr>
				<th class='th-left' colspan="2"><?php echo $this->lang->line('team');?></th>
				<th><?php echo $this->lang->line('played');?></th>
				<th><?php echo $this->lang->line('won');?></th>
				<th><?php echo $this->lang->line('lost');?></th>
				<th><?php echo $this->lang->line('tie');?></th>
				<th><?php echo $this->lang->line('points');?></th>
				<th><?php echo $this->lang->line('goals_for');?></th>
				<th><?php echo $this->lang->line('goals_against');?></th>
                <?php if (admin()): ?>
                <th><?php echo $this->lang->line('admin');?></th>
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
                <td><?php echo anchor('team/edit/'.$result->id,$this->lang->line('edit').' '.$this->lang->line('team'), 'class="adminlink"'); ?></th>
                <?php endif; ?>
		</tr>
		<?php endforeach; ?>
        </tbody>
    </table>
