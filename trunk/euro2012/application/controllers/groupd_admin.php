<?php
class Groupd_admin extends Controller {

	public function __construct() {
		parent::Controller();
		
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
	}

	public function index() {

        if(Current_User::user()){
            if(Current_User::user()->admin){
    
             // Lookup the matches in this group
             $vars['matches'] = Doctrine_Query::create()
                ->select('m.match_number,
                          m.home_goals,
                          m.away_goals,
                          th.name,
                          th.flag,
                          ta.name,
                          ta.flag,
                          v.name')
                ->from('Matches m, m.TeamHome th, m.TeamAway ta, m.Venue v')
                ->where('m.match_group = "D"')
                ->orderBy('m.match_time')
                ->execute();
                
            $vars['title'] = "Group D Administration";
            $vars['content_view'] = "group_admin";		
            $vars['group'] = "d";		
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

        if(Current_User::user()){
            if(Current_User::user()->admin){
                if ($this->_submit_validate() === FALSE) {
                    $this->index();
                    return;
                }
                
                // Lookup matchnumbers again (this could be more elegant, but I don't know how)
                $matches = Doctrine_Query::create()
                    ->select('m.match_number')
                    ->from('Matches m')
                    ->where('m.match_group = "D"')
                    ->execute();
                
                foreach ($matches as $match) {
                 
                    // Find the match record
                    if ($m = Doctrine::getTable('Matches')->findOneByMatch_number($this->input->post('match_number'.$match->match_number))) {
                        
                        // Check if there's a number of goals 
                        if ($this->input->post('home_goals'.$match->match_number)<>'') {
                            $m->home_goals = $this->input->post('home_goals'.$match->match_number);
                            }
                        // If there is no number, wipe the result for this match, user probably wants to delete a wrong result    
                        else {
                            $m->home_goals = NULL;
                            }
                        // Check if there's a number of goals    
                        if ($this->input->post('away_goals'.$match->match_number)<>'') {           
                            $m->away_goals = $this->input->post('away_goals'.$match->match_number);
                            }
                        // If there is no number, wipe the result for this match, user probably wants to delete a wrong result    
                        else {
                            $m->away_goals = NULL;
                            }
                        // and save the result!                
                        $m->save();
                    }   
                }
                // Now recalculate the standings, and go back to group overview
                if ($this->groupcalc->groupresults()) {
                    redirect('/groupd');
                    }
            }
        }
	}
	
    private function _submit_validate() {
        // Fetch all match numbers, again :(
        $matches = Doctrine_Query::create()
            ->select('m.match_number')
            ->from('Matches m')
            ->where('m.match_group = "D"')
            ->execute();
        
        foreach ($matches as $match) {
		// validation rules
		    $this->form_validation->set_rules('match_number'.$match->match_number, 'Match number',
			    'required');
		    $this->form_validation->set_rules('home_goals'.$match->match_number, 'Home Goals',
			    'integer');
		    $this->form_validation->set_rules('away_goals'.$match->match_number, 'Away Goals',
			    'integer');
		    }
		return $this->form_validation->run();

	}
	

}
