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
                <th class='th-left' colspan="3"><?php echo lang('Rank');?></th>
                <th class='th-left'><?php echo lang('User');?></th>
                <th><?php echo lang('Total_points');?></th>
                <th><?php echo lang('Points_for_home_goals');?></th>
                <th><?php echo lang('Points_for_away_goals');?></th>
                <th><?php echo lang('Points_for_Win-Draw-Loss');?></th>
                <th>Bonus punten</th>
                <th>Punten voor<br />teams</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($rankings as $ranking): ?>
            <tr>
                <?php if (($ranking['User']['position'] < $ranking['User']['lastposition']) && $ranking['User']['lastposition'] != 0) {
                        $indication= "<img src='".base_url()."images/icons/arrow_up.png' alt='' /></td><td style='padding:0;'><span class='green'>(".$ranking['User']['lastposition'].")</span>";
                        }
                      elseif (($ranking['User']['position'] > $ranking['User']['lastposition']) && $ranking['User']['lastposition'] != 0) {
                        $indication= "<img src='".base_url()."images/icons/arrow_down_red.png' alt='' /></td><td style='padding:0;'><span class='red'>(".$ranking['User']['lastposition'].")</span>";
                        }
                      else {
                        $indication= "</td><td style='padding:0;'>(".$ranking['User']['lastposition'].")";
                        } ?>
                
                <td><?php echo $ranking['User']['position']; ?></td>
                <td style='padding:0;'><?php echo $indication; ?></td>
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
                <td class="td-center"><?php echo $ranking['exact']; ?></td>
                <td class="td-center"><?php echo $ranking['home_team'] + $ranking['away_team']; ?></td>
            </tr>    
        <?php endforeach; ?>
        </tbody>
    </table>
