<?php
class User_predictions extends Controller {

	public function __construct() {
		parent::Controller();
		
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
	}

    public function index(){
    
    }

	public function group($group) {
        if($user_id = logged_in()){
             // Lookup the matches in this group, and their predictions by this user
            $vars['predictions'] = Doctrine_Query::create()
                ->select('m.match_name,
                          m.match_number,
                          m.match_time,
                          m.home_goals,
                          m.away_goals,
                          m.home_id,
                          m.away_id,
                          m.type_id,
                          m.time_close,
                          m.match_group,
                          th.team_id_home,
                          th.name,
                          th.flag,
                          pth.name,
                          pth.flag,
                          ta.team_id_away,
                          ta.name,
                          ta.flag,
                          pta.name,
                          pta.flag,
                          p.home_goals,
                          p.away_goals,
                          p.points_total_this_match,
                          p.calculated,
                          u.*
                          ')
                ->from('Predictions p, p.Match m, m.TeamHome th, m.TeamAway ta, m.Venue v, p.User u, p.TeamHome pth, p.TeamAway pta')
                ->where('p.user_id = '.$user_id)
                ->andWhere('m.match_group = "'.$group.'"')
                ->orderBy('m.match_time')
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();
            
            foreach ($vars['predictions'] as $prediction)
                {
                $num = $prediction['Match']['match_number'];
                if (mysql_to_unix($prediction['Match']['time_close']) > time())
                    {
                    $closed[$num] = 0;
                    }
                else
                    {
                    $closed[$num] = 1;
                    }
                }
            $vars['closed'] = $closed;    
            $vars['title'] = "Predictions Group ".strtoupper($group);
            $vars['content_view'] = "user_predictions";		
            $vars['settings'] = $this->settings_functions->settings();
		$this->load->view('template', $vars);
        }    
        else {
            // No user is logged in
            // Current user is not an admin
            $vars['title'] = "Not logged in";
            $vars['content_view'] = "not_logged_in";
            $vars['settings'] = $this->settings_functions->settings();
		$this->load->view('template', $vars);
            }             
	}
    
	public function view($user_id) {
        $settings = $this->settings_functions->settings();
        if (logged_in()) {
            if (($user_id == Current_User::user()->id) || ($settings['view_other_users'])) {
                 // Lookup the matches in this group, and their predictions by this user
                $vars['predictions'] = Doctrine_Query::create()
                    ->select('m.match_name,
                              m.match_number,
                              m.match_time,
                              m.home_goals,
                              m.away_goals,
                              m.home_id,
                              m.time_close,
                              m.match_group,
                              m.type_id,
                              th.name,
                              th.flag,
                              ta.name,
                              ta.flag,
                              p.home_goals,
                              p.away_goals,
                              p.points_total_this_match,
                              p.calculated,
                              pth.team_id_home,
                              pth.name,
                              pth.flag,
                              pta.name,
                              pta.flag,
                              pta.team_id_home,
                              u.nickname
                              ')
                    ->from('Predictions p, p.Match m, m.TeamHome th, m.TeamAway ta, m.Venue v, p.User u, p.TeamHome pth, p.TeamAway pta')
                    ->where('p.user_id = '.$user_id)
                    ->orderBy('m.match_time')
                    ->execute();
                
                foreach ($vars['predictions'] as $prediction)
                    {
                    $num = $prediction->Match->match_number;
                    if (mysql_to_unix($prediction->Match->time_close) > time())
                        {
                        $closed[$num] = 0;
                        }
                    else
                        {
                        $closed[$num] = 1;
                        }
                    }
                $vars['closed'] = $closed;    
                $vars['title'] = "Predictions Overview";
                $vars['content_view'] = "user_predictions";		
                $vars['settings'] = $this->settings_functions->settings();
		    $this->load->view('template', $vars);
		    }
		    elseif (!$settings['view_other_users']) {
                $vars['message'] = "You are not allowed to see other users predictions!";
                $vars['title'] = "Not allowed";
                $vars['content_view'] = "error";
                $vars['settings'] = $this->settings_functions->settings();
		        $this->load->view('template', $vars);		        
        }    
        else {
            // No user is logged in
            // Current user is not an admin
            $vars['title'] = "Not logged in";
            $vars['content_view'] = "not_logged_in";
            $vars['settings'] = $this->settings_functions->settings();
		    $this->load->view('template', $vars);
            }
        }                
	}
	
	
	public function edit() {
        $settings = $this->settings_functions->settings();
        if (logged_in()) {
            $user_id = logged_in();
             // Lookup the matches in the group phase, and their predictions by this user
            $vars['predictions_group_phase'] = Doctrine_Query::create()
                ->select('m.match_name,
                          m.match_number,
                          m.match_time,
                          m.home_goals,
                          m.away_goals,
                          m.home_id,
                          m.time_close,
                          m.match_group,
                          m.type_id,
                          th.name,
                          th.flag,
                          ta.name,
                          ta.flag,
                          p.home_goals,
                          p.away_goals,
                          p.points_total_this_match,
                          p.calculated,
                          p.home_id,
                          p.away_id,
                          u.nickname,
                          v.name,
                          v.time_offset_utc
                          ')
                ->from('Predictions p, p.Match m, m.TeamHome th, m.TeamAway ta, m.Venue v, p.User u')
                ->where('p.user_id = '.$user_id)
                ->andWhere('m.type_id = 6') // group matches
                ->orderBy('m.match_time')
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();
                
            $vars['predictions_qf'] = Doctrine_Query::create()
                ->select('m.match_name,
                          m.match_number,
                          m.match_time,
                          m.home_goals,
                          m.away_goals,
                          m.home_id,
                          m.time_close,
                          m.match_group,
                          m.group_home,
                          m.group_away,
                          m.type_id,
                          th.name,
                          th.flag,
                          ta.name,
                          ta.flag,
                          p.home_goals,
                          p.away_goals,
                          p.points_total_this_match,
                          p.calculated,
                          p.home_id,
                          p.away_id,
                          pth.name,
                          pth.flag,
                          pta.name,
                          pta.flag,
                          u.nickname,
                          v.name,
                          v.time_offset_utc
                          ')
                ->from('Predictions p, p.Match m, m.TeamHome th, m.TeamAway ta, p.TeamHome pth, p.TeamAway pta, m.Venue v, p.User u')
                ->where('p.user_id = '.$user_id)
                ->andWhere('m.type_id = 4') // quarter final matches
                ->orderBy('m.match_time')
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();
                
            $vars['predictions_sf'] = Doctrine_Query::create()
                ->select('m.match_name,
                          m.match_number,
                          m.match_time,
                          m.home_goals,
                          m.away_goals,
                          m.home_id,
                          m.time_close,
                          m.match_group,
                          m.group_home,
                          m.group_away,
                          m.type_id,
                          th.name,
                          th.flag,
                          ta.name,
                          ta.flag,
                          p.home_goals,
                          p.away_goals,
                          p.points_total_this_match,
                          p.calculated,
                          p.home_id,
                          p.away_id,
                          pth.name,
                          pth.flag,
                          pta.name,
                          pta.flag,
                          u.nickname,
                          v.name,
                          v.time_offset_utc
                          ')
                ->from('Predictions p, p.Match m, m.TeamHome th, m.TeamAway ta, p.TeamHome pth, p.TeamAway pta, m.Venue v, p.User u')
                ->where('p.user_id = '.$user_id)
                ->andWhere('m.type_id = 2') // semi final matches
                ->orderBy('m.match_time')
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();
                
            $vars['predictions_f'] = Doctrine_Query::create()
                ->select('m.match_name,
                          m.match_number,
                          m.match_time,
                          m.home_goals,
                          m.away_goals,
                          m.home_id,
                          m.time_close,
                          m.match_group,
                          m.group_home,
                          m.group_away,
                          m.type_id,
                          th.name,
                          th.flag,
                          ta.name,
                          ta.flag,
                          p.home_goals,
                          p.away_goals,
                          p.points_total_this_match,
                          p.calculated,
                          p.home_id,
                          p.away_id,
                          pth.name,
                          pth.flag,
                          pta.name,
                          pta.flag,
                          u.nickname,
                          v.name,
                          v.time_offset_utc
                          ')
                ->from('Predictions p, p.Match m, m.TeamHome th, m.TeamAway ta, p.TeamHome pth, p.TeamAway pta, m.Venue v, p.User u')
                ->where('p.user_id = '.$user_id)
                ->andWhere('m.type_id = 1') // final match
                ->orderBy('m.match_time')
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();
                
                // Get the teams, and pass them on for the dropdown
                $teams = Doctrine_Query::create()
                    ->select('t.name,
                              t.team_group,
                              t.team_id_home')
                    ->from('Teams t')
                    ->where('t.team_id_home < 50')
                    ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                    ->execute();
                foreach ($teams as $team) {
                    $vars['teams'.strtolower($team['team_group'])][$team['team_id_home']] = $team['name']; //make separate arrays for each group
                    }
                $vars['teamsa'][0] = "-"; // add an item to the array for 'none selected'
                $vars['teamsb'][0] = "-";
                $vars['teamsc'][0] = "-";
                $vars['teamsd'][0] = "-";
                
                foreach ($vars['teamsa'] as $k => $v) {
                    $vars['teamsab'][$k] = $v; // make an array for teams from group A & B. The Key ($k) equals the 'id' in the database
                    }
                foreach ($vars['teamsb'] as $k => $v) {
                    $vars['teamsab'][$k] = $v; // make an array for teams from group A & B
                    }
                foreach ($vars['teamsc'] as $k => $v) {
                    $vars['teamscd'][$k] = $v; // make an array for teams from group C & D
                    }
                foreach ($vars['teamsd'] as $k => $v) {
                    $vars['teamscd'][$k] = $v; // make an array for teams from group C & D
                    }
                foreach ($vars['teamsab'] as $k => $v) {
                    $vars['teamsabcd'][$k] = $v; // make an array for teams from group A & B & C & D
                    }
                foreach ($vars['teamscd'] as $k => $v) {
                    $vars['teamsabcd'][$k] = $v; // make an array for teams from group A & B & C & D
                    }        
                    ksort($vars['teamsab']); // sort the arrays on 'id'
                    ksort($vars['teamscd']);
                    ksort($vars['teamsabcd']);
                    
            foreach ($vars['predictions_group_phase'] as $prediction)
                {
                $num = $prediction['Match']['match_number'];
                if (mysql_to_unix($prediction['Match']['time_close']- $prediction['Match']['Venue']['time_offset_utc'] + $settings['server_time_offset_utc']) > time())
                    {
                    $closed[$num] = 0;
                    }
                else
                    {
                    $closed[$num] = 1;
                    }
                }
            $vars['closed'] = $closed;    
            $vars['title'] = "Change your predictions";
            $vars['content_view'] = "user_predictions_edit";		
            $vars['settings'] = $this->settings_functions->settings();
		    $this->load->view('template', $vars);
            }
        else {
            // No user is logged in
            // Current user is not an admin
            $vars['title'] = "Not logged in";
            $vars['content_view'] = "not_logged_in";
            $vars['settings'] = $this->settings_functions->settings();
		    $this->load->view('template', $vars);
            }                
	}
	
	public function submit() {

        if(logged_in()){
            $vars['time_warning'] = false;
            $user_id = logged_in();
            $predictions = Doctrine_Query::create()
                ->select('p.id,
                          p.home_goals,
                          p.away_goals,
                          p.home_id,
                          p.away_id,
                          p.match_number,
                          m.match_number,
                          m.match_name
                          m.time_close,
                          m.venue_id,
                          v.venue_id,
                          v.time_offset_utc
                          ')
                ->from('Predictions p INDEXBY p.id, p.Match m, m.Venue v')
                ->where('p.user_id = '.$user_id)
                ->orderBy('m.match_time')
                ->execute();
        $server_offset = Doctrine::getTable('Settings')->findOneBySetting('server_time_offset_utc');
        $arrPost = $this->input->post('post_array');    //get all posted values in one array
        foreach ($arrPost as $id => $value) {           // $id represents the 'id' column in the predictions table
            
          if (time() < (mysql_to_unix($predictions[$id]['Match']['time_close']) - $predictions[$id]['Match']['Venue']['time_offset_utc'] + $server_offset['value'])) {  
            
            foreach ($value as $k => $v) {              // $k represents 'home_goals', 'away_goals' etc.

                    $predictions[$id][$k]=$v;
                    }
                  }
                  else {
                    $vars['time_warning'] = true;
                    }
                }
        $predictions->save();
        $vars['title'] = "Predictions Saved";
        $vars['message'] = "All your predictions were saved";
        $vars['content_view'] = "success";
        $vars['settings'] = $this->settings_functions->settings();
        $this->load->view('template', $vars);

                } else {        
                // Nobody is logged in
                $vars['title'] = "Not logged in";
                $vars['content_view'] = "not_logged_in";
                $vars['settings'] = $this->settings_functions->settings();
	            $this->load->view('template', $vars);
                }
	}

	public function edit_single($match_number) { //edit function for predictions

        if(logged_in()){
            $user_id = logged_in();
            $predictions = Doctrine_Query::create()
                ->select('m.match_name,
                          m.match_number,
                          m.match_time,
                          m.home_goals,
                          m.away_goals,
                          m.home_id,
                          m.time_close,
                          m.match_group,
                          m.group_home,
                          m.group_away,
                          m.type_id,
                          m.description,
                          th.name,
                          th.id,
                          th.flag,
                          ta.name,
                          ta.flag,
                          ta.id,
                          p.*,
                          pth.name,
                          pth.flag,
                          pth.id,
                          pta.name,
                          pta.flag,
                          pta.id,
                          v.time_offset_utc,
                          v.city
                          ')
                ->from('Predictions p, p.Match m, p.TeamHome pth, p.TeamAway pta, m.TeamHome th, m.TeamAway ta, m.Venue v')
                ->where('p.user_id = '.$user_id)
                ->andWhere('p.match_number = '.$match_number)
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();
            
                // Get the teams, and pass them on for the dropdown
                $teams = Doctrine_Query::create()
                    ->select('t.name,
                              t.id,
                              t.team_group,
                              t.team_id_home,
                              t.team_id_away')
                    ->from('Teams t')
                    ->where('t.team_id_home < 50')
                    ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                    ->execute();
                
                if (($predictions[0]['home_id'] == 0 || $predictions[0]['away_id'] == 0) && $predictions[0]['Match']['type_id'] < 6) {
                    $vars['warning'] = 1;
                    }
                else {
                    $vars['warning'] = 0;
                    }
                
                foreach ($teams as $team) {
                    //see if this team is in the 'group_home' for this match
                    if (!(strpos($predictions[0]['Match']['group_home'], $team['team_group']) === false) ) {
                        $teamshome[$team['id']] = $team['name'];
                        }
                    if (!(strpos($predictions[0]['Match']['group_away'], $team['team_group']) === false) ) {
                        $teamsaway[$team['id']] = $team['name'];
                        }
                    }
                $teamshome[0] = "-";
                $teamsaway[0] = "-";
                ksort($teamshome);
                ksort($teamsaway);
                $vars['teamshome'] = $teamshome;
                $vars['teamsaway'] = $teamsaway;
                $vars['prediction'] = $predictions[0];
                $vars['title'] = "Change prediction";
                $vars['content_view'] = "predictionedit";
                $vars['settings'] = $this->settings_functions->settings();
          		$this->load->view('template', $vars);

        } else {
            // No user is logged in
            $vars['title'] = "Not logged in";
            $vars['content_view'] = "not_logged_in";
            $vars['settings'] = $this->settings_functions->settings();
		    $this->load->view('template', $vars);
            }             
	}
	
	public function prediction_single_submit() {

        if(logged_in()){
            if ($this->_submit_single_validate() === FALSE) {
                $this->edit_single($this->input->post('match_number'));
                return;
                }
            
                if ($prediction = Doctrine::getTable('Predictions')->findOneById($this->input->post('id'))) {
                    
                    if ($this->input->post('homegoals') != NULL) {    
                        $prediction->home_goals = $this->input->post('homegoals');
                        }
                    else {
                        $prediction->home_goals = NULL;
                        }
                    if ($this->input->post('awaygoals') != NULL) {    
                        $prediction->away_goals = $this->input->post('awaygoals');
                        }
                    else {
                        $prediction->away_goals = NULL;
                        }
                    if ($this->input->post('home_id') != NULL) {
                        $prediction->home_id = $this->input->post('home_id');
                        }
                    if ($this->input->post('away_id') != NULL) {
                        $prediction->away_id = $this->input->post('away_id');
                        }
                                                     
                    // and save the result!                
                    $prediction->save();
                    $vars['message'] = "Voorspelling voor ".$prediction['Match']['match_name']." (".$prediction['Match']['TeamHome']['name']." - ".$prediction['Match']['TeamAway']['name'].") opgeslagen!";
                    $vars['title'] = "Prediction Changed";
                    $vars['content_view'] = "success";
                    $vars['settings'] = $this->settings_functions->settings();
        		    $this->load->view('template', $vars);
                    }
            }        
            else {        
            // Nobody is logged in
            $vars['title'] = "Not logged in";
            $vars['content_view'] = "not_logged_in";
            $vars['settings'] = $this->settings_functions->settings();
            $this->load->view('template', $vars);
            }
	}
	
    private function _submit_single_validate() {

		// validation rules
		$this->form_validation->set_rules('homegoals', 'Home goals',
			'numeric');
	    $this->form_validation->set_rules('awaygoals', 'Away goals',
			'numeric');
			
		return $this->form_validation->run();
		    
		return true;

	}
    
}
