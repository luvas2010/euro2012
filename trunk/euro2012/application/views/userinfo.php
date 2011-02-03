<?php
// File: /system/application/views/userinfo.php
// Version: 1.01
// Author: Schop
// revisions:
// 1.01:
//      - Changed all references to column values to ArrayAccess
//      - Everything inside a table for now, until I get time to work on the layout of these damn forms

$this->lang->load('user', language());
?>
    <h3><?php echo lang('Edit_User_Info');?></h3>

    <?php echo form_open('user_info/submit'); ?>

        <?php echo validation_errors('<p class="error">','</p>'); ?>
    
        <?php echo form_hidden('id',$user['id']); ?>            
        <table>
            <thead>
                <tr>
                    <th colspan="2">User id: <?php echo $user['id'] ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><label for="username"><?php echo lang('User_name:');?></label></td>
                    <td><?php echo form_input('username',$user['username']); ?>
                </tr>
                <tr>
                    <td><label for="nickname"><?php echo lang('Nick_name:');?></label></td>
                    <td><?php echo form_input('nickname',$user['nickname']); ?></td>
                </tr>
                <tr>
                    <td><label for="password"><?php echo lang('Password:');?></label></td>
                    <td><?php echo form_password('password'); ?></td>
                </tr>
                <tr>
                    <td><label for="passconf"><?php echo lang('Confirm_Password:');?></label></td>
                    <td><?php echo form_password('passconf'); ?></td>
                </tr>
                <tr>
                    <td><label for="language"><?php echo lang('Language:');?></label></td>
                    <?php $languages = Array('english' => 'english', 'nederlands' =>  'nederlands'); ?>
                    <td><?php echo form_dropdown('language',$languages, $user['language']);?></td>
                <tr>
                    <td><label for="email"><?php echo lang('E-mail:');?></label></td>
                    <td><?php echo form_input('email',$user->email); ?></td>
                </tr>
                <tr>
                    <td><label for="street"><?php echo lang('Adress:');?></label></td>
                    <td><?php echo form_input('street',$user->street); ?></td>
                </tr>
                <tr>
                    <td><label for="zip"><?php echo lang('Zipcode:');?></label></td>
                    <td><?php echo form_input('zip',$user->zipcode); ?></td>
                <tr>
                    <td><label for="city"><?php echo lang('City:');?></label></td>
                    <td><?php echo form_input('city',$user->city); ?></td>
                </tr>
                <tr>
                    <td><label for="phone"><?php echo lang('Phone:');?></label></td>
                    <td><?php echo form_input('phone',$user->phone); ?></td>
                </tr>
            </tbody>
         </table>   

        <p class='buttons'>
            <?php echo form_submit('submit',lang('save')); ?>
            <?php echo anchor('/','<img src="'.base_url().'images/icons/cross.png" alt="" />'.lang('cancel'), 'class="negative"'); ?>
        </p>
    <?php echo form_close(); ?>
