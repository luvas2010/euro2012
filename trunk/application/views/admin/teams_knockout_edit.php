<div class='container_12'>
    <div class='grid_12 alpha omega'>
        <h2><?php echo $title; ?></h2>
        <?php
            $attributes = array('id' => 'Me');
            echo form_open('admin/teams_knockout_edit/index/save', $attributes);
        ?>
        <div class="buttons"><input type='submit' value='<?php echo lang('save'); ?>' class='button save' /></div>
        <div class='clear'></div>
        <table class="stripeMe">
            <tr>
                <th><?php echo lang('match_number'); ?></th>
                <th><?php echo lang('home'); ?></th>
                <th><?php echo lang('away'); ?></th>
                <th><?php echo lang('match_time'); ?></th>
            </tr>
            <?php
                $i = 0;
                foreach($matches as $match)
                {
                    if ($match['match_uid'] >= 25 && $match['match_uid'] <= 31)
                    {
            ?>        
            <tr>
                <td><?php echo $match['match_uid']; ?></td>
                <td>
                    <?php
                        $options = $home_teams[$match['match_uid']];
                        echo form_dropdown('home_team['.$i.']', $options, $match['home_team']);
                    ?>
                </td>
                <td>
                    <?php
                        $options = $away_teams[$match['match_uid']];
                        echo form_dropdown('away_team['.$i.']', $options, $match['away_team']);
                    ?>
                </td>
                <td><?php echo mdate("%d-%m-%Y %H:%i",$match['timestamp']); ?></td>                
            </tr>
            <?php echo form_hidden('match_uid['.$i.']',$match['match_uid']); ?> 
            <?php  $i++; }} ?>
        </table>
        <div class="buttons"><input type='submit' value='<?php echo lang('save'); ?>' class='button save' /></div>
        <div class='clear'></div>
        <?php echo form_close(); ?>
    </div>
</div>
