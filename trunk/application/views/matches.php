    <h2><?php echo lang('overview_matches'); ?></h2>
    <ul class='buttons'>
        <li><?php echo anchor('predictions/editgroup/A',lang('group').' A', "class='button'"); ?></li>
        <li><?php echo anchor('predictions/editgroup/B',lang('group').' B', "class='button'"); ?></li>
        <li><?php echo anchor('predictions/editgroup/C',lang('group').' C', "class='button'"); ?></li>
        <li><?php echo anchor('predictions/editgroup/D',lang('group').' D', "class='button'"); ?></li>
        <li><?php echo anchor('predictions/editgroup/QF',lang('quarter_final'), "class='button'"); ?></li>
        <li><?php echo anchor('predictions/editgroup/SF',lang('semi_final'), "class='button'"); ?></li>
        <li><?php echo anchor('predictions/editgroup/F',lang('final'), "class='button'"); ?></li>
        <li><?php echo anchor('predictions/edit',lang('all_predictions'), "class='button'"); ?></li>
    </ul>
    <div class='clear'></div>
    <table class="stripeMe">
        <tr>
            <th><?php echo lang('match_number'); ?></th>
            <th><?php echo lang('group'); ?></th>
            <th><?php echo lang('home'); ?><br/>(<?php echo lang('prediction');?>)</th>
			<th><?php echo lang('away'); ?><br/>(<?php echo lang('prediction');?>)</th>
            <th><?php echo lang('predicted'); ?></th>
            <th><?php echo lang('result'); ?></th>
            <th><?php echo lang('match_time'); ?></th>
            <th><?php echo lang('prediction'); ?></th>
            <th><?php echo lang('scores_for_match'); ?></th>

        </tr>
        <?php foreach($matches as $match) { ?>
        <tr>
            <td><?php echo $match['match_uid'];?></td>
            <td><?php echo $match['match_group'];?></td>
            <?php if($match['home_team'][0] != 'W' && $match['home_team'][0] != 'R' && $match['away_team'][0] != 'W' && $match['away_team'][0] != 'R')
                { ?>
            <td><span class="teamflag <?php echo $match['home_team'];?>"><?php echo anchor('stats/view_team/'.$match['home_team'],get_team_name($match['home_team']));?></span>
			<?php if ($match['match_uid'] >= 25)
                { ?>
                <br />
                <?php echo "(".get_team_name($match['pred_home_team']).")"; } ?>
			</td>
            <td><span class="teamflag <?php echo $match['away_team'];?>"><?php echo anchor('stats/view_team/'.$match['away_team'],get_team_name($match['away_team']));?></span>
                <?php if ($match['match_uid'] >= 25)
                { ?>
                <br />
                <?php echo "(".get_team_name($match['pred_away_team']).")";?>
                <?php } ?>
            </td>
            <?php } else { ?>
            <td><span class="teamflag <?php echo $match['home_team'];?>"><?php echo get_team_name($match['home_team']);?></span>
			<?php if ($match['match_uid'] >= 25)
                { ?>
                <br />
                <?php echo "(".get_team_name($match['pred_home_team']).")"; ?>
                <?php } ?>
            </td>
            <td><span class="teamflag <?php echo $match['away_team'];?>"><?php echo get_team_name($match['away_team']);?></span>
                <?php if ($match['match_uid'] >= 25)
                { ?>
                <br />
                <?php echo "(".get_team_name($match['pred_away_team']).")";?>
                <?php } ?>
            </td>
			<?php } ?>
            <td class='centertext'><?php echo $match['pred_home_goals']." - ".$match['pred_away_goals']; ?></td>
            <td class='centertext'><?php echo $match['home_goals']." - ".$match['away_goals'];?></td>
            <td><?php echo mdate("%d %M %Y %H:%i",$match['timestamp']); ?></td>
            <td><?php echo anchor('predictions/editgroup/'.$match['match_group'],lang($match['match_group']), 'class="button small"'); ?></td>
            <?php if($match['match_calculated'] == 1)
                  { ?>
                  <td><?php echo anchor('results/show/'.$match['match_uid'],lang('show_scores_for_match'), 'class="button small"'); ?></td>
            <?php }
                  else
                  { ?>
                  <td><?php echo lang('not_calculated_yet'); ?></td>
                  <?php } ?>      
        </tr>
        <?php } ?>  
    </table>

