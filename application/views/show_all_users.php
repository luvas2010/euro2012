    <h2><?php echo $title; ?></h2>
    <table class='stripeMe'>
        <tr>
            <th>id</th>
			<th><?php echo lang('username'); ?></th>
			<th><?php echo lang('points'); ?></th>
			<?php 
            if ($this->config->item('public_social_links'))
            {
            ?>
            <th>Facebook</th>
			<th>Twitter</th>
            <?php
            }
            ?>
            <th>E-mail</th>
        </tr>
		
        <?php foreach($users as $user) { ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
			<td><?php echo $user['username']; ?></td>
			<td><?php echo $user['points_total']; ?></td>
            <?php 
            if ($this->config->item('public_social_links'))
            {
            ?>
			<td>
			<?php
			if (isset($users_social[$user['id']]['facebook_id']))
			{
				$facebook_id = $users_social[$user['id']]['facebook_id'];
				
				echo anchor('http://facebook.com/profile.php?id='.$facebook_id, 'Facebook profile', array('target' => '_blank', 'title' => 'Facebook'));
            }
			?>
			</td>
			<td>
			<?php
			if(isset($twitter_accounts[$user['id']]['screen_name']))
			{
				$screen_name = $twitter_accounts[$user['id']]['screen_name'];
				//echo $screen_name;
                echo anchor('http://twitter.com/'.$screen_name, $screen_name, array('target' => '_blank', 'title' => $screen_name));
                
            }
			?>			
			</td>
            <?php
            }
            ?>
            <td><?php echo safe_mailto($user['email'],$user['email']); ?> </td>
        </tr>
        <?php } ?>  
    </table>
