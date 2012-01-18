<div id="content">
    <div class="container_12">
        <div class="grid_12">
            <h2><?php echo anchor(current_url(), lang('password_page_name')); ?></h2>
            <?php echo $this->load->view('account/account_menu', array('current' => 'account_password')); ?>
        </div>
        <div class="clear"></div>
        <div class="grid_10">
            <?php $attributes = array('id' => 'validateMe'); ?>
            <?php echo form_open(uri_string(), $attributes); ?>
            <?php echo form_fieldset(); ?>
            <?php if ($this->session->flashdata('password_info')) : ?>
            <div class="grid_10 alpha omega">
                <div class="form_info"><?php echo $this->session->flashdata('password_info'); ?></div>
            </div>
            <div class="clear"></div>
            <?php endif; ?>
            <?php echo lang('password_safe_guard_your_account'); ?>
            <div class="grid_4 alpha">
                <?php echo form_label(lang('password_new_password'), 'password_new_password'); ?>
            </div>
            <div class="grid_6 omega">
                <?php echo form_password(array(
                        'name' => 'password_new_password',
                        'id' => 'password_new_password',
                        'value' => set_value('password_new_password'),
                        'autocomplete' => 'off',
                        'class' => 'text required',
                        'minlength' => '6'
                    )); ?>
                <?php echo form_error('password_new_password'); ?>
            </div>
            <div class="clear"></div>
            <div class="grid_4 alpha">
                <?php echo form_label(lang('password_retype_new_password'), 'password_retype_new_password'); ?>
            </div>
            <div class="grid_6 omega">
                <?php echo form_password(array(
                        'name' => 'password_retype_new_password',
                        'id' => 'password_retype_new_password',
                        'value' => set_value('password_retype_new_password'),
                        'autocomplete' => 'off',
                        'class' => 'text required',
                        'minlength' => '6',
                        'equalTo' => '#password_new_password'
                    )); ?>
                <?php echo form_error('password_retype_new_password'); ?>
            </div>
            <div class="clear"></div>
            <div class="prefix_4 grid_6 alpha omega">
                <?php echo form_button(array(
                        'type' => 'submit',
                        'class' => 'button save',
                        'content' => lang('password_change_my_password')
                    )); ?>
            </div>
            <?php echo form_fieldset_close(); ?>
            <?php echo form_close(); ?>
        </div>
        <div class="clear"></div>
    </div>
</div>
