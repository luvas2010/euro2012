<h3>Alle gebruikers</h3>
<?php echo form_open('user_info/submit_all'); ?>
    <p class='buttons'>
	    <?php echo form_submit('submit','Wijzigingen opslaan'); ?>
	    <?php echo anchor('/user_info/list_all','<img src="'.base_url().'images/icons/cross.png" alt="" />Annuleren', 'class="negative"'); ?>
    </p><hr />
<?php foreach ($users as $user): ?>
<?php $id = $user['id']; ?>
<div class="user">
    <ul>
        <li>Id: <span class='bold'><?php echo $user['id']; ?></span></li>
        <li><label for="username">Gebruiker: </label><?php echo form_input("post_array[".$id."][username]",$user['username']);?></li>
        <li><label for="email">Email: </label><?php echo form_input("post_array[".$id."][email]",$user['email']);?></li>
        <li><label for="nickname">Nickname: </label><?php echo form_input("post_array[".$id."][nickname]",$user['nickname']);?></li>
        <li><label for="admin">Administrator: </label><?php echo form_checkbox("post_array[".$id."][admin]", 1, $user['admin']);?></li>
        <li><label for="active">Aktief: </label><?php echo form_checkbox("post_array[".$id."][active]", 1, $user['active']);?></li>
        <li><label for="paid">Betaald: </label><?php echo form_checkbox("post_array[".$id."][paid]", 1, $user['paid']);?></li>  
    </ul>
    <ul>
        <li>&nbsp;</li>
        <li><label for="street">Adres: </label><?php echo form_input("post_array[".$id."][street]",$user['street']);?></li>
        <li><label for="zipcode">Postcode: </label><?php echo form_input("post_array[".$id."][zipcode]",$user['zipcode']);?></li>
        <li><label for="city">Woonplaats: </label><?php echo form_input("post_array[".$id."][city]",$user['city']);?></li>
        <li><label for="phone">Telefoon: </label><?php echo form_input("post_array[".$id."][phone]",$user['phone']);?></li>
    </ul>
    <ul>
        <li>&nbsp;</li>
        <li>Ranglijst: <span class='bold'><?php echo $user['position']?></span></li>
        <li>Punten: <span class='bold'><?php echo $user['points']?></span></li>
        <li>Aangemaakt op: <span class='bold'><?php echo $user['created_at']?></span></li>
        <li>Laatste login: <span class='bold'><?php echo $user['lastlogin']?></span></li>
    </ul>

    <p class='buttons'>
        <?php $random = random_string('alnum', 8); ?>
        <?php echo anchor('/user_info/resetpw/'.$user['id'], '<img src="'.base_url().'images/icons/key.png" alt="" />Wachtwoord reset', 'class="negative"'); ?>
        <?php echo anchor('/user_info/delete_user/'.$user['id'],'<img src="'.base_url().'images/icons/user_delete.png" alt="" />Delete User '.$user['nickname'], 'class="negative"'); ?></p>
</div>
<?php endforeach; ?>
<?php echo form_close(); ?>
