<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pool {

    // get_top_ranking(n) will return an array of the top n players
    public function get_top_ranking($num)
    {
        
        $CI =& get_instance();
        $sql_query = "SELECT *
                FROM `prediction`
                JOIN `account`
                ON  `account`.`id` = `prediction`.`account_id`
                JOIN `match`
                ON `match`.`match_uid` = `prediction`.`pred_match_uid`
                AND `pred_calculated` = 1
                GROUP BY `prediction`.`pred_match_uid`,`account_id`";
        
        $query = $CI->db->query($sql_query);
        $results = $query->result_array();
        if ($query->num_rows() > 0)
        {
            foreach ($results as $key => $row) {
                        $total_points[$key]  = $row['pred_points_total'];
                    }
                    
            // Sort the data with total_points descending
                    array_multisort($total_points, SORT_DESC, $results);          

            $i = 0;
            foreach ($results as $t)
            {
                //if ($i >= $num) { break;}
                $account_id = $t['account_id'];
                $sql_query = "SELECT *
                              FROM `prediction`
                              JOIN `account`
                              ON `account`.`id` = `prediction`.`account_id`
                              AND `prediction`.`account_id` = $account_id
                              AND `prediction`.`pred_calculated` = 1
                              JOIN `match`
                              ON `match`.`match_uid` = `prediction`.`pred_match_uid`
                              ORDER BY `prediction`.`pred_match_uid`";
                              
                $query = $CI->db->query($sql_query);
                $user_pred = $query->result_array();
                $old = 0;
                foreach ($user_pred as $pred)
                {
                    
                    $user[$pred['account_id']]['match'][$pred['pred_match_uid']] = $pred['pred_points_total'];
                    $user[$pred['account_id']]['aggregate'][$pred['pred_match_uid']] = $old + $pred['pred_points_total'];
                    $user[$pred['account_id']]['username'] = $pred['username'];
                    $user[$pred['account_id']]['group'][$pred['pred_match_uid']] = $pred['match_group'];
                    $user[$pred['account_id']]['userid'] = $pred['account_id'];
                    $old = $old + $pred['pred_points_total'];
					$user[$pred['account_id']]['points_total'] = $old;
                }
				
                $i++;
                
            }
            $topusers = array_slice($user,0, $num);
        }
        else
        {
            $topusers = 0;
        }
        return($topusers);
        
    }

    public function calculate_group($group)
    {
        $CI =& get_instance();

        $sql_query = "SELECT * FROM `match` WHERE `match`.`match_group` = '$group'";
        $query = $CI->db->query($sql_query);
        $matches = $query->result_array();

        $team = array();
        foreach ($matches as $match)
        {
            //create an array of teams to hold results
            $home_team = $match['home_team'];
            $away_team = $match['away_team'];
            $team[$home_team] = array(  'team_uid' => $home_team,
                                        'team_name' => get_team_name($home_team),
                                        'group' => $group,
                                        'goals_for' => 0,
                                        'goals_against' => 0,
                                        'played' => 0,
                                        'won' => 0,
                                        'tie' => 0,
                                        'lost' => 0,
                                        'points' => 0,
                                        'pos_in_group' => 0);
            $team[$away_team] = array(  'team_uid' => $away_team,
                                        'team_name' => get_team_name($away_team),
                                        'group' => $group,
                                        'goals_for' => 0,
                                        'goals_against' => 0,
                                        'played' => 0,
                                        'won' => 0,
                                        'tie' => 0,
                                        'lost' => 0,
                                        'points' => 0,
                                        'pos_in_group' => 0);
        }
        
        
        
        foreach ($matches as $match)
        {
            // calculate group standings
            $home_team = $match['home_team'];
            $away_team = $match['away_team'];
            
            if ($match['home_goals'] !== NULL && $match['away_goals'] !== NULL)
            {
                    $team[$home_team]['played'] = $team[$home_team]['played'] + 1;
                    $team[$away_team]['played'] = $team[$away_team]['played'] + 1;
                    $team[$home_team]['goals_for'] = $team[$home_team]['goals_for'] + $match['home_goals'];
                    $team[$home_team]['goals_against'] = $team[$home_team]['goals_against'] + $match['away_goals'];
                    $team[$away_team]['goals_for'] = $team[$away_team]['goals_for'] + $match['away_goals'];
                    $team[$away_team]['goals_against'] = $team[$away_team]['goals_against'] + $match['home_goals'];                    
                    
                    if ($match['home_goals'] > $match['away_goals'])
                    {
                        $team[$home_team]['won'] = $team[$home_team]['won'] + 1;
                        $team[$away_team]['lost'] = $team[$away_team]['lost'] + 1;
                        $team[$home_team]['points'] = $team[$home_team]['points'] +3;
                        $team[$away_team]['points'] = $team[$away_team]['points'] +0;
                    }
                    if ($match['home_goals'] < $match['away_goals'])
                    {
                        $team[$away_team]['won'] = $team[$away_team]['won'] + 1;
                        $team[$home_team]['lost'] = $team[$home_team]['lost'] + 1;
                        $team[$away_team]['points'] = $team[$away_team]['points'] +3;
                        $team[$home_team]['points'] = $team[$home_team]['points'] +0;
                    }                    
                    if ($match['home_goals'] == $match['away_goals'])
                    {
                        $team[$away_team]['tie'] = $team[$away_team]['tie'] + 1;
                        $team[$home_team]['tie'] = $team[$home_team]['tie'] + 1;
                        $team[$home_team]['points'] = $team[$home_team]['points'] + 1;
                        $team[$away_team]['points'] = $team[$away_team]['points'] + 1;
                    }
                }  
        }
        foreach ($team as $key => $row)
        {
                $points[$key] = $row['points'];
                $goals_for[$key] = $row['goals_for'];
                $goals_against[$key] = $row['goals_against'];
        }
            
        array_multisort($points, SORT_DESC, $goals_for, SORT_DESC, $goals_against, SORT_ASC, $team);
   
        return $team;
        
    }
    
    public function calculate_pred_group($group)
    {
        $CI =& get_instance();
        $account_id = $CI->session->userdata('account_id');
        $sql_query = "SELECT *
                      FROM `prediction`
                      JOIN `match`
                      ON `match`.`match_uid` = `prediction`.`pred_match_uid`
                      AND `prediction`.`account_id` = '$account_id'
                      AND `match`.`match_group` = '$group'";
                      
        $query = $CI->db->query($sql_query);
        $predictions = $query->result_array();

        $team = array();
        foreach ($predictions as $prediction)
        {
            //create an array of teams to hold results
            $home_team = $prediction['home_team'];
            $away_team = $prediction['away_team'];
            $team[$home_team] = array(  'team_uid' => $home_team,
                                        'team_name' => get_team_name($home_team),
                                        'group' => $group,
                                        'goals_for' => 0,
                                        'goals_against' => 0,
                                        'played' => 0,
                                        'won' => 0,
                                        'tie' => 0,
                                        'lost' => 0,
                                        'points' => 0,
                                        'pos_in_group' => 0);
            $team[$away_team] = array(  'team_uid' => $away_team,
                                        'team_name' => get_team_name($away_team),
                                        'group' => $group,
                                        'goals_for' => 0,
                                        'goals_against' => 0,
                                        'played' => 0,
                                        'won' => 0,
                                        'tie' => 0,
                                        'lost' => 0,
                                        'points' => 0,
                                        'pos_in_group' => 0);
        }
        
        
        
        foreach ($predictions as $prediction)
        {
            // calculate group standings
            $home_team = $prediction['home_team'];
            $away_team = $prediction['away_team'];
            
            if ($prediction['pred_home_goals'] !== NULL && $prediction['pred_away_goals'] !== NULL)
            {
                    $team[$home_team]['played'] = $team[$home_team]['played'] + 1;
                    $team[$away_team]['played'] = $team[$away_team]['played'] + 1;
                    $team[$home_team]['goals_for'] = $team[$home_team]['goals_for'] + $prediction['pred_home_goals'];
                    $team[$home_team]['goals_against'] = $team[$home_team]['goals_against'] + $prediction['pred_away_goals'];
                    $team[$away_team]['goals_for'] = $team[$away_team]['goals_for'] + $prediction['pred_away_goals'];
                    $team[$away_team]['goals_against'] = $team[$away_team]['goals_against'] + $prediction['pred_home_goals'];                    
                    
                    if ($prediction['pred_home_goals'] > $prediction['pred_away_goals'])
                    {
                        $team[$home_team]['won'] = $team[$home_team]['won'] + 1;
                        $team[$away_team]['lost'] = $team[$away_team]['lost'] + 1;
                        $team[$home_team]['points'] = $team[$home_team]['points'] +3;
                        $team[$away_team]['points'] = $team[$away_team]['points'] +0;
                    }
                    if ($prediction['pred_home_goals'] < $prediction['pred_away_goals'])
                    {
                        $team[$away_team]['won'] = $team[$away_team]['won'] + 1;
                        $team[$home_team]['lost'] = $team[$home_team]['lost'] + 1;
                        $team[$away_team]['points'] = $team[$away_team]['points'] +3;
                        $team[$home_team]['points'] = $team[$home_team]['points'] +0;
                    }                    
                    if ($prediction['pred_home_goals'] == $prediction['pred_away_goals'])
                    {
                        $team[$away_team]['tie'] = $team[$away_team]['tie'] + 1;
                        $team[$home_team]['tie'] = $team[$home_team]['tie'] + 1;
                        $team[$home_team]['points'] = $team[$home_team]['points'] + 1;
                        $team[$away_team]['points'] = $team[$away_team]['points'] + 1;
                    }
                }  
        }
        foreach ($team as $key => $row)
        {
                $points[$key] = $row['points'];
                $goals_for[$key] = $row['goals_for'];
                $goals_against[$key] = $row['goals_against'];
        }
            
        array_multisort($points, SORT_DESC, $goals_for, SORT_DESC, $goals_against, SORT_ASC, $team);

        return $team;
        
    }

    public function calculate_match($match_uid)
    {
        $CI =& get_instance();
        
            $pred_points_goals = $CI->config->item('pred_points_goals');
            $pred_points_result = $CI->config->item('pred_points_result');
            $pred_points_bonus = $CI->config->item('pred_points_bonus');
            
            
            $sql_query = "SELECT *
                          FROM `prediction`
                          WHERE `prediction`.`pred_match_uid` = $match_uid";

            $query = $CI->db->query($sql_query);
            $predictions = $query->result_array();
            
            $sql_query = "SELECT *
                          FROM `match`
                          WHERE `match_uid` = $match_uid";
            $query = $CI->db->query($sql_query);
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
                        $points_home_team = $CI->config->item('pred_points_qf_team');
                    }
                    else
                    {
                        $points_home_team = 0;
                    }
                    if ($prediction['pred_away_team'] == $match['away_team'])
                    {
                        $points_away_team = $CI->config->item('pred_points_qf_team');
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
                        $points_home_team = $CI->config->item('pred_points_sf_team');
                    }
                    else
                    {
                        $points_home_team = 0;
                    }
                    if ($prediction['pred_away_team'] == $match['away_team'])
                    {
                        $points_away_team = $CI->config->item('pred_points_sf_team');
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
                        $points_home_team = $CI->config->item('pred_points_f_team');
                    }
                    else
                    {
                        $points_home_team = 0;
                    }
                    if ($prediction['pred_away_team'] == $match['away_team'])
                    {
                        $points_away_team = $CI->config->item('pred_points_f_team');
                    }
                    else
                    {
                        $points_away_team = 0;
                    }
                    $sql_query = "SELECT SUM(home_goals) AS sum_home_goals, SUM(away_goals) as sum_away_goals
                                  FROM `match`
                                  WHERE 1";
                    $query = $CI->db->query($sql_query);
                    $totals = $query->row_array();
                    $totalgoals_tournament = $totals['sum_home_goals'] + $totals['sum_away_goals'];
                    $sql_query = "SELECT `pred_total_goals`, `pred_champion`
                                  FROM `account_details`
                                  WHERE `account_id` = '$current_account'";
                    $query = $CI->db->query($sql_query);
                    $pred = $query->row_array();
                    
                    $diff = abs($pred['pred_total_goals'] - $totalgoals_tournament);
                    $max_bonus = $CI->config->item('pred_points_bonus');
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
                    $query = $CI->db->query($sql_query);
                    $champion = $query->row_array();
                    
                    if ($pred['pred_champion'] == $champion['winning_team'])
                    {
                        $bonus_points = $bonus_points + $CI->config->item('pred_points_champion');
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
                $query = $CI->db->query($sql_query);
                $i++;
            }    
            $sql_query = "UPDATE `match`
                          SET `match_calculated` = 1
                          WHERE `match_uid` = $match_uid";
            $query = $CI->db->query($sql_query);

            return $i;
    }

    public function delete_calc($match_uid)
    {
        $CI =& get_instance();
        $sql_query = "UPDATE `prediction`
                      SET 
                        `pred_points_home_goals` = '0',
                        `pred_points_away_goals` = '0',
                        `pred_points_result` = '0',
                        `pred_points_bonus` = '0',
                        `pred_points_home_team` ='0',
                        `pred_points_away_team` ='0',
                        `pred_points_total` = '0',
                        `pred_calculated` = '0' WHERE `prediction`.`pred_match_uid` = '$match_uid'";
        $query = $CI->db->query($sql_query);
        $sql_query = "UPDATE `match`
                      SET
                        `home_goals` = NULL,
                        `away_goals` = NULL,
                        `match_calculated` = '0'
                      WHERE `match_uid` = '$match_uid'";
        $query = $CI->db->query($sql_query);
    }
}

/* End of file Someclass.php */
