        <h3>Edit my predictions</h3>
        
	    <?php echo form_open('user_predictions/submit'); ?>

	    <?php echo validation_errors('<p class="error">','</p>'); ?>
	    
	    <h3>Group Stage</h3>
	    <!-- groupmatches -->
	    <?php echo unix_to_human(now()). " - ".unix_to_human(mysql_to_unix($predictions[0]['Match']['time_close']) -$predictions[0]['Match']['Venue']['time_offset_utc'] + $settings['server_time_offset_utc']); ?>
	    <table>
	        <thead>
	            <tr>
	                <th colspan=3>Home</th>
	                <th colspan=3>Away</th>
	                <th>Closing Time</th>
	            </tr>
	        </thead>
	        <tbody>
            <?php foreach ($predictions as $prediction): ?>
		        <?php if ($prediction['Match']['type_id'] == 6) : //these are the group matches ?> 
		                <?php if (now() <  (mysql_to_unix($prediction['Match']['time_close']) -$prediction['Match']['Venue']['time_offset_utc'] + $settings['server_time_offset_utc'])): ?>
		                <tr>
		                <?php echo form_hidden('id['.$prediction['id'].']',$prediction['id']); ?>
                            <td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['Match']['TeamHome']['flag'];?>" alt="" /></td>	            
	                        <td>
	                            <label for="home_goals['<?php echo $prediction['id']; ?>']"><?php echo $prediction['Match']['TeamHome']['name']; ?>:</label>
		                    </td>
		                    <td>
		                        <?php echo form_input('home_goals['.$prediction['id'].']',$prediction['home_goals'],'size=2'); ?>
	                        </td>
	                        <td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['Match']['TeamAway']['flag'];?>" alt="" /></td>
	                        <td>
		                        <label for="away_goals['<?php echo $prediction['id']; ?>']>"><?php echo $prediction['Match']['TeamAway']['name']; ?>:</label>
		                    </td>
		                    <td>
		                        <?php echo form_input('away_goals['.$prediction['id'].']',$prediction['home_goals'], 'size=2'); ?>
	                        </td>
	                        <td><?php echo $prediction['Match']['time_close']; ?></td> 
	                    </tr>
	                <?php else : ?>    
		                <tr>
		                <?php echo form_hidden('id'.$prediction['id'],$prediction['id']); ?>
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
	                        <td class="td-center"><span class='red bold'>Closed</span></td> 
	                    </tr>
	                <?php endif; ?>    
	            <?php endif; ?>
	        <?php endforeach; ?>
	        </tbody>
        </table><!-- end group matches -->
        <p class='buttons'>
	        <?php echo form_submit('submit','Save'); ?>
	        <?php echo anchor('/','<img src="'.base_url().'images/icons/cross.png" alt="" />Cancel', 'class="negative"'); ?>
        </p>
        <?php echo form_close(); ?>
