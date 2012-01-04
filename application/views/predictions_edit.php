    <h2>Edit Predictions for <?php echo $account_details->fullname; ?></h2>
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
    echo form_open('predictions/edit/save', $attributes); ?>
    <div class="buttons"><input type='submit' value='<?php echo lang('save'); ?>' class='button save' /></div>
    <div class='clear'></div>

    <table class="stripeMe">
        <tr>
            <th>Group</th>
            <th>Home - Away</th>
            <th>Prediction<br/>Home Goals</th>
            <th>Prediction<br/>Away Goals</th>
            <th><?php echo lang('result'); ?></th>
            <th>Match Time</th>
        </tr>
        <?php $i = 0; ?>
        <?php foreach($predictions as $prediction) { ?>
        <?php $pid = $prediction['prediction_uid']; ?>
        <tr>
            <td><?php echo $prediction['match_group'];?></td>
            <td><?php echo get_team_name($prediction['home_team']); ?> - <?php echo get_team_name($prediction['away_team']);?></td>
            <?php
            if (!prediction_closed($prediction['pred_match_uid']))
            {
                $data = array(
                  'name'        => 'pred_home_goals['.$i.']',
                  'value'       => $prediction['pred_home_goals'],
                  'size'        => 5,
                  'class'       => 'digits'
                );
                ?>
                <td><?php echo form_input($data);?></td>
                <?php 
                $data = array(
                  'name'        => 'pred_away_goals['.$i.']',
                  'value'       => $prediction['pred_away_goals'],
                  'size'        => 5,
                  'class'       => 'digits'
                );
                ?>            
                <td><?php echo form_input($data);?></td>
            <?php
            }
            else
            {
            ?>
            <td class='centertext'><?php echo $prediction['pred_home_goals'] ;?></td>
            <td class='centertext'><?php echo $prediction['pred_away_goals'] ;?></td>
            <?php
            }
            ?> 
            <td class='centertext'><?php echo $prediction['home_goals']." - ".$prediction['away_goals']; ?></td>
            <td><?php echo mdate("%d %M %Y %H:%i",$prediction['timestamp']); ?></td>
        </tr>
        <?php echo form_hidden('prediction_uid['.$i.']',$pid); ?>
        <?php echo form_hidden('pred_match_uid['.$i.']',$prediction['pred_match_uid']);?>
        <?php $i++; } ?>    
    </table>
    <div class="buttons"><input type='submit' value='<?php echo lang('save'); ?>' class='button save' /></div>
    <div class='clear'></div>
    <?php echo form_close(); ?>
