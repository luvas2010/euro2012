<div id="main_menu">
    <div class="container_12">
        <div class="grid_12">
            <ul class='buttons'>
                <li<?php if ($current == 'account_settings') echo ' class="active"'; ?>><?php echo anchor('account/account_settings', lang('website_account'), "class='button user'"); ?></li>
                <?php if ($account->password) : ?>
                <li<?php if ($current == 'account_password') echo ' class="active"'; ?>><?php echo anchor('account/account_password', lang('website_password'), "class='button lock_edit'"); ?></li>
                <?php endif; ?>
                <li<?php if ($current == 'account_profile') echo ' class="active"'; ?>><?php echo anchor('account/account_profile', lang('website_profile'), "class='button vcard'"); ?></li>
            	<?php if ($this->poolconfig_model->item('third_party_auth_providers') != "")
				{ ?>
				<li<?php if ($current == 'account_linked') echo ' class="active"'; ?>><?php echo anchor('account/account_linked', lang('website_linked'), "class='button link'"); ?></li>
                <?php  } ?>
				<li<?php if ($current == 'delete_account') echo ' class="active"'; ?>><?php echo anchor('admin/users/delete/'.$account->id, lang('delete_account'), "class='button user_delete'"); ?></li>
            </ul>
        </div>
        <div class="clear"></div>
    </div>
</div>
