
<?php
    $mysql_query = "SELECT DISTINCT `company` FROM `account_details` ORDER BY `company`";
    $query = $this->db->query($mysql_query);
    $companies = $query->result_array();
    ?>
    <h2><?php echo $title; ?></h2>

        


    <div id="chart"></div>

    <?php
    if (is_array($topusers))
    {
          
    $filter_list[0] = "Show All";
    foreach($companies as $company)
    {
        if ($company['company'] != "")
        {
            $filter_list[$company['company']] = $company['company'];
        }
    }
    $options = $filter_list;
        echo form_open("charts/top");
        echo "<div class='grid_12 alpha omega'><h2>";
        if ($filter != "0") { echo $filter; } else { echo "Filter:"; }
        echo "</h2></div>";
        echo "<div class='clear'></div>";
        echo "<div class='grid_4 aplha'>".form_dropdown('company', $options, $account_details->company)."</div>";
        
        ?>
        <div class='grid_8 omega'><input type='submit' value='Filter' class='button save' /></div>
        <?php echo form_close(); ?>
        <div class="clear"></div>
        <?php
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
            if ($filter == $topuser['company'] || $filter == "0")
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
                <th><?php echo lang('sign_up_company'); ?>
                <?php foreach ($topusers[0]['match'] as $key => $value) { ?>
                <th><?php echo $key; ?></th>
                <?php } ?>
                <th><?php echo lang('total_points');?> </th>
            </tr>
            <?php
            $i = 1;
            foreach($topusers as $topuser) {
            if ($filter == $topuser['company'] || $filter == "0")
                { ?>
            <tr>
                <?php $totalp = 0; ?>
                <td><?php echo $topuser['username']; ?></td>
                <td><?php echo $topuser['company']; ?></td>
                <?php foreach ($topuser['match'] as $key => $match) {
                    $group = $topuser['group'][$key];
                    ?>
                <td><?php echo anchor('predictions/show/'.$topuser['userid'].'/'.$group,$match); $totalp = $totalp + $match; ?></td>
                <?php } ?>
                <td class='centertext'><?php echo $totalp; ?></td>
            </tr>
            <?php

            $i++;
                }
            } ?>  
        </table>
    <?php
    }
    else
    {
    ?>
    <div class='info'><?php echo lang('no_info_yet'); ?></div>
    <?php } ?>
    


