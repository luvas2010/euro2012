<div class="container_12">
    <div class="grid_12 alpha omega">
        <h2><?php echo $title; ?></h2>
        <?php 
        if (isset($users[0]))
        {
        ?>
        <table id="usermanagement" class="stripeMe">
            <tr>
                <th><?php echo lang('user_name'); ?></th>
                <th colspan="3"><?php echo lang('user_details'); ?></th>
                <th><?php echo lang('action'); ?></th>
            </tr>
            <?php foreach($users as $user) { ?>
            <tr>
                <td><?php echo "<span class='boldtext'>".$user['username']."</span><br />ID : ".$user['id'];?></td>
                <td class="smalltext"><?php echo lang('first_name').": ".$user['firstname']."<br />"; ?>
                    <?php echo lang('last_name').": ".$user['lastname']."<br />"; ?>
                    <?php echo lang('full_name').": ".$user['fullname']."<br />"; ?>
                </td>
                <td class="smalltext">    
                    <?php echo lang('email_address').": ".safe_mailto($user['email'])."<br />"; ?>
                    <?php echo lang('company').": ".$user['company']; ?>                    
                </td>
                <td class="smalltext">    
                    <?php echo lang('created_on').": ".$user['createdon']."<br />";?>
                    <?php echo lang('last_signed_in_on').": ".$user['lastsignedinon']."<br />";?>
                    <?php if (isset($user['verifiedon']))
                          {
                            echo lang('verified_on').": ".$user['verifiedon'];
                          }
                     ?>                     
                </td>            
                <td>
                    <?php if(!$user['is_admin'])
                            {
                                echo anchor('admin/users/delete/'.$user['id'], lang('delete_user'), 'class="button delete"')."<br />";
                                //echo "<br />".anchor('admin/users/make_admin/'.$user['id'], 'Make Admin', 'class="button flag"');
                             }
                           if (!isset($user['verifiedon']))
                                {    
                                    echo anchor('admin/users/verify_user/'.$user['id'], lang('verify_user'), 'class="button add"');
                                }
						   $play_for_money = $this->config->item('play_for_money');
						   if ($play_for_money == 1)
						   {
								if($user['payed'] == 0)
								{
									echo anchor('admin/users/user_payed/'.$user['id'], lang('mark_payed'), 'class="button add"');
								}
							}
                    ?>
                </td>

            </tr>
            <?php } ?>  
        </table>
        <?php
        }
        else
        {
        ?>
        <p><?php echo lang('no_users_found'); ?></p>
        <?php } ?>
    </div>    
</div>