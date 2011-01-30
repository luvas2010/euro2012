<?php
// File: application/views/ranking.php
// Author: Schop
// Version: 1.0
?>

    <h3><?php echo $title; ?></h3><a href="#user">Find myself</a>
    <table id='ranking' class='tablesorter'>
        <thead>
            <tr>
                <th class='th-left'>Rank</th>
                <th class='th-left'>User</th>
                <th>Total points</th>
                <th>Points for home goals</th>
                <th>Points for away goals</th>
                <th>Points for Win-Draw-Loss</th>
                <?php if ($settings['use_cards']): ?>
                <th>Points for yellow cards</th>
                <th>Points for red cards</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
        <?php $rank = 1; $lasttotal = 0; foreach ($rankings as $ranking): ?>
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
