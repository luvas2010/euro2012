<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Groupcalc {

    function Groupresults()
    {

            // create an array that holds results for each team
    	    for ($i = 0; $i <= 16; $i++) {
            $count[$i] = array('played' => 0,
                               'won' => 0, 
                               'tie' => 0,
                               'lost' => 0,
                               'goals_for' => 0,
                               'goals_against' => 0,
                               'points' => 0);
            }
	        
	    $results['matches'] = Doctrine_Query::create()
	        ->select('m.match_number,m.home_goals, m.away_goals, m.home_id, m.away_id')
	        ->from('Matches m')
	        ->where('m.type_id = 6')
	        ->execute();
	      
        // Check score for each match
	    foreach($results['matches'] as $result):
	        if ($result->home_goals <> ""):
	            
	            // Count the goals first
	            $count[$result->home_id]['goals_for'] = $count[$result->home_id]['goals_for'] + $result->home_goals;
	            $count[$result->home_id]['goals_against'] = $count[$result->home_id]['goals_against'] + $result->away_goals;
	            $count[$result->away_id]['goals_for'] = $count[$result->away_id]['goals_for'] + $result->away_goals;
	            $count[$result->away_id]['goals_against'] = $count[$result->away_id]['goals_against'] + $result->home_goals;
	            
	            // Count matches played 
	            $count[$result->home_id]['played'] = $count[$result->home_id]['played'] + 1;
	            $count[$result->away_id]['played'] = $count[$result->away_id]['played'] + 1;
	            
	            // Count the points, and won/tie/loss
	            if ($result->home_goals > $result->away_goals):
                    $count[$result->home_id]['points'] = $count[$result->home_id]['points'] + 3;
                    $count[$result->home_id]['won'] = $count[$result->home_id]['won'] + 1;
                    $count[$result->away_id]['lost'] = $count[$result->away_id]['lost'] + 1; 
                elseif ($result->home_goals < $result->away_goals):
                    $count[$result->away_id]['points'] = $count[$result->away_id]['points'] + 3;
                    $count[$result->away_id]['won'] = $count[$result->away_id]['won'] + 1;
                    $count[$result->home_id]['lost'] = $count[$result->home_id]['lost'] + 1; 
                elseif  ($result->home_goals == $result->away_goals):
                    $count[$result->away_id]['points'] = $count[$result->away_id]['points'] + 1;
                    $count[$result->home_id]['points'] = $count[$result->home_id]['points'] + 1;
                    $count[$result->home_id]['tie'] = $count[$result->home_id]['tie'] + 1; 
                    $count[$result->away_id]['tie'] = $count[$result->away_id]['tie'] + 1; 
                endif;
             
            endif;
	    endforeach;
	    
	    for ($i=1; $i<=16; $i++) {
	    
	        $q = Doctrine_Query::create()
            ->update('Teams')
            ->set('played', $count[$i]['played'])
            ->set('won', $count[$i]['won'])
            ->set('tie', $count[$i]['tie'])
            ->set('lost', $count[$i]['lost'])
            ->set('points', $count[$i]['points'])
            ->set('goals_for', $count[$i]['goals_for'])
            ->set('goals_against', $count[$i]['goals_against'])
            ->where('team_id_home = '.$i)
            ->execute();
            
        }        
	    return true;
    
    }
}

?>