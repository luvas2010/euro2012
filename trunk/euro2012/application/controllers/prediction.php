<?php
// File: /system/application/controllers/prediction.php
// Version: 1.0
// Author: Schop
// Revisions:

class Prediction extends Controller {


    public function index(){
    }
	public function edit($match_number) { //edit function for predictions

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
	
	public function prediction_submit() {

        if(logged_in()){
            if ($this->_submit_validate() === FALSE) {
                $this->edit($this->input->post('match_number'));
                return;
                }
            
                if ($prediction = Doctrine::getTable('Predictions')->findOneById($this->input->post('id'))) {
                    echo $prediction['Match']['match_time'];
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
                    $vars['message'] = "Prediction for ".$prediction['Match']['TeamHome']['name']." - ".$prediction['Match']['TeamAway']['name']." changed!";
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
	
    private function _submit_validate() {

		// validation rules
		$this->form_validation->set_rules('homegoals', 'Home goals',
			'numeric');
	    $this->form_validation->set_rules('awaygoals', 'Away goals',
			'numeric');
			
		return $this->form_validation->run();
		    
		return true;

	}
}
