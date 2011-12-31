    <h2><?php echo $title; ?></h2>
    <div id="chart"></div>
    
    <?php
    if (is_array($topusers))
    {
        //first make categories string
        $titlestring = "'Top ".$num."'";
        $categories = "['0'";
        foreach ($topusers[0]['match'] as $key => $value) {
            if ($categories == "")
            {
                $categories = "['".lang('match')." ".$key."'";
            }
            else
            {
                $categories .= ",'".lang('match')." ".$key."'";
            }
        }
        $categories .=  "]";
        
        //make series string
        $series=  "";
        foreach ($topusers as $topuser)
        {
            if ($series=="")
            {
                $series = "[{ name: '".$topuser['username']."', data: [0,".join(",",$topuser['aggregate'])."]}";
            }
            else
            {
                $series .= ", { name: '".$topuser['username']."', data: [0,".join(",",$topuser['aggregate'])."]}";
            }
        }
        $series .= "]";
        ?>
        <script>
            var chart1; // globally available
            $(document).ready(function() {
                  chart1 = new Highcharts.Chart({
                     chart: {
                        renderTo: 'chart',
                        type: 'spline'
                     },
                    plotOptions: {
                        series: {
                            animation: {
                                duration: 3000
                            }
                        }
                    },
                     title: {
                        text: <?php echo $titlestring; ?>
                     },
                    credits: {
                        enabled: false
                     },
                     xAxis: {
                        startOnTick: true,
                        labels: {
                            rotation: 270
                        },
                        categories: <?php echo $categories; ?>
                     },
                     yAxis: {
                        min: 0,
                        allowDecimals: false, 
                        title: {
                           text: <?php echo "'".lang('points')."'"; ?>
                        }
                     },
                     series: <?php echo $series; ?>
                  });
               });
        </script>
        <table class="stripeMe">
            <tr>
                <th><?php echo lang('username'); ?></th>
                <?php foreach ($topusers[0]['match'] as $key => $value) { ?>
                <th><?php echo $key; ?></th>
                <?php } ?>
                <th><?php echo lang('total_points');?> </th>
            </tr>
            <?php
            $i = 1;
            foreach($topusers as $topuser) { ?>
            <tr>
                <?php $totalp = 0; ?>
                <td><?php echo $topuser['username']; ?></td>
                <?php foreach ($topuser['match'] as $key => $match) {
                    $group = $topuser['group'][$key];
                    ?>
                <td><?php echo anchor('standings/show/'.$topuser['userid'].'/'.$group,$match); $totalp = $totalp + $match; ?></td>
                <?php } ?>
                <td class='centertext'><?php echo $totalp; ?></td>
            </tr>
            <?php

            $i++;
            } ?>  
        </table>
    <?php
    }
    else
    {
    ?>
    <div class='info'><?php echo lang('no_info_yet'); ?></div>
    <?php } ?>
    


