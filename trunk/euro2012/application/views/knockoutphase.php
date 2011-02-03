<?php $this->lang->load('match', language()); ?> 
	<h3><?php echo $this->lang->line('matches_knockout_phase'); ?></h3>
	<table>
        <thead>
			<tr>
				<th class='th-left'><?php echo $this->lang->line('match');?></th>
				<th class='th-left' colspan="2"><?php echo $this->lang->line('home'); ?></th>
				<th class='th-left' colspan="2"><?php echo $this->lang->line('away'); ?></th>
				<th><?php echo $this->lang->line('result'); ?></th>
				<th class='th-left'><?php echo $this->lang->line('venue'); ?></th>
				<th><?php echo $this->lang->line('time'); ?></th>
                <?php if (admin()): ?>
                <th>Admin</th>
				<?php endif; ?>
			</tr>
		</thead>
        <tbody>
        <?php foreach($matches as $match): ?>
			<tr>
				<td><?php echo $match->match_name; ?></td>
				<td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $match['TeamHome']['flag'];?>" alt="" /></td>
				<td><?php echo $match->TeamHome->name; ?></td>
				<td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $match['TeamAway']['flag'];?>" alt="" /></td>
				<td><?php echo $match->TeamAway->name; ?></td>
				<td class='td-center'><?php echo $match->home_goals." - ".$match->away_goals; ?></td>
				<td><?php echo $match->Venue->name; ?></td>
				<td class='td-center'><?php echo $match->match_time; ?></td>
                <?php if (admin()): ?>
                <td><?php echo anchor('match/details/'.$match['match_number'],$this->lang->line('edit_match_details'), 'class="adminlink" title="Edit this match"'); ?></td>
                <?php endif; ?> 
			</tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    
    <?php if(Current_User::user()): ?>
        <?php if(Current_User::user()->admin): ?>
        <div id="admintools" class="buttons">
            <?php echo anchor('knockoutphase_admin','<img src="'.base_url().'images/icons/table_edit.png" alt="" />Knockout Phase Administration'); ?>    
        </div>
        <?php  endif; ?>
    <?php  endif; ?>
