<?php
class Teams_knockout_edit extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        $this->load->helper(array('language', 'url', 'form', 'ssl', 'pool', 'date'));
        $this->load->library(array('authentication'));
        $this->load->model(array('account_model','poolconfig_model'));
        $this->load->model(array('account_details_model'));
        $this->db->select('language');
        $query = $this->db->get_where('account_details', array('account_id' => $this->session->userdata('account_id')));
        $lang = $query->row_array();
        if (isset($lang['language']))  {$this->config->set_item('language',$lang['language']);}
        $this->lang->load(array('general','admin_teams_knockout_edit'));
    }
    
    function index($action = NULL)
    {
        if ($this->authentication->is_signed_in() && is_admin())
        {

            if ($action == NULL)
            {
                // Get possible home & away teams for QF, SF and F
                $sql_query = "SELECT *
                              FROM `match`
                              WHERE `match`.`match_uid` >= 25
                              AND `match`.`match_uid` <= 31";
                $query = $this->db->query($sql_query);
                $matches = $query->result_array();
                
                $home_teams = array(
                                '25' => array('WA' => get_team_name('WA')),
                                '26' => array('WB' => get_team_name('WB')),
                                '27' => array('WC' => get_team_name('WC')),
                                '28' => array('WD' => get_team_name('WD')),
                                '29' => array('W25' => get_team_name('W25')),
                                '30' => array('W26' => get_team_name('W26')),
                                '31' => array('W29' => get_team_name('W29'))
                                );
                $away_teams = array(
                                '25' => array('RB' => get_team_name('RB')),
                                '26' => array('RA' => get_team_name('RA')),
                                '27' => array('RD' => get_team_name('RD')),
                                '28' => array('RC' => get_team_name('RC')),
                                '29' => array('W27' => get_team_name('W27')),
                                '30' => array('W28' => get_team_name('W28')),
                                '31' => array('W30' => get_team_name('W30'))
                                );                            
                foreach($matches as $match)
                {
                    $groups_home = explode(',',$match['match_group_home_team']);
                    $groups_away = explode(',',$match['match_group_away_team']);
                    //build WHERE clause
                    
                    foreach($groups_home as $group)
                    {
                        if(!isset($whereclause))
                        {
                            $whereclause = "`team`.`team_group` = '$group'";
                        }
                        else
                        {
                            $whereclause .= " OR `team`.`team_group` = '$group'";
                        }
                    }
                    
                    $sql_query = "SELECT `team_uid`
                                  FROM `team`
                                  WHERE $whereclause";
                    unset($whereclause);
                    $query = $this->db->query($sql_query);
                    $teams = $query->result_array();
                    //echo $sql_query."<br/>";
                    foreach($teams as $team)
                    {
                        $home_teams[$match['match_uid']][$team['team_uid']] = get_team_name($team['team_uid']);
                    }
                    
                    foreach($groups_away as $group)
                    {
                        if(!isset($whereclause))
                        {
                            $whereclause = "`team`.`team_group` = '$group'";
                        }
                        else
                        {
                            $whereclause .= " OR `team`.`team_group` = '$group'";
                        }
                    }
                    
                    $sql_query = "SELECT `team_uid`
                                  FROM `team`
                                  WHERE $whereclause";
                    unset($whereclause);
                    $query = $this->db->query($sql_query);
                    $teams = $query->result_array();
                    //echo $sql_query."<br/>";
                    foreach($teams as $team)
                    {
                        $away_teams[$match['match_uid']][$team['team_uid']] = get_team_name($team['team_uid']);
                    }
                         
                }
                
                $data = array(
                                'home_teams' => $home_teams,
                                'away_teams' => $away_teams,
                                'matches'   => $matches,
                                'account'   => $this->account_model->get_by_id($this->session->userdata('account_id')),
                                'account_details' => $this->account_details_model->get_by_account_id($this->session->userdata('account_id')),
                                'content_main' => 'admin/teams_knockout_edit',
                                'title' => lang('edit_teams_knockout')
                                );
                $this->load->view('template/template', $data);
            }
            
            if ($action == 'save') {
                $post_array = $this->input->post();

                for($i = 0; $i <= 6; $i++)
                {
                    $match_uid = $post_array['match_uid'][$i];
                    $home_team = $post_array['home_team'][$i];
                    $away_team = $post_array['away_team'][$i];
                    
                    $sql_query = "UPDATE `match`
                                  SET `home_team` = '$home_team',
                                      `away_team` = '$away_team'
                                  WHERE `match_uid` = '$match_uid'";
                    $query = $this->db->query($sql_query);
                }
                $this->session->set_flashdata('info', lang('data_saved'));
                redirect('/admin/teams_knockout_edit');
                
            }
            else
            {
            
            }
        }
        else
        {
            redirect('account/sign_in/?continue='.urlencode(site_url('admin/teams_knockout_edit')));
        }
    }

}
