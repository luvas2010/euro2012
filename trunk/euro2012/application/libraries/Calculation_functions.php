<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

    // $settings
    //   [points_for_goals]
    //   [points_for_wdl]
    //   [points_for_exact_score]
    //   [points_for_team_qf]
    //   [points_for_team_sf]
    //   [points_for_team_f]
    //   [points_for_champion]
    //   [view_other_users]


class Calculation_functions {

    function reset_calculations() {
        $q = Doctrine_Query::create()
            ->update('Predictions p, Users u')
            ->set('p.calculated', '0')
            ->set('u.points', '0')
            ->execute();

            return true;
    }
    
    function matchstats($match_number) {
             
        $max = Doctrine_Query::create()
            ->Select('MAX(p.points_total_this_match)')
            ->from('Predictions p')
            ->where('p.match_number = '.$match_number)
            ->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR)
            ->execute();

        $min = Doctrine_Query::create()
            ->Select('MIN(p.points_total_this_match)')
            ->from('Predictions p')
            ->where('p.match_number = '.$match_number)
            ->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR)
            ->execute();
        
        $avg = Doctrine_Query::create()
            ->Select('AVG(p.points_total_this_match)')
            ->from('Predictions p')
            ->where('p.match_number = '.$match_number)
            ->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR)
            ->execute();
            
               
        
        $max_users = Doctrine_Query::create()
            ->Select('u.nickname,
                      p.*')
            ->from('Predictions p, p.User u')
            ->where('p.match_number = '.$match_number)
            ->andWhere('p.points_total_this_match = '.$max)
            ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
            ->execute();

        $min_users = Doctrine_Query::create()
            ->Select('u.nickname,
                      p.*')
            ->from('Predictions p, p.User u')
            ->where('p.match_number = '.$match_number)
            ->andWhere('p.points_total_this_match = '.$min)
            ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
            ->execute();
            
        $all_users =  Doctrine_Query::create()
            ->Select('u.nickname,
                      p.*')
            ->from('Predictions p, p.User u')
            ->where('p.match_number = '.$match_number)
            ->orderBy('p.points_total_this_match DESC')
            ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
            ->execute(); 
        
        $stats['max'] = $max_users;
        $stats['min'] = $min_users;
        $stats['all'] = $all_users;
        $stats['avg'] = $avg;
        return $stats;
        
      }    

    function calculate_points($settings) { //calculate matches

            $total = 0;

            //Calculations done per user
            $users = Doctrine_Query::create()
                ->select('u.id,
                          u.points,
                          u.previouspoints
                          ')
                ->from('Users u')
                ->execute();
                
            // get all predictions for each user
            foreach ($users as $user) {
                $predictions = Doctrine_Query::create()
                    ->select('m.match_number,
                              m.home_goals,
                              m.away_goals,
                              m.home_id,
                              m.away_id,
                              m.type_id,
                              p.home_goals,
                              p.away_goals,
                              p.home_id,
                              p.away_id,
                              p.total_points_curr,
                              p.total_points_prev
                              ')
                    ->from('Predictions p, p.Match m')
                    ->where('p.calculated = 0') // has not been calculated
                    ->andWhere('m.home_goals IS NOT NULL') // match has home goals filled out
                    ->andWhere('m.away_goals IS NOT NULL') // match has away goals filled out
                    ->andWhere('p.user_id = '.$user['id'])
                    ->orderBy('p.user_id, m.match_time')
                    ->execute();           
                
                $count = 0;
                
                $points_after_this_match = $user['points'];
                $user['previouspoints'] = $user['points'];
                foreach ($predictions as $prediction) {
                    // First check points scored for goals and wdl (toto)
                    
                    // Home goals
                    if (($prediction['Match']['home_goals'] == $prediction['home_goals']) && ($prediction['home_goals'] != NULL))  {
                        $prediction['points_home_goals'] = $settings['points_for_goals'];
                        } else {
                        $prediction['points_home_goals'] = 0;
                        }
                        
                    // Away Goals
                    if (($prediction['Match']['away_goals'] == $prediction['away_goals']) && ($prediction['away_goals'] != NULL)) {
                        $prediction['points_away_goals'] = $settings['points_for_goals'];
                        } else {
                        $prediction['points_away_goals'] = 0;
                        }
                        
                    // Win - Draw - Loss (toto)    
                    if (
                        ($prediction['Match']['home_goals'] > $prediction['Match']['away_goals']) && ($prediction['home_goals'] > $prediction['away_goals'])
                        || ($prediction['Match']['home_goals'] < $prediction['Match']['away_goals']) && ($prediction['home_goals'] < $prediction['away_goals'])
                        || ($prediction['Match']['home_goals'] == $prediction['Match']['away_goals']) && ($prediction['home_goals'] == $prediction['away_goals'])
                        && ($prediction['home_goals'] != NULL && $prediction['away_goals'] !=NULL) 
                       ) {
                        $prediction['points_toto'] = $settings['points_for_wdl'];
                        } else {
                        $prediction['points_toto'] = 0;
                        }
                        
                    // Exact score (bonus)    
                    if (($prediction['Match']['home_goals'] == $prediction['home_goals']) && ($prediction['Match']['away_goals'] == $prediction['away_goals'])) {
                        $prediction['points_exact'] = $settings['points_for_exact_score'];
                        } else {
                        $prediction['points_exact'] = 0;
                        }
                            
                    
                    $prediction['points_home_id'] = 0;
                    $prediction['points_away_id'] = 0;
                    
                    // Team points not in group stage
                    if ($prediction['Match']['type_id'] == 6) {
                        $prediction['points_home_id'] = 0;
                        $prediction['points_away_id'] = 0;
                        }               
                            
                    if ($prediction['Match']['type_id'] == 4 && $prediction['Match']['home_goals'] != NULL && $prediction['Match']['away_goals'] != NULL) { // this is a quarter final match
                        if ($prediction['home_id'] == $prediction['Match']['home_id']) {
                            $prediction['points_home_id'] = $settings['points_for_team_qf'];
                            }
                        if ($prediction['away_id'] == $prediction['Match']['away_id']) {
                            $prediction['points_away_id'] = $settings['points_for_team_qf'];
                            }
                        }
                    if ($prediction['Match']['type_id'] == 2 && $prediction['Match']['home_goals'] != NULL && $prediction['Match']['away_goals'] != NULL) { // this is a semi final match
                        if ($prediction['home_id'] == $prediction['Match']['home_id']) {
                            $prediction['points_home_id'] = $settings['points_for_team_sf'];
                            }
                        if ($prediction['away_id'] == $prediction['Match']['away_id']) {
                            $prediction['points_away_id'] = $settings['points_for_team_sf'];
                            }
                        }
                    if ($prediction['Match']['type_id'] == 1 && $prediction['Match']['home_goals'] != NULL && $prediction['Match']['away_goals'] != NULL) { // this is the final match
                        if ($prediction['home_id'] == $prediction['Match']['home_id']) {
                            $prediction['points_home_id'] = $settings['points_for_team_f'];
                            }
                        if ($prediction['away_id'] == $prediction['Match']['away_id']) {
                            $prediction['points_away_id'] = $settings['points_for_team_f'];
                            }
                        }
                    
                    // add all points up        
                    $prediction['points_total_this_match'] = ($prediction['points_home_goals']
                                                            + $prediction['points_away_goals']
                                                            + $prediction['points_toto']
                                                            + $prediction['points_exact']
                                                            + $prediction['points_home_id']
                                                            + $prediction['points_away_id']);
                    $prediction['calculated'] = 1; //set this one as done
                    $prediction['total_points_prev'] = $points_after_this_match;
                    $points_after_this_match = $points_after_this_match + $prediction['points_total_this_match'];
                    $prediction['total_points_curr'] = $points_after_this_match;
                    $user['points'] = $points_after_this_match;
                    //echo "calculated: ".$prediction['id']."<br />";
                    $total++;
                    
                    }
                    $predictions->save();
                }
                
                // if the final has a result, we need to calculate the extra questions too!
                $matchtable = Doctrine::getTable('Matches');
                $final = $matchtable->findOneByMatch_number(99);
                if ($final->home_goals != NULL && $final->away_goals != NULL) { //there is a result
                    foreach ($users as $user) {
                        $answers = Doctrine_Query::create()
                            ->select('ea.answer',
                                     'ea.points',
                                     'ea.question_id',
                                     'eq.id',
                                     'eq.answer',
                                     'eq.points',
                                     'eqt.id')
                            ->from('Extra_answers ea, ea.Question eq, eq.QType eqt')
                            ->where('ea.user_id = '.$user['id'])
                            ->andWhere('eq.active = 1')
                            ->execute();
                        foreach ($answers as $answer) {
                            if ($answer['Question']['QType']['id'] == 1) { //exact answer needed
                                if (strtolower($answer['answer']) == strtolower($answer['Question']['answer'])) {
                                    $answer['points'] = $answer['Question']['points'];
                                    $user['points'] = $user['points'] + $answer['points'];
                                    }
                                else {
                                    $answer['points'] = 0;
                                    }
                                }
                                
                            if ($answer['Question']['QType']['id'] == 2) { // approximate answer needed
                                $diff = abs($answer['answer'] - $answer['Question']['answer']);
                                if ($diff < $answer['Question']['points']) {
                                    $answer['points'] = $answer['Question']['points'] - $diff;
                                    $user['points'] = $user['points'] + $answer['points'];
                                    }
                                else {
                                    $answer['points'] = 0;
                                    }
                                }

                            if ($answer['Question']['QType']['id'] == 3) { // answer out of the list needed
                                $answer_list = explode(",", $answer['Question']['answer']);
                                $answer_lookup = $answer['answer']."+";
                                if (in_array($answer_lookup,$answer_list)) {
                                    $answer['points'] = $answer['Question']['points'];
                                    $user['points'] = $user['points'] + $answer['points'];
                                    }
                                else {
                                    $answer['points'] = 0;
                                    }
                                }


                            } //end foreach answers
                            $answers->save();    
                        } //end foreach users
                    }             
                
                
                $users->save();
                
                
                
                //Now update position for each user
                $users = Doctrine_Query::create()
                    ->select('u.id,
                              u.points,
                              u.position,
                              u.lastposition
                              ')
                    ->from('Users u')
                    ->orderBy('u.points DESC')
                    ->execute();
                
                $rank = 0;
                $truerank = 0;
                $lastpoints = 0;
                foreach ($users as $user){
                    $truerank++;
                    if ($lastpoints != $user['points']) {
                        $rank = $truerank;
                        }
                    $user['lastposition'] = $user['position'];
                    $user['position'] = $rank;
                    $lastpoints = $user['points'];
                    }
                    
                $users->save();                    
                return $total;
    }
      
 
}
