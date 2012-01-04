    <h2><?php echo lang('nav_champ_graph'); ?></h2>
    <div id="chart"></div>
    
    <?php
    //first make data string
    
    $data = "";
    if (is_array($percentage))
    {
    foreach ($percentage as $key => $value) {
        if ($data == "")
        {
            $data = "[['".get_team_name($key)."', ".$value."]";
        }
        else
        {
            $data .= ",['".get_team_name($key)."', ".$value."]";
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
         text: '<?php echo lang('nav_champ_graph');?>'
      },
        credits: {
            enabled: false
         },      
      tooltip: {
         formatter: function() {
            return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
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
                  return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
              }
            },
            showInLegend: false
         }
      },
       series: [{
         type: 'pie',
         name: 'Champions',
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
