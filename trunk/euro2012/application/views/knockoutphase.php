<?php $this->lang->load('match', language()); ?> 
	<h3><?php echo lang('matches_knockout_phase'); ?></h3>
   
	<table width="100%">
        <thead>
			<tr>
				<th class='th-left'><?php echo lang('match');?></th>
				<th class='th-left' colspan="2"><?php echo lang('home'); ?></th>
				<th class='th-left' colspan="2"><?php echo lang('away'); ?></th>
				<th><?php echo lang('result'); ?></th>
				<th><?php echo lang('time'); ?></th>
                <?php if (admin()): ?>
                <th>Admin</th>
				<?php endif; ?>
			</tr>
		</thead>
        <tbody>
        <?php foreach($predictions as $prediction): ?>
			<tr>
				<td><?php echo $prediction['Match']['match_name']; ?></td>
				<td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['Match']['TeamHome']['flag'];?>" alt="" /></td>
				<td><?php echo $prediction['Match']['TeamHome']['name']; ?></td>
				<td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['Match']['TeamAway']['flag'];?>" alt="" /></td>
				<td><?php echo $prediction['Match']['TeamAway']['name']; ?></td>
				<td class='td-center'><?php echo $prediction['Match']['home_goals']." - ".$prediction['Match']['away_goals']; ?></td>
				<td class='td-center'><?php echo mdate("%d %M, %H:%i",mysql_to_unix($prediction['Match']['match_time']) - $prediction['Match']['Venue']['time_offset_utc'] + $settings['server_time_offset_utc']); ?></td>
                <?php if (admin()): ?>
                <td><?php echo anchor('match/details/'.$prediction['Match']['match_number'],lang('edit_match_details'), 'class="adminlink" title="Edit this match"'); ?></td>
                <?php endif; ?> 
			</tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <table width='100%' id="brackets">
        <tbody>
            <tr>
                <td class='td-center'>
                    <table width='100%'>
                        <thead>
                            <tr>
                                <th colspan="2">
                                <?php echo $predictions[51]['Match']['match_name']; ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $predictions[51]['Match']['TeamHome']['flag'];?>" alt="" /></td><td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $predictions[51]['Match']['TeamAway']['flag'];?>" alt="" /></td>
                        </tr>
                        <tr>
                            <td class='td-center'><?php echo $predictions[51]['Match']['TeamHome']['name']; ?></td><td class='td-center'><?php echo $predictions[51]['Match']['TeamAway']['name']; ?></td>
                        </tr>
                        </tbody>
                    </table>    
                </td>
                <td class='arrowdown'>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td colspan='1'></td>
                <td class='td-center'>
                    <table width='100%'>
                        <thead>
                            <tr>
                                <th colspan="2">
                                <?php echo $predictions[61]['Match']['match_name']; ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $predictions[61]['Match']['TeamHome']['flag'];?>" alt="" /></td><td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $predictions[61]['Match']['TeamAway']['flag'];?>" alt="" /></td>
                        </tr>
                        <tr>
                            <td class='td-center'><?php echo $predictions[61]['Match']['TeamHome']['name']; ?></td><td class='td-center'><?php echo $predictions[61]['Match']['TeamAway']['name']; ?></td>
                        </tr>
                        </tbody>
                    </table>    
                </td>
                <td class='bigarrowdown' rowspan='2'></td>
            </tr>

            <tr>
                <td class='td-center'>
                    <table width='100%'>
                        <thead>
                            <tr>
                                <th colspan="2">
                                <?php echo $predictions[53]['Match']['match_name']; ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $predictions[53]['Match']['TeamHome']['flag'];?>" alt="" /></td><td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $predictions[53]['Match']['TeamAway']['flag'];?>" alt="" /></td>
                        </tr>
                        <tr>
                            <td class='td-center'><?php echo $predictions[53]['Match']['TeamHome']['name']; ?></td><td class='td-center'><?php echo $predictions[53]['Match']['TeamAway']['name']; ?></td>
                        </tr>
                        </tbody>
                    </table>    
                </td>
                <td class='arrowup'>&nbsp;</td>
            </tr>

            <tr>
                <td colspan='2'></td>
                <td class='td-center'>
                    <table width='100%'>
                        <thead>
                            <tr>
                                <th colspan="2">
                                <?php echo $predictions[99]['Match']['match_name']; ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $predictions[99]['Match']['TeamHome']['flag'];?>" alt="" /></td><td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $predictions[99]['Match']['TeamAway']['flag'];?>" alt="" /></td>
                        </tr>
                        <tr>
                            <td class='td-center'><?php echo $predictions[99]['Match']['TeamHome']['name']; ?></td><td class='td-center'><?php echo $predictions[99]['Match']['TeamAway']['name']; ?></td>
                        </tr>
                        </tbody>
                    </table>    
                </td>
            </tr>

            <tr>
                <td class='td-center'>
                    <table width='100%'>
                        <tbody>
                        <thead>
                            <tr>
                                <th colspan="2">
                                <?php echo $predictions[52]['Match']['match_name']; ?>
                                </th>
                            </tr>
                        </thead>                     
                        <tr>
                            <td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $predictions[52]['Match']['TeamHome']['flag'];?>" alt="" /></td><td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $predictions[52]['Match']['TeamAway']['flag'];?>" alt="" /></td>
                        </tr>
                        <tr>
                            <td class='td-center'><?php echo $predictions[52]['Match']['TeamHome']['name']; ?></td><td class='td-center'><?php echo $predictions[52]['Match']['TeamAway']['name']; ?></td>
                        </tr>
                        </tbody>
                    </table>    
                </td>
                <td class='arrowdown'>&nbsp;</td>
                <td class='bigarrowup' rowspan='2'>&nbsp;</td>
            </tr>

            <tr>
                <td colspan='1'></td>
                <td class='td-center'>
                    <table width='100%'>
                        <thead>
                            <tr>
                                <th colspan="2">
                                <?php echo $predictions[62]['Match']['match_name']; ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $predictions[62]['Match']['TeamHome']['flag'];?>" alt="" /></td><td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $predictions[62]['Match']['TeamAway']['flag'];?>" alt="" /></td>
                        </tr>
                        <tr>
                            <td class='td-center'><?php echo $predictions[62]['Match']['TeamHome']['name']; ?></td><td class='td-center'><?php echo $predictions[62]['Match']['TeamAway']['name']; ?></td>
                        </tr>
                    </table>    
                </td>
            </tr>

            <tr>
                <td class='td-center'>
                    <table width='100%'>
                        <thead>
                            <tr>
                                <th colspan="2">
                                <?php echo $predictions[54]['Match']['match_name']; ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $predictions[54]['Match']['TeamHome']['flag'];?>" alt="" /></td><td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $predictions[54]['Match']['TeamAway']['flag'];?>" alt="" /></td>
                        </tr>
                        <tr>
                            <td class='td-center'><?php echo $predictions[54]['Match']['TeamHome']['name']; ?></td><td class='td-center'><?php echo $predictions[54]['Match']['TeamAway']['name']; ?></td>
                        </tr>
                    </table>    
                </td>
                </td>
                <td class='arrowup'>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>            
        </tbody>
    </table>
     
    <?php if(logged_in()): ?>
        <?php if(admin()): ?>
        <p id="admintools" class="buttons">
            <?php echo anchor('knockoutphase_admin','<img src="'.base_url().'images/icons/table_edit.png" alt="" />Knockout Phase Administration'); ?>    
        </p>
        <?php  endif; ?>
    <?php  endif; ?>

