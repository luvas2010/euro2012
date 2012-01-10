<!-- <?php print_r($predictions); ?> -->
<div class='container_12'>
    <h2 class="teamflag <?php echo $team_uid;?>"><?php echo $title ?></h2>
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
            <script>
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
                    return '<b>'+ this.point.name +'</b>: '+ this.y;
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
                          return '<b>'+ this.point.name +'</b>: '+ this.y;
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
    </div>    
</div> <!-- end container_12 -->