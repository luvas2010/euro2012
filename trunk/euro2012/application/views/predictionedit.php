 <?php
// File: /system/application/views/predictionedit.php
// Version: 1.0
// Author: Schop 
?>
       <h3>Edit Prediction</h3>
	    <div id="prediction_form">
	    <?php echo form_open('prediction/prediction_submit'); ?>

	    <?php echo validation_errors('<p class="error">','</p>'); ?>
        
		    <?php echo form_hidden('id',$prediction->id); ?>
            <?php echo form_hidden('match_number',$prediction->match_number); ?>
            <?php if ($prediction->Match->type_id == 6): ?>
                <p>
                    <label for="homegoals"><?php echo $prediction->Match->TeamHome->name; ?> :</label>
                    <?php echo form_input('homegoals',$prediction->home_goals); ?>
                </p>
                <p>
                    <label for="awaygoals"><?php echo $prediction->Match->TeamAway->name; ?> :</label>
                    <?php echo form_input('awaygoals',$prediction->away_goals); ?>
                </p>
            <?php endif; ?></p>
            <p class='buttons'>
	        <?php echo form_submit('submit','Save'); ?>
	        <?php echo anchor('/home','<img src="'.base_url().'images/icons/cross.png" alt="" />Cancel', 'class="negative"'); ?>
            </p>
            


        <?php echo form_close(); ?>
        </div> <!-- end div #prediction_form -->
        <div id="prediction_info">
                <h4>Information</h4>
                <ul>
                    <li><?php echo "Server time: ".unix_to_human(time(), false, 'eu')." so it is ".unix_to_human(time() - $settings['server_time_offset_utc'] + $prediction->Match->Venue->time_offset_utc, false, 'eu')." over there in ".$prediction->Match->Venue->city; ?></li>
                    <li><?php echo "Match time in ".$prediction->Match->Venue->city." : ".$prediction->Match->time_close; ?></li>
                <?php $local_close = strtotime($prediction->Match->time_close) + $settings['server_time_offset_utc'] - $prediction->Match->Venue->time_offset_utc; ?>
                    <li><?php echo "In your timezone, the prediction closes at: ".unix_to_human($local_close, false,'eu'); ?></li>
                    <li>Now() says: <?php echo unix_to_human(now());?></li>
                </ul>
        </div> <!-- end div #prediction_info -->
