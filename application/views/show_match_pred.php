    <h2><?php echo $title; ?></h2>
    
    <div class='clear'></div>
    <table class='stripeMe'>
        <tr>
            <th><?php echo lang('username'); ?></th>
            <th><?php echo lang('prediction'); ?></th>
            <th><?php echo lang('points'); ?></th>
            <?php
            if($this->poolconfig_model->item('public_social_links') == 1)
            { ?>
            <th>Twitter</th>
            <th>Facebook</th>
            <?php } ?>

        </tr>
        <?php foreach($results as $result) { ?>
        <tr>
            <td><?php echo $result['username']; ?></td>
            <?php if($this->poolconfig_model->item('public_predictions') == 1 || prediction_closed($match_uid) || $result['match_calculated'])
            { ?>
                <td class='centertext'><?php echo $result['pred_home_goals']." - ".$result['pred_away_goals']; ?></td>
                <td class='centertext'><?php echo anchor('predictions/show/'.$result['id'].'/'.$result['match_group'], $result['pred_points_total']); ?></td>
            <?php
            } else {
            ?>
                <td class='centertext'><?php echo lang('secret'); ?></td>
                <td class='centertext'><?php echo lang('secret'); ?></td>
            <?php } ?>
            <?php
            if($this->poolconfig_model->item('public_social_links') == 1)
            { ?>
            <td>
            <?php
            if($result['twitter_id'] != "")
            {
                echo anchor('https://twitter.com/account/redirect_by_id?id='.$result['twitter_id'], 'Twitter profile');
            } ?>
            </td>
            <td><?php
            if($result['facebook_id'] != "")
            {
            echo anchor('http://facebook.com/profile.php?id='.$result['facebook_id'], 'Facebook profile', array('target' => '_blank', 'title' => 'Facebook'));
            }
            ?>
            </td>
            <?php } ?>
        </tr>
        <?php } ?>  
    </table>
