<?php $this->lang->load('navigation', language()); ?>
<?php $this->lang->load('match', language()); ?>
        <ul class="sf-menu">
            <li><?php echo anchor('home','Home'); ?></li>
            <?php if (logged_in()) : ?>
                <li><a href="#"><?php echo lang('matches');?></a>
                    <ul>
                        <li><?php echo anchor('match/viewall','Alle wedstrijden'); ?></li>
                        <li><?php echo anchor('group/overview/a',lang('group').' A'); ?>
                            <ul>
                                <li><?php echo anchor('group/overview/a',lang('overview').' '.lang('group').' A'); ?></li>
                                <li><?php echo anchor('group/predictions/a',lang('check').' '.lang('my_predictions').lang('for').lang('group').' A');?></li>
                            </ul>
                        </li>
                        <li><?php echo anchor('group/overview/b',lang('group').' B'); ?>
                            <ul>
                                <li><?php echo anchor('group/overview/b',lang('overview').' '.lang('group').' B'); ?></li>
                                <li><?php echo anchor('group/predictions/b',lang('check').' '.lang('my_predictions').lang('for').lang('group').' B');?></li>
                            </ul>
                        </li>
                        <li><?php echo anchor('group/overview/c',lang('group').' C'); ?>
                            <ul>
                                <li><?php echo anchor('group/overview/c',lang('overview').' '.lang('group').' C'); ?></li>
                                <li><?php echo anchor('group/predictions/c',lang('check').' '.lang('my_predictions').lang('for').lang('group').' C');?></li>
                            </ul>
                        </li>
                        <li><?php echo anchor('group/overview/d',lang('group').' D'); ?>
                            <ul>
                                <li><?php echo anchor('group/overview/d',lang('overview').' '.lang('group').' D'); ?></li>
                                <li><?php echo anchor('group/predictions/d',lang('check').' '.lang('my_predictions').lang('for').lang('group').' D');?></li>
                            </ul>
                        </li>
                        <li><?php echo anchor('knockoutphase',lang('knockout_phase')); ?></li>
                    </ul>
                </li>
                <li><?php echo anchor('ranking', lang('ranking')); ?></li>
                <li><a href="#"><?php echo lang('user');?></a>
                    <ul>
                        <li><?php echo anchor('user_predictions/view/'.Current_User::user()->id,lang('see_my_predictions')); ?></li>
                        <li><?php echo anchor('user_predictions/edit/',lang('edit_my_predictions')); ?></li>
                        <li><?php echo anchor('user_info',lang('account_info')); ?></li>
                        <li><a href="#"><?php echo lang('language');?></a>
                            <ul>
                                <li><?php echo anchor('user_info/switch_language/english', '<img src="'.base_url().'images/flags/16/uk.png" alt="" /> English', 'title="Switch to English"');?></li>
                                <li><?php echo anchor('user_info/switch_language/nederlands', '<img src="'.base_url().'images/flags/16/nl.png" a.t="" /> Nederlands', 'title="Nederlands"');?></li>
                            </ul>
                        </li>
                    </ul>
                </li>        
                <?php if (admin()): ?>
                    <li><a href="#">Administratie</a>
                        <ul>
                            <li><?php echo anchor('settings_admin',lang('settings'));?></li>
                            <li><a href="#">Berekeningen</a>
                                <ul>
                                    <li><?php echo anchor('admin_functions/calculate_new', 'Bereken nieuwe uitslagen'); ?></li>
                                    <li><?php echo anchor('admin_functions/recalculate_all','Bereken alles opnieuw'); ?><li>
                                </ul>    
                            </li>
                            <li><?php echo anchor('user_info/list_all','Gebruikerslijst'); ?></li>
                            <li><?php echo anchor('text/view', 'Teksten'); ?></li>
                            <li><?php echo anchor('admin_functions/backup', 'Maak een backup'); ?></li>
                            
                         </ul>
                    </li>
                    <li><a href="#">Test functies</a>
                        <ul>
                            <li><?php echo anchor('admin_functions/create_users','Maak 50 test gebruikers aan'); ?></li>
                            <li><?php echo anchor('admin_functions/randomize_predictions','Vul alle voorspellingen willekeurig in'); ?></li>
                            <li><?php echo anchor('admin_functions/clear_results','Wis alle uitslagen en punten'); ?></li>
                            <li><?php echo anchor('admin_functions/clear_predictions','Wis alle voorspellingen'); ?></li>
                        </ul>
                    </li>      
                <?php endif; ?>
                <li><?php echo anchor('logout',lang('logout')); ?></li>
            <?php else: ?>
                <li><?php echo anchor('login',lang('login')); ?></li>
                <li><?php echo anchor('signup',lang('create')); ?></li>
            <?php endif; ?>
        </ul>
