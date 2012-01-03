        <ul class="sf-menu">
            <li><?php echo anchor('/',lang('navhome')); ?></li>
            <!--
            <li><a href="#"><?php echo lang('groups'); ?></a>
                <ul>
                    <li><?php echo anchor('group/show/A',lang('group').' A'); ?></li>
                    <li><?php echo anchor('group/show/B',lang('group').' B'); ?></li>
                    <li><?php echo anchor('group/show/C',lang('group').' C'); ?></li>
                    <li><?php echo anchor('group/show/D',lang('group').' D'); ?></li>
                </ul>
            </li>
            -->
            <li><?php echo anchor('matches',lang('nav_matches')); ?></li>
            <li><a href="#"><?php echo lang('predictions'); ?></a>
                <ul>
                    <li><?php echo anchor('predictions/editgroup/A',lang('group').' A'); ?></li>
                    <li><?php echo anchor('predictions/editgroup/B',lang('group').' B'); ?></li>
                    <li><?php echo anchor('predictions/editgroup/C',lang('group').' C'); ?></li>
                    <li><?php echo anchor('predictions/editgroup/D',lang('group').' D'); ?></li>
                    <li><?php echo anchor('predictions/editgroup/QF',lang('quarter_final')); ?></li>
                    <li><?php echo anchor('predictions/editgroup/SF',lang('semi_final')); ?></li>
                    <li><?php echo anchor('predictions/editgroup/F',lang('final')); ?></li>
                    <li><?php echo anchor('predictions/extra',lang('nav_extra')); ?></li>
                    <li><?php echo anchor('predictions/edit',lang('all_predictions')); ?></li>
                </ul>
            </li>
            <li><?php echo anchor('standings', lang('nav_standings')); ?></li>
            <li><a href"#"><?php echo lang('statistics'); ?> </a>
                <ul>
                    <li><?php echo anchor('charts/champion', lang('nav_champ_graph'));?></li>
                    <li><?php echo anchor('charts/totalgoals', lang('nav_totalgoals_graph'));?></li>
                    <li><?php echo anchor('charts/top/10', lang('nav_top_ten'));?></li>
                </ul>
            </li>
            <?php if ($this->authentication->is_signed_in()) { ?>
            <?php
                if (is_admin()) {
                    ?>
            <li class="adminmenu"><a href="#"><?php echo lang('adminmenu'); ?></a>
                <ul>
                    <li><?php echo anchor('admin/matches_edit',lang('edit_match_results')); ?></li>
                    <li><?php echo anchor('admin/teams_knockout_edit',lang('edit_teams_knockout_phase')); ?></li>

                    <li><?php echo anchor('#',lang('usermanagement')); ?>
                        <ul>
                            <li><?php echo anchor('admin/users',lang('list_all_users')); ?>
                            <li><?php echo anchor('admin/users/unverified',lang('show_unverified_users')); ?>
                            
                        </ul>
                    </li>
                </ul>
            </li>
       
            <?php } ?>
            <?php } ?>
            <?php if ($this->authentication->is_signed_in()) { ?>
                <li><?php echo anchor('account/account_settings', lang('website_account')); ?></li>
                <li class="adminmenu"><?php echo anchor('account/sign_out', lang('website_sign_out')); ?></li>
            <?php } else {?>
                <li class="adminmenu"><?php echo anchor('account/sign_up', lang('website_sign_up')); ?></li>
                <li class="adminmenu"><?php echo anchor('account/sign_in', lang('website_sign_in')); ?></li>
            <?php } ?>
        </ul>