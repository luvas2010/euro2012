<?php
// File: /system/application/controllers/match.php
// Version: 1.0
// Author: Schop
// Revisions:

class Match extends Controller {


    public function index(){
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
                              m.match_group,
                              m.match_number,
                              m.time_close,
                              th.name,
                              ta.name,
                              v.name,
                              v.venue_id')
                    ->from('Matches m, m.TeamHome th, m.TeamAway ta, m.Venue v')
                    ->where('m.match_number = '.$match_id)
                    ->execute();

                    
                // Get the teams, and pass them on for the dropdown
                $teams = Doctrine_Query::create()
                    ->select('t.name,
                              t.team_id_home')
                    ->from('Teams t')
                    ->where('t.team_group = "'.$vars['match'][0]['match_group'].'"')
                    ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                    ->execute();
                foreach ($teams as $team) {
                    $vars['teams'][$team['team_id_home']] = $team['name'];
                    }
                    
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
