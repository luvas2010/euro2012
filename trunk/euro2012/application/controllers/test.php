<?php
class Test extends Controller {

//...
    function index()
    {
    $settings = $this->settings_functions->settings();
    $this->calculation_functions->calculate_points($settings);
       
//    $stats = $this->calculation_functions->matchstats(63);
    
//    foreach ($stats['max'] as $user) {       
//        echo $user['points_total_this_match']." - ".$user['User']['nickname']."<br />";
//        }
//    foreach ($stats['min'] as $user) {       
//        echo $user['points_total_this_match']." - ".$user['User']['nickname']."<br />";
//        }
//    print_r($stats['avg']);        
    }
    
    function randomize_predictions() {
        $conn = Doctrine_Manager::connection();
        $q = Doctrine_Query::create()
            ->select('p.*')
            ->from('Predictions p')
            ->execute();
            
        foreach ($q as $prediction) {
            $prediction->home_goals = mt_rand(0, 4);
            $prediction->away_goals = mt_rand(0, 4);
            $prediction->calculated = 0;
            }
        
        $conn->flush();
        echo "done";    
            

    }
    
	function prediction_profiler() {

		// set up the profiler
		$profiler = new Doctrine_Connection_Profiler();
		foreach (Doctrine_Manager::getInstance()->getConnections() as $conn) {
			$conn->setListener($profiler);
		}

		// copied from home controller
             // Lookup the matches in this group
             $vars['predictions_score'] = Doctrine_Query::create()
                ->select('p.match_number,
                          p.user_id,
                          p.home_goals,
                          p.away_goals,
                          m.home_id,
                          m.away_id,
                          m.match_number,
                          u.nickname
                          ')
                ->addSelect('(SELECT t.name FROM Teams t WHERE t.team_id_home = m.home_id) as homename')
                ->addSelect('(SELECT t2.name FROM Teams t2 WHERE t2.team_id_away = m.away_id) as awayname')
                ->from('Predictions_score p, p.Match m, p.User u')
                ->where('p.user_id = '.$user_id)
                ->orderBy('p.match_number')
                ->execute();
            	
            $vars['settings'] = $this->settings_functions->settings();
		$this->load->view('template', $vars);

		// analyze the profiler data
		$time = 0;
		$events = array();
		foreach ($profiler as $event) {
		    $time += $event->getElapsedSecs();
			if ($event->getName() == 'query' || $event->getName() == 'execute') {
				$event_details = array(
					"type" => $event->getName(),
					"query" => $event->getQuery(),
					"time" => sprintf("%f", $event->getElapsedSecs())
				);
				if (count($event->getParams())) {
					$event_details["params"] = $event->getParams();
				}
				$events []= $event_details;
			}
		}
		print_r($events);
		echo "\nTotal Doctrine time: " . $time  . "\n";
		echo "Peak Memory: " . memory_get_peak_usage() . "\n";
	}
	
	function check()
	   {
	       echo "Admin:".admin()."<br />";
	       echo "User_id: ".logged_in()."<br />";
           print_r($setting->toArray());
           
        }

            
}
