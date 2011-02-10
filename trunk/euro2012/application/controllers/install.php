<?php
// install script

class Install extends Controller {

	public function __construct() {
		parent::Controller();

		$this->load->helper(array('form'));
		$this->load->library('form_validation');
	}

    function index() {
    
        $this->load->database();
        $this->load->dbutil(); 
        $check_table = $this->db->dbprefix."users";
        if ($this->db->table_exists($check_table)) {
            $vars['warning']= true;
            $tables = $this->db->list_tables();
            foreach ($tables as $table) {
                if (strncmp($table,$this->db->dbprefix, strlen($this->db->dbprefix)) == 0){
                    $vars['tables'][] = $table;
                    }
                }
        }
        else {
            $vars['warning'] = false;
            }
        
        $vars['db_set'] = $this->db;
            //print_r ($db_set);
        $vars['title'] = "Installation Step 1";
        $vars['content_view'] = "install_step1";
        $this->load->view('install_template', $vars);
    }
    
    function step2() {
        
        $this->load->dbforge();
        $checktables = array('predictions','matches','texts','venues','settings','teams','users');
        foreach ($checktables as $checktable) {
            $check_table = $this->db->dbprefix.$checktable;
            if ($this->db->table_exists($check_table)) {
                    $this->dbforge->drop_table($checktable);
                    }
            }
    
        $conn = Doctrine_Manager::connection();
        Doctrine::createTablesFromModels();
        $vars['models'] = Doctrine::getLoadedModels();
        $vars['title'] = "Installation Step 2";
        $vars['content_view'] = "install_step2";
        $this->load->view('install_template', $vars);
        
    }
    
    function first_user() {

		if ($this->_submit_validate() === FALSE) {
			//$this->step2();
			return;
		}
		Doctrine_Manager::connection()->execute('SET FOREIGN_KEY_CHECKS = 0');

		Doctrine::loadData(APPPATH.'/fixtures');
		
		$username = $this->input->post('username');
        //create the new user
		$u = new Users();
		$u->username = $this->input->post('username');
		$u->password = $this->input->post('password');
		$u->email = $this->input->post('email');
		$u->nickname = $this->input->post('nickname');
		$u->active = 1;
		$u->admin = 1;

		$u->save();
		
		if ($this->input->post('play') == 'play'){
    		// Get all match numbers
    		$matches = Doctrine_Query::create()
                ->select('m.match_number')
                ->from('Matches m')
                ->execute(); 
    		
    		// Now create a new set of predictions for this user
    		// User gets a prediction record for each match
    		
    		$i = 1;
    		foreach ($matches as $match) {
                $p[$i] = new Predictions();
                $p[$i]->user_id = $u['id'];
                $p[$i]->match_number = $match->match_number;
                $p[$i]->calculated = 0;
                $i++;
                }
            $conn = Doctrine_Manager::connection();
            $conn->flush();    
            }
            $vars['message'] = "Installatie is klaar. Je kunt nu ".anchor('login','inloggen')." als <strong>".$u['username']."</strong>.";
            $vars['title'] = "Installation complete.";
            $vars['content_view'] = "success";
            $vars['settings'] = $this->settings_functions->settings();
	        $this->load->view('template', $vars);             
    }

	private function _submit_validate() {

		// validation rules
		$this->form_validation->set_rules('username', 'Username',
			'required|alpha_numeric|min_length[4]|max_length[40]|unique[Users.username]');

		$this->form_validation->set_rules('password', 'Password',
			'required|min_length[5]|max_length[12]');

		$this->form_validation->set_rules('passconf', 'Confirm Password',
			'required|matches[password]');

		$this->form_validation->set_rules('email', 'E-mail',
			'required|valid_email|unique[Users.email]');

		$this->form_validation->set_rules('nickname', 'Nickname',
			'required|min_length[4]|max_length[40]|unique[Users.nickname]');
			
		return $this->form_validation->run();

	}

}        