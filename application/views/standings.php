<!-- <?php print_r($points); ?> -->
    <h2><?php echo lang('standings'); ?></h2>
    <?php if ($account->payed == 0 && $this->config->item('play_for_money') == 1)
          {?>
        <div class='error'><?php echo lang('why_am_i_not_here_payed');?></div>
    <?php } ?>
    <?php if ($num > 0) { ?>
    <div class='buttons'><a href='#me' class='button'><?php echo lang('find_yourself'); ?></a><?php echo anchor('charts/top/10',lang('see_top_ten'), 'class="button"'); ?></div>
    <div class='clear'></div>
    <table class="stripeMe">
        <tr>
            <th><?php echo lang('position'); ?></th>
            <th><?php echo lang('username'); ?></th>
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
            <td><?php echo $point['total_points']; ?></td>
            
            <?php foreach($point['matches'] as $key =>$value)
            {
            ?>
            <td class='centertext'><?php echo anchor('standings/show/'.$point['account_id'].'/'.$key, $value) ;?></td>
            <?php } ?>

        </tr>
        <?php
        $oldpoints = $point['total_points'];
        $i++;
        } ?>  
    </table>
    <?php } else { ?>
    <div class='error'><?php echo lang('no_results_yet'); ?></div>
    <?php } ?>

