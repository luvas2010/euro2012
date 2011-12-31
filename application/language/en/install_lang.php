<?php
$lang['created_table']                  =   "Created Table";
$lang['create_admin_account']           =   "Create Administrator Account";
$lang['create_first_account']           =   "Create the first user account. his will be the administrator account.";
$lang['username']                       =   "User name";
$lang['first_name']                     =   "First Name";
$lang['last_name']                      =   "Last Name";
$lang['email']                          =   "Email Address";
$lang['password']                       =   "Password";
$lang['installation_script_running']    =   "Installation of %s";
$lang['start']                          =   "Install checks";
$lang['step1']                          =   "Step 1: Creating tables";
$lang['step2']                          =   "Step 2: Configuration check";
$lang['start_installation']             =   "Start install procedure";
$lang['version']                        =   "Version";
$lang['installation_not_possible']      =   "Your server does not meet the requirements for installation";
$lang['user_created']                   =   "User %s created!";
$lang['config_change']                  =   "You can change these settings in <span class='code'>/application/config/pool.php</span>.
                                             After you've made your changes you can refresh this page.";
$lang['time_offset_check']              =   "Your time offset is <span class='boldtext'>%s seconds</span>. If the time displayed at the bottom is not correct, change this in <span class='code'>/application/config/pool.php</span>.";
$lang['timezone_check']                 =   "Looks like your server is in timezone <span class='boldtext'><em>'%s'</em></span>.";
$lang['try_this_offset']                =   "If that is correct, your time_offset should be <span class='boldtext'>%s seconds</span>";
$lang['predictions_open']               =   "If set to `1` or `TRUE` users can predict match results until the match starts.
                                             If set to `0` or `FALSE`, users can predict match results until Match #1 starts.
                                             You can change this in <span class='code'>/application/config/pool.php</span>.";
$lang['sign_up_email_admin']            =   "Send the admin account an e-mail when a new user signs up
                                             You can change this in <span class='code'>/application/config/pool.php</span>.";
$lang['verify_users']                   =   "Admin has to verify users before they can login
                                             You can change this in <span class='code'>/application/config/pool.php</span>.";             
$lang['pred_points_goals']              =   "Points for predicting 'home' or 'away' goals correct.";
$lang['pred_points_result']             =   "Points for predicting correct who wins the match (or tie).";
$lang['pred_points_qf_team']            =   "Points for predicting a team in the Quarter Finals correct.";
$lang['pred_points_sf_team']            =   "Points for predicting a team in the Semi Finals correct.";
$lang['pred_points_f_team']             =   "Points for predicting a team in the Final correct.";
$lang['pred_points_bonus']              =   "Maximum Bonus points for total number of goals.";
$lang['pred_points_champion']           =   "Points for predicting the champion correct";
$lang['account_settings']               =   "<p class='info'>In the same configuration file you will find a lot of `account settings`,
                                             with which you can change the way people sign up and sign in.
                                             You will have to enter the Twitter keys and Facebook keys if you want your users to be able to
                                             sign up and sign in through those networks. The instructions are self explanatory, you will find them in the file<br/>
                                             If you do not want the social network integration, then change<br/>
                                             <span class='code'>\$config['third_party_auth_providers'] = array('facebook', 'twitter', 'google');</span><br/>
                                             into<br/>
                                             <span class='code'>\$config['third_party_auth_providers'] = array();</span></p>
                                             ";
$lang['done_take_me_home']              =   "It looks alright, take me to the home page";
/* End of file install_lang.php */
/* Location: ./application/language/en/install_lang.php */
