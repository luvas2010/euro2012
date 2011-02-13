<?php $this->lang->load('user', language());?>
        <h3><?php echo lang('Edit_my_predictions');?></h3>
        <p>Here you can edit your preditctions. You can either predict every match for yourself, or you can click the button below, and let Octopus Paul do it for you. After Octopus Paul puts his predictions in, you can change them to whatever you like. If you have existing predictions, you will keep those. Octopus Paul will only predict results and teams if you have not filled them out yet!</p>
        <p class='buttons'><?php echo anchor('user_predictions/octopus', '<img src="'.base_url().'images/icons/wand.png" alt="" />'.lang('Let_Paul_do_it')); ?></p>
	    <?php echo form_open('user_predictions/submit'); ?>

	    <?php echo validation_errors('<p class="error">','</p>'); ?>
	    
	    <h3 class="topline"><?php echo lang('Group_Stage');?></h3>
	    <!-- groupmatches -->
	    <!--<?php echo unix_to_human(now()). " - ".unix_to_human(mysql_to_unix($predictions_group_phase[0]['Match']['time_close']) -$predictions_group_phase[0]['Match']['Venue']['time_offset_utc'] + $settings['server_time_offset_utc']); ?> -->
	    <table>
	        <thead>
	            <tr>
	                <th colspan=3><?php echo lang('Home');?></th>
	                <th colspan=3><?php echo lang('Away');?></th>
	                <th><?php echo lang('Closing_Time');?></th>
	            </tr>
	        </thead>
	        <tbody>
            <?php foreach ($predictions_group_phase as $prediction): ?>
		        <?php if ($prediction['Match']['type_id'] == 6) : //these are the group matches ?> 
		                <?php if (now() <  (mysql_to_unix($prediction['Match']['time_close']) -$prediction['Match']['Venue']['time_offset_utc'] + $settings['server_time_offset_utc'])): ?>
		                <tr>
                            <td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['Match']['TeamHome']['flag'];?>" alt="" /></td>	            
	                        <td>
	                            <label for="post_array[<?php echo $prediction['id'];?>][home_goals]"><?php echo $prediction['Match']['TeamHome']['name']; ?>:</label>
		                    </td>
		                    <td>
		                        <?php echo form_input('post_array['.$prediction['id'].'][home_goals]',$prediction['home_goals'],'size=2'); ?>
	                        </td>
	                        <td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['Match']['TeamAway']['flag'];?>" alt="" /></td>
	                        <td>
		                        <label for="post_array[<?php echo $prediction['id'];?>][away_goals]"><?php echo $prediction['Match']['TeamAway']['name']; ?>:</label>
		                    </td>
		                    <td>
		                        <?php echo form_input('post_array['.$prediction['id'].'][away_goals]',$prediction['away_goals'], 'size=2'); ?>
	                        </td>
	                        <td><?php echo mdate("%d %M, %H:%i",mysql_to_unix($prediction['Match']['time_close']) - $prediction['Match']['Venue']['time_offset_utc'] + $settings['server_time_offset_utc']); ?></td> 
	                    </tr>
	                <?php else : ?>    
		                <tr>
                            <td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['Match']['TeamHome']['flag'];?>" alt="" /></td>	            
	                        <td>
	                            <?php echo $prediction['Match']['TeamHome']['name']; ?>
		                    </td>
		                    <td class="td-center">
		                        <?php echo $prediction['home_goals']; ?>
	                        </td>
	                        <td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['Match']['TeamAway']['flag'];?>" alt="" /></td>
	                        <td>
		                        <?php echo $prediction['Match']['TeamAway']['name']; ?>
		                    </td>
		                    <td class="td-center">
		                        <?php echo $prediction['home_goals']; ?>
	                        </td>
	                        <td class="td-center"><span class='red bold'><?php echo lang('Closed');?></span></td> 
	                    </tr>
	                <?php endif; ?>    
	            <?php endif; ?>
	        <?php endforeach; ?>
	        </tbody>
        </table><!-- end group matches -->
        <p class='buttons'>
	        <?php echo form_submit('submit',lang('save')); ?>
	        <?php echo anchor('/','<img src="'.base_url().'images/icons/cross.png" alt="" />'.lang('cancel'), 'class="negative"'); ?>
        </p>
        <!-- Quarter final matches -->
        <?php //todo: lock the teampredictionsafter the tournament has started. Use function started() to determine, it returns 'true' if started. ?>
        <h3 class="topline"><?php echo lang('Quarter_Finals');?></h3>
	    <table>
	        <thead>
	            <tr>
	                <th><?php echo lang('Match');?></th>
                    <th colspan=2><?php echo lang('Team_Home');?></th>	                
	                <th><?php echo lang('Home');?></th>
	                <th colspan=2><?php echo lang('Team_Away');?></th>
	                <th><?php echo lang('Away');?></th>
	                <th><?php echo lang('Closing_Time');?></th>
	            </tr>
	        </thead>
            <tfoot>
                <tr>
                    <th colspan=8 class="info"><?php echo lang('info_1');?></th>
                </tr>
            </tfoot>  
	        <tbody>
            <?php foreach ($predictions_qf as $prediction): ?>
		        <?php if ($prediction['Match']['type_id'] == 4) : //these are the quarter final matches ?> 
		                <?php if (time() <  mysql_to_unix($prediction['Match']['time_close']) - $prediction['Match']['Venue']['time_offset_utc'] + $settings['server_time_offset_utc']): ?>
		                <tr>
		                    <td><?php echo $prediction['Match']['match_name']; ?></td>
                            <td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['TeamHome']['flag'];?>" alt="" /></td>	            

                            <?php if ($prediction['Match']['group_home'] == "A") {
                                        $teamshome = $teamsa;
                                        $teamsaway = $teamsb;
                                        }
                                  elseif($prediction['Match']['group_home'] == "B") {
                                      $teamshome = $teamsb;
                                      $teamsaway = $teamsa;
                                      }
                                  elseif($prediction['Match']['group_home'] == "C") {	                    
		                              $teamshome = $teamsc;
		                              $teamsaway = $teamsd;
		                              }
		                          elseif($prediction['Match']['group_home'] == "D") {
		                              $teamshome = $teamsd;
		                              $teamsaway = $teamsc;
		                              } ?>   
		                    <td>
		                      <?php echo form_dropdown('post_array['.$prediction['id'].'][home_id]',$teamshome,$prediction['home_id']); ?><br/>
		                      (<?php echo $prediction['Match']['TeamHome']['name']; ?>)
		                    </td>                          

		                    <td>
		                        <?php echo form_input('post_array['.$prediction['id'].'][home_goals]',$prediction['home_goals'],'size=2'); ?>
	                        </td>
                            <td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['TeamAway']['flag'];?>" alt="" /></td>	            
		                    <td>
		                      <?php echo form_dropdown('post_array['.$prediction['id'].'][away_id]',$teamsaway,$prediction['away_id']); ?><br/>
		                      (<?php echo $prediction['Match']['TeamAway']['name']; ?>)
		                    </td>

		                    <td>
		                        <?php echo form_input('post_array['.$prediction['id'].'][away_goals]',$prediction['away_goals'], 'size=2'); ?>
	                        </td>
	                        <td><?php echo mdate("%d %M, %H:%i",mysql_to_unix($prediction['Match']['time_close']) - $prediction['Match']['Venue']['time_offset_utc'] + $settings['server_time_offset_utc']); ?></td> 
	                    </tr>
	                <?php else : ?>    
		                <tr>
                            <td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['Match']['TeamHome']['flag'];?>" alt="" /></td>	            
	                        <td>
	                            <?php echo $prediction['Match']['TeamHome']['name']; ?>
		                    </td>
		                    <td class="td-center">
		                        <?php echo $prediction['home_goals']; ?>
	                        </td>
	                        <td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['Match']['TeamAway']['flag'];?>" alt="" /></td>
	                        <td>
		                        <?php echo $prediction['Match']['TeamAway']['name']; ?>
		                    </td>
		                    <td class="td-center">
		                        <?php echo $prediction['home_goals']; ?>
	                        </td>
	                        <td class="td-center"><span class='red bold'><?php echo lang('Closed');?></span></td> 
	                    </tr>
	                <?php endif; ?>    
	            <?php endif; ?>
	        <?php endforeach; ?>
	        </tbody>
        </table><!-- end Quarter Final Matches -->
        <p class='buttons'>
	        <?php echo form_submit('submit',lang('save')); ?>
	        <?php echo anchor('/','<img src="'.base_url().'images/icons/cross.png" alt="" />'.lang('cancel'), 'class="negative"'); ?>
        </p>     

        <!-- Semi final matches -->
        <h3 class="topline"><?php echo lang('Semi_Finals');?></h3>
	    <table>
	        <thead>
	            <tr>
	                <th><?php echo lang('Match');?></th>
                    <th colspan=2><?php echo lang('Team_Home');?></th>	                
	                <th><?php echo lang('Home');?></th>
	                <th colspan=2><?php echo lang('Team_Away');?></th>
	                <th><?php echo lang('Away');?></th>
	                <th><?php echo lang('Closing_Time');?></th>
	            </tr>
	        </thead>
            <tfoot>
                <tr>
                    <th colspan=8 class="info"><?php echo lang('info_1');?></th>
                </tr>
            </tfoot>                
	        <tbody>
            <?php foreach ($predictions_sf as $prediction): ?>
		        <?php if ($prediction['Match']['type_id'] == 2) : //these are the semi final matches, extra check, unneccessary ?> 
		                <?php if (time() <  mysql_to_unix($prediction['Match']['time_close']) - $prediction['Match']['Venue']['time_offset_utc'] + $settings['server_time_offset_utc']): ?>
		                <tr>
		                    <td><?php echo $prediction['Match']['match_name']; ?></td>
                            <td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['TeamHome']['flag'];?>" alt="" /></td>	            

                            <?php $teamshome = $teamsab;$teamsaway = $teamscd;?>
		                    <td>
		                      <?php echo form_dropdown('post_array['.$prediction['id'].'][home_id]',$teamshome,$prediction['home_id']); ?><br/>
		                      (<?php echo $prediction['Match']['TeamHome']['name']; ?>)
		                    </td>                          
		                    <td>
		                        <?php echo form_input('post_array['.$prediction['id'].'][home_goals]',$prediction['home_goals'],'size=2'); ?>
	                        </td>
                            <td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['TeamAway']['flag'];?>" alt="" /></td>	            
		                    <td>
		                      <?php echo form_dropdown('post_array['.$prediction['id'].'][away_id]',$teamsaway,$prediction['away_id']); ?><br/>
		                      (<?php echo $prediction['Match']['TeamAway']['name']; ?>)
		                    </td>

		                    <td>
		                        <?php echo form_input('post_array['.$prediction['id'].'][away_goals]',$prediction['away_goals'], 'size=2'); ?>
	                        </td>
	                        <td><?php echo mdate("%d %M, %H:%i",mysql_to_unix($prediction['Match']['time_close']) - $prediction['Match']['Venue']['time_offset_utc'] + $settings['server_time_offset_utc']); ?></td> 
	                    </tr>
	                <?php else : ?>    
		                <tr>
                            <td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['Match']['TeamHome']['flag'];?>" alt="" /></td>	            
	                        <td>
	                            <?php echo $prediction['Match']['TeamHome']['name']; ?>
		                    </td>
		                    <td class="td-center">
		                        <?php echo $prediction['home_goals']; ?>
	                        </td>
	                        <td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['Match']['TeamAway']['flag'];?>" alt="" /></td>
	                        <td>
		                        <?php echo $prediction['Match']['TeamAway']['name']; ?>
		                    </td>
		                    <td class="td-center">
		                        <?php echo $prediction['home_goals']; ?>
	                        </td>
	                        <td class="td-center"><span class='red bold'><?php echo lang('Closed');?></span></td> 
	                    </tr>
	                <?php endif; ?>    
	            <?php endif; ?>
	        <?php endforeach; ?>
	        </tbody>
        </table><!-- end Semi Final Matches -->
        <p class='buttons'>
	        <?php echo form_submit('submit',lang('save')); ?>
	        <?php echo anchor('/','<img src="'.base_url().'images/icons/cross.png" alt="" />'.lang('cancel'), 'class="negative"'); ?>
        </p>     

        <!-- Final match -->
        <h3 class="topline"><?php echo lang('Final');?></h3>
	    <table>
	        <thead>
	            <tr>
	                <th><?php echo lang('Match');?></th>
                    <th colspan=2><?php echo lang('Team_Home');?>/th>	                
	                <th><?php echo lang('Home');?></th>
	                <th colspan=2><?php echo lang('Team_Away');?></th>
	                <th><?php echo lang('Away');?></th>
	                <th><?php echo lang('Closing_Time');?></th>
	            </tr>
	        </thead>
            <tfoot>
                <tr>
                    <th colspan=8 class="info"><?php echo lang('info_1');?></th>
                </tr>
            </tfoot>  
	        <tbody>
            <?php foreach ($predictions_f as $prediction): ?>
		        <?php if ($prediction['Match']['type_id'] == 1) : //this is the final match ?> 
		                <?php if (time() <  mysql_to_unix($prediction['Match']['time_close']) - $prediction['Match']['Venue']['time_offset_utc'] + $settings['server_time_offset_utc']): ?>
		                <tr>
		                    <td><?php echo $prediction['Match']['match_name']; ?></td>
                            <td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['TeamHome']['flag'];?>" alt="" /></td>	            

                            <?php $teamshome = $teamsabcd;$teamsaway = $teamsabcd;?>
		                    <td>
		                      <?php echo form_dropdown('post_array['.$prediction['id'].'][home_id]',$teamshome,$prediction['home_id']); ?><br/>
		                      (<?php echo $prediction['Match']['TeamHome']['name']; ?>)
		                    </td>                          
		                    <td>
		                        <?php echo form_input('post_array['.$prediction['id'].'][home_goals]',$prediction['home_goals'],'size=2'); ?>
	                        </td>
                            <td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['TeamAway']['flag'];?>" alt="" /></td>	            
		                    <td>
		                      <?php echo form_dropdown('post_array['.$prediction['id'].'][away_id]',$teamsaway,$prediction['away_id']); ?><br/>
		                      (<?php echo $prediction['Match']['TeamAway']['name']; ?>)
		                    </td>
		                    <td>
		                        <?php echo form_input('post_array['.$prediction['id'].'][away_goals]',$prediction['away_goals'], 'size=2'); ?>
	                        </td>
	                        <td><?php echo mdate("%d %M, %H:%i",mysql_to_unix($prediction['Match']['time_close']) - $prediction['Match']['Venue']['time_offset_utc'] + $settings['server_time_offset_utc']); ?></td> 
	                    </tr>
	                <?php else : ?>    
		                <tr>
                            <td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['Match']['TeamHome']['flag'];?>" alt="" /></td>	            
	                        <td>
	                            <?php echo $prediction['Match']['TeamHome']['name']; ?>
		                    </td>
		                    <td class="td-center">
		                        <?php echo $prediction['home_goals']; ?>
	                        </td>
	                        <td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['Match']['TeamAway']['flag'];?>" alt="" /></td>
	                        <td>
		                        <?php echo $prediction['Match']['TeamAway']['name']; ?>
		                    </td>
		                    <td class="td-center">
		                        <?php echo $prediction['home_goals']; ?>
	                        </td>
	                        <td class="td-center"><span class='red bold'><?php echo lang('Closed');?></span></td> 
	                    </tr>
	                <?php endif; ?>    
	            <?php endif; ?>
	        <?php endforeach; ?>
	        </tbody>
        </table><!-- end Final Match -->
        <p class='buttons'>
	        <?php echo form_submit('submit',lang('save')); ?>
	        <?php echo anchor('/','<img src="'.base_url().'images/icons/cross.png" alt="" />'.lang('cancel'), 'class="negative"'); ?>
        </p>  
        <?php echo form_close(); ?>
