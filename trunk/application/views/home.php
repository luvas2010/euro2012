<div class="container_12">
    <div id="column1" class="grid_3 alpha">
        <?php if ($this->authentication->is_signed_in()) { ?>
            <h3><?php echo sprintf(lang('website_welcome_username'), '<strong>'.$account_details->firstname.'</strong>'); ?></h3>
            <p><?php echo sprintf(lang('user_points'), get_user_points($account->id)); ?></p><p><?php echo anchor('standings#me',lang('check_user_pos')); ?></p>
			<?php if ($account->payed == 0 && $this->config->item('play_for_money') == 1)
			  {?>
			<div class='error'><?php echo lang('not_payed_yet');?></div>
				<?php } ?>
			<?php
            if (!get_total_goals($account->id)) {
            ?>
            <div class='error'><?php echo lang('total_goals_missing'); ?><br/>
			<?php echo anchor('predictions/extra',lang('nav_extra')); ?> 
			</div>
            <?php } ?>
			<?php echo get_missing_teams_list(array(
							'heading'   => "<div class='error'><p>%heading%</p>",
							'pre'       => "<ul class='matchlist'>",
							'post'      => "</ul></div>",
							'listitem'  => "<li>%matchlink%</li>")
							); ?>
                            
        <?php if($this->config->item('play_for_money'))
              { ?>
        <div class="infostay">
            
            <?php
                $sql_query = "SELECT *
                              FROM `account`
                              WHERE `verifiedon` is NOT NULL";
                              
                $query = $this->db->query($sql_query);
                $num = $query->num_rows();
                $payment_per_user = $this->config->item('payment_per_user');
                $curr = $this->config->item('currency');
                $total_money = $num * $payment_per_user;
                $payout_sched = explode(",",$this->config->item('payout_schedule'));
                $total_payed_out = array_sum($payout_sched);
                echo "<p>".sprintf(lang('total_money'), $num, $curr.$payment_per_user, $curr.$total_money)."</p>";
                if ($total_payed_out<100)
                {
                    echo "<p>".sprintf(lang('money_payed_out'), $total_payed_out, $curr.(($total_payed_out/100)*$total_money))."</p>";
                }
                $num = count($payout_sched);
                echo "<p>".lang('money_distribution').":<br/>";
                $i = 1;
                foreach ($payout_sched as $pay)
                {
                    if($i==1)
                    {
                        echo lang('winner').": ".$curr.number_format(($pay/100)*($total_payed_out/100)*$total_money,2,'.','')."<br/>";
                    }
                    else
                    {
                        echo lang('number')." ".$i.": ".$curr.number_format(($pay/100)*($total_payed_out/100)*$total_money,2,'.','')."<br/>";
                    }
                    $i++;
                }    
                    
            ?>
        </div>
        <?php } ?>
    </div> <!-- end column1 -->
    <div id="" class='grid_3'>
    		<h3><?php echo lang('next_matches'); ?></h3>
            <?php
            // get_next_matches( number_of_matches, format = "<li>%matchtime%: %home% - %away% (%prediction%)</li>"
            echo get_next_matches(2,"<span class='centertext'><h4>%group%</h4><h4>%matchtime%</h4></span><p class='centertext'><span class='boldtext'>%home% - %away%</span><br/>(%prediction%)</p>%chart%");
            ?>
    </div>
     <div id="column2" class="grid_6 omega">
		<div class="grid_3 alpha">
			<h3><?php echo lang('top_10');?></h3>
			<?php $this->load->library('pool');
				  $topusers = $this->pool->get_top_ranking(10);
                  echo "<ul>";
				  foreach ($topusers as $user)
				  {
						echo "<li><span class='boldtext'>".$user['username'].": </span>".$user['points_total']." ".lang('points')."</li>";
				  }
				  echo "</ul><br/>".anchor('charts/top/10',lang('see_top_ten'), 'class="button"');;
			?>
			
		</div>
		<div class="grid_3 omega">
            <h3><?php echo lang('nav_champ_graph');?></h3>
            
                <?php $sql_query = "SELECT `pred_champion`, COUNT(`account_id`) as `number`
                      FROM `account_details`
                      WHERE `pred_champion` <> ''
                      AND   `pred_champion` <> 'NULL'
                      GROUP BY `pred_champion`";
                        $query = $this->db->query($sql_query);
                        $champions = $query->result_array();
                        $total = 0;
                        $num = $query->num_rows();
                        if ($num > 0)
                        {       
                             foreach ($champions as $champion)
                            {
                                $total = $total + $champion['number'];
                            }
                            reset($champions);
                            foreach ($champions as $champion)
                            {
                                $chartdata[get_team_name($champion['pred_champion'])] = $champion['number']/$total * 100;
                            }    
                            
                            echo "<div id='champchart'></div>";
                            $categories = "";
                            $data = "";
                            foreach ($chartdata as $key => $value) {
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
							if ($num == 1) { $num++; }
                            $champchart = "<script>
                                    var chart;
                                    $(document).ready(function() {
                                       chart = new Highcharts.Chart({
                                          chart: {
                                             renderTo: 'champchart',
                                             defaultSeriesType: 'bar',
                                             height: ".$num*40 ."
                                          },
                                          colors: ['#FF0000', '#EE7F01', '#EE2E2F', '#185AA9', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
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
                                             labels: {
                                                formatter: function() {
                                                    return this.value +'%';
                                                }
                                             },
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
                                                pointWidth: 10,
                                                colorByPoint: true
                                                }
                                          },                                        
                                          legend: {
                                             enabled: false
                                          },
                                          tooltip: {
                                             formatter: function() {
                                                return '<b>'+ this.x +'</b><br/>'+
                                                    this.y + '%';
                                             }
                                          },
                                          series: [{
                                             name: '',
                                             data: $data,        
                                          }]
                                       });
                                    });
                                </script>";
                                echo $champchart;
                        }
                           
                ?>
		</div>
        <div class="clear"></div>
		<div class="grid_3 alpha">

        </div>        
            <?php echo get_missing_result_list(array(
                                        'heading'   => "<h4 class='to_do'>%heading%</h4>",
                                        'pre'       => "<ul class='matchlist'>",
                                        'post'      => "</ul>",
                                        'listitem'  => "<li>%matchlink%</li>")
                                        ); ?>
        <?php } ?>
    </div><!-- end column2 -->
	<div class="clear"></div>
</div>


