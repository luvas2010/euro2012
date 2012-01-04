<div id="content">
    <div class="container_12">
        <div class="grid_12">
            <h2><?php echo anchor(current_url(), lang('profile_page_name')); ?></h2>
            <?php echo $this->load->view('account/account_menu', array('current' => 'account_profile')); ?>
        </div>
        <div class="clear"></div>
        <div class="grid_10">
            <?php echo form_open_multipart(uri_string()); ?>
            <?php echo form_fieldset(); ?>
            <?php if (isset($profile_info)) : ?>
            <div class="grid_10 alpha omega">
                <div class="form_info"><?php echo $profile_info; ?></div>
            </div>
            <div class="clear"></div>
            <?php endif; ?>
            <p><?php echo lang('profile_instructions'); ?></p>
            <div class="grid_4 alpha">
                <?php echo form_label(lang('profile_username'), 'profile_username'); ?>
            </div>
            <div class="grid_6 omega">
                <?php echo form_input(array(
                        'name' => 'profile_username',
                        'id' => 'profile_username',
                        'value' => set_value('profile_username') ? set_value('profile_username') : (isset($account->username) ? $account->username : ''),
                        'maxlength' => '24'
                    )); ?>
                <?php echo form_error('profile_username'); ?>
                <?php if (isset($profile_username_error)) : ?>
                <span class="field_error"><?php echo $profile_username_error; ?></span>
                <?php endif; ?>
            </div>
            <div class="clear"></div>
            <div class="grid_4 alpha">
                <?php echo form_label(lang('profile_picture'), 'profile_picture'); ?>
            </div>
            <div class="grid_6 omega">
                <p>
                    <?php if (isset($account_details->picture)) : ?>
                    <img src="<?php echo base_url(); ?>resource/user/profile/<?php echo $account_details->picture; ?>?t=<?php echo md5(time()); ?>" alt="" /><div class="clear"></div><?php echo anchor('account/account_profile/index/delete', lang('profile_delete_picture'), 'class="button delete"'); ?>
                    <?php else : ?>
                    <img src="<?php echo base_url(); ?>resource/img/default-picture.gif" alt="" />
                    <?php endif; ?>
                </p>
            <div class="clear"></div>
                <?php echo form_upload(array(
                    'name' => 'account_picture_upload',
                    'id' => 'account_picture_upload'
                )); ?>
                <p><small><?php echo lang('profile_picture_guidelines'); ?></small></p>
                <?php if (isset($profile_picture_error)) : ?>
                <span class="field_error"><?php echo $profile_picture_error; ?></span>
                <?php endif; ?>
            </div>
            <div class="clear"></div>
            <div class="prefix_4 grid_6 alpha omega">
                <?php echo form_button(array(
                        'type' => 'submit',
                        'class' => 'button save',
                        'content' => lang('profile_save')
                    )); ?>
            </div>
            <?php echo form_fieldset_close(); ?>
            <?php echo form_close(); ?>
        </div>
        <div class="clear"></div>
    </div>
</div>
