<?php
class Calculations extends CI_Controller {

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
        $this->lang->load(array('general','admin_matches'));
    }
    
    function index() {
    }
    
    function calculate_match($match_uid, $recalc = 0)
    {
        if ($this->authentication->is_signed_in() && is_admin())
        {

            $pred_points_goals = $this->poolconfig_model->item('pred_points_goals');
            $pred_points_result = $this->poolconfig_model->item('pred_points_result');
            $pred_points_bonus = $this->poolconfig_model->item('pred_points_bonus');
            
            
            $sql_query = "SELECT *
                          FROM `prediction`
                          WHERE `prediction`.`pred_match_uid` = $match_uid";
            if (!$recalc)
            {
                $sql_query .= " AND `prediction`.`pred_calculated` = 0";
            }
            $query = $this->db->query($sql_query);
            $predictions = $query->result_array();
            
            $sql_query = "SELECT *
                          FROM `match`
                          WHERE `match_uid` = $match_uid";
            $query = $this->db->query($sql_query);
            $match = $query->row_array();
            $i = 0;
            foreach ($predictions as $prediction)
            {
                $bonus_points = 0; // check this on the last match
                $current_account = $prediction['account_id'];
                if (($prediction['pred_home_goals'] == $match['home_goals']) && $prediction['pred_home_goals'] != NULL)
                {
                    $home_goals_points = $pred_points_goals;
                }
                else
                {
                    $home_goals_points = 0;
                }                    
                if (($prediction['pred_away_goals'] == $match['away_goals']) && $prediction['pred_away_goals'] != NULL)
                {
                    $away_goals_points = $pred_points_goals;
                }
                else
                {
                    $away_goals_points = 0;
                }                 
                if (
                    (($prediction['pred_home_goals'] > $prediction['pred_away_goals']) && ($match['home_goals'] > $match['away_goals']))
                    ||
                    (($prediction['pred_home_goals'] < $prediction['pred_away_goals']) && ($match['home_goals'] < $match['away_goals']))
                    ||
                    (($prediction['pred_home_goals'] == $prediction['pred_away_goals']) && ($match['home_goals'] == $match['away_goals']))
                    &&
                    ($match['home_goals'] != NULL && $match['away_goals'] != NULL)
                    &&
                    ($prediction['pred_home_goals'] != NULL && $prediction['pred_away_goals'] != NULL)
                    )
                {
                    $result_points = $pred_points_result;
                }
                else
                {
                    $result_points = 0;
                }  

                if ($prediction['pred_match_uid'] >= 25 && $prediction['pred_match_uid'] <= 28)
                {
                    if ($prediction['pred_home_team'] == $match['home_team'])
                    {
                        $points_home_team = $this->poolconfig_model->item('pred_points_qf_team');
                    }
                    else
                    {
                        $points_home_team = 0;
                    }
                    if ($prediction['pred_away_team'] == $match['away_team'])
                    {
                        $points_away_team = $this->poolconfig_model->item('pred_points_qf_team');
                    }
                    else
                    {
                        $points_away_team = 0;
                    }
                }
                elseif ($prediction['pred_match_uid'] >= 29 && $prediction['pred_match_uid'] <= 30)
                {
                    if ($prediction['pred_home_team'] == $match['home_team'])
                    {
                        $points_home_team = $this->poolconfig_model->item('pred_points_sf_team');
                    }
                    else
                    {
                        $points_home_team = 0;
                    }
                    if ($prediction['pred_away_team'] == $match['away_team'])
                    {
                        $points_away_team = $this->poolconfig_model->item('pred_points_sf_team');
                    }
                    else
                    {
                        $points_away_team = 0;
                    }
                }
                elseif ($prediction['pred_match_uid'] == 31)
                {                  
                    if ($prediction['pred_home_team'] == $match['home_team'])
                    {
                        $points_home_team = $this->poolconfig_model->item('pred_points_f_team');
                    }
                    else
                    {
                        $points_home_team = 0;
                    }
                    if ($prediction['pred_away_team'] == $match['away_team'])
                    {
                        $points_away_team = $this->poolconfig_model->item('pred_points_f_team');
                    }
                    else
                    {
                        $points_away_team = 0;
                    }
                    $sql_query = "SELECT SUM(home_goals) AS sum_home_goals, SUM(away_goals) as sum_away_goals
                                  FROM `match`
                                  WHERE 1";
                    $query = $this->db->query($sql_query);
                    $totals = $query->row_array();
                    $totalgoals_tournament = $totals['sum_home_goals'] + $totals['sum_away_goals'];
                    $sql_query = "SELECT `pred_total_goals`, `pred_champion`
                                  FROM `account_details`
                                  WHERE `account_id` = '$current_account'";
                    $query = $this->db->query($sql_query);
                    $pred = $query->row_array();
                    
                    $diff = abs($pred['pred_total_goals'] - $totalgoals_tournament);
                    $max_bonus = $this->poolconfig_model->item('pred_points_bonus');
                    if ($diff < $max_bonus && $pred['pred_total_goals'] > 0)
                    {
                        //echo "yes, diff: ".$diff."<br>";
                        $bonus_points =  $max_bonus - $diff;
                        //echo "bonus: ".$bonus_points;
                    }
                    else
                    {
                        $bonus_points = 0;
                    }
                    
                    $sql_query = "SELECT `winning_team`
                                  FROM `match`
                                  WHERE `match_uid` = 31";
                    $query = $this->db->query($sql_query);
                    $champion = $query->row_array();
                    
                    if ($pred['pred_champion'] == $champion['winning_team'])
                    {
                        $bonus_points = $bonus_points + $this->poolconfig_model->item('pred_points_champion');
                    }
                    
                }
                else
                {
                    $points_home_team = 0;
                    $points_away_team = 0;
                }
                
                $prediction_uid = $prediction['prediction_uid'];
                
                $sql_query = "UPDATE `prediction`
                              SET `pred_points_home_goals`= $home_goals_points,
                                  `pred_points_away_goals`= $away_goals_points,
                                  `pred_points_result`= $result_points,
                                  `pred_points_bonus`= $bonus_points,
                                  `pred_points_home_team` = $points_home_team,
                                  `pred_points_away_team` = $points_away_team,
                                  `pred_points_total` = ($home_goals_points + $away_goals_points + $result_points + $bonus_points + $points_home_team + $points_away_team),
                                  `pred_calculated`= 1
                              WHERE `prediction_uid` = $prediction_uid";
                $query = $this->db->query($sql_query);
                $i++;
                
                $sql_query = "UPDATE `match`
                              SET `match_calculated` = 1
                              WHERE `match_uid` = $match_uid";
                $query = $this->db->query($sql_query);
                              
            }
            $this->session->set_flashdata('info', "Calculated ".$i." predictions");
            redirect('results/show/'.$match_uid);
        }
        else
        {
            redirect('account/sign_in/?continue='.urlencode(site_url('admin/matches_edit')));
        }
    }
    
}
?>
