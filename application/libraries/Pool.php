<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pool {
    /* function get_top_ranking(number)
      Returns: a multidimensional array of the 'number' top ranked payers:
      [match] => Array
      (
      [1] => points for this match_uid
      [..] =>

      )

      [aggregate] => Array
      (
      [1] => total points after this match
      [..] =>
      )

      [username] => username
      [group] => Array
      (
      [1] => group for this match_uid
      [..] =>
      )

      [userid] => user's id
      [points_total] => total points after all calculated matches
     */

    public function get_top_ranking($num) {

        $CI = & get_instance();
        $CI->load->model('poolconfig_model');

        $query = $CI->db->query('SELECT MAX(match_uid) FROM `match` WHERE `match_calculated` = 1');
        $maxId = 0;
        if ($query->num_rows() > 0) {
            $maxId = array_pop(array_pop($query->result_array()));
        }

        if ($maxId > 1) {
            $sql_query = "SELECT *, SUM(`prediction`.`pred_points_total`) AS points_total
                FROM `prediction`
                JOIN `account`
                ON  `account`.`id` = `prediction`.`account_id`
                JOIN `match`
                ON `match`.`match_uid` = `prediction`.`pred_match_uid`
                AND `pred_calculated` = 1
            WHERE `match_uid` < $maxId
                GROUP BY `account_id`
            ORDER BY points_total DESC";

            $query = $CI->db->query($sql_query);
            $lastRanking = array();
            if ($query->num_rows() > 0) {
                $rows = $query->result_array();

                foreach ($rows as $i => $row) {
                    $lastRanking[$row['account_id']] = $i;
                }
            }
        }

        $sql_query = "SELECT *, SUM(`prediction`.`pred_points_total`) AS points_total
                FROM `prediction`
                JOIN `account`
                ON  `account`.`id` = `prediction`.`account_id`
                JOIN `match`
                ON `match`.`match_uid` = `prediction`.`pred_match_uid`
                AND `pred_calculated` = 1
                GROUP BY `account_id`
            ORDER BY points_total DESC
            LIMIT $num";

        $query = $CI->db->query($sql_query);
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            $i = 0;
            foreach ($rows as $row) {
                $user[$i]['username'] = $row['username'];
                $user[$i]['points_total'] = $row['points_total'];
                $user[$i]['userid'] = $row['account_id'];

                $account_id = $row['account_id'];
                $sql_query = "SELECT *
                       FROM `prediction`
                       JOIN `match`
                       ON `match`.`match_uid` = `prediction`.`pred_match_uid`
                       AND `prediction`.`account_id` = $row[account_id]
                       AND `prediction`.`pred_calculated` = 1";
                $query = $CI->db->query($sql_query);
                $preds = $query->result_array();
                $old = 0;
                foreach ($preds as $pred) {
                    $account_details = $CI->account_details_model->get_by_account_id($pred['account_id']);
                    $company = $account_details->company;
                    $user[$i]['match'][$pred['pred_match_uid']] = $pred['pred_points_total'];
                    $user[$i]['group'][$pred['pred_match_uid']] = $pred['match_group'];
                    $user[$i]['aggregate'][$pred['pred_match_uid']] = $old + $pred['pred_points_total'];
                    $user[$i]['company'] = $company;
                    $user[$i]['lastranking'] = isset($lastRanking[$row['account_id']]) ? $lastRanking[$row['account_id']] + 1 : 'geen';
                    $user[$i]['maxid'] = $maxId;
                    $old = $old + $pred['pred_points_total'];
                }
                $i++;
            }
        } else {
            $user = 0; // no results yet
        }

        return $user;
    }

    public function calculate_group($group) {
        $CI = & get_instance();
        $CI->load->model('poolconfig_model');

        $sql_query = "SELECT * FROM `match` WHERE `match`.`match_group` = '$group'";
        $query = $CI->db->query($sql_query);
        $matches = $query->result_array();

        $team = array();
        foreach ($matches as $match) {
            //create an array of teams to hold results
            $home_team = $match['home_team'];
            $away_team = $match['away_team'];
            $team[$home_team] = array('team_uid' => $home_team,
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
            $team[$away_team] = array('team_uid' => $away_team,
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



        foreach ($matches as $match) {
            // calculate group standings
            $home_team = $match['home_team'];
            $away_team = $match['away_team'];

            if ($match['home_goals'] !== NULL && $match['away_goals'] !== NULL) {
                $team[$home_team]['played'] = $team[$home_team]['played'] + 1;
                $team[$away_team]['played'] = $team[$away_team]['played'] + 1;
                $team[$home_team]['goals_for'] = $team[$home_team]['goals_for'] + $match['home_goals'];
                $team[$home_team]['goals_against'] = $team[$home_team]['goals_against'] + $match['away_goals'];
                $team[$away_team]['goals_for'] = $team[$away_team]['goals_for'] + $match['away_goals'];
                $team[$away_team]['goals_against'] = $team[$away_team]['goals_against'] + $match['home_goals'];

                if ($match['home_goals'] > $match['away_goals']) {
                    $team[$home_team]['won'] = $team[$home_team]['won'] + 1;
                    $team[$away_team]['lost'] = $team[$away_team]['lost'] + 1;
                    $team[$home_team]['points'] = $team[$home_team]['points'] + 3;
                    $team[$away_team]['points'] = $team[$away_team]['points'] + 0;
                }
                if ($match['home_goals'] < $match['away_goals']) {
                    $team[$away_team]['won'] = $team[$away_team]['won'] + 1;
                    $team[$home_team]['lost'] = $team[$home_team]['lost'] + 1;
                    $team[$away_team]['points'] = $team[$away_team]['points'] + 3;
                    $team[$home_team]['points'] = $team[$home_team]['points'] + 0;
                }
                if ($match['home_goals'] == $match['away_goals']) {
                    $team[$away_team]['tie'] = $team[$away_team]['tie'] + 1;
                    $team[$home_team]['tie'] = $team[$home_team]['tie'] + 1;
                    $team[$home_team]['points'] = $team[$home_team]['points'] + 1;
                    $team[$away_team]['points'] = $team[$away_team]['points'] + 1;
                }
            }
        }
        foreach ($team as $key => $row) {
            $points[$key] = $row['points'];
            $goals_for[$key] = $row['goals_for'];
            $goals_against[$key] = $row['goals_against'];
        }

        array_multisort($points, SORT_DESC, $goals_for, SORT_DESC, $goals_against, SORT_ASC, $team);

        return $team;
    }

    public function calculate_pred_group($group) {
        $CI = & get_instance();
        $CI->load->model('poolconfig_model');
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
        foreach ($predictions as $prediction) {
            //create an array of teams to hold results
            $home_team = $prediction['home_team'];
            $away_team = $prediction['away_team'];
            $team[$home_team] = array('team_uid' => $home_team,
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
            $team[$away_team] = array('team_uid' => $away_team,
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



        foreach ($predictions as $prediction) {
            // calculate group standings
            $home_team = $prediction['home_team'];
            $away_team = $prediction['away_team'];

            if ($prediction['pred_home_goals'] !== NULL && $prediction['pred_away_goals'] !== NULL) {
                $team[$home_team]['played'] = $team[$home_team]['played'] + 1;
                $team[$away_team]['played'] = $team[$away_team]['played'] + 1;
                $team[$home_team]['goals_for'] = $team[$home_team]['goals_for'] + $prediction['pred_home_goals'];
                $team[$home_team]['goals_against'] = $team[$home_team]['goals_against'] + $prediction['pred_away_goals'];
                $team[$away_team]['goals_for'] = $team[$away_team]['goals_for'] + $prediction['pred_away_goals'];
                $team[$away_team]['goals_against'] = $team[$away_team]['goals_against'] + $prediction['pred_home_goals'];

                if ($prediction['pred_home_goals'] > $prediction['pred_away_goals']) {
                    $team[$home_team]['won'] = $team[$home_team]['won'] + 1;
                    $team[$away_team]['lost'] = $team[$away_team]['lost'] + 1;
                    $team[$home_team]['points'] = $team[$home_team]['points'] + 3;
                    $team[$away_team]['points'] = $team[$away_team]['points'] + 0;
                }
                if ($prediction['pred_home_goals'] < $prediction['pred_away_goals']) {
                    $team[$away_team]['won'] = $team[$away_team]['won'] + 1;
                    $team[$home_team]['lost'] = $team[$home_team]['lost'] + 1;
                    $team[$away_team]['points'] = $team[$away_team]['points'] + 3;
                    $team[$home_team]['points'] = $team[$home_team]['points'] + 0;
                }
                if ($prediction['pred_home_goals'] == $prediction['pred_away_goals']) {
                    $team[$away_team]['tie'] = $team[$away_team]['tie'] + 1;
                    $team[$home_team]['tie'] = $team[$home_team]['tie'] + 1;
                    $team[$home_team]['points'] = $team[$home_team]['points'] + 1;
                    $team[$away_team]['points'] = $team[$away_team]['points'] + 1;
                }
            }
        }
        foreach ($team as $key => $row) {
            $points[$key] = $row['points'];
            $goals_for[$key] = $row['goals_for'];
            $goals_against[$key] = $row['goals_against'];
        }

        array_multisort($points, SORT_DESC, $goals_for, SORT_DESC, $goals_against, SORT_ASC, $team);

        return $team;
    }

    public function calculate_match($match_uid) {
        $CI = & get_instance();
        $CI->load->model('poolconfig_model');
        $pred_points_goals = $CI->poolconfig_model->item('pred_points_goals');
        $pred_points_result = $CI->poolconfig_model->item('pred_points_result');
        $pred_points_bonus = $CI->poolconfig_model->item('pred_points_bonus');

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

        $sql_query = "SELECT `home_team`, `away_team` FROM `match` WHERE `match_uid` >= 25 AND `match_uid` <= 28";
        $query = $CI->db->query($sql_query);
        //$qf_teams = $query->row_array();

        $query_qf_teams = $query->result_array();
        $qf_teams = array();
        foreach ($query_qf_teams as $value) {
            array_push($qf_teams, $value['home_team']);
            array_push($qf_teams, $value['away_team']);
        }

        $sql_query = "SELECT `home_team`, `away_team` FROM `match` WHERE `match_uid` >= 29 AND `match_uid` <= 30";
        $query = $CI->db->query($sql_query);
        $query_sf_teams = $query->result_array();
        $sf_teams = array();
        foreach ($query_sf_teams as $value) {
            array_push($sf_teams, $value['home_team']);
            array_push($sf_teams, $value['away_team']);
        }

        $sql_query = "SELECT `home_team`, `away_team` FROM `match` WHERE `match_uid` = 31";
        $query = $CI->db->query($sql_query);
        $query_f_teams = $query->result_array();
        $f_teams = array();
        foreach ($query_f_teams as $value) {
            array_push($f_teams, $value['home_team']);
            array_push($f_teams, $value['away_team']);
        }


        $i = 0;
        foreach ($predictions as $prediction) {
            $bonus_points = 0; // check this on the last match
            $current_account = $prediction['account_id'];
            if (($prediction['pred_home_goals'] == $match['home_goals']) && $prediction['pred_home_goals'] != NULL) {
                $home_goals_points = $pred_points_goals;
            } else {
                $home_goals_points = 0;
            }
            if (($prediction['pred_away_goals'] == $match['away_goals']) && $prediction['pred_away_goals'] != NULL) {
                $away_goals_points = $pred_points_goals;
            } else {
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
            ) {
                $result_points = $pred_points_result;
            } else {
                $result_points = 0;
            }

            if ($prediction['pred_match_uid'] >= 25) { /* dont calculate point for user don't predict teams knockout stage. They don't predict but get value such as WA, RA, WB, RB, W25, ..... in home_team, away_team in their predictions table */
                $bonus_pred_away_team_flag = FALSE;
                $bonus_pred_home_team_flag = FALSE;
                $reserve_teams = array('WA', 'RA', 'WB', 'RB', 'WC', 'RC', 'WD', 'RD', 'W25', 'W26', 'W27', 'W28', 'W29', 'W30', NULL);
                if (in_array($prediction['pred_home_team'], $reserve_teams)) {
                    $bonus_pred_home_team_flag = TRUE;
                }
                if (in_array($prediction['pred_away_team'], $reserve_teams)) {
                    $bonus_pred_away_team_flag = TRUE;
                }
                $points_home_team = 0;
                $points_away_team = 0;
            }

            if ($prediction['pred_match_uid'] >= 25 && $prediction['pred_match_uid'] <= 28) {

                if (!$bonus_pred_home_team_flag) {

                    if ($prediction['pred_home_team'] == $match['home_team']) {
                        $points_home_team = $CI->poolconfig_model->item('pred_points_qf_team');
                    } elseif (in_array($prediction['pred_home_team'], $qf_teams)) {
                        $points_home_team = $CI->poolconfig_model->item('pred_points_qf_team_wrong_pos');
                    }
                }

                if (!$bonus_pred_away_team_flag) {
                    if ($prediction['pred_away_team'] == $match['away_team']) {
                        $points_away_team = $CI->poolconfig_model->item('pred_points_qf_team');
                    } elseif (in_array($prediction['pred_away_team'], $qf_teams)) {
                        $points_away_team = $CI->poolconfig_model->item('pred_points_qf_team_wrong_pos');
                    }
                }
            } elseif ($prediction['pred_match_uid'] >= 29 && $prediction['pred_match_uid'] <= 30) {
                if (!$bonus_pred_home_team_flag) {
                    if ($prediction['pred_home_team'] == $match['home_team']) {
                        $points_home_team = $CI->poolconfig_model->item('pred_points_sf_team');
                    } elseif (in_array($prediction['pred_home_team'], $sf_teams)) {
                        $points_home_team = $CI->poolconfig_model->item('pred_points_sf_team_wrong_pos');
                    }
                }

                if (!$bonus_pred_away_team_flag) {
                    if ($prediction['pred_away_team'] == $match['away_team']) {
                        $points_away_team = $CI->poolconfig_model->item('pred_points_sf_team');
                    } elseif (in_array($prediction['pred_away_team'], $sf_teams)) {
                        $points_away_team = $CI->poolconfig_model->item('pred_points_sf_team_wrong_pos');
                    }
                }
            } elseif ($prediction['pred_match_uid'] == 31) {

                if (!$bonus_pred_home_team_flag) {
                    if ($prediction['pred_home_team'] == $match['home_team']) {
                        $points_home_team = $CI->poolconfig_model->item('pred_points_f_team');
                    } elseif (in_array($prediction['pred_home_team'], $f_teams)) {
                        $points_home_team = $CI->poolconfig_model->item('pred_points_f_team_wrong_pos');
                    }
                }
                if (!$bonus_pred_away_team_flag) {
                    if ($prediction['pred_away_team'] == $match['away_team']) {
                        $points_away_team = $CI->poolconfig_model->item('pred_points_f_team');
                    } elseif (in_array($prediction['pred_away_team'], $f_teams)) {
                        $points_away_team = $CI->poolconfig_model->item('pred_points_f_team_wrong_pos');
                    }
                }
                
                if (prediction_closed(31)){

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
                    $max_bonus = $CI->poolconfig_model->item('pred_points_bonus');
                    if ($diff < $max_bonus && $pred['pred_total_goals'] > 0) {
                        //echo "yes, diff: ".$diff."<br>";
                        $bonus_points = $max_bonus - $diff;
                        //echo "bonus: ".$bonus_points;
                    } else {
                        $bonus_points = 0;
                    }

                    $sql_query = "SELECT `winning_team`
                                    FROM `match`
                                    WHERE `match_uid` = 31";
                    $query = $CI->db->query($sql_query);
                    $champion = $query->row_array();

                    if ($pred['pred_champion'] == $champion['winning_team']) {
                        $bonus_points = $bonus_points + $CI->poolconfig_model->item('pred_points_champion');
                    }
                }
            } else {
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

            /* Will display the bonus point for QF, SF, F and hide the predictions if the match is not start - hale
              If we know the team go to QF, SF, F and the match is not start. We can still calculate and display bonus point
              Go to that match, click Save and Calculate button, please note that DO NOT ENTER the score, just let the score textbox blank.
              Also, hide the predictions of users for these match before kickoff time

              if (($prediction['pred_match_uid'] >= 25 && $prediction['pred_match_uid'] <= 31)&& (!prediction_closed($prediction['pred_match_uid'])))
              {
              $match_uid =	$prediction['pred_match_uid'];
              $sql_query = "UPDATE `prediction`
              SET `pred_calculated` = 0
              WHERE `pred_match_uid` = $match_uid";
              $query = $CI->db->query($sql_query);
              } */
        }
        $sql_query = "UPDATE `match`
                          SET `match_calculated` = 1
                          WHERE `match_uid` = $match_uid";
        $query = $CI->db->query($sql_query);


        return $i;
    }

    public function delete_calc($match_uid) {
        $CI = & get_instance();
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