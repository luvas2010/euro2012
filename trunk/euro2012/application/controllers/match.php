<?php
// File: /system/application/controllers/match.php
// Version: 1.01
// Author: Schop
// Revisions:
//      1.01 added result()

class Match extends Controller {


    public function index(){
    //nothing here, these are just match functions
    }
    
    public function result($match_id) {
        if (admin()) {
            $vars['match'] = Doctrine_Query::create()
            ->select('m.match_name,
                      m.match_time,
                      m.home_goals,
                      m.away_goals,
                      m.home_id,
                      m.away_id,
                      m.type_id,
                      m.match_group,
                      m.group_home,
                      m.group_away,
                      m.match_number,
                      m.time_close,
                      th.name,
                      th.flag,
                      ta.name,
                      ta.flag,
                      v.name,
                      v.venue_id')
            ->from('Matches m, m.TeamHome th, m.TeamAway ta, m.Venue v')
            ->where('m.match_number = '.$match_id)
            ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
            ->execute();

            $vars['title'] = "Change match results";
            $vars['content_view'] = "matchresultedit";
            $vars['settings'] = $this->settings_functions->settings();
      		$this->load->view('template', $vars);            
            
            }
        else {      
            // Current user is not an admin
            $vars['title'] = "Access denied";
            $vars['content_view'] = "access_denied";
            $vars['settings'] = $this->settings_functions->settings();
	        $this->load->view('template', $vars);
            }
    }
    
    public function match_result_submit() {
    
        if (admin()) {
            if ($this->_submit_result_validate() === FALSE) {
                $this->index();
                return;
                }
            
                if ($match = Doctrine::getTable('Matches')->findOneById($this->input->post('id'))) {
                    
                    if ($this->input->post('homegoals') != NULL) {
                        $match->home_goals = $this->input->post('homegoals');
                        }
                    else {
                        $match->home_goals = NULL; //probably wiping out a wrong result, save it as NULL
                        }
                    if ($this->input->post('awaygoals') != NULL) {
                        $match->away_goals = $this->input->post('awaygoals');
                        }
                    else {
                        $match->away_goals = NULL;
                        }
                    
                    // and save the result!                
                    $match->save();
                    $vars['message'] = "Match ".$match->match_name." changed!";
                    $vars['title'] = "Match Saved";
                    $vars['content_view'] = "success";
                    $vars['settings'] = $this->settings_functions->settings();
        		    $this->load->view('template', $vars);
                }        
            }
        else {      
            // Current user is not an admin
            $vars['title'] = "Access denied";
            $vars['content_view'] = "access_denied";
            $vars['settings'] = $this->settings_functions->settings();
	        $this->load->view('template', $vars);
            }

    }
    
    private function _submit_result_validate() {

		// validation rules
		$this->form_validation->set_rules('homegoals', 'Home Goals',
			'numeric');

		$this->form_validation->set_rules('awaygoals', 'Away Goals',
			'numeric');
			
		return $this->form_validation->run();

	}
    
	public function details($match_id) { //edit function for match details (time, teams)

        if(logged_in()){
            if(admin()){
            
                $vars['match'] = Doctrine_Query::create()
                    ->select('m.match_name,
                              m.match_time,
                              m.home_goals,
                              m.away_goals,
                              m.home_id,
                              m.away_id,
                              m.type_id,
                              m.match_group,
                              m.group_home,
                              m.group_away,
                              m.match_number,
                              m.time_close,
                              th.name,
                              th.team_id_home,
                              ta.name,
                              ta.team_id_away,
                              v.name,
                              v.venue_id')
                    ->from('Matches m, m.TeamHome th, m.TeamAway ta, m.Venue v')
                    ->where('m.match_number = '.$match_id)
                    ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                    ->execute();
                
                
                    // Get the teams, and pass them on for the dropdown
                    $teams = Doctrine_Query::create()
                        ->select('t.name,
                                  t.team_group,
                                  t.team_id_home,
                                  t.team_id_away')
                        ->from('Teams t')
                        ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                        ->execute();
                 
                 if ($vars['match'][0]['type_id'] == 6) {                       
                    foreach ($teams as $team) {
                        if ($team['team_group'] == $vars['match'][0]['match_group']) {
                            $vars['teamshome'][$team['team_id_home']] = $team['name'];
                            $vars['teamsaway'][$team['team_id_home']] = $team['name'];
                            }
                        }
                    }
                
                if ($vars['match'][0]['type_id'] < 6) {
                foreach ($teams as $team) {
                    //see if this team is in the 'group_home' for this match
                    if (!(strpos($vars['match'][0]['group_home'], $team['team_group']) === false) ) {
                        $teamshome[$team['team_id_home']] = $team['name'];
                        }
                    if (!(strpos($vars['match'][0]['group_away'], $team['team_group']) === false) ) {
                        $teamsaway[$team['team_id_away']] = $team['name'];
                        }
                    if ($vars['match'][0]['match_group'] == $team['team_group']) {
                        $teamshome[$team['team_id_home']] = $team['name'];
                        $teamsaway[$team['team_id_away']] = $team['name'];
                        }
                    }
                
                    $teamshome[0] = "-";
                    $teamsaway[0] = "-";
                    ksort($teamshome);
                    ksort($teamsaway);
                    $vars['teamshome']=$teamshome;
                    $vars['teamsaway']=$teamsaway;
                    }

                
                 // if ($vars['match'][0]['type_id'] == 4) {
                        // if ($vars['match'][0]['group_home'] == "A") {
                            // foreach ($teams as $team) {
                                // if ($team['team_group'] == "A") {
                                    // $vars['teamshome'][$team['team_id_home']] = $team['name'];
                                    // }
                                // elseif ($team['team_group'] == "B") {    
                                    // $vars['teamsaway'][$team['team_id_away']] = $team['name'];
                                    // }
                                // }
                            // $vars['teamshome'][$vars['match'][0]['home_id']] = $vars['match'][0]['TeamHome']['name'];
                            // $vars['teamsaway'][$vars['match'][0]['away_id']] = $vars['match'][0]['TeamAway']['name'];
                            // }
                        // if ($vars['match'][0]['group_home'] == "C") {
                            // foreach ($teams as $team) {
                                // if ($team['team_group'] == "C") {
                                    // $vars['teamshome'][$team['team_id_home']] = $team['name'];
                                    // }
                                // elseif ($team['team_group'] == "D") {    
                                    // $vars['teamsaway'][$team['team_id_away']] = $team['name'];
                                    // }
                                // }
                            // $vars['teamshome'][$vars['match'][0]['home_id']] = $vars['match'][0]['TeamHome']['name'];
                            // $vars['teamsaway'][$vars['match'][0]['away_id']] = $vars['match'][0]['TeamAway']['name'];
                            // }
                        // }                                        
                    
                   // if ($vars['match'][0]['type_id'] == 2) {
                   
                        // $findteamshome = Doctrine_Query::create()
                            // ->select('m.home_id,
                                       // m.away_id,
                                       // th.name,
                                       // th.team_id_home,
                                       // ta.name,
                                       // ta.team_id_away')
                             // ->from('Matches m, m.TeamHome th, m.TeamAway ta')
                             // ->where('m.match_number = '.($vars['match'][0]['match_number'] - 10))
                             // ->execute();

                        // $findteamsaway = Doctrine_Query::create()
                            // ->select('m.home_id,
                                       // m.away_id,
                                       // th.name,
                                       // th.team_id_home,
                                       // ta.name,
                                       // ta.team_id_away')
                             // ->from('Matches m, m.TeamHome th, m.TeamAway ta')
                             // ->where('m.match_number = '.($vars['match'][0]['match_number'] - 8))
                             // ->execute();
                             
                        // foreach ($findteamshome as $team) {
                                // $vars['teamshome'][$team['home_id']] = $team['TeamHome']['name'];
                                // $vars['teamshome'][$team['away_id']] = $team['TeamAway']['name'];
                                // }
                        // foreach ($findteamsaway as $team) {
                                // $vars['teamsaway'][$team['home_id']] = $team['TeamHome']['name'];
                                // $vars['teamsaway'][$team['away_id']] = $team['TeamAway']['name'];
                                // }                                
                                
                        // $vars['teamshome'][$vars['match'][0]['home_id']] = $vars['match'][0]['TeamHome']['name'];
                        // $vars['teamsaway'][$vars['match'][0]['away_id']] = $vars['match'][0]['TeamAway']['name'];
                        // }
                        
                   // if ($vars['match'][0]['type_id'] == 1) { //the final
                   
                        // $findteamshome = Doctrine_Query::create()
                            // ->select('m.home_id,
                                       // m.away_id,
                                       // th.name,
                                       // th.team_id_home,
                                       // ta.name,
                                       // ta.team_id_away')
                             // ->from('Matches m, m.TeamHome th, m.TeamAway ta')
                             // ->where('m.match_number = 61')
                             // ->execute();

                        // $findteamsaway = Doctrine_Query::create()
                            // ->select('m.home_id,
                                       // m.away_id,
                                       // th.name,
                                       // th.team_id_home,
                                       // ta.name,
                                       // ta.team_id_away')
                             // ->from('Matches m, m.TeamHome th, m.TeamAway ta')
                             // ->where('m.match_number = 62')
                             // ->execute();
                             
                        // foreach ($findteamshome as $team) {
                                // $vars['teamshome'][$team['home_id']] = $team['TeamHome']['name'];
                                // $vars['teamshome'][$team['away_id']] = $team['TeamAway']['name'];
                                // }
                        // foreach ($findteamsaway as $team) {
                                // $vars['teamsaway'][$team['home_id']] = $team['TeamHome']['name'];
                                // $vars['teamsaway'][$team['away_id']] = $team['TeamAway']['name'];
                                // }                                
                                
                        // $vars['teamshome'][$vars['match'][0]['home_id']] = $vars['match'][0]['TeamHome']['name'];
                        // $vars['teamsaway'][$vars['match'][0]['away_id']] = $vars['match'][0]['TeamAway']['name'];
                        // }                     
                        // $vars['teamshome'][0] = "-";
                        // $vars['teamsaway'][0] = "-";
                // Get the venues, and pass them on for the dropdown
                $venues = Doctrine_Query::create()
                    ->select('v.name,
                              v.city,
                              v.venue_id')
                    ->from('Venues v')
                    ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                    ->execute();
                foreach ($venues as $venue) {
                    $vars['venues'][$venue['venue_id']] = $venue['name']." - ".$venue['city'];
                    }
                
                $vars['title'] = "Change match details";
                $vars['content_view'] = "matchedit";
                $vars['settings'] = $this->settings_functions->settings();
          		$this->load->view('template', $vars);
                }
            else {
                // Current user is not an admin
                $vars['title'] = "Access denied";
                $vars['content_view'] = "access_denied";
                $vars['settings'] = $this->settings_functions->settings();
		        $this->load->view('template', $vars);
                }
        } else {
            // No user is logged in
            $vars['title'] = "Not logged in";
            $vars['content_view'] = "not_logged_in";
            $vars['settings'] = $this->settings_functions->settings();
		    $this->load->view('template', $vars);
            }             
	}
	
	public function submit() {

        if(logged_in()){
            if(admin()){
                if ($this->_submit_validate() === FALSE) {
                    $this->index();
                    return;
                    }
                
                    if ($team = Doctrine::getTable('Teams')->findOneById($this->input->post('id'))) {
                        
                            $team->name = $this->input->post('teamname');
                            $team->flag = $this->input->post('teamflag');
                        
                        // and save the result!                
                        $team->save();
                        $vars['message'] = "Team ".$team->name." changed!";
                        $vars['title'] = "Team Changed";
                        $vars['content_view'] = "success";
                        $vars['settings'] = $this->settings_functions->settings();
            		    $this->load->view('template', $vars);
                    }
                } else {
                // Current user is not an admin
                $vars['title'] = "Access denied";
                $vars['content_view'] = "access_denied";
                $vars['settings'] = $this->settings_functions->settings();
        		$this->load->view('template', $vars);       
                }
        } else {        
        // Nobody is logged in
        $vars['title'] = "Not logged in";
        $vars['content_view'] = "not_logged_in";
        $vars['settings'] = $this->settings_functions->settings();
	    $this->load->view('template', $vars);
        }
	}

	public function match_submit() {

        if(logged_in()){
            if(admin()){
                if ($this->_submit_validate() === FALSE) {
                    $this->index();
                    return;
                    }
                
                    if ($match = Doctrine::getTable('Matches')->findOneById($this->input->post('id'))) {
                        
                            $match->match_name = $this->input->post('matchname');
                            $match->home_id = $this->input->post('teamhome');
                            $match->away_id = $this->input->post('teamaway');
                            $match->venue_id = $this->input->post('venue');
                            $match->match_time = $this->input->post('matchtime');
                            $match->time_close = $this->input->post('timeclose');
                            
                        // and save the result!                
                        $match->save();
                        $vars['message'] = "Match ".$match->match_name." changed!";
                        $vars['title'] = "Match Changed";
                        $vars['content_view'] = "success";
                        $vars['settings'] = $this->settings_functions->settings();
            		    $this->load->view('template', $vars);
                    }
                } else {
                // Current user is not an admin
                $vars['title'] = "Access denied";
                $vars['content_view'] = "access_denied";
                $vars['settings'] = $this->settings_functions->settings();
        		$this->load->view('template', $vars);       
                }
        } else {        
        // Nobody is logged in
        $vars['title'] = "Not logged in";
        $vars['content_view'] = "not_logged_in";
        $vars['settings'] = $this->settings_functions->settings();
	    $this->load->view('template', $vars);
        }
	}
	
    private function _submit_validate() {


		    
		return true;

	}
}
