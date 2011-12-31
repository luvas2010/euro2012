	<h2><?php echo sprintf(lang('edit_prediction_for'),get_match($prediction['pred_match_uid'])); ?></h2>
    <?php 
        if (validation_errors())
        {
            echo "<div class='error'>";
            echo validation_errors();
            echo "</div>";
        }
    ?>
    <?php 
    $attributes = array('id' => 'validateMe');
    echo form_open("matches/edit_prediction/".$prediction['pred_match_uid']."/save", $attributes); ?>
    
    <div class='clear'></div>

    <table class="stripeMe">
		<tr>
			<th><?php echo lang('match_number'); ?></th>
            <th>Home - Away</th>
            <th>Prediction<br/>Home Goals</th>
            <th>Prediction<br/>Away Goals</th>
		</tr>
        
        <?php $pid = $prediction['prediction_uid']; ?>
		<tr>
			<td><?php echo $prediction['pred_match_uid'];?></td>
            <td><?php echo get_match($prediction['pred_match_uid']); ?> </td>
            <?php 
            $data = array(
              'name'        => 'pred_home_goals',
              'value'       => $prediction['pred_home_goals'],
              'size'        => 5,
              'class'       => 'digits'
            );
            ?>
            <td><?php echo form_input($data);?></td>
            <?php 
            $data = array(
              'name'        => 'pred_away_goals',
              'value'       => $prediction['pred_away_goals'],
              'size'        => 5,
              'class'       => 'digits'
            );
            ?>            
            <td><?php echo form_input($data);?></td>
		</tr>
        <?php echo form_hidden('prediction_uid',$pid); ?>
        <?php echo form_hidden('pred_match_uid',$prediction['pred_match_uid']);?>
			
	</table>
    <div class="buttons"><input type='submit' value='Save' class='button save' /></div>
    <div class='clear'></div>
    <?php echo form_close(); ?>
