    <h2><?php echo $title; ?></h2>
    <div id="chart"></div>
    
    <?php
    if (is_array($pred_goals))
    {
        //first make categories string

        $categories = "";
        $data = "";
        foreach ($pred_goals as $key => $value) {
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
        ?>
        <script>
            var chart;
            $(document).ready(function() {
               chart = new Highcharts.Chart({
                  chart: {
                     renderTo: 'chart',
                     defaultSeriesType: 'column',
                     margin: [ 50, 50, 100, 80]
                  },
                  title: {
                     text: '<?php echo lang('nav_totalgoals_graph'); ?>'
                  },
                    credits: {
                        enabled: false
                     },      
                  xAxis: {
                     categories: <?php echo $categories; ?>,
                     labels: {
                        rotation: -45,
                        align: 'right',
                        style: {
                            font: 'normal 13px Verdana, sans-serif'
                        }
                     }
                  },
                  yAxis: {
                     min: 0,
                     title: {
                        text: '<?php echo lang('number_of_times_predicted'); ?>'
                     }
                  },
                  legend: {
                     enabled: false
                  },
                  tooltip: {
                     formatter: function() {
                        return '<b>'+ this.x +'</b><br/>'+
                            '<?php echo lang('goals');?>';
                     }
                  },
                  series: [{
                     name: '<?php echo lang('goals');?>',
                     data: <?php echo $data;?>,        
                  }]
               });
            });
        </script>
        <ul>
            <li>Average goals per match is <?php echo $average_goals;?> after <?php echo $num_matches;?> matches.</li>
            <li>With this average, the total in 31 matches will be around <?php echo $total_with_average;?></li>
        </ul>
    <?php
    }
    else
    {
    ?>
    <div class='info'><?php echo lang('no_info_yet'); ?></div>
    <?php } ?>
