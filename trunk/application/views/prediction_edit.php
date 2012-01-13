<div class="container_12">
	<h2><?php echo sprintf(lang('edit_prediction_for'),get_match($prediction['pred_match_uid'])); ?></h2>
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
	<div class="grid_12 alpha omega">
		<h2 class='centertext'><?php echo sprintf(lang('make_prediction_for'), $prediction['pred_match_uid']);?></h2>
		<div class="grid_4 alpha prefix_2 centertext">
			<?php echo get_home_shirt($prediction['home_team']); ?><br/>
			<h2><?php echo lang($prediction['home_team'])?></h2>
			<?php 
            $data = array(
              'name'        => 'pred_home_goals',
              'value'       => $prediction['pred_home_goals'],
              'size'        => 5,
              'class'       => 'digits bigtext centertext'
            );
            ?>
            <?php echo form_input($data);?>
		</div>
		<div class="grid_4 omega suffix_2 centertext">
			<?php echo get_away_shirt($prediction['away_team']); ?>
			<h2><?php echo lang($prediction['away_team'])?></h2>
			<?php 
            $data = array(
              'name'        => 'pred_away_goals',
              'value'       => $prediction['pred_away_goals'],
              'size'        => 5,
              'class'       => 'digits bigtext centertext'
            );
            ?>            
            <?php echo form_input($data);?>
		</div>
		<div class='grid_2 prefix_5 suffix_5 centertext'>
			<input type='submit' value='<?php echo lang('save');?>' class='button save big' />
		</div>	
	</div>	

        <?php echo form_hidden('prediction_uid',$prediction['prediction_uid']); ?>
        <?php echo form_hidden('pred_match_uid',$prediction['pred_match_uid']);?>
		<?php echo form_hidden('pred_match_group',$prediction['match_group']);?>

    <div class='clear'></div>
    <?php echo form_close(); ?>

	<div class='grid_12 alpha omega'>
	<h3>Er zijn al <?php echo $num; ?> voorspellingen gemaakt voor deze wedstrijd. Hieronder kun je zien wat de andere deelnemers denken dan er gaat gebeuren.</h3>
	</div>

        <div class='grid_5 alpha'>
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
        <div class='grid_7 omega'>
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