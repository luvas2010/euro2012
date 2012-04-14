<?php
    $mysql_query = "SELECT DISTINCT `company` FROM `account_details` ORDER BY `company`";
    $query = $this->db->query($mysql_query);
    $companies = $query->result_array();
    ?>
    
    <h2><?php echo lang('standings'); ?></h2>
    <?php if ($account->payed == 0 && $this->poolconfig_model->item('play_for_money') == 1)
          {?>
        <div class='error'><?php echo lang('why_am_i_not_here_payed');?></div>
    <?php } ?>
    <?php if ($num > 0) { ?>
    <div class='buttons'><a href='#me' class='button'><?php echo lang('find_yourself'); ?></a><?php echo anchor('charts/top/10',lang('see_top_ten'), 'class="button"'); ?></div>
    <div class='clear'></div>
    <hr/>
    <?php
    $filter_list[0] = "Show All";
    foreach($companies as $company)
    {
        if ($company['company'] != "")
        {
            $filter_list[$company['company']] = $company['company'];
        }
    }
    $options = $filter_list;
        echo form_open("standings");
        echo "<div class='grid_12 alpha omega'><h2>";
        if ($filter != "0") { echo $filter; } else { echo "Filter:"; }
        echo "</h2></div>";
        echo "<div class='clear'></div>";
        echo "<div class='grid_4 aplha'>".form_dropdown('company', $options, $account_details->company)."</div>";
        
        ?>
        

        <div class='grid_8 omega'><input type='submit' value='Filter' class='button save' /></div>
        <?php echo form_close(); ?>
        <div class="clear"></div>
       
    <table class="stripeMe">
        <tr>
            <th><?php echo lang('position'); ?></th>
            <th><?php echo lang('username'); ?></th>
            <th><?php echo lang('sign_up_company'); ?></th>
            <th><?php echo lang('points'); ?></th>
            <?php
                foreach($points[0]['matches'] as $key => $value)
                {
                    echo "<th>".lang($key)."</th>";
                }
            ?>
        </tr>
        <?php
        $oldpoints = 0;
        $realpos = 0;
        $i = 1;
        foreach($points as $point) {
        if ($filter == $point['company'] || $filter == "0")
        {
        
            if ($oldpoints != $point['total_points'])
            {
                $realpos = $i;
            }
        ?>
        <tr>
            <td><?php echo $realpos;?></td>
            <td><?php if($account->username != $point['username'])
                      {
                          echo $point['username'];
                       }
                       else
                       {
                           echo "<a name='me'><a/><span class='boldtext'>".$point['username']."</span>";
                       }
                 ?></td>
            <td><?php echo $point['company']; ?></td>     
            <td><?php echo $point['total_points']; ?></td>
            
            <?php foreach($point['matches'] as $key =>$value)
            {
            ?>
            <td class='centertext'><?php echo anchor('predictions/show/'.$point['account_id'].'/'.$key, $value) ;?></td>
            <?php } ?>

        </tr>
        <?php
        $oldpoints = $point['total_points'];
        $i++;
        }
        } ?>  
    </table>
    <?php } else { ?>
    <div class='error'><?php echo lang('no_results_yet'); ?></div>
    <?php } ?>

