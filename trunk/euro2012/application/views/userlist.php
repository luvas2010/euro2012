<h3>All users</h3>
<?php foreach ($users as $user): ?>
<div class="user">
    <ul>
        <li>Id: <span class='bold'><?php echo $user['id']; ?></span></li>
        <li>Username: <span class='bold'><?php echo $user['username']; ?></span></li>
        <li>Email: <span class='bold'><?php echo safe_mailto($user['email'],$user['email']); ?></span></li>
        <li>Nickname: <span class='bold'><?php echo $user['nickname']; ?></span></li>
        <?php if ($user['admin']): ?>
            <li><span class='green bold'>Administrator</span><li>
        <?php endif;?>
        <?php if ($user['active']): ?>
            <li><span class='green bold'>User is active</span><li>
        <?php else: ?>
            <li><span class='red bold'>User is not active</span><li>
        <?php endif;?>
        <?php if ($user['paid']): ?>
            <li><span class='green bold'>User has paid</span><li>
        <?php else: ?>
            <li><span class='red bold'>User has not paid yet</span><li>
        <?php endif;?>    
    </ul>
    <ul>
        <li>Address: <span class='bold'><?php echo $user['street']; ?></span></li>
        <li>Zipcode: <span class='bold'><?php echo $user['zipcode']; ?></span></li>
        <li>City: <span class='bold'><?php echo $user['city']; ?></span></li>
        <li>Phone: <span class='bold'><?php echo $user['phone']; ?></span></li>
    </ul>
    <ul>
        <li>Position: <span class='bold'><?php echo $user['position']?></span></li>
        <li>Points: <span class='bold'><?php echo $user['points']?></span></li>
    </ul>
    <ul>
        <li>Position: <span class='bold'><?php echo $user['created_at']?></span></li>
        <li>Last login: <span class='bold'><?php echo $user['lastlogin']?></span></li>
    </ul>

    <p class='buttons'>
        <?php echo anchor('/user_info/user_edit/'.$user['id'],'<img src="'.base_url().'images/icons/user_edit.png" alt="" />Edit User '.$user['nickname'], 'class="positive"'); ?>
        <?php echo anchor('/user_info/delete_user/'.$user['id'],'<img src="'.base_url().'images/icons/user_delete.png" alt="" />Delete User '.$user['nickname'], 'class="negative"'); ?></p>
</div>
<?php endforeach; ?>
