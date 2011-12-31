<div id="main_menu">
    <div class="container_12">
        <div class="grid_12">
            <ul class='buttons'>
                <li<?php if ($current == 'account_settings') echo ' class="active"'; ?>><?php echo anchor('account/account_settings', lang('website_account'), "class='button'"); ?></li>
                <?php if ($account->password) : ?>
                <li<?php if ($current == 'account_password') echo ' class="active"'; ?>><?php echo anchor('account/account_password', lang('website_password'), "class='button'"); ?></li>
                <?php endif; ?>
                <li<?php if ($current == 'account_profile') echo ' class="active"'; ?>><?php echo anchor('account/account_profile', lang('website_profile'), "class='button'"); ?></li>
                <li<?php if ($current == 'account_linked') echo ' class="active"'; ?>><?php echo anchor('account/account_linked', lang('website_linked'), "class='button'"); ?></li>
            </ul>
        </div>
        <div class="clear"></div>
    </div>
</div>
