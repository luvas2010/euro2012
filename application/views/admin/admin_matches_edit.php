<div class='container_12'>
    <div class='grid_12 alpha omega'>
        <h2><?php echo $title; ?></h2>
        <?php
            $attributes = array('id' => 'validateMe');
            echo form_open('admin/matches_edit/index/save', $attributes);
        ?>
        <div class="buttons"><input type='submit' value='<?php echo lang('save'); ?>' class='button save' /></div>
        <div class='clear'></div>
        <table class="stripeMe">
            <tr>
                <th><?php echo lang('match_number'); ?></th>
                <th><?php echo lang('home'); ?></th>
                <th><?php echo lang('home_goals'); ?></th>
                <th><?php echo lang('away'); ?></th>
                <th><?php echo lang('away_goals'); ?></th>
                <th><?php echo lang('match_time'); ?></th>
                <th><?php echo lang('status'); ?></th>
                <th><?php echo lang('action'); ?></th>
            </tr>
            <?php
                $i = 0;
                foreach($matches as $match) {
            ?>        
            <tr>
                <td><?php echo $match['match_uid'];?></td>
                <td><?php echo get_team_name($match['home_team']); ?></td>

                <?php
                   $data = array(
                  'name'        => 'home_goals['.$i.']',
                  'value'       => $match['home_goals'],
                  'size'        => 5,
                  'class'       => 'digits');
                ?>
                <td><?php echo form_input($data);?></td>
                <td><?php echo get_team_name($match['away_team']);?></td>
                <?php
                   $data = array(
                  'name'        => 'away_goals['.$i.']',
                  'value'       => $match['away_goals'],
                  'size'        => 5,
                  'class'       => 'digits');
                ?>
                <td><?php echo form_input($data); ?></td>
                <td><?php echo mdate("%d-%m-%Y %H:%i",$match['timestamp']); ?></td>
                    <?php
                        if ($match['match_calculated'] == '1')
                        {
                        ?>
                        <td><?php echo lang('calculated'); ?></td>
                        <td><?php echo anchor('admin/calculations/calculate_match/'.$match['match_uid'].'/1', lang('recalculate')); ?></td>    
                        <?php
                        }
                        else
                        {
                            if (isset($match['home_goals']) && isset($match['away_goals']))
                            {
                            ?>
                                <td><?php echo lang('not_calculated'); ?></td>
                                <td><?php echo anchor('admin/calculations/calculate_match/'.$match['match_uid'], lang('calculate')); ?></td>
                            <?php
                            }
                            else
                            {
                            ?>
                                <td><?php echo lang('no_result_yet'); ?></td>
                                <td></td>
                            <?php
                            }
                            ?>
                        <?php
                        }
                        ?>                                
            </tr>
            
            
            <?php if($match['match_uid'] == 31)
            { ?>
            <tr>
                <td>31</td>
                <?php 
                //$sql_query = "SELECT `team_uid`
                              //FROM `team`
                              //WHERE `team_group` = 'A'
                              //OR    `team_group` = 'B'
                              //OR    `team_group` = 'C'
                              //OR    `team_group` = 'D'";
                //$query = $this->db->query($sql_query);
                //$teams = $query->result_array();
                //$options["NULL"] = lang('choose_a_team');
                //foreach ($teams as $team)
                //{
                    //$options[$team['team_uid']] = get_team_name($team['team_uid']);
                //}
                
                $options = array("NULL" =>lang('choose_a_team'), $match['home_team'] => get_team_name($match['home_team']), $match['away_team'] => get_team_name($match['away_team']));
                ?>
                <td colspan='7'>
                <?php
                    echo form_dropdown('champion', $options, $match['winning_team']);
                ?>
                </td>
            </tr>
            <?php } ?>
            <?php echo form_hidden('match_uid['.$i.']',$match['match_uid']); ?> 
            <?php  $i++; } ?>
        </table>
        <div class="buttons"><input type='submit' value='<?php echo lang('save'); ?>' class='button save' /></div>
        <div class='clear'></div>
    </div>
</div>
