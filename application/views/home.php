<div class="container_12">
    <div id="column1" class="grid_3 alpha">
        <?php if ($this->authentication->is_signed_in()) { ?>
            <h3><?php echo sprintf(lang('website_welcome_username'), '<strong>'.$account_details->firstname.'</strong>'); ?></h3>
            <p><?php echo sprintf(lang('user_points'), get_user_points($account->id)); ?></p><p><?php echo anchor('standings#me',lang('check_user_pos')); ?></p>
        <?php if($this->poolconfig_model->item('play_for_money'))
              { ?>
        <div class="infostay">
            
            <?php
                $sql_query = "SELECT *
                              FROM `account`
                              WHERE `verifiedon` is NOT NULL";
                              
                $query = $this->db->query($sql_query);
                $num = $query->num_rows();
                $payment_per_user = $this->poolconfig_model->item('payment_per_user');
                $curr = $this->poolconfig_model->item('currency');
                $total_money = $num * $payment_per_user;
                $payout_sched = explode(",",$this->poolconfig_model->item('payout_schedule'));
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
		<?php
		if($this->poolconfig_model->item('enable_shoutbox') == 1)
		{
		?>
        <div id="shoutbox">
            <h3><?php echo anchor('shoutbox/showall',lang('user_messages'),"title='".lang('show_all_shouts')."'");?></h3>
            <input type="text" id="shout" name="shout" maxlength="255" value="<?php echo lang('type_message_here');?>" class='text' />
            <input type="submit" id="shout_submit" value="<?php echo lang('post_message'); ?>" class="button user_comment" />
			
            <div id="shoutlist">
            </div>
			
			<script type='text/javascript'>
                $(document).ready(function (){
                    $("#shout").val('<?php echo lang('type_message_here'); ?>');
                    $("#shout").focus(function(){
                        // Check for the change
                        if(this.value == this.defaultValue){
                            $('#shout').val('');
                        }
                    });		

                    $('#shout_submit').click(function() {
                        var shouttxt = $('#shout').val();
                        $.post("<?php echo site_url('shoutbox/addshout'); ?>", { 'shouttxt' : shouttxt },
                                function(data) {
                                    $('#shoutlist').empty().append(data);
                                    $('#shout').val('');
                                     }
                            );
                    });
                    
                  <?php if ($this->authentication->is_signed_in())
                          {
                        if($account_details->pool_style==null) { ?>
    
                        $.ajax({
                            url: "<?php echo site_url('shoutbox/getshouts/5'); ?>",
                            success: function(data) { $('#shoutlist').empty().append(data);
                                                    }
                            });
                        <?php } else { ?>
                        $.ajax({
                            url: "<?php echo site_url('shoutbox/getshouts/5'); ?>",
                            success: function(data) { $('#shoutlist').empty().append(data);
                                                  if( $(window).height() > $('body').height() )   //after load shoubox re-initiate footer properties 
                                                     {$('#footer').css("position","fixed");  
                                                      $('#footer').css("bottom","0");
                                                      $('#footer').css("width","100%");}
                                                  else
                                                     {$('#footer').css("position","relative")
                                                      $('#footer').css("width","");
                                                     }
                                                    }
                            });
                        <?php } ?>
                        <?php } ?>
                    });
			</script>
        </div> <!-- end shoutbox -->
		<?php } ?>
    </div> <!-- end column1 -->
    <div class='grid_4'>
            <?php if(!tournament_done())
			{ ?>
			<h3><?php echo lang('next_matches'); ?></h3>
            <?php
            // get_next_matches( number_of_matches, format = "<li>%matchtime%: %home% - %away% (%prediction%)</li>"
            echo get_next_matches(2,"<p class='centertext boldtext'>%group%<br/>%matchtime%</p><p class='grid_2 alpha centertext boldtext'>%homeshirt%<br/>%home%</p><p class='grid_2 omega centertext boldtext'>%awayshirt%<br/>%away%</p><p class='grid_4 alpha omega centertext'>( %prediction% )</p><p class=' grid_4 alpha omega centertext'>%chart%</p>");
            ?>
			<?php 
			}
			else
			{
			?>
			Match 31 has been calculated. Game over.
			<?php } ?>
    </div>
     <div id="column2" class="grid_5 omega">
              <div class="grid_5 alpha omega">
            <script type="text/javascript"><!--
google_ad_client = "ca-pub-2098404720901613";
/* pool */
google_ad_slot = "7735837555";
google_ad_width = 336;
google_ad_height = 280;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></div>
		<div class="grid_5 alpha omega">

		    <h3><?php echo lang('played_matches'); ?></h3>
            <?php if($played = get_last_matches(2,"<p class='grid_3 alpha'>%home% - %away%</p><p class='grid_1 centertext'>%result%</p><p class='grid_1 centertext omega'>%total_points%</p><div class='clear'></div>"))
            { ?>
			<p class='grid_3 alpha'><?php echo lang('match'); ?></p><p class='grid_1 centertext'><?php echo lang('result'); ?></p><p class='grid_1 centertext omega'><?php echo ucfirst(lang('points')); ?></p>
            <?php
            // get_next_matches( number_of_matches, format = "<li>%matchtime%: %home% - %away% (%prediction%)</li>"
            echo $played;
            } else {
            echo "<div class='infostay'>".lang('no_info_yet')."</div>";
            } ?>
<h3><?php echo lang('top_10');?></h3>
         <?php $this->load->library('pool');
              $topusers = $this->pool->get_top_ranking(10);
              if (is_array($topusers))
              {
               echo "<table style='border:none;'>";
               echo "<tr><th>#</th><th>Gebruiker</th><th>punten</th></tr>";
               echo '<!--'. var_export($topusers, true) . '-->';
               foreach ($topusers as $i => $user)
                 {
                     echo "<tr style='border: none;'><td>".($i+1)."&nbsp;(".$user['lastranking'].")</td><td><span class='boldtext'>".$user['username']; if (!empty($user['company'])) echo ' ('.$user['company'].')';
                     echo "</span></td><td>".$user['points_total']."</td></tr>";
                 }
               echo "</table>";  
                 echo "</ul><br/>".anchor('charts/top/10',lang('see_top_ten'), 'class="button chart-line"');;
              }
              else
              {
               echo "<div class='infostay'>".lang('no_info_yet')."</div>";
              }
         ?>
			
		</div>
        <br/>
		<div class="grid_5 alpha omega">
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
                                $chartdata[get_team_name($champion['pred_champion']."_utf")] = number_format($champion['number']/$total * 100, 1);
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
                            $champchart = "<script type='text/javascript'>
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
                                                return this.x + ': ' +
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
						else
						{
							echo "<div class='infostay'>".lang('no_info_yet')."</div>";
						}
                           
                ?>
		</div>
        <div class="clear"></div>       
        <?php }
		else
		{
			redirect('account/sign_in/?continue='.site_url(''));
		}?>
    </div><!-- end column2 -->
	<div class="clear"></div>
</div>

