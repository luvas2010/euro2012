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
                          m.type_id,
                          th.name,
                          th.flag,
                          ta.name,
                          ta.flag,
                          p.*,
                          pth.name,
                          pth.flag,
                          pta.name,
                          pta.flag,
                          v.time_offset_utc,
                          v.city
                          ')
                ->from('Predictions p, p.Match m, p.TeamHome pth, p.TeamAway pta, m.TeamHome th, m.TeamAway ta, m.Venue v')
                ->where('p.user_id = '.$user_id)
                ->andWhere('p.match_number = '.$match_number)
                ->execute();
                
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
                    
                        
                        $prediction->home_goals = $this->input->post('homegoals');
                        $prediction->away_goals = $this->input->post('awaygoals');
                    
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
			'required|numeric');
	    $this->form_validation->set_rules('awaygoals', 'Away goals',
			'required|numeric');
			
		return $this->form_validation->run();
		    
		return true;

	}
}
