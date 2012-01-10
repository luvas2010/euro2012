<!-- <?php print_r($predictions); ?> -->
<div class='container_12'>
    <h2><?php echo $title ?></h2>
    <div class='grid_12 alpha omega'>
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
</div> <!-- end container_12 -->