	<h3>Matches Group Stage</h3>
	<table id="home_table" class="match_table">
        <thead>
            <tr>
                <th class="th-left" colspan="4">Match</th>
                <th>Group</th>
                <th>Result</th>
                <th>Your Prediction</th>
                <th>Points earned</th>
                <th>Closing time</th>
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
				<td class="td-center"><?php echo $prediction['Match']['home_goals']." - ".$prediction['Match']['away_goals']; ?></td>
				<td class="td-center"><?php echo $prediction['home_goals']." - ".$prediction['away_goals']; ?></td>
                <td class="td-center"><?php if($prediction['calculated']) {echo $prediction['points_total_this_match'];} else {echo "-";}; ?></td>
                <?php if (($prediction['calculated'] && $prediction['Match']['home_goals'] != NULL && $prediction['Match']['away_goals'] != NULL) || ($prediction['Match']['home_goals'] != NULL && $prediction['Match']['away_goals'] != NULL && $prediction['home_goals'] == NULL && $prediction['away_goals'] == NULL)) : // has been calulated, so prediction is 'closed' ?>
                    <td class="td-center"><span class="red bold">Closed</span></td>
                <?php elseif (!$closed[$num] && !$prediction['calculated'] && $prediction['Match']['home_goals'] == NULL && $prediction['Match']['away_goals'] == NULL): // not closed, no calculation, no result so the prediction is 'open' ?>
                    <td class="td-center"><?php echo $prediction['Match']['time_close']; ?></td>
                <?php elseif (($closed[$num] && !$prediction['calculated']) || ($prediction['Match']['home_goals'] != NULL && $prediction['Match']['away_goals'] != NULL && !$prediction['calculated']) || ($prediction['Match']['home_goals'] == NULL && $prediction['Match']['away_goals'] == NULL && $prediction['calculated'])): // prediction is closed, or has a result, but has not been calculated yet, o rhas been calculated but the result has been removed ?>
                    <td class="td-center"><span class="green bold">Pending calculation</span></td>
                <?php endif; ?>
                <td><div class="arrow"></div></td>
			</tr>
            <tr> <!-- table row for match details -->
                <td colspan="10">
                    <!-- links and points detail -->
                    <div class="match-detail">                
                        <div class="match-detail-block">
                            <ul>
                                <li><h4>Links for this match:</h4></li>
                                <?php if ($prediction['calculated']): ?>
                                    <li><?php echo anchor('matchstats/score/'.$num,'Check other people&rsquo;s score'); ?></li>
                                <?php elseif (!$prediction['calculated'] && !$closed[$num] && $prediction['Match']['home_goals'] == NULL && $prediction['Match']['away_goals'] == NULL) : ?>
                                    <li><?php echo anchor('prediction/edit/'.$num,'Edit prediction'); ?></li>
                                <?php elseif (($closed[$num] && !$prediction['calculated']) || ($prediction['Match']['home_goals'] != NULL && $prediction['Match']['away_goals'] != NULL && !$prediction['calculated'])): ?>
                                    <li><span class="green bold">Pending Calculation</span></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <?php if($prediction['calculated']): ?>
                            <div class="match-detail-block">
                            <ul>
                                <li><h4>Your results for this match:</h4></li>
                                <li>
                                    <?php if ($prediction['points_home_goals'] == 0){ echo "<span class='strikethrough'>"; } ?>
                                    <?php echo $settings['points_for_goals']; ?> Points for home goals
                                    <?php if ($prediction['points_home_goals'] == 0){ echo "</span>"; } ?>
                                </li>
                                <li>
                                    <?php if ($prediction['points_away_goals'] == 0){ echo "<span class='strikethrough'>"; } ?>
                                    <?php echo $settings['points_for_goals']; ?> Points for away goals
                                    <?php if ($prediction['points_away_goals'] == 0){ echo "</span>"; } ?>
                                </li>
                                <li>
                                    <?php if ($prediction['points_toto'] == 0){ echo "<span class='strikethrough'>"; } ?>
                                    <?php echo $settings['points_for_wdl']; ?> Points for win-draw-loss
                                    <?php if ($prediction['points_toto'] == 0){ echo "</span>"; } ?>
                                </li>
                                <li>
                                    <?php if ($prediction['points_exact'] == 0){ echo "<span class='strikethrough'>"; } ?>
                                    <?php echo $settings['points_for_exact_score']; ?> Bonus points for exact
                                    <?php if ($prediction['points_exact'] == 0){ echo "</span>"; } ?>
                                </li>
                                <li class="list-sum"><?php echo $prediction['points_total_this_match']; ?> Total points</li>    
                            </ul>
                            </div>
                            <div class="match-detail-block">
                            <ul>
                                <li><h4>Other things:</h4></li>
                                <li>Total points after this match: <span class='bold'><?php echo $prediction['total_points_curr']; ?></span></li>
                            </ul>
                            </div>
                        <?php endif; ?>                   
                        <?php if (admin()): ?>
                            <div class="adminlink">
                                <ul>
                                    <li><h4>Administration</h4></li>
                                    <li><?php echo anchor('match/result/'.$prediction['match_number'],'Edit match results', 'class="adminlink"'); ?></li>
                                    <li><?php echo anchor('match/details/'.$prediction['match_number'],'Edit match details', 'class="adminlink" title="Edit this match"'); ?></li>
                                </ul>
                            </div><!-- end adminlinks -->
                        <?php endif; ?>
                    </div> <!-- end links and points detail -->
                </td>
            </tr>
            
        <?php endforeach; ?>
        </tbody>
    </table>
