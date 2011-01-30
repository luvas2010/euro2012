<?php
// File: /system/application/views/matchstats.php
// Version: 1.0
// Author: Schop
?>
<div class='center'>
        <h2>Match Scores</h2>
    
    <div id='match-stats'>
        <div class='stats-name'>
            <?php echo $hometeam['name'];?>
        </div>
        <div class='stats-name'>
            <?php echo $awayteam['name'];?>
        </div>   
        <div class='stats-name'>
            <img src="<?php echo base_url();?>images/flags/64/<?php echo $hometeam['flag'];?>" alt="" />
        </div>
        <div class='stats-name'>
            <img src="<?php echo base_url();?>images/flags/64/<?php echo $awayteam['flag'];?>" alt="" />
        </div>
        <div class='stats-score'>
            <?php echo $match['home_goals'];?>
        </div>
        <div class='stats-score'>
            <?php echo $match['away_goals'];?>
        </div>   

    </div>    
    <table id="match-stats-table" class="tablesorter">
        <thead>
            <tr>
                <th class="th-left">User</th>
                <th>Prediction</th>
                <th>Total points</th>
                <th>For home goals</th>
                <th>For away goals</th>
                <th>For win-draw-loss</th>
                <th>Bonus Points</th>          
            </tr>        
        </thead>
        <tbody>
        <?php foreach ($stats['all'] as $user) {       
                echo "<tr><td>".$user['User']['nickname']."</td>";
                echo     "<td class='td-center'>".$user['home_goals']." - ".$user['away_goals']."</td>";
                echo     "<td class='td-center'>".$user['points_total_this_match']."</td>";
                echo     "<td class='td-center'>".$user['points_home_goals']."</td>";
                echo     "<td class='td-center'>".$user['points_away_goals']."</td>";
                echo     "<td class='td-center'>".$user['points_toto']."</td>";
                echo     "<td class='td-center'>".$user['points_exact']."</td>";
                echo "</tr>";
                }
        ?>
        </tbody>
    </table>
</div>
<div>
    <p>The average score for this match was <?php echo number_format($stats['avg'],2,'.',''); ?> points.</p>        
</div>    
