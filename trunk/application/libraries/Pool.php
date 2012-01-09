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
    
}

/* End of file Someclass.php */
