 <?php
// File: /system/application/views/predictionedit.php
// Version: 1.0
// Author: Schop 
?>
       <h3>Voorspelling invoeren voor <?php echo $prediction['Match']['match_name']; ?></h3>
       <h4><?php echo $prediction['Match']['description']; ?></h4>
	    <div id="prediction_form">
	    <?php echo form_open('user_predictions/prediction_single_submit'); ?>

	    <?php echo validation_errors('<p class="error">','</p>'); ?>
            <?php $local_close = strtotime($prediction['Match']['time_close']) + $settings['server_time_offset_utc'] - $prediction['Match']['Venue']['time_offset_utc']; ?>
		    <?php echo form_hidden('id',$prediction['id']); ?>
            <?php echo form_hidden('match_number',$prediction['match_number']); ?>
            <?php if ($prediction['Match']['type_id'] == 6): //editing a group match?>
            
                <table>
                    <thead>
                        <tr>
                            <th colspan="2" class="th-left">Thuis ploeg</th>
                            <th>Goals</th>
                            <th colspan="2" class="th-left">Uit ploeg</th>
                            <th>Goals</th>
                            <th>Wedstrijd begint om<br />(in <?php echo $prediction['Match']['Venue']['city'];?>)</th>
                            <th>Sluitingstijd<br />(op deze server)</th>
                        </tr>
                    </thead>
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
                            <th colspan="2" class="th-left">Thuis ploeg</th>
                            <th>Goals</th>
                            <th colspan="2" class="th-left">Uit ploeg</th>
                            <th>Goals</th>
                            <th>Wedstrijd tijd<br />(in <?php echo $prediction['Match']['Venue']['city'];?>)</th>
                            <th>Sluitingstijd<br />(op deze server)</th>
                        </tr>
                    </thead>
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
            <div class="info">
            <p>Je kunt de uitslag voorspellen tot aan de sluitingstijd. Let op, de tijd op de server wordt hiervoor gebruikt!.<br />De tijd op de server is nu <?php echo unix_to_human(time()); ?></p>
            <?php if ($prediction['Match']['type_id'] < 6) : ?>
                <p class='bold'>Welke teams deze wedstijd spelen, moet je voor het toernooi begint voorspellen!</p>
            <?php endif; ?>
            </div>
            <?php if ($warning) : ?>
                <p class='error'>Je hebt de landen nog niet voorspeld voor deze wedstijd! Doe dit v&oacute;&oacute;r het toernooi begint, anders loop je misschien kostbare punten mis!</p>
            <?php endif; ?>

            
            <p class='buttons'>
	        <?php echo form_submit('submit','Save'); ?>
	        <?php echo anchor('/home','<img src="'.base_url().'images/icons/cross.png" alt="" />Cancel', 'class="negative"'); ?>
            </p>
            


        <?php echo form_close(); ?>
        </div> <!-- end div #prediction_form -->
