<?php
// File: application/views/ranking.php
// Author: Schop
// Version: 1.0
$this->lang->load('rank', language());
?>

    <h3><?php echo lang('ranking'); ?></h3><a href="#user"><?php echo lang('Find_myself');?></a>
    <table id='ranking' class='tablesorter'>
        <thead>
            <tr>
                <th class='th-left'><?php echo lang('Rank');?></th>
                <th class='th-left'><?php echo lang('User');?></th>
                <th><?php echo lang('Total_points');?></th>
                <th><?php echo lang('Points_for_home_goals');?></th>
                <th><?php echo lang('Points_for_away_goals');?></th>
                <th><?php echo lang('Points_for_Win-Draw-Loss');?></th>
                <?php if ($settings['use_cards']): ?>
                <th><?php echo lang('Points_for_yellow_cards');?></th>
                <th><?php echo lang('Points_for_red_cards');?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
        <?php $rank = 1; $lastrank = 0; $lasttotal = 0; foreach ($rankings as $ranking): ?>
            <tr>
                <td><?php if ($ranking['total'] != $lasttotal) {echo $rank; $lastrank = $rank;} else {echo $lastrank;} ?></td>
                <td><?php if ($ranking['user_id'] == logged_in()) {echo "<a name='user'></a><span class='red'>";} //mark red when it's this user ?> 
                    <?php if ($settings['view_other_users']) :?>
                        <?php echo anchor('user_predictions/view/'.$ranking['user_id'],$ranking['User']['nickname'],'title = "See '.$ranking['User']['nickname'].'&rsquo;s predictions"'); ?>
                    <?php else : ?>    
                        <?php echo $ranking['User']['nickname']; ?>
                    <?php endif; ?>
                <?php if ($ranking['user_id'] == logged_in()) {echo "</span>";}?></td>
                <td class="td-center"><?php echo $ranking['total']; $lasttotal = $ranking['total'];?></td>
                <td class="td-center"><?php echo $ranking['homegoals']; ?></td>
                <td class="td-center"><?php echo $ranking['awaygoals']; ?></td>
                <td class="td-center"><?php echo $ranking['toto']; ?></td>
                <?php if ($settings['use_cards']): ?>
                <td class="td-center"><?php echo $ranking['yellow']; ?></td>
                <td class="td-center"><?php echo $ranking['red']; ?></td>
                <?php endif; ?>
            </tr>    
        <?php $rank++; endforeach; ?>
        </tbody>
    </table>
