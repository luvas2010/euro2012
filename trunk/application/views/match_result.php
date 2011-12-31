<?php $this->load->helper('form'); ?>
<?php echo validation_errors(); ?>
<?php 
    $attributes = array('id' => 'validateMe');
    echo form_open('matches/result/'.$match['match_uid'].'/save', $attributes); ?>

    <table>
        <tr>
            <th>Group</th>
            <th>Home</th>
            <th>Goals</th>
            <th>Away</th>
            <th>Goals</th>
            <th>Match Time</th>
        </tr>
        
        <tr>
            <td><?php echo $match['match_group'];?></td>
            <td><?php echo get_team_name($match['home_team']); ?></td>
            <?php
               $data = array(
              'name'        => 'home_goals',
              'value'       => $match['home_goals'],
              'size'        => 5,
              'class'       => 'digits');
            ?>
            <td><?php echo form_input($data);?></td>
            <td><?php echo get_team_name($match['away_team']);?></td>
            <?php
               $data = array(
              'name'        => 'away_goals',
              'value'       => $match['away_goals'],
              'size'        => 5,
              'class'       => 'digits');
            ?>
            <td><?php echo form_input($data); ?></td>
            <td><?php echo mdate("%d-%m-%Y %H:%i",$match['timestamp']); ?></td>
        </tr>
        
    </table>
    <?php echo form_hidden('match_uid',$match['match_uid']); ?>
    <?php echo form_hidden('match_group',$match['match_group']); ?>
    <div class="buttons"><input type='submit' value='Save' class='button save' /></div>
    <?php echo form_close(); ?>

</div>
