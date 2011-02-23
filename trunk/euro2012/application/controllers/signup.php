<?php

class Signup extends Controller {

	public function __construct() {
		parent::Controller();

		$this->load->helper(array('form'));
		$this->load->library('form_validation');
	}

	public function index() {
	    $vars['title'] = "Signup for an account";
        $vars['content_view'] = "signup_form";		
        $vars['settings'] = $this->settings_functions->settings();
        $this->load->view('template', $vars);
		//$this->load->view('signup_form');
	}

	public function submit() {

		if ($this->_submit_validate() === FALSE) {
			$this->index();
			return;
		}
        $settings = $this->settings_functions->settings();
		$this->load->helper('string');
		$activation = random_string('alnum', 16);
        $username = $this->input->post('username');
        //create the new user
		$u = new Users();
		$u->username = $this->input->post('username');
		$u->password = $this->input->post('password');
		$u->email = $this->input->post('email');
		$u->nickname = $this->input->post('nickname');
		$u->street = $this->input->post('street');
		$u->city = $this->input->post('city');
		$u->phone = $this->input->post('phone');
		$u->activecode = $activation;
        $u->language = $this->input->post('language');
        if ($settings['user_activation'] == 0) {
            $u->active = 1;
            }
		$u->save();
		
		// Get all match numbers
		$matches = Doctrine_Query::create()
            ->select('m.match_number')
            ->from('Matches m')
            ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
            ->execute(); 
		
		// Now create a new set of predictions for this user
		// User gets a prediction record for each match
		
		$i = 1;
		foreach ($matches as $match) {
            $p[$i] = new Predictions();
            $p[$i]->user_id = $u['id'];
            $p[$i]->match_number = $match['match_number'];
            $p[$i]->calculated = 0;
            $i++;
        }
        
        //get the extra questions
        $questions = Doctrine_Query::create()
            ->select('q.id')
            ->from('Extra_questions q')
            ->execute();
        
        $x=1;        
        foreach($questions as $question) {
            $a[$x] = new Extra_answers();
            $a[$x]->user_id = $u['id'];
            $a[$x]->question_id = $question['id'];
            $a[$x]->answer = "-";
            $x++;
            }
        
        $conn = Doctrine_Manager::connection();
        $conn->flush();    
        if ($settings['user_activation']) {
            $this->load->library('email');
            $this->email->from('info@voetbalpool.nl', 'Voetbalpool2012.nl');
            $this->email->to($u->email); 
            $this->email->subject($settings['poolname'].' Activation request');
            $this->email->message('Hi '.$u->nickname.'. Go here to activate the account: '.base_url().'user_info/activate/'.$u->activecode);	
            $this->email->send();
            $vars['message'] = "Gefeliciteerd ".$u->nickname.", je bent geregistreerd. Er is een e-mail gestuurd naar ".$u->email." met een bevestigings linkje. totdat je account is geactiveerd via deze link, kun je nog niet inloggen.";
            }   
        else {
            $vars['message'] = "User ".$u->nickname." created. You can now login.";
            }
        $vars['title'] = "User created";
		$vars['content_view'] = "success";
		$vars['settings'] = $settings;
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
	
		$this->form_validation->set_rules('street', 'Adress',
			'min_length[4]|max_length[60]');

		$this->form_validation->set_rules('city', 'City',
			'min_length[4]|max_length[40]');

		$this->form_validation->set_rules('phone', 'Phonenumber',
			'min_length[4]|max_length[40]');
			
		return $this->form_validation->run();

	}
}
