<?php
class Predictions extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        // Load the necessary stuff...
        $this->load->helper(array('language', 'url', 'form', 'ssl', 'pool', 'date'));
        $this->load->library(array('authentication'));
        $this->load->model(array('account_model'));
        $this->load->model(array('account_details_model'));
        $this->db->select('language');
        $query = $this->db->get_where('account_details', array('account_id' => $this->session->userdata('account_id')));
        $lang = $query->row_array();
        if (isset($lang['language']))  {$this->config->set_item('language',$lang['language']);}
        $this->lang->load(array('general', 'predictions'));
    }
    
    function index()
    {
    
        maintain_ssl();
        
        if ($this->authentication->is_signed_in())
        {
            $data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
            $data['account_details'] = $this->account_details_model->get_by_account_id($this->session->userdata('account_id'));

            $account_id = $data['account']->id;
            
            $sql_query = "SELECT *
                            FROM `prediction`
                            JOIN `match`
                            ON `prediction`.`pred_match_uid` = `match`.`match_uid` AND prediction.account_id = '$account_id'
                            ORDER BY `prediction`.`pred_match_uid` ASC
                            ";
            $query = $this->db->query($sql_query);
            $data['predictions'] = $query->result_array();
            
            $data['title'] = sprintf(lang('predictions_for'), $data['account_details']->fullname);
            $data['content_main'] = "predictions";
            
            $this->load->view('template/template', $data);
        }
        else
        {
            redirect('account/sign_in/?continue='.urlencode(base_url().'/predictions'));
        }    
    }
    
    function edit($action = NULL)
    {
        maintain_ssl();
        if ($this->authentication->is_signed_in())
        {
            $data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
            $data['account_details'] = $this->account_details_model->get_by_account_id($this->session->userdata('account_id'));

            $account_id = $data['account']->id;
            
            $sql_query = "SELECT *
                            FROM `prediction`
                            JOIN `match`
                            ON `prediction`.`pred_match_uid` = `match`.`match_uid` AND prediction.account_id = '$account_id'
                            ORDER BY `prediction`.`pred_match_uid` ASC
                            ";
            $query = $this->db->query($sql_query);
            $data['predictions'] = $query->result_array();
            $data['num'] = $query->num_rows();
        }
        else
        {
            redirect('account/sign_in/?continue='.urlencode(base_url().'/predictions/edit'));
        }
        
        if ($this->authentication->is_signed_in() && $action == 'save')
        {
            $post_array = $this->input->post();
            
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('', '<br />');
            for ($i = 0; $i < $data['num']; $i++) {
                if ($post_array['pred_home_goals'][$i] != "")
                {
                    $text = '"Home Goals" for match '.get_match($post_array['pred_match_uid'][$i]);
                    $this->form_validation->set_rules('pred_home_goals['.$i.']',$text,'trim|is_natural');
                }
               if ($post_array['pred_away_goals'][$i] != "") {
                    $text = '"Away Goals" for match '.get_match($post_array['pred_match_uid'][$i]);
                    $this->form_validation->set_rules('pred_away_goals['.$i.']',$text,'trim|is_natural');
                }
            }
            $this->form_validation->set_message('is_natural', '%s can only be 0 or a positive number.');
            
            
            if ($this->form_validation->run() ==  FALSE) {

            $data['title'] = "Edit Predictions for ".$data['account']->username;
            $data['content_main'] = "predictions_edit";
            
            $this->load->view('template/template', $data);
                        
            }
            else
            {
                
                for ($i=0;$i<$data['num'];$i++) {
                    $prediction_uid = $post_array['prediction_uid'][$i];
                    if ($post_array['pred_home_goals'][$i] != "")
                    {
                        $pred_home_goals = $post_array['pred_home_goals'][$i];
                        $home_goals_sql = "`pred_home_goals` =  '$pred_home_goals'";
                    }
                    else
                    {
                        $home_goals_sql = "`pred_home_goals` =  NULL";
                    }
                    if ($post_array['pred_away_goals'][$i] != "")
                    {
                        $pred_away_goals = $post_array['pred_away_goals'][$i];
                        $away_goals_sql = "`pred_away_goals` =  '$pred_away_goals'";
                    }
                    else
                    {
                        $away_goals_sql = "`pred_away_goals` =  NULL";
                    }
                    $sql_query = "UPDATE `prediction`
                                  SET ".$home_goals_sql.",
                                       ".$away_goals_sql."
                                  WHERE `prediction_uid` = '$prediction_uid'";
                    $query = $this->db->query($sql_query);
                }
                redirect('/predictions/');
            }
            
        }

        if ($this->authentication->is_signed_in() && $action == NULL)
        {

            
            $data['title'] = "Edit Predictions for ".$data['account']->username;
            $data['content_main'] = "predictions_edit";
            
            $this->load->view('template/template', $data);
        }
       
        
    }
    
    function editgroup($group, $action = NULL)
    {
        $group = strtoupper($group);
        maintain_ssl();
        if ($this->authentication->is_signed_in())
        {
            $data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
            $data['account_details'] = $this->account_details_model->get_by_account_id($this->session->userdata('account_id'));

            $account_id = $data['account']->id;
            
            if ($group != 'ALL')
            {
                $sql_query = "SELECT *
                              FROM `prediction`
                              JOIN `match`
                              ON `prediction`.`pred_match_uid` = `match`.`match_uid`
                              AND prediction.account_id = '$account_id'
                              AND `match`.`match_group` = '$group'
                              ORDER BY `prediction`.`pred_match_uid` ASC";
            }
            else
            {
                $sql_query = "SELECT *
                              FROM `prediction`
                              JOIN `match`
                              ON `prediction`.`pred_match_uid` = `match`.`match_uid`
                              AND prediction.account_id = '$account_id'
                              ORDER BY `prediction`.`pred_match_uid` ASC";
            }
            
            $query = $this->db->query($sql_query);
            $data['predictions'] = $query->result_array();
            $data['num'] = $query->num_rows();
                          
            if (($group == 'QF' || $group == 'SF' || $group == 'F'))
            {
                
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
                foreach($data['predictions'] as $prediction)
                {
                    if ($prediction['match_uid'] >= 25 && $prediction['match_uid'] <= 28)
                    {
                        $groups_home = explode(',',$prediction['match_group_home_team']);
                        $groups_away = explode(',',$prediction['match_group_away_team']);
                        //build WHERE clause
                        
                        foreach($groups_home as $group_home)
                        {
                            if(!isset($whereclause))
                            {
                                $whereclause = "`team`.`team_group` = '$group_home'";
                            }
                            else
                            {
                                $whereclause .= " OR `team`.`team_group` = '$group_home'";
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
                            $home_teams[$prediction['match_uid']][$team['team_uid']] = get_team_name($team['team_uid']);
                        }
                        
                        foreach($groups_away as $group_away)
                        {
                            if(!isset($whereclause))
                            {
                                $whereclause = "`team`.`team_group` = '$group_away'";
                            }
                            else
                            {
                                $whereclause .= " OR `team`.`team_group` = '$group_away'";
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
                            $away_teams[$prediction['match_uid']][$team['team_uid']] = get_team_name($team['team_uid']);
                        }
                    }
                    
                    if ($prediction['match_uid'] == 29) {
                        $sql_query = "SELECT `pred_home_team`, `pred_away_team`
                                      FROM `prediction`
                                      WHERE `pred_match_uid` = '25'
                                      AND `account_id` = '$account_id'";
                        $query = $this->db->query($sql_query);
                        $pos_teams = $query->result_array();
                        foreach ($pos_teams as $pos_team)
                        {
                            if ($pos_team['pred_home_team'][0] != NULL && $pos_team['pred_home_team'][0] != 'W' )
                            {
                                $home_teams[29][$pos_team['pred_home_team']] = get_team_name($pos_team['pred_home_team']);
                            }
                            if ($pos_team['pred_away_team'][0] != NULL && $pos_team['pred_away_team'][0] != 'R')
                            {
                                $home_teams[29][$pos_team['pred_away_team']] = get_team_name($pos_team['pred_away_team']);
                            }
                        }
                        $sql_query = "SELECT `pred_home_team`, `pred_away_team`
                                      FROM `prediction`
                                      WHERE `pred_match_uid` = '27'
                                      AND `account_id` = '$account_id'";
                        $query = $this->db->query($sql_query);
                        $pos_teams = $query->result_array();
                        foreach ($pos_teams as $pos_team)
                        {
                            if ($pos_team['pred_home_team'][0] != NULL && $pos_team['pred_home_team'][0] != 'W')
                            {
                                $away_teams[29][$pos_team['pred_home_team']] = get_team_name($pos_team['pred_home_team']);
                            }
                            if ($pos_team['pred_away_team'][0] != NULL && $pos_team['pred_away_team'][0] != 'R')
                            {
                                $away_teams[29][$pos_team['pred_away_team']] = get_team_name($pos_team['pred_away_team']);
                            }
                        }
                    }
                    if ($prediction['match_uid'] == 30) {
                        $sql_query = "SELECT `pred_home_team`, `pred_away_team`
                                      FROM `prediction`
                                      WHERE `pred_match_uid` = '26'
                                      AND `account_id` = '$account_id'";
                        $query = $this->db->query($sql_query);
                        $pos_teams = $query->result_array();
                        foreach ($pos_teams as $pos_team)
                        {
                            if ($pos_team['pred_home_team'][0] != NULL && $pos_team['pred_home_team'][0] != 'W')
                            {
                                $home_teams[30][$pos_team['pred_home_team']] = get_team_name($pos_team['pred_home_team']);
                            }
                            if ($pos_team['pred_away_team'][0] != NULL && $pos_team['pred_away_team'][0] != 'R')
                            {
                                $home_teams[30][$pos_team['pred_away_team']] = get_team_name($pos_team['pred_away_team']);
                            }                        }
                        $sql_query = "SELECT `pred_home_team`, `pred_away_team`
                                      FROM `prediction`
                                      WHERE `pred_match_uid` = '28'
                                      AND `account_id` = '$account_id'";
                        $query = $this->db->query($sql_query);
                        $pos_teams = $query->result_array();
                        foreach ($pos_teams as $pos_team)
                        {
                            if ($pos_team['pred_home_team'][0] != NULL && $pos_team['pred_home_team'][0] != 'W')
                            {
                                $away_teams[30][$pos_team['pred_home_team']] = get_team_name($pos_team['pred_home_team']);
                            }
                            if ($pos_team['pred_away_team'][0] != NULL && $pos_team['pred_away_team'][0] != 'R')
                            {
                                $away_teams[30][$pos_team['pred_away_team']] = get_team_name($pos_team['pred_away_team']);
                            }                         }
                    }
                    if ($prediction['match_uid'] == 31) {
                        $sql_query = "SELECT `pred_home_team`, `pred_away_team`
                                      FROM `prediction`
                                      WHERE `pred_match_uid` = '29'
                                      AND `account_id` = '$account_id'";
                        $query = $this->db->query($sql_query);
                        $pos_teams = $query->result_array();
                        foreach ($pos_teams as $pos_team)
                        {
                            if ($pos_team['pred_home_team'][0] != NULL && $pos_team['pred_home_team'][0] != 'W')
                            {
                                $home_teams[31][$pos_team['pred_home_team']] = get_team_name($pos_team['pred_home_team']);
                            }
                            if ($pos_team['pred_away_team'][0] != NULL && $pos_team['pred_away_team'][0] != 'W')
                            {
                                $home_teams[31][$pos_team['pred_away_team']] = get_team_name($pos_team['pred_away_team']);
                            }                         }
                        $sql_query = "SELECT `pred_home_team`, `pred_away_team`
                                      FROM `prediction`
                                      WHERE `pred_match_uid` = '30'
                                      AND `account_id` = '$account_id'";
                        $query = $this->db->query($sql_query);
                        $pos_teams = $query->result_array();
                        foreach ($pos_teams as $pos_team)
                        {
                            if ($pos_team['pred_home_team'][0] != NULL && $pos_team['pred_home_team'][0] != 'W')
                            {
                                $away_teams[31][$pos_team['pred_home_team']] = get_team_name($pos_team['pred_home_team']);
                            }
                            if ($pos_team['pred_away_team'][0] != NULL && $pos_team['pred_away_team'][0] != 'W')
                            {
                                $away_teams[31][$pos_team['pred_away_team']] = get_team_name($pos_team['pred_away_team']);
                            }                           }
                    }
                }
                //echo "Count: ".count($home_teams[31]);
                $data['home_teams'] = $home_teams;
                $data['away_teams'] = $away_teams;
            }                
                
                                
            

            $data['group'] = $group;
            $this->load->library('pool');
            if ($group == 'A' || $group == 'B' || $group == 'C' || $group == 'D') {
                $data['pred_results'] = $this->pool->calculate_pred_group($group); // Predicted results
                $data['results']      = $this->pool->calculate_group($group);      // Real results
            }
        }
        else
        {
            redirect('account/sign_in/?continue='.urlencode(base_url().'/predictions/editgroup/'.$group));
        }
         
        if ($action == 'save')
        {
            $post_array = $this->input->post();
            //echo "<pre>";print_r($post_array); echo "</pre>";
 
            for ($i=0;$i<$data['num'];$i++)
            {
                if (isset($post_array['pred_home_goals'][$i]))
                {
                    if (!prediction_closed($post_array['pred_match_uid'][$i]))
                    {
                        $prediction_uid = $post_array['prediction_uid'][$i];
                        if ($post_array['pred_home_goals'][$i] != "")
                        {
                            $pred_home_goals = $post_array['pred_home_goals'][$i];
                            $home_goals_sql = "`pred_home_goals` =  '$pred_home_goals'";
                        }
                        else
                        {
                            $home_goals_sql = "`pred_home_goals` =  NULL";
                        }
                        if ($post_array['pred_away_goals'][$i] != "")
                        {
                            $pred_away_goals = $post_array['pred_away_goals'][$i];
                            $away_goals_sql = "`pred_away_goals` =  '$pred_away_goals'";
                        }
                        else
                        {
                            $away_goals_sql = "`pred_away_goals` =  NULL";
                        }

                        $sql_query = "UPDATE `prediction`
                                      SET ".$home_goals_sql.",
                                           ".$away_goals_sql."
                                      WHERE `prediction_uid` = '$prediction_uid'";
                        $query = $this->db->query($sql_query);
                    }
                    else
                    {
                        $this->session->set_flashdata('info', sprintf(lang('match_has_started'), $post_array['pred_match_uid'][$i]));
                    }
                }
                if (!prediction_closed(1) && ($group == 'QF' || $group == 'SF' || $group == 'F'))
                {

                            $pred_home_team = $post_array['pred_home_team'][$i];
                            $prediction_uid = $post_array['prediction_uid'][$i];
                            $sql_query = "UPDATE `prediction`
                                          SET `pred_home_team` = '$pred_home_team'
                                          WHERE `prediction_uid` = '$prediction_uid'";
                            $query = $this->db->query($sql_query);

                            $pred_away_team = $post_array['pred_away_team'][$i];
                            $prediction_uid = $post_array['prediction_uid'][$i];
                            $sql_query = "UPDATE `prediction`
                                          SET `pred_away_team` = '$pred_away_team'
                                          WHERE `prediction_uid` = '$prediction_uid'";
                            $query = $this->db->query($sql_query);

                        //echo $sql_query."<br/>";
                }
            }
            $this->session->set_flashdata('info', lang('data_saved'));
            redirect ('predictions/editgroup/'.$group);
        }

        if ($this->authentication->is_signed_in() && $action == NULL)
        {

            
            $data['title'] = sprintf(lang('predictions_for_group'), lang($group));
            $data['content_main'] = "predictions_editgroup";
            
            $this->load->view('template/template', $data);
        }
    }
    
    function extra($action = NULL)
    {
        maintain_ssl();
        if ($this->authentication->is_signed_in())
        {
            $data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
            $data['account_details'] = $this->account_details_model->get_by_account_id($this->session->userdata('account_id'));

            $account_id = $data['account']->id;
            
            $sql_query = "SELECT `pred_total_goals`, `pred_champion`
                            FROM `account_details`
                            WHERE `account_details`.`account_id` = '$account_id'
                            ";
            $query = $this->db->query($sql_query);
            $data['prediction'] = $query->row_array();
        }
        else
        {
            redirect('account/sign_in/?continue='.urlencode(base_url().'/predictions/extra'));
        }
        
        if ($this->authentication->is_signed_in() && $action == 'save')
        {
            $totalgoals = $this->input->post('totalgoals');
            $champion =     $this->input->post('champion');
            $account_id = $this->input->post('account_id');
                
            if ($totalgoals == "")
            {
                $sql_extra = "`pred_total_goals` = NULL";
            }
            else
            {
                $sql_extra = "`pred_total_goals` = $totalgoals";
            }
            if ($champion != "")
            {
                $sql_extra .= ", `pred_champion` = '$champion'";
            }
            $sql_query = "UPDATE `account_details`
                          SET $sql_extra
                          WHERE `account_id` = $account_id";
            $query = $this->db->query($sql_query);
        
            redirect('/');
        }    
        
        if ($this->authentication->is_signed_in() && $action == NULL)
        {

            
            $data['title'] = lang('nav_extra');
            $data['content_main'] = "prediction_extra";
            
            $this->load->view('template/template', $data);
        }
       
        
    }
     
      
}
?>
