 <?php
// File: /system/application/views/predictionedit.php
// Version: 1.0
// Author: Schop 
?>
       <h3>Edit Prediction</h3>
	    <div id="prediction_form">
	    <?php echo form_open('prediction/prediction_submit'); ?>

	    <?php echo validation_errors('<p class="error">','</p>'); ?>
            <?php $local_close = strtotime($prediction['Match']['time_close']) + $settings['server_time_offset_utc'] - $prediction['Match']['Venue']['time_offset_utc']; ?>
		    <?php echo form_hidden('id',$prediction['id']); ?>
            <?php echo form_hidden('match_number',$prediction['match_number']); ?>
            <?php if ($prediction['Match']['type_id'] == 6): //editing a group match?>
            
                <table>
                    <thead>
                        <tr>
                            <th colspan="3" class="th-left">Home</th>
                            <th colspan="3" class="th-left">Away</th>
                            <th>Match Time (in <?php echo $prediction['Match']['Venue']['city'];?>)</th>
                            <th>Closing Time (on this server)</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="8" class="info th-left">
                                <p>You can change your prediction until the match starts. Make sure you pay attention to the closing time 'on this server'.<br />The current time on the server is <?php echo unix_to_human(time()); ?></p>
                            </th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['Match']['TeamHome']['flag'];?>" alt="" /></td>
                            <td><label for="homegoals"><?php echo $prediction['Match']['TeamHome']['name']; ?> :</label></td>
                            <td><?php echo form_input('homegoals',$prediction['home_goals'], "size='2'"); ?></td>
                            <td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['Match']['TeamAway']['flag'];?>" alt="" /></td>
                            <td><label for="awaygoals"><?php echo $prediction['Match']['TeamAway']['name']; ?> :</label></td>
                            <td><?php echo form_input('awaygoals',$prediction['away_goals'], "size='2'"); ?></td>
                            <td class='td-center'><?php echo $prediction['Match']['match_time'];?></td>
                            <td class='td-center'><?php echo unix_to_human($local_close, false,'eu');?></td>
                        </tr>
                    </tbody>
                </table>
            <?php endif; ?>
            
           <?php if ($prediction['Match']['type_id'] < 6): //editing a knockout match?>
                <table>
                    <thead>
                        <tr>
                            <th colspan="3" class="th-left">Home</th>
                            <th colspan="3" class="th-left">Away</th>
                            <th>Match Time (in <?php echo $prediction['Match']['Venue']['city'];?>)</th>
                            <th>Closing Time (on this server)</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="8" class="info th-left">
                                <p>You can change the goals prediction until the match starts. Make sure you pay attention to the closing time 'on this server'.<br />The current time on the server is <?php echo unix_to_human(time()); ?></p>
                                <p class='bold'>You will have to predict the teams before the tournament starts.</p>
                            </th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['Match']['TeamHome']['flag'];?>" alt="" /></td>
                            <td><?php echo form_dropdown('home_id',$teamshome,$prediction['TeamHome']['id']);?></td>
                            <td><?php echo form_input('homegoals',$prediction['home_goals'], "size='2'"); ?></td>
                            <td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['Match']['TeamAway']['flag'];?>" alt="" /></td>
                            <td><?php echo form_dropdown('away_id',$teamsaway,$prediction['TeamAway']['id']);?></td>
                            <td><?php echo form_input('awaygoals',$prediction['away_goals'], "size='2'"); ?></td>
                            <td class='td-center'><?php echo $prediction['Match']['match_time'];?></td>
                            <td class='td-center'><?php echo unix_to_human($local_close, false,'eu');?></td>
                        </tr>
                    </tbody>
                </table>
            <?php endif; ?>

            
            <p class='buttons'>
	        <?php echo form_submit('submit','Save'); ?>
	        <?php echo anchor('/home','<img src="'.base_url().'images/icons/cross.png" alt="" />Cancel', 'class="negative"'); ?>
            </p>
            


        <?php echo form_close(); ?>
        </div> <!-- end div #prediction_form -->
