<?php
// File: /system/application/controllers/team.php
// Version: 1.0
// Author: Schop

class Team extends Controller {

	public function __construct() {
		parent::Controller();
		
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
	}
    public function index(){
    }
	public function edit($team_id) {

        if(logged_in()){
            if(admin()){
    
                 $vars['team'] = Doctrine_Query::create()
                ->select('*')
                ->from('teams t')
                ->where('t.id ='.$team_id)
                ->execute();
                //print_r($team->toArray());              
                $vars['title'] = "Change team details";
                $vars['content_view'] = "teamedit";
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
                        
                            $team->name      = $this->input->post('teamname');
                            $team->flag      = $this->input->post('teamflag');
                            $team->shortname = $this->input->post('shortname');
                        
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
	
    private function _submit_validate() {


		    
		return true;

	}
}
