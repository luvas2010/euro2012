<div class="container_12">
	<div class="match_nav">
        <div class='grid_3 alpha suffix_6'>
            <?php
                if($prediction['pred_match_uid'] > 1)
                { 
                    $prev_match = $prediction['pred_match_uid'] -1;
                    echo anchor('predictions/edit_match/'.$prev_match, lang('match')." ".$prev_match, "class='button  arrow_left'");
                }
                else
                {
                echo "&nbsp;";
                }
            ?>    
        </div>
        <div class='grid_3 omega align_right'>
                <?php
                if($prediction['pred_match_uid'] < 31)
                { 
                    $next_match = $prediction['pred_match_uid'] +1;
                    echo anchor('predictions/edit_match/'.$next_match, lang('match')." ".$next_match, "class='button  arrow_right'");
                }
                else
                {
                echo "&nbsp;";
                }
                ?>  
        </div>
        <div class='clear'></div>
    </div>
    <?php 
        if (validation_errors())
        {
            echo "<div class='error'>";
            echo validation_errors();
            echo "</div>";
        }
    ?>
    <?php 
    $attributes = array('id' => 'validateMe');
    echo form_open("predictions/edit_match/".$prediction['pred_match_uid']."/save", $attributes); ?>
    
    <div class='clear'></div>
	<div class="grid_8 alpha">
		
        <h3 class='centertext'><?php echo sprintf(lang('make_prediction_for'), $prediction['pred_match_uid']);?></h3>
		<div class="grid_4 alpha mediumtext centertext">
			<?php echo get_home_shirt($prediction['home_team'], TRUE); ?><br/>
            <?php if ($prediction['home_team'][0] != 'W' && $prediction['home_team'][0] != 'R') { ?>
			<h2><?php echo anchor('stats/view_team/'.$prediction['home_team'],lang($prediction['home_team']))?></h2>
            <?php } else { ?>
            <h2><?php echo lang($prediction['home_team'])?></h2>
            <?php } ?>
            <?php if($prediction['pred_match_uid'] >= 25)
            {
             ?>
                    <div class='grid_2 alpha'>
                        <?php echo lang('team'); ?>
                    </div>
                    <div class='grid_2 omega align_left'>            
                     <?php if ((!prediction_closed(1) && $prediction['pred_calculated'] == 0) && $prediction['pred_match_uid'] >= 25 && $prediction['pred_match_uid'] <= 31 )
                           {
                               $options = $home_teams[$prediction['match_uid']];
                               echo form_dropdown('pred_home_team['.$match_uid.']', $options, $prediction['pred_home_team'])."<br/><br/>";
                           }
                           else
                           {
                               echo lang($prediction['pred_home_team'])."<br/><br/>";
                           }
                     ?>     
                    </div>
                    <div class='grid_2 alpha'>
                        <?php echo lang('goals'); ?>
                    </div>
                    <div class='grid_2 omega align_left'>            
                    <?php if(!prediction_closed($prediction['pred_match_uid']) && $prediction['pred_calculated'] == 0)
                        { ?>
                        <?php 
                        $data = array(
                          'name'        => 'pred_home_goals',
                          'value'       => $prediction['pred_home_goals'],
                          'size'        => 5,
                          'class'       => 'digits centertext'
                        );
                        ?>
                        <?php echo form_input($data);?>
                        <?php } else { ?>
                        <?php echo $prediction['pred_home_goals']; ?>
                        <?php } ?>
                    </div>
            <?php } else { ?>
            <?php if(!prediction_closed($prediction['pred_match_uid']) && $prediction['pred_calculated'] == 0)
                        { ?>
                        <?php 
                        $data = array(
                          'name'        => 'pred_home_goals',
                          'value'       => $prediction['pred_home_goals'],
                          'size'        => 5,
                          'class'       => 'digits mediumtext centertext'
                        );
                        ?>
                        <?php echo form_input($data);?>
                        <?php } else { ?>
                        <span class='bigtext'><?php echo $prediction['pred_home_goals']; ?></span>
                        <?php } ?>
            <?php } ?>
		</div>
		<div class="grid_4 omega mediumtext centertext">
			<?php echo get_away_shirt($prediction['away_team'], TRUE); ?>
            <?php if ($prediction['away_team'][0] != 'W' && $prediction['away_team'][0] != 'R') { ?>
			<h2><?php echo anchor('stats/view_team/'.$prediction['away_team'],lang($prediction['away_team']))?></h2>
            <?php } else { ?>
            <h2><?php echo lang($prediction['away_team']);?></h2>
            <?php } ?>
            <?php if($prediction['pred_match_uid'] >= 25)
            {
             ?>
                    <div class='grid_2 alpha'>
                        <?php echo lang('team'); ?>
                    </div>
                    <div class='grid_2 omega align_left'>            
                     <?php if (!prediction_closed(1) && $prediction['pred_calculated'] == 0 && $prediction['pred_match_uid'] >= 25 && $prediction['pred_match_uid'] <= 31 )
                           {
                               $options = $away_teams[$prediction['match_uid']];
                               echo form_dropdown('pred_away_team['.$match_uid.']', $options, $prediction['pred_away_team'])."<br/><br/>";
                           }
                           else
                           {
                               echo lang($prediction['pred_away_team'])."<br/><br/>";
                           }
                     ?>     
                    </div>
                    <div class='grid_2 alpha'>
                        <?php echo lang('goals'); ?>
                    </div>
                    <div class='grid_2 omega align_left'>            
                    <?php if(!prediction_closed($prediction['pred_match_uid']))
                        { ?>
                        <?php 
                        $data = array(
                          'name'        => 'pred_away_goals',
                          'value'       => $prediction['pred_away_goals'],
                          'size'        => 5,
                          'class'       => 'digits centertext'
                        );
                        ?>
                        <?php echo form_input($data);?>
                        <?php } else { ?>
                        <?php echo $prediction['pred_away_goals']; ?>
                        <?php } ?>
                    </div>
            <?php } else { ?>
            <?php if(!prediction_closed($prediction['pred_match_uid']) && $prediction['pred_calculated'] == 0)
                        { ?>
                        <?php 
                        $data = array(
                          'name'        => 'pred_away_goals',
                          'value'       => $prediction['pred_away_goals'],
                          'size'        => 5,
                          'class'       => 'digits mediumtext centertext'
                        );
                        ?>
                        <?php echo form_input($data);?>
                        <?php } else { ?>
                        <span class='bigtext'><?php echo $prediction['pred_away_goals']; ?></span>
                        <?php } ?>
            <?php } ?>
            </div>
        <?php if(!prediction_closed($prediction['pred_match_uid']) && $prediction['pred_calculated'] == 0)
            { ?>
		<div class='grid_2 prefix_3 suffix_3 centertext'>
			<br/><br/><input type='submit' value='<?php echo lang('save');?>' class='button save' />
		</div>
        <?php } ?>
        <?php echo form_hidden('prediction_uid',$prediction['prediction_uid']); ?>
        <?php echo form_hidden('pred_match_uid',$prediction['pred_match_uid']);?>
		<?php echo form_hidden('pred_match_group',$prediction['match_group']);?>
        <?php echo form_close(); ?>
        <?php if(prediction_closed(1) && $prediction['pred_match_uid'] >= 25)
        { ?>
        <div class='clear'></div>
        <div class='infostay'><?php echo lang('tournament_started'); ?></div>
        <?php } ?>
        
        <?php if($prediction['pred_calculated']) { ?>
        <div class="grid_8 alpha margintop_20">
        <h3 class='centertext'><?php echo sprintf(lang('results_for_match'), $match_uid); ?></h3>
            <div class='grid_4 alpha centertext'>
                <span class='bigtext'><?php echo $prediction['home_goals']; ?></span>
            </div>    
            <div class='grid_4 omega centertext'>
                <span class='bigtext'><?php echo $prediction['away_goals']; ?></span>
            </div>
            <div class='grid_8 alpha margintop_20'>
                <p><?php echo sprintf(lang('total_points_awarded'), $prediction['pred_points_total']); ?></p>
                <ul>
                <?php if ($prediction['pred_home_goals'] == $prediction['home_goals']) { ?>
                <li><?php echo sprintf(lang('goals_correct'), get_team_name($prediction['home_team']), $this->config->item('pred_points_goals')); ?></li>
                <?php } else { ?>
                <li><?php echo sprintf(lang('goals_wrong'), get_team_name($prediction['home_team'])); ?></li>
                <?php } ?>
                <?php if ($prediction['pred_away_goals'] == $prediction['away_goals']) { ?>
                <li><?php echo sprintf(lang('goals_correct'), get_team_name($prediction['away_team']), $this->config->item('pred_points_goals')); ?></li>
                <?php } else { ?>
                <li><?php echo sprintf(lang('goals_wrong'), get_team_name($prediction['away_team'])); ?></li>
                <?php } ?>
                <?php if($prediction['pred_home_goals'] > $prediction['pred_away_goals'] && $prediction['home_goals'] > $prediction['away_goals'])
                       { ?>
                <li><?php echo sprintf(lang('result_right_win'), get_team_name($prediction['home_team']), get_team_name($prediction['away_team']), $this->config->item('pred_points_result')); ?></li>
                <?php  }  ?>                       
                <?php if($prediction['pred_home_goals'] < $prediction['pred_away_goals'] && $prediction['home_goals'] < $prediction['away_goals'])
                       { ?>
                <li><?php echo sprintf(lang('result_right_win'), get_team_name($prediction['away_team']), get_team_name($prediction['home_team']), $this->config->item('pred_points_result')); ?></li>
                <?php  }  ?>                            
                <?php if($prediction['pred_home_goals'] == $prediction['pred_away_goals'] && $prediction['home_goals'] == $prediction['away_goals'])
                       { ?>
                <li><?php echo sprintf(lang('result_right_tie'), get_team_name($prediction['away_team']), get_team_name($prediction['home_team']), $this->config->item('pred_points_result')); ?></li>
                <?php  }  ?>                            
                </ul>          
            </div>

            
            <?php
                $home_goals_correct = 0;
                $away_goals_correct = 0;
                $result_correct     = 0;
                $everything_correct = 0;
             
                foreach ($predictions as $p)
                {
                    if ($p['home_goals'] == $p['pred_home_goals'])
                    {
                        $home_goals_correct++;
                    }
                    if ($p['away_goals'] == $p['pred_away_goals'])
                    {
                        $away_goals_correct++;
                    }
                    if ($p['away_goals'] == $p['pred_away_goals'] && $p['home_goals'] == $p['pred_home_goals'])
                    {
                        $everything_correct++;
                    }
                    if (
                            ($p['away_goals'] > $p['home_goals'] && $p['pred_away_goals'] > $p['pred_home_goals'])
                            ||
                            ($p['away_goals'] < $p['home_goals'] && $p['pred_away_goals'] < $p['pred_home_goals'])
                            ||
                            ($p['away_goals'] == $p['home_goals'] && $p['pred_away_goals'] == $p['pred_home_goals'])
                        )
                    {
                        $result_correct++;
                    }  
                }
            ?>                
            <p>Totaal <?php echo $num; ?> voorspellingen.<br/>
            Home goals correct: <?php echo $home_goals_correct; ?><br/>
            Away goals correct: <?php echo $away_goals_correct; ?><br/>
            Result correct: <?php echo $result_correct; ?><br/>
            Everything correct: <?php echo $everything_correct; ?></p>
            <?php   $this->load->library('pool');
					$top_3 = get_top_ranking_for_match($match_uid);
					if (is_array($top_3))
					{
						echo "<h3>Top 3</h3>";
						echo "<ul>";
						foreach($top_3 as $user)
						{
							echo "<li><span class='boldtext'>".$user['username'].": </span>".$user['pred_points_total']."</li>";
						}
						echo "</ul>";
					}	
			?>		
        </div>
        <?php } ?>
        
	</div>	
	<div class='grid_4 omega'>
    <h3 class='centertext'><?php echo lang('statistics'); ?></h3>
	<p><?php echo sprintf(lang('statistics_prediction_help'), $num); ?></p>
        <div class='grid_4 alpha omega'>
        <?php echo sprintf(lang('who_will_win_stat'), anchor('stats/view_team/'.$predictions[0]['home_team'],lang($predictions[0]['home_team'])),anchor('stats/view_team/'.$predictions[0]['away_team'],lang($predictions[0]['away_team']))); ?>
        <?php
            $stats = get_match_stats($match_uid);    
            $statschart = "<div id='chart".$match_uid."'></div>";
            if (is_array($stats))
            {
                //first make categories string

                $categories = "";
                $data = "";
                foreach ($stats as $key => $value) {
                    if ($categories == "")
                    {
                        $categories = "['".$key."'";
                    }
                    else
                    {
                        $categories .= ",'".$key."'";
                    }
                    if ($data == "")
                    {
                        $data = "[".$value;
                    }
                    else
                    {
                        $data .= ", ".$value;
                    }    
                }
                $categories .=  "]";
                $data .= "]";
                $pred_text = lang('predictions');
                $statschart .= "<script>
                                var chart;
                                $(document).ready(function() {
                                   chart = new Highcharts.Chart({
                                      chart: {
                                         renderTo: 'chart".$match_uid."',
                                         defaultSeriesType: 'bar',
                                         height: 200
                                      },
                                      colors: ['#FF0000', '#008C48', '#EE2E2F', '#185AA9', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
                                      title: {
                                         text: null
                                      },
                                        credits: {
                                            enabled: false
                                         },      
                                      xAxis: {
                                         tickmarkPlacement: 'on',
                                         categories: $categories,
                                         labels: {
                                            align: 'right',
                                            style: {
                                                font: 'normal 13px Verdana, sans-serif'
                                            }
                                         }
                                      },
                                      yAxis: {
                                         allowDecimals: false,
                                         min: 0,
                                         title: {
                                            text: null
                                            }
                                      },
                                      plotOptions : {
                                        bar: {
                                            pointPadding: 0,
                                            groupPadding: 0,
                                            pointWidth: 20,
                                            colorByPoint: true
                                            }
                                      },      
                                      legend: {
                                         enabled: false
                                      },
                                      tooltip: {
                                         formatter: function() {
                                            return '<b>'+ this.x +'</b><br/>'+
                                                this.y + ' $pred_text';
                                         }
                                      },
                                      series: [{
                                         name: '',
                                         data: $data,        
                                      }]
                                   });
                                });
                            </script>";
                echo $statschart;
            }
            ?>
        </div>
        <div class='grid_4 alpha omega'>
        <h3>Meer statistieken</h3>
            <ul class='hasbullets'>
            <?php   $home_goals_total = 0;
                    $away_goals_total = 0;
                    $num = 0;
                    $max_home_goals = 0;
                    $max_away_goals = 0;
                    foreach ($predictions as $prediction)
                    {
                        $home_goals_total = $home_goals_total + $prediction['pred_home_goals'];
                        $away_goals_total = $away_goals_total + $prediction['pred_away_goals'];
                        if ($prediction['pred_home_goals'] > $max_home_goals)
                        {
                            $max_home_goals = $prediction['pred_home_goals'];
                        }    
                        if ($prediction['pred_away_goals'] > $max_away_goals)
                        {
                            $max_away_goals = $prediction['pred_away_goals'];
                        }                         
                        $num++;
                    }
                    echo "<li>".sprintf(lang('match_avg_goals'),number_format($home_goals_total/$num, 2),anchor('stats/view_team/'.$predictions[0]['home_team'],lang($predictions[0]['home_team'])),number_format($away_goals_total/$num, 2),anchor('stats/view_team/'.$predictions[0]['away_team'],lang($predictions[0]['away_team'])))."</li>";
                    echo "<li>".sprintf(lang('match_max_goals'),anchor('stats/view_team/'.$predictions[0]['home_team'],lang($predictions[0]['home_team'])),$max_home_goals)."</li>";
                    echo "<li>".sprintf(lang('match_max_goals'),anchor('stats/view_team/'.$predictions[0]['away_team'],lang($predictions[0]['away_team'])),$max_away_goals)."</li>";
                    
                    ?>
            </ul>        
        </div>
    </div>    
</div>