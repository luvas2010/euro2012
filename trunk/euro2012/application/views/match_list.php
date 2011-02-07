<?php $this->lang->load('match', language()); ?>
<?php echo $text; ?>
	<h3><?php echo lang('match_group_stage');?></h3>
	<table id="home_table" class="match_table">
        <thead>
            <tr>
                <th class="th-left" colspan="4"><?php echo lang('match');?></th>
                <th><?php echo lang('group');?></th>
                <th><?php echo lang('result');?></th>
                <th><?php echo lang('your_prediction');?></th>
                <th><?php echo lang('points_earned');?></th>
                <th><?php echo lang('closing_time');?></th>
                <th>&nbsp;</th>
            </tr>
		</thead>
        <tbody>
        <?php foreach($predictions as $prediction): ?>
            <?php $num = $prediction['match_number']; ?>
			<tr>
				<td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['Match']['TeamHome']['flag'];?>" alt="" /></td>
                <td><?php echo $prediction['Match']['TeamHome']['name'] ?></td>
				<td class='td-center'><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $prediction['Match']['TeamAway']['flag'];?>" alt="" /></td>
                <td><?php echo $prediction['Match']['TeamAway']['name']; ?></td>
                <td class="td-center"><?php echo $prediction['Match']['match_group']; ?></td>
				<td class="td-center">
                <?php echo $prediction['Match']['home_goals']." - ".$prediction['Match']['away_goals']; ?></td>
				<td class="td-center">
                    <?php if ($prediction['Match']['type_id'] < 6):?>
                    <?php echo $prediction['TeamHome']['name'];?> - <?php echo $prediction['TeamAway']['name'];?><br /><br />
                    <?php endif; ?>                
                    <?php echo $prediction['home_goals']." - ".$prediction['away_goals']; ?></td>
                <td class="td-center"><?php if($prediction['calculated']) {echo $prediction['points_total_this_match'];} else {echo "-";}; ?></td>
                <?php if ((     $prediction['calculated'] 
                                && $prediction['Match']['home_goals'] != NULL 
                                && $prediction['Match']['away_goals'] != NULL) //has been set to calculated and has a result
                            || ($prediction['Match']['home_goals'] != NULL
                                && $prediction['Match']['away_goals'] != NULL
                                && $prediction['home_goals'] == NULL
                                && $prediction['away_goals'] == NULL)) : // OR has a result, but no prediction ?? this has to be reviewed ?>
                    <td class="td-center"><span class="red bold"><?php echo lang('closed');?></span></td>
                <?php elseif (  !$closed[$num]
                                && !$prediction['calculated']
                                && $prediction['Match']['home_goals'] == NULL
                                && $prediction['Match']['away_goals'] == NULL): // not closed, no calculation, no result so the prediction is 'open' ?>
                    <td class="td-center"><?php echo $prediction['Match']['time_close']; ?></td>
                <?php elseif ((     $closed[$num]
                                    && !$prediction['calculated'])
                               ||   ($prediction['Match']['home_goals'] != NULL
                                    && $prediction['Match']['away_goals'] != NULL
                                    && !$prediction['calculated'])
                               ||   ($prediction['Match']['home_goals'] == NULL
                                    && $prediction['Match']['away_goals'] == NULL
                                    && $prediction['calculated'])): // prediction is closed, or has a result, but has not been calculated yet, o rhas been calculated but the result has been removed ?>
                    <td class="td-center"><span class="green bold"><?php echo lang('pending_calculation');?></span></td>
                <?php endif; ?>
                <td><div class="arrow"></div></td>
			</tr>
            <tr> <!-- table row for match details -->
                <td colspan="10">
                    <!-- links and points detail -->
                    <div class="match-detail">                
                        <div class="match-detail-block">
                            <ul>
                                <li><h4><?php echo lang('links_for_this_match');?>:</h4></li>
                                <?php if ($prediction['calculated']): ?>
                                    <li><?php echo anchor('matchstats/score/'.$num,'Check other people&rsquo;s score'); ?></li>
                                <?php elseif (!$prediction['calculated'] && !$closed[$num] && $prediction['Match']['home_goals'] == NULL && $prediction['Match']['away_goals'] == NULL) : ?>
                                    <li><?php echo anchor('user_predictions/edit_single/'.$num,lang('edit_prediction')); ?></li>
                                <?php elseif (($closed[$num] && !$prediction['calculated']) || ($prediction['Match']['home_goals'] != NULL && $prediction['Match']['away_goals'] != NULL && !$prediction['calculated'])): ?>
                                    <li><span class="green bold"><?php echo lang('pending_calculation');?></span></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <?php if($prediction['calculated']): ?>
                            <div class="match-detail-block">
                            <ul>
                                <li><h4><?php echo lang('your_results_for_this_match');?>:</h4></li>
                                <li>
                                    <?php if ($prediction['points_home_goals'] == 0){ echo "<span class='strikethrough'>"; } ?>
                                    <?php echo $settings['points_for_goals'].' '.lang('points_for_home_goals');?>
                                    <?php if ($prediction['points_home_goals'] == 0){ echo "</span>"; } ?>
                                </li>
                                <li>
                                    <?php if ($prediction['points_away_goals'] == 0){ echo "<span class='strikethrough'>"; } ?>
                                    <?php echo $settings['points_for_goals'].' '.lang('points_for_away_goals');?>
                                    <?php if ($prediction['points_away_goals'] == 0){ echo "</span>"; } ?>
                                </li>
                                <li>
                                    <?php if ($prediction['points_toto'] == 0){ echo "<span class='strikethrough'>"; } ?>
                                    <?php echo $settings['points_for_wdl'].' '.lang('points_for_win-draw-loss');?>
                                    <?php if ($prediction['points_toto'] == 0){ echo "</span>"; } ?>
                                </li>
                                <li>
                                    <?php if ($prediction['points_exact'] == 0){ echo "<span class='strikethrough'>"; } ?>
                                    <?php echo $settings['points_for_exact_score'].' '.lang('bonus_points_for_exact');?>
                                    <?php if ($prediction['points_exact'] == 0){ echo "</span>"; } ?>
                                </li>
                                <?php if ($prediction['Match']['type_id'] == 4) : ?>
                                    <li>
                                    <?php if ($prediction['points_home_id'] == 0) {echo "<span class='strikethrough'>";} ?>
                                    <?php echo $settings['points_for_team_qf']." ".lang('points_for_home_team'); ?>
                                    <?php if ($prediction['points_home_id'] == 0) {echo "</span>";} ?>
                                    </li>
                                    <li>
                                    <?php if ($prediction['points_away_id'] == 0) {echo "<span class='strikethrough'>";} ?>
                                    <?php echo $settings['points_for_team_qf']." ".lang('points_for_away_team'); ?>
                                    <?php if ($prediction['points_away_id'] == 0) {echo "</span>";} ?>
                                    </li>                                        
                                <?php endif; ?>
                                <li class="list-sum"><?php echo $prediction['points_total_this_match'].' '.lang('total_points');?></li>    
                            </ul>
                            </div>
                            <div class="match-detail-block">
                            <ul>
                                <li><h4><?php echo lang('other_things');?>:</h4></li>
                                <li><?php echo lang('total_points_after_this_match');?>: <span class='bold'><?php echo $prediction['total_points_curr']; ?></span></li>
                            </ul>
                            </div>
                        <?php endif; ?>                   
                        <?php if (admin()): ?>
                            <div class="adminlink">
                                <ul>
                                    <li><h4><?php echo lang('administration');?></h4></li>
                                    <li><?php echo anchor('match/result/'.$prediction['match_number'],lang('edit_match_results'), 'class="adminlink"'); ?></li>
                                    <li><?php echo anchor('match/details/'.$prediction['match_number'],lang('edit_match_details'), 'class="adminlink" title="Edit this match"'); ?></li>
                                </ul>
                            </div><!-- end adminlinks -->
                        <?php endif; ?>
                    </div> <!-- end links and points detail -->
                </td>
            </tr>
            
        <?php endforeach; ?>
        </tbody>
    </table>
