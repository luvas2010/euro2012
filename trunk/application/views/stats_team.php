<div class='container_12'>
    <?php if($team_uid[0] != 'W' && $team_uid[0] != 'R') { ?>
    <div class="grid_9 alpha">
    <h2 class="teamflag <?php echo $team_uid;?>"><?php echo $title ?></h2>
    </div>
    <div class="grid_3 omega">
        <?php
        echo get_home_shirt($team_uid);
        echo get_away_shirt($team_uid);
        ?>
    </div>
    <div class='grid_12 alpha omega'>
    <h3><?php echo lang('group_stage'); ?></h3>    
        <div class='grid_8 alpha'>
            
            <p><?php echo sprintf(lang('num_of_predictions_made'), $num, lang($team_uid)); ?></p>
            <div id="chart"></div>
            
            <?php
            //first make data string
            
            $data = "";
            if (is_array($group_stage))
            {
            foreach ($group_stage as $key => $value) {
                if ($data == "")
                {
                    $data = "[['".sprintf(lang($key), lang($team_uid))."', ".$value."]";
                }
                else
                {
                    $data .= ",['".sprintf(lang($key), lang($team_uid))."', ".$value."]";
                }
            }
            $data .=  "]";
            
            ?>
            <script type='text/javascript'>
        var chart;
        $(document).ready(function() {
           chart = new Highcharts.Chart({
              chart: {
                 renderTo: 'chart',
                 plotBackgroundColor: null,
                 plotBorderWidth: null,
                 plotShadow: false
              },
              title: {
                 text: null
              },
                credits: {
                    enabled: false
                 },      
              tooltip: {
                 formatter: function() {
                    return this.point.name +': '+ this.y;
                 }
              },
              plotOptions: {
                series: {
                    animation: {
                        duration: 3000
                    }
                },
                 pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                       enabled: true,
                       formatter: function() {
                          return this.point.name +': '+ this.y;
                      }
                    },
                    showInLegend: false
                 }
              },
               series: [{
                 type: 'pie',
                 name: 'W-T-L',
                 data: <?php echo $data; ?>
              }]
           });
        });
            </script>
            <?php
            }
            else
            {
            ?>
            <div class='info'><?php echo lang('no_info_yet');?></div>
            <?php
            }
            ?>            
            
        </div>
        <div class='grid_4 omega'>

        <ul class='hasbullets'>
            <li><?php echo sprintf(lang('goals_prediction'), lang($team_uid),$avg_goals_for,$avg_goals_against);?></li>
            <li><?php echo sprintf(lang('pred_freq_qf'), lang($team_uid), $knockout_stage['quarter_finals']); ?></li>
            <li><?php echo sprintf(lang('pred_freq_sf'), $knockout_stage['semi_finals']); ?></li>
            <li><?php echo sprintf(lang('pred_freq_f'), $knockout_stage['finals']); ?></li>
            <li><?php echo sprintf(lang('pred_freq_champ'), lang($team_uid), $num_champ); ?></li>
        </ul>
        
        </div>
        <div class='clear'></div>
        <div class='grid 12 alpha omega'>
        <h3><?php echo sprintf(lang('your_predictions_for_group_stage'),get_team_name($team_uid)); ?></h3>
        </div>
        <div class='grid_10 alpha'>
            <table class="stripeMe">
                <tr>
                    <th><?php echo lang('match_number');?></th>
                    <th><?php echo lang('home'); ?></th>
                    <th><?php echo lang('away'); ?></th>
                    <th><?php echo lang('prediction');?></th>
                    <th><?php echo lang('result'); ?></th>
                    <th><?php echo lang('points'); ?></th>
                    <th><?php echo lang('match_time'); ?></th>
                </tr>
            <?php foreach($user_team_pred_group_stage as $pred)
                  {
            ?>
                <tr>
                    <td><?php echo $pred['pred_match_uid']; ?></td>
                    <?php if ($pred['home_team'] == $team_uid) { ?>
                    <td><span class="teamflag <?php echo $pred['home_team'];?>"><?php echo lang($pred['home_team']); ?></span></td>
                    <?php } else { ?>
                    <td><span class="teamflag <?php echo $pred['home_team'];?>"><?php echo anchor('stats/view_team/'.$pred['home_team'],lang($pred['home_team'])); ?></span></td>
                    <?php  } ?>
                    <?php if ($pred['away_team'] == $team_uid) { ?>
                    <td><span class="teamflag <?php echo $pred['away_team'];?>"><?php echo lang($pred['away_team']); ?></span></td>
                    <?php } else { ?>
                    <td><span class="teamflag <?php echo $pred['away_team'];?>"><?php echo anchor('stats/view_team/'.$pred['away_team'],lang($pred['away_team'])); ?></span></td>
                    <?php  } ?>
                    <td class='centertext'><?php echo $pred['pred_home_goals']." - ".$pred['pred_away_goals']; ?></td>
                    <td class='centertext'><?php echo $pred['home_goals']." - ".$pred['away_goals']; ?></td>
                    <td class='centertext'><?php echo $pred['pred_points_total']; ?></td>
                    <td><?php echo mdate("%d %M %Y %H:%i",$pred['timestamp']);?></td>
                </tr>
            <?php } ?>
            </table>
            
            <?php if (isset($user_team_pred_knockout_stage[0]))
                  {
            ?>
            <h3><?php echo sprintf(lang('your_predictions_for_knockout_stage'),get_team_name($team_uid)); ?></h3>
            <table class="stripeMe">
                <tr>
                    <th><?php echo lang('match_number');?></th>
                    <th><?php echo lang('home'); ?></th>
                    <th><?php echo lang('away'); ?></th>
                    <th><?php echo lang('prediction');?></th>
                    <th><?php echo lang('result'); ?></th>
                    <th><?php echo lang('points'); ?></th>
                    <th><?php echo lang('match_time'); ?></th>
                </tr>
            <?php foreach($user_team_pred_knockout_stage as $pred)
                  {
            ?>
                <tr><td class='centertext' colspan='7'><span class='boldtext'><?php echo lang($pred['match_group']);?></span></td></tr>
                <tr>
                    <td><?php echo $pred['pred_match_uid']; ?></td>
                    <?php if ($pred['pred_home_team'] == $team_uid) { ?>
                    <td><span class="teamflag <?php echo $pred['pred_home_team'];?>"><?php echo lang($pred['pred_home_team']); ?></span></td>
                    <?php } else { ?>
                    <td><span class="teamflag <?php echo $pred['pred_home_team'];?>"><?php echo anchor('stats/view_team/'.$pred['pred_home_team'], lang($pred['pred_home_team'])); ?></span></td>
                    <?php } ?>
                    <?php if ($pred['pred_away_team'] == $team_uid) { ?>
                    <td><span class="teamflag <?php echo $pred['pred_away_team'];?>"><?php echo lang($pred['pred_away_team']); ?></span></td>
                    <?php } else { ?>
                    <td><span class="teamflag <?php echo $pred['pred_away_team'];?>"><?php echo anchor('stats/view_team/'.$pred['pred_away_team'], lang($pred['pred_away_team'])); ?></span></td>
                    <?php } ?>
                    <td class='centertext'><?php echo $pred['pred_home_goals']." - ".$pred['pred_away_goals']; ?></td>
                    <td class='centertext'><?php echo $pred['home_goals']." - ".$pred['away_goals']; ?></td>
                    <td class='centertext'><?php echo $pred['pred_points_total']; ?></td>
                    <td><?php echo mdate("%d %M %Y %H:%i",$pred['timestamp']);?></td>
                </tr>
            <?php } ?>
            </table>            
            
            <?php } else { ?>
            <h3><?php echo sprintf(lang('no_knockout_predictions'), get_team_name($team_uid)); ?></h3>
            <?php } ?>
        </div>
    </div>
    <?php } else { ?>
    No
    <?php } ?>
</div> <!-- end container_12 -->