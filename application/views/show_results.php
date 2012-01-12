<div class='container_12'>
    <h3 class='centertext'><?php echo $title; ?></h3>
    <div class='grid_10 alpha omega prefix_1 suffix_1'>
        <div class='grid_3 alpha centertext'>
            <p class='bigtext'><?php echo lang($results[0]['home_team']); ?></p>
            <?php echo get_home_shirt($results[0]['home_team'], TRUE); ?>
            
        </div>
        <div class='grid_1 superbigtext centertext'>
            <?php echo $results[0]['home_goals']; ?>
        </div> 
        <div class='grid_2 superbigtext centertext'>
            -
        </div> 
        <div class='grid_1 superbigtext centertext'>
            <?php echo $results[0]['away_goals']; ?>
        </div>
        <div class='grid_3 omega centertext'>
            <p class='bigtext'><?php echo lang($results[0]['away_team']); ?></p>
            <?php echo get_away_shirt($results[0]['away_team'], TRUE); ?>
        </div>
    </div>    
    <h3><a href='#me'><?php echo lang('find_yourself'); ?></a></h3>
    <div class='clear'></div>
    
    <?php if($results[0]['match_calculated'] == 1)
    {
    ?>
    <p>
        <a href="https://twitter.com/share" class="twitter-share-button" 
           data-url='<?php echo $share_url;?>' 
           data-text= '<?php echo $share_text_twitter;?>' 
           data-hashtags='<?php echo $this->config->item("pool_name");?>' 
           data-lang="en" 
           data-count="horizontal">Tweet
        </a>

        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    </p>
    <table class="stripeMe">
        
        <tr>
            <th><?php echo lang('position'); ?></th>
            <th><?php echo lang('username'); ?></th>
            <th><?php echo lang('prediction'); ?></th>
            <th><?php echo lang('points'); ?></th>
            <th><?php echo lang('total_points'); ?></th>
        </tr>
        <?php
        $oldpoints = 0;
        $realpos = 0;
        $i = 1;  
        foreach($results as $result) {
            if ($oldpoints != $result['total_points'])
            {
                $realpos = $i;
            }
        ?>
        <tr>
            <td><?php echo $realpos;?></td>
            <td><?php if($account->username != $result['username'])
            {
              echo $result['username'];
            }
            else
            {
               $text = sprintf(lang('share_my_score_twitter'), $realpos, $result['total_points'], get_match($match_uid));
               echo "<a name='me'><a/><span class='boldtext'>".$result['username']."</span><br />
               <a href='https://twitter.com/share' class='twitter-share-button' 
           data-url='$share_url' 
           data-text= '$text' 
           data-hashtags='' 
           data-lang='en' 
           data-count='horizontal'>Tweet
        </a>";
            }
            ?></td>
            <td>
                <?php if($match_uid >= 25)
                      {
                          echo $result['pred_home_team']." - ".$result['pred_away_team']."<br/>";
                      }
                      ?>
                <?php echo $result['pred_home_goals']." - ".$result['pred_away_goals']; ?></td>
            <td class='smalltext'>
                <?php echo lang('home_goals').": ".$result['pred_points_home_goals']; ?><br/>
                <?php echo lang('away_goals').": ".$result['pred_points_away_goals']; ?><br/>
                <?php echo lang('match_result').": ".$result['pred_points_result']; ?>
                
                <?php
                if ($result['match_uid'] >= 25)
                {
                    echo "<br />";
                    echo lang('team_home').": ".$result['pred_points_home_team']."<br />";
                    echo lang('team_away').": ".$result['pred_points_away_team'];
                }
                ?>
                <?php if ($match_uid == 31) { echo "<br />".lang('bonus').": ".$result['pred_points_bonus'];} ?>
            </td>
            <td class='bigtext'>
                <?php echo $result['pred_points_home_goals']
                           + $result['pred_points_away_goals']
                           + $result['pred_points_result']
                           + $result['pred_points_bonus']
                           + $result['pred_points_home_team']
                           + $result['pred_points_away_team']
                           ; ?>
            </td>

        </tr>
        <?php
        $oldpoints = $result['total_points'];
        $i++;
        } ?>  
    </table>
    <?php
    }
    else
    { ?>
    <div class='error'><?php echo lang('match_not_calculated'); ?></div>
    <?php } ?>
<?php
    //$this->load->config('twitter');
    //$this->load->helper('twitter');  
    //$consumer_key = $this->config->item('twitter_consumer_key');
    //$consumer_secret = $this->config->item('twitter_consumer_secret');
    //$account_id = $account->id;
    //$sql_query = "SELECT * FROM `account_twitter`
                  //WHERE `account_id` = '$account_id'";
    //$query = $this->db->query($sql_query);
    //$row = $query->row_array();
    //$token = $row['oauth_token'];
    //$secret = $row['oauth_token_secret'];
    //$twitterObj = new EpiTwitter($consumer_key, $consumer_secret, $token, $secret);
    //$status = $twitterObj->post('/statuses/update.json', array('status' => 'This a simple test from twitter-async at ' . date('m-d-Y h:i:s')));
    ?>
</div>
