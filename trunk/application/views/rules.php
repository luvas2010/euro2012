<div class="container_12">

	<div id="home" class="grid_6 alpha">
        <h2><?php echo lang('nav_rules'); ?></h2>
		<?php echo sprintf(lang('welcometext'), anchor('predictions/editgroup/QF', lang('QF')),
												anchor('predictions/editgroup/SF', lang('SF')),
												anchor('predictions/editgroup/F', lang('F')),
												anchor('predictions/extra', lang('total_goals_pred')),
												anchor('predictions/extra', lang('champion_pred'))); ?>
	
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
	</div>
	<div id="rules" class="grid_6 omega">
        <?php echo sprintf(lang('points_awarded'), $this->poolconfig_model->item("pred_points_goals"),
                                                $this->poolconfig_model->item("pred_points_result"),
                                                $this->poolconfig_model->item("pred_points_qf_team"),
                                                $this->poolconfig_model->item("pred_points_sf_team"),
                                                $this->poolconfig_model->item("pred_points_f_team"),
                                                $this->poolconfig_model->item('pred_points_bonus'),
                                                $this->poolconfig_model->item('pred_points_bonus'),
                                                $this->poolconfig_model->item('pred_points_champion')); ?>
		<div class='errorstay'><?php echo lang('result_rules'); ?></div>
	</div>
    <div class='clear'></div>
</div>


