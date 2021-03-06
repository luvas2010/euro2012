    <ul class="sf-menu">
            <li><?php echo anchor('/',lang('navhome')); ?></li>
                                       
            <!-- hide menu when not logged in -->
            <?php if (($this->authentication->is_signed_in()) or
                     ($this->poolconfig_model->item('pool_style')==null)) { ?>
            
            <li><?php echo anchor('matches',lang('nav_matches')); ?></li>
            
             
            <?php } ?>
            <!-- hide menu when not logged in -->
            <?php if (($this->authentication->is_signed_in()) or
                     ($this->poolconfig_model->item('pool_style')==null)) { ?>
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
                    <li><?php echo anchor('predictions/editgroup/ALL',lang('all_predictions')); ?></li>
                </ul>
            </li>
            <?php } ?>
      <li><?php echo anchor('rules', lang('nav_rules')); ?></li>
      <!-- hide menu when not logged in -->
      <?php if (($this->authentication->is_signed_in()) or
                ($this->poolconfig_model->item('pool_style')==null)) { ?>
			
            <li><?php echo anchor('standings', lang('nav_standings')); ?></li>
            <li><a href="#"><?php echo lang('statistics'); ?> </a>
                <ul>
                    <li><?php echo anchor('charts/champion', lang('nav_champ_graph'));?></li>
                    <li><?php echo anchor('charts/totalgoals', lang('nav_totalgoals_graph'));?></li>
                    <li><?php echo anchor('charts/top/10', lang('nav_top_ten'));?></li>
                    <?php $sql_query = "SELECT `team_uid`
                                        FROM `team`
                                        WHERE `team_group` = 'A' OR `team_group` = 'B' OR `team_group` = 'C' OR `team_group` = 'D'";
                          $query = $this->db->query($sql_query);
                          $teams = $query->result_array();?>
                          
                    <li><a>Teams</a>
                        <ul>
                            <?php foreach($teams as $team) { ?>
                            <li><?php echo anchor('stats/view_team/'.$team['team_uid'], '<span class="teamflag '.$team['team_uid'].'">'.lang($team['team_uid']).'</span>');?></li>
                            <?php } ?>
                        </ul>
                    </li>
                    
                </ul>
            </li>
            <?php } ?>
            
           
            <!-- hide admin menu if not logged in and not admin user -->
            <?php if (($this->authentication->is_signed_in()) or
                     ($this->poolconfig_model->item('pool_style')==null)) { ?>
            <?php
                if (is_admin()) {
                    ?>
            <li class="adminmenu"><a href="#"><?php echo lang('adminmenu'); ?></a>
                <ul>
                    <li><?php echo anchor('admin/matches_edit',lang('edit_match_results')); ?></li>
                    <li><?php echo anchor('admin/teams_knockout_edit',lang('edit_teams_knockout_phase')); ?></li>
                    <li><?php echo anchor('admin/emailer',"E-Mail"); ?></li>
                    <li><?php echo anchor('#',lang('usermanagement')); ?>
                        <ul>
                            <li><?php echo anchor('admin/users',lang('list_all_users')); ?></li>
                            <li><?php echo anchor('admin/users/unverified',lang('show_unverified_users')); ?></li>
                            <?php if ($this->poolconfig_model->item('play_for_money'))
							{ ?>
							<li><?php echo anchor('admin/users/unpayed',lang('show_unpayed_users')); ?></li>
							<?php } ?>
                        </ul>
                    </li>
                    <li><?php echo anchor('admin/check_settings/cat/0', lang('check_settings'));?></li>
                   
                </ul>
            </li>
       
            <?php } ?>
            <?php } ?>
            <?php if ($this->authentication->is_signed_in()) 
                      { ?>
                <li><?php echo anchor('account/account_settings', lang('website_account')); ?></li>
                <li class=""><?php echo anchor('account/sign_out', lang('website_sign_out')); ?></li>
            <?php } else {?>
                <li class=""><?php echo anchor('account/sign_up', lang('website_sign_up')); ?></li>
                <li class=""><?php echo anchor('account/sign_in', lang('website_sign_in')); ?></li>
            <?php } ?>
        </ul>
                
        <ul class='languages'>
            <?php
                $sql_query = "SELECT * FROM `ref_language` WHERE `active` = 1 ORDER BY `one`";
                $query = $this->db->query($sql_query);
                $languages = $query->result_array();
                $path = $this->config->item('base_url');
                
                foreach($languages as $language)
                {
                $image_url = '<img src="'.$path.'/css/flags/lang_'.$language['one'].'.png"/>';
            ?>
            <li><?php echo anchor('account/account_settings/set_language/'.$language['one'].'?continue='.urlencode(current_url()), $image_url, 'title="'.$language['language'].'"' );?></li>
            
            <?php } ?>
        </ul>
        
  
