    <h2><?php echo sprintf(lang('overview_of_predictions_for'), $account_details->fullname); ?></h2>
    <div class='buttons'><?php echo anchor("/predictions/edit",lang('edit_all_predictions'),"class='button'"); ?></div>
    <div class='clear'></div>
    <table class='stripeMe'>
        <tr>
            <th><?php echo lang('match_number'); ?></th>
            <th><?php echo lang('group'); ?></th>
            <th><?php echo lang('home'); ?> - <?php echo lang('away'); ?></th>
            <th><?php echo lang('prediction'); ?></th>
            <th><?php echo lang('result'); ?></th>
            <th><?php echo lang('points_scored'); ?></th>
            <th><?php echo lang('total_points'); ?></th>
            <th><?php echo lang('match_time'); ?></th>
            <th><?php echo lang('prediction'); ?></th>
        </tr>
        <?php foreach($predictions as $prediction) { ?>
        <tr>
            <td><?php echo $prediction['match_uid']; ?></td>
            <td class='smalltext'><?php echo $prediction['match_group'];?></td>
            <td><?php echo get_team_name($prediction['home_team']); ?> - <?php echo get_team_name($prediction['away_team']);?></td>
            <td class='centertext'><?php echo $prediction['pred_home_goals']; ?> - <?php echo $prediction['pred_away_goals']; ?></td>
            <td class='centertext'><?php echo $prediction['home_goals']." - ".$prediction['away_goals']; ?></td>
            <td class='smalltext'>
                <?php echo lang('home_goals').": ".$prediction['pred_points_home_goals']; ?><br/>
                <?php echo lang('away_goals').": ".$prediction['pred_points_away_goals']; ?><br/>
                <?php echo lang('match_result').": ".$prediction['pred_points_result']; ?>
            </td>
            <td class='bigtext'>
                <?php echo $prediction['pred_points_home_goals'] + $prediction['pred_points_away_goals'] + $prediction['pred_points_result']; ?>
            </td>
            <td><?php echo mdate("%d %M %Y %H:%i",$prediction['timestamp']); ?></td>
            <td><?php echo anchor('matches/edit_prediction/'.$prediction['match_uid'],lang('prediction'), 'class="button small"'); ?></td>
        </tr>
        <?php } ?>  
    </table>
