    <h2><?php echo $title; ?></h2>
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
    <div class='grid_12 alpha omega'>
        <?php 
        $attributes = array('id' => 'validateMe');
        echo form_open("predictions/extra/save", $attributes); ?>

        <table class="stripeMe">
            <tr>
                <th><?php echo lang('prediction'); ?></th>
                <th><?php echo lang('explanation'); ?></th>
            </tr>
            <tr>
           <?php if (!prediction_closed(1)) { ?>
                <?php 
                $data = array(
                  'name'        => 'totalgoals',
                  'value'       => $prediction['pred_total_goals'],
                  'size'        => 5,
                  'class'       => 'digits'
                );
                ?>
                <td class='centertext'><?php echo form_input($data);?></td>
                
           <?php } else { ?>
                <td><?php echo $prediction['pred_total_goals']; ?></td>
           <?php  } ?>
                <td><?php echo sprintf(lang('predict_total_goals'), $this->config->item('pred_points_bonus'), $this->config->item('pred_points_bonus') -1, $this->config->item('pred_points_bonus')-2);?></td>

            </tr>
            <tr>
           <?php if (!prediction_closed(1)) { ?>
                <?php 
                $sql_query = "SELECT `team_uid`
                              FROM `team`
                              WHERE `team_group` = 'A'
                              OR    `team_group` = 'B'
                              OR    `team_group` = 'C'
                              OR    `team_group` = 'D'";
                $query = $this->db->query($sql_query);
                $teams = $query->result_array();
                $options["NULL"] = lang('choose_a_team');
                foreach ($teams as $team)
                {
                    $options[$team['team_uid']] = get_team_name($team['team_uid']);
                }
                ?>
                <td>
                <?php
                    echo form_dropdown('champion', $options, $prediction['pred_champion']);
                ?>
                </td>
                
           <?php } else { ?>
                <td><?php echo get_team_name($prediction['champion']); ?></td>
           <?php  } ?>
                <td><?php echo sprintf(lang('predict_champion'), $this->config->item('pred_points_champion'));?></td>

            </tr>
            
            <?php echo form_hidden('account_id',$account->id); ?>
                
        </table>
        <?php if (!prediction_closed(1)) { ?>
        <div class="buttons"><input type='submit' value='Save' class='button save' /></div>
        <?php } ?>
        <div class='clear'></div>
        <?php echo form_close(); ?>
    </div>
