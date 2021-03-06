<?php
class Stats extends CI_Controller {

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
        if (isset($lang['language']))
        {
            if ($lang['language'] == "de" || $lang['language'] == "en" || $lang['language'] == "nl")
            {
                $this->config->set_item('language',$lang['language']);
            }
            else
            {
                $lang['language'] = $this->config->item('language');
                $this->config->set_item('language',$lang['language']);
            }
        }
        else
        {
            $lang['language'] = $this->config->item('language');
        }
        $this->lang->load(array('general','standings', 'stats'));
    }
    function index()
    {
    }
    
    function view_match($match_uid)
    {
        maintain_ssl();
        
        if ($this->authentication->is_signed_in())
        {       
            $account_id = $this->session->userdata('account_id');
            
            $sql_query = "SELECT *
                            FROM `prediction`
                            JOIN `match`
                            ON `match`.`match_uid` = `prediction`.`pred_match_uid`
                            JOIN `account`
                            ON `account`.`id` = `prediction`.`account_id`
                            AND `prediction`.`pred_match_uid` = $match_uid";
            
            $query = $this->db->query($sql_query);
            $predictions = $query->result_array();

            $data = array(
                        'predictions'       => $predictions,
                        'match_uid'         => $match_uid,
                        'account'           => $this->account_model->get_by_id($this->session->userdata('account_id')),
                        'account_details'   => $this->account_details_model->get_by_account_id($this->session->userdata('account_id'))
                        );
            $data['content_main'] = "stats_match";
            $data['title'] = sprintf(lang('view_stats_for'), lang($predictions[0]['home_team']), lang($predictions[0]['away_team'])) ;
    
            $this->load->view('template/template', $data);            
        }
        else
        {
            redirect('account/sign_in/?continue='.site_url('stats/view_match/'.$match_uid));
        }
    }
    
    function view_team($team_uid)
    {
        maintain_ssl();
        
        if ($this->authentication->is_signed_in())
        {       
            if ($team_uid[0] != 'W' && $team_uid[0] != 'R')
            {
                $account_id = $this->session->userdata('account_id');
                
                $sql_query = "SELECT *
                                FROM `match`
                                JOIN `prediction`
                                ON `prediction`.`pred_match_uid` = `match`.`match_uid`
                                AND (`home_team` = '$team_uid' OR `away_team` = '$team_uid')
                                AND `match`.`match_uid` < 25
                                AND (`prediction`.`pred_home_goals` IS NOT NULL AND `prediction`.`pred_away_goals` IS NOT NULL )
                                JOIN `account`
                                ON `account`.`id` = `prediction`.`account_id`
                                ORDER BY `account`.`id`";
                                
                $query = $this->db->query($sql_query);
                $predictions = $query->result_array();
                $total_goals_for = 0;
                $total_goals_against = 0;
                $num = $query->num_rows();
                $group_stage['win'] = 0;
                $group_stage['loss'] = 0;
                $group_stage['tie'] = 0;
                foreach ($predictions as $p)
                {
                    if($p['home_team'] == $team_uid)
                    {
                        $total_goals_for = $total_goals_for + $p['pred_home_goals'];
                        $total_goals_against = $total_goals_against + $p['pred_away_goals'];
                    }
                    else
                    {
                        $total_goals_for = $total_goals_for + $p['pred_away_goals'];
                        $total_goals_against = $total_goals_against + $p['pred_home_goals'];
                    }
                    
                    if (($p['home_team'] == $team_uid && $p['pred_home_goals'] > $p['pred_away_goals'])
                        ||
                       ($p['away_team'] == $team_uid && $p['pred_home_goals'] < $p['pred_away_goals']))
                    {
                        $group_stage['win']++;
                    }
                    elseif (($p['home_team'] == $team_uid && $p['pred_home_goals'] < $p['pred_away_goals'])
                            ||
                           ($p['away_team'] == $team_uid && $p['pred_home_goals'] > $p['pred_away_goals']))
                    {
                        $group_stage['loss']++;
                    }       
                    elseif (($p['home_team'] == $team_uid && $p['pred_home_goals'] == $p['pred_away_goals'])
                            ||
                            ($p['away_team'] == $team_uid && $p['pred_home_goals'] == $p['pred_away_goals'])
                            )
                    {
                        $group_stage['tie']++;
                    }
                }
                
                $sql_query = "SELECT *
                              FROM `prediction`
                              WHERE (`prediction`.`pred_home_team` = '$team_uid' OR `prediction`.`pred_away_team` = '$team_uid')
                              AND `prediction`.`pred_match_uid` >= 25";
                                
                $query = $this->db->query($sql_query);
                $predictions = $query->result_array();
                $knockout_stage['quarter_finals'] = 0;
                $knockout_stage['semi_finals'] = 0;
                $knockout_stage['finals'] = 0;
                
                foreach($predictions as $p)
                {
                    if($p['pred_match_uid'] >= 25 && $p['pred_match_uid'] <= 28)
                    {
                        $knockout_stage['quarter_finals']++;
                    }
                    elseif($p['pred_match_uid'] >= 29 && $p['pred_match_uid'] <= 30)
                    {
                        $knockout_stage['semi_finals']++;
                    }
                    elseif($p['pred_match_uid'] == 31)
                    {
                        $knockout_stage['finals']++;
                    }
                }
                
                $sql_query = "SELECT *
                              FROM `account_details`
                              WHERE `pred_champion` = '$team_uid'";
                $query = $this->db->query($sql_query);
                $num_champ = $query->num_rows();
                
                $sql_query = "SELECT *
                              FROM `prediction`
                              JOIN `match`
                              ON `match`.`match_uid` = `prediction`.`pred_match_uid`
                              AND (`match`.`home_team` = '$team_uid' OR `match`.`away_team` = '$team_uid')
                              AND `match`.`match_uid` < 25
                              AND   `account_id` = '$account_id'";
                $query = $this->db->query($sql_query);
                $user_team_pred_group_stage = $query->result_array();

                $sql_query = "SELECT *
                              FROM `prediction`
                              JOIN `match`
                              ON `match`.`match_uid` = `prediction`.`pred_match_uid`
                              AND (`prediction`.`pred_home_team` = '$team_uid' OR `prediction`.`pred_away_team` = '$team_uid')
                              AND `match`.`match_uid` >= 25
                              AND   `account_id` = '$account_id'";
                $query = $this->db->query($sql_query);
                $user_team_pred_knockout_stage = $query->result_array();            

                if ($num > 0)
                {
                    $avg_goals_for = number_format($total_goals_for/$num,2);
                    $avg_goals_against = number_format($total_goals_against/$num,2);
                }
                else
                {
                    $avg_goals_for = 0;
                    $avg_goals_against = 0;
                }
                
                $data = array(
                            'group_stage'       => $group_stage,
                            'knockout_stage'    => $knockout_stage,
                            'num'               => $num,
                            'num_champ'         => $num_champ,
                            'user_team_pred_group_stage'    => $user_team_pred_group_stage,
                            'user_team_pred_knockout_stage' => $user_team_pred_knockout_stage,
                            'avg_goals_for'     => $avg_goals_for,
                            'avg_goals_against' => $avg_goals_against,
                            'team_uid'          => $team_uid,
                            'account'           => $this->account_model->get_by_id($this->session->userdata('account_id')),
                            'account_details'   => $this->account_details_model->get_by_account_id($this->session->userdata('account_id'))
                            );
                $data['content_main'] = "stats_team";
                $data['title'] = sprintf(lang('view_team_stats'), lang($team_uid)) ;
        
                $this->load->view('template/template', $data);  
            }
            else
            {
                $this->session->set_flashdata('error', lang('no_stats_for_that_team'));
                redirect('/');
            }
        }    
        else
        {
            redirect('account/sign_in/?continue='.site_url('stats/view_team/'.$team_uid));
        }
    }    
}
