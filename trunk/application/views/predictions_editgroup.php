<div class='container_12'>    
    <h2><?php echo sprintf(lang('predictions_for_group'),$group); ?></h2>
    <?php 
        if (validation_errors())
        {
            echo "<div class='error'>";
            echo validation_errors();
            echo "</div>";
        }
    ?>
    <div class='clear'></div>
    <ul class='buttons'>
        <li><?php echo anchor('predictions/editgroup/A',lang('group').' A', "class='button'"); ?></li>
        <li><?php echo anchor('predictions/editgroup/B',lang('group').' B', "class='button'"); ?></li>
        <li><?php echo anchor('predictions/editgroup/C',lang('group').' C', "class='button'"); ?></li>
        <li><?php echo anchor('predictions/editgroup/D',lang('group').' D', "class='button'"); ?></li>
        <li><?php echo anchor('predictions/editgroup/QF',lang('quarter_final'), "class='button'"); ?></li>
        <li><?php echo anchor('predictions/editgroup/SF',lang('semi_final'), "class='button'"); ?></li>
        <li><?php echo anchor('predictions/editgroup/F',lang('final'), "class='button'"); ?></li>
        <li><?php echo anchor('predictions/extra',lang('nav_extra'), "class='button'"); ?></li>
        <li><?php echo anchor('predictions/editgroup/ALL',lang('all_predictions'), "class='button'"); ?></li>
    </ul>
    <div class='clear'></div>
    <div class='info'>
        <div class="grid_2 alpha">
            <div class='buttons'><?php echo anchor('predictions/randomizer/'.$group, 'Randomizer', "class='button flag'"); ?></div>
        </div>
        <div class="grid_9 omega">
            <?php echo lang('randomizer_intro'); ?>
        </div>
        <div class='clear'></div>
    </div>
    

    <div class='grid_12 alpha omega'>
        <?php 
        $attributes = array('id' => 'validateMe');
        echo form_open('predictions/editgroup/'.$group.'/save', $attributes); ?>
        <table class="stripeMe" style="width:100%">
            <tr>
                <th><?php echo lang('match_number'); ?></th>
                <th><?php echo lang('home'); ?></th>
                <th><?php echo lang('away'); ?></th>
                <th colspan=2><?php echo lang('prediction');?></th>
                <th><?php echo lang('result'); ?></th>
                <th><?php echo lang('points_scored'); ?></th>
                <th><?php echo lang('match_time'); ?></th>
            </tr>
            <?php $i = 0; ?>
            <?php foreach($predictions as $prediction) { ?>
            <?php $pid = $prediction['prediction_uid']; ?>
            <tr>
                <td><?php echo $prediction['match_uid'];?></td>
                <!--<td><?php echo get_team_name($prediction['home_team']); ?></td>-->
                
            <?php if (!prediction_closed(1) && $prediction['pred_match_uid'] >= 25 && $prediction['pred_match_uid'] <= 31 ) { ?>
             <td>
                <?php
                    $options = $home_teams[$prediction['match_uid']];
                    echo form_dropdown('pred_home_team['.$i.']', $options, $prediction['pred_home_team']);
                ?>
             </td>
             <td>
                <?php 
                    $options = $away_teams[$prediction['match_uid']];
                    echo form_dropdown('pred_away_team['.$i.']', $options, $prediction['pred_away_team']);
                ?>
             </td>
             <?php } elseif (prediction_closed(1) && $prediction['pred_match_uid'] >= 25 && $prediction['pred_match_uid'] <= 31) { ?>
             <td><?php echo lang($prediction['pred_home_team']); ?></td>
             <td><?php echo lang($prediction['pred_away_team']); ?></td>
             <?php }
                   else
                   { ?>
                       <td><?php echo lang($prediction['home_team']); ?></td>
                       <td><?php echo lang($prediction['away_team']); ?></td>
                   <?php } ?>    
                
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
                    <td class='centertext'><?php echo form_input($data);?></td>
                    <!--<td><?php echo get_team_name($prediction['away_team']);?></td>-->
                    <?php 
                    $data = array(
                      'name'        => 'pred_away_goals['.$i.']',
                      'value'       => $prediction['pred_away_goals'],
                      'size'        => 5,
                      'class'       => 'digits'
                    );
                    ?>            
                    <td class='centertext'><?php echo form_input($data);?></td>
                <?php
                }
                else
                {
                ?>
                <td class='centertext'><?php echo $prediction['pred_home_goals'] ;?></td>
                <!--<td><?php echo get_team_name($prediction['away_team']);?></td>-->
                <td class='centertext'><?php echo $prediction['pred_away_goals'] ;?></td>
                <?php
                }
                ?>    
                <td class='centertext'><?php echo $prediction['home_goals']." - ".$prediction['away_goals']; ?></td>
                <td class='centertext'>
                    <?php
                        if ($prediction['pred_calculated'] == '1')
                        {
                            echo anchor('standings/show/'.$account->id.'/'.$prediction['match_group'],$prediction['pred_points_home_goals']
                                 + $prediction['pred_points_away_goals']
                                 + $prediction['pred_points_result']
                                 + $prediction['pred_points_bonus']
                                 + $prediction['pred_points_home_team']
                                 + $prediction['pred_points_away_team']);
                        }
                        else
                        {
                            if ($prediction['home_goals'] != NULL && $prediction['away_goals'] != NULL)
                            {
                                echo lang('please_be_patient');
                            }
                            else
                            {
                                echo "?";
                            }    
                        }
                    ?>
                </td>
                <td><?php echo mdate("%d %M %Y %H:%i",$prediction['timestamp']); ?></td>
            </tr>
            <?php echo form_hidden('prediction_uid['.$i.']',$pid); ?>
            <?php echo form_hidden('pred_match_uid['.$i.']',$prediction['pred_match_uid']);?>
            <?php $i++; } ?>    
        </table>
        <div class="buttons"><input type='submit' value='<?php echo lang('save'); ?>' class='button save' /></div>
       
    </div>    
    <div class='clear'></div>
    

    <?php if (isset($pred_results)) { // User selected group A, B, C or D?> 
    
        <div class='grid_6 alpha'>
        <h3><?php echo sprintf(lang('pred_standings_in_group'), $group); ?></h3> 
            <table class="stripeMe" style="width:100%">
                <tr>
                    <th><?php echo lang('position'); ?></th>
                    <th><?php echo lang('team'); ?></th>
                    <th><?php echo lang('played'); ?></th>
                    <th><?php echo lang('won'); ?></th>
                    <th><?php echo lang('tie'); ?></th>
                    <th><?php echo lang('lost'); ?></th>
                    <th><?php echo lang('points'); ?></th>
                    <th><?php echo lang('goals'); ?></th>
                </tr>

                <?php $pos = 1; ?>
                <?php foreach($pred_results as $pred_result) { ?>
                <tr>
                    <td><?php echo $pos;?></td>
                    <td><?php echo $pred_result['team_name']; ?></td>
                    <td><?php echo $pred_result['played'];?></td>
                    <td><?php echo $pred_result['won'];?></td>
                    <td><?php echo $pred_result['tie'];?></td>
                    <td><?php echo $pred_result['lost'];?></td>
                    <td><?php echo $pred_result['points'];?></td>
                    <td><?php echo $pred_result['goals_for']." - ".$pred_result['goals_against'];?></td>
                </tr>
                <?php $pos++; } ?>  
            </table>
        </div>
        <div class='grid_6 omega'>
        <h3><?php echo sprintf(lang('standings_in_group'), $group); ?></h3> 
            <table class="stripeMe" style="width:100%">
                <tr>
                    <th><?php echo lang('position'); ?></th>
                    <th><?php echo lang('team'); ?></th>
                    <th><?php echo lang('played'); ?></th>
                    <th><?php echo lang('won'); ?></th>
                    <th><?php echo lang('tie'); ?></th>
                    <th><?php echo lang('lost'); ?></th>
                    <th><?php echo lang('points'); ?></th>
                    <th><?php echo lang('goals'); ?></th>
                </tr>

                <?php $pos = 1; ?>
                <?php foreach($results as $result) { ?>
                <tr>
                    <td><?php echo $pos;?></td>
                    <td><?php echo $result['team_name']; ?></td>
                    <td><?php echo $result['played'];?></td>
                    <td><?php echo $result['won'];?></td>
                    <td><?php echo $result['tie'];?></td>
                    <td><?php echo $result['lost'];?></td>
                    <td><?php echo $result['points'];?></td>
                    <td><?php echo $result['goals_for']." - ".$result['goals_against'];?></td>
                </tr>
                <?php $pos++; } ?>  
            </table>
        </div>
        
    <?php
    }
    ?>
</div>
