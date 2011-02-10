<?php
// File: /system/application/controllers/user_info.php
// Version: 1.0
// Author: Schop

class User_info extends Controller {

    public function index() {
        
        $user_id =logged_in();
        $vars['user'] = Doctrine::getTable('Users')->findOneById($user_id);
        $vars['title'] = "User Info";
        $vars['content_view'] = "userinfo";
        $vars['settings'] = $this->settings_functions->settings();
		$this->load->view('template', $vars);
    }
    
    public function reset_password() {

        $vars['title'] = "Password Reset";
        $vars['content_view'] = "password_reset_form";
        $vars['settings'] = $this->settings_functions->settings();
		$this->load->view('template', $vars);        
    }
    
    public function reset_pass_submit () {
   
        if ($this->_reset_pass_submit_validate() === FALSE) {
			$this->reset_password();
			return;
		}
        $settings = $this->settings_functions->settings();
        $resetcode = random_string('alnum', 32);
        $user = Doctrine::getTable('Users')->findOneByEmail($this->input->post('email'));
        $user->resetcode = $resetcode;
        $user->save();
        $this->load->library('email');
        $this->email->from('info@voetbalpool.nl', 'Voetbalpool2012.nl');
        $this->email->to($user->email); 
        $this->email->subject($settings['poolname'].' Reset password request');
        $this->email->message('Hi '.$user->nickname.'. Go here to set a new password: '.base_url().'/user_info/new_password/'.$user->resetcode);
        //echo base_url().'/user_info/new_password/'.$user->resetcode;
        $this->email->send();
        $vars['message'] = "Er is een e-mail gestuurd naar ".$user->email." met een link. Klik op de link om een nieuw wachtwoord in te stellen.";
        $vars['title'] = "Password reset";
		$vars['content_view'] = "success";
		$vars['settings'] = $settings;
		$this->load->view('template', $vars);
    }

	private function _reset_pass_submit_validate() {

		
		$this->form_validation->set_rules('email', 'E-mail',
			'required|valid_email|exists[Users.email]');
			
		return $this->form_validation->run();

	}
    
    public function new_password($resetcode) {
    
        if ($user = Doctrine::getTable('Users')->findOneByResetcode($resetcode)) {
                $vars['user'] = $user;
                $vars['title'] = lang('user_info');
                $vars['content_view'] = "userinfo";
                
                $this->load->view('template', $vars);
            }
        else { 
            $vars['title'] = 'Error';
            $vars['message'] = 'That activation code is not in the database.';
            $vars['content_view'] = "error";
            $vars['settings'] = $this->settings_functions->settings();
            $this->load->view('template', $vars);
        }
    }
    public function user_edit($id) {
        
        if (admin()) {
        
            $vars['user'] = Doctrine::getTable('Users')->findOneById($id);
            
            $vars['title'] = "User Info";
            $vars['content_view'] = "userinfo";
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
    
    public function list_all() {
        if (admin()) {
            $vars['users'] = Doctrine_Query::create()
                ->select('u.*')
                ->from('Users u')
                ->orderBy('u.nickname')
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();
                
            $vars['title'] = "User List";
            $vars['content_view'] = "userlist";
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
    
    public function activate($activecode) {
    
        if ($u = Doctrine::getTable('Users')->findOneByActivecode($activecode)) {
            if ($u->active == 0) {
                $u->active = 1;
                $u->save();
                $vars['title'] = "Success";
                $vars['message'] = "User ".$u->nickname." activated!";
                $vars['content_view'] = "success";
                }
            else {
                $vars['title'] = 'Error';
                $vars['message'] = 'User '.$u->nickname.' was already activated!';
                $vars['content_view'] = "error";
                }
                
            $vars['settings'] = $this->settings_functions->settings();
            $this->load->view('template', $vars);
            }
        else {
            $vars['title'] = "Error";
            $vars['message'] = "User not found!";
            $vars['content_view'] = "error";
            $vars['settings'] = $this->settings_functions->settings();
            $this->load->view('template', $vars);        
            }
        }
        
    public function submit_all() {
            
        $userTable = Doctrine::getTable('Users');
        $userTable->setAttribute(Doctrine::ATTR_COLL_KEY, 'id'); // make sure they get indexed by ID
        $u = $userTable->findAll();
        $replace = false;
        $arrPost = $this->input->post('post_array');    //get all posted values in one array
        foreach ($arrPost as $id => $value) {           // $id represents the 'id' column in the user table
            foreach ($value as $k => $v) {              // $k represents 'street', 'city' etc.  
                
                if ($u[$id][$k]!= $v) { // iterate over all fileds, see if one has changed
                    
                    if ($v != NULL) {
                        $u[$id][$k]=$v;
                        }
                    else {
                        $u[$id][$k]=NULL;
                        }
                    $replace = true;    // this record will have to be updated
                    }
                }
                if ($replace) {
                    $u[$id]->replace(); // update the record
                    $replace= false;
                    }
            }
        
        $u->free();
        
        $vars['title'] = "Success";
        $vars['message'] = "All changed were saved";
		$vars['content_view'] = "success";
		$vars['settings'] = $this->settings_functions->settings();
		$this->load->view('template', $vars);
         
        }
    
    public function submit() {

		if ($this->_submit_validate() === FALSE) {
			$this->index();
			return;
		}
		
		$u = Doctrine::getTable('Users')->findOneById($this->input->post('id'));
        
		$u->username = $this->input->post('username');
    	$u->password = $this->input->post('password');
 		$u->email = $this->input->post('email');
		$u->nickname = $this->input->post('nickname');
        $u->language = $this->input->post('language');
		$u->street = $this->input->post('street');
		$u->zipcode = $this->input->post('zip');
		$u->city = $this->input->post('city');
		$u->phone = $this->input->post('phone');

		$u->save();
        $vars['title'] = "Success";
        $vars['message'] = "User ".$u->nickname." saved";
		$vars['content_view'] = "success";
		$vars['settings'] = $this->settings_functions->settings();
		$this->load->view('template', $vars);
	}
	
	private function _submit_validate() {

		// validation rules
		$this->form_validation->set_rules('username', 'Username',
			'required|alpha_numeric|min_length[4]|max_length[40]');

		$this->form_validation->set_rules('password', 'Password',
			'required|min_length[5]|max_length[12]');

		$this->form_validation->set_rules('passconf', 'Confirm Password',
			'required|matches[password]');

		$this->form_validation->set_rules('email', 'E-mail',
			'required|valid_email');

		$this->form_validation->set_rules('nickname', 'Nickname',
			'required|min_length[4]|max_length[40]');
	
		$this->form_validation->set_rules('street', 'Adress',
			'min_length[4]|max_length[60]');

		$this->form_validation->set_rules('city', 'City',
			'min_length[4]|max_length[60]');

		$this->form_validation->set_rules('phone', 'Phonenumber',
			'min_length[4]|max_length[15]');
			
		return $this->form_validation->run();

	}
    
    function delete_user($id) {
    
        if (admin()) {
            $userTable = Doctrine::getTable("Users");

            
            $user = $userTable->find($id);
            
            // deletes user and all related composite objects
            if($user !== false) {
                $predictionTable = Doctrine::getTable("Predictions");
                $predictions = $predictionTable->findByUser_id($id);
                $predictions->delete();
                $user->delete();
                $vars['title'] = "User deleted";
                $vars['content_view'] = "success";
                $vars['message'] = "User ".$user->nickname." deleted";		
                $vars['settings'] = $this->settings_functions->settings();
                $this->load->view('template', $vars);
                }
            }
            else {
            // Current user is not an admin
            $vars['title'] = "Access denied";
            $vars['message'] = "You are not an administrator";
            $vars['content_view'] = "error";
            $vars['settings'] = $this->settings_functions->settings();
    		$this->load->view('template', $vars);
            }
    }
    
    public function switch_language($language) {
        if (logged_in()) {
            $id = logged_in();
            $userTable = Doctrine::getTable("Users");
            $user = $userTable->find($id);        
            $user->language = $language;
            $user->save();
            redirect('/');
            }
    }
    
    public function resetpw($id) {
        $random = random_string('alnum', 8);
        if (admin() || logged_in() == $id) {
            $userTable = Doctrine::getTable("Users");
            $user = $userTable->find($id);        
            $user->password = $random;
            $user->save();
            $vars['settings'] = $this->settings_functions->settings();
                $this->load->library('email');
                $this->email->from('info@voetbalpool.nl', 'Voetbalpool2012.nl');
                $this->email->to($user->email); 
                $this->email->subject($vars['settings']['poolname'].' wachtwoord reset');
                $email = 'Hoi '.$user->nickname.'. Je wachtwoord voor '.$vars['settings']['poolname'].' is nu:<br /><br /><strong>'.$random.'</strong><br /><br />Je kunt dit veranderen door in te loggen op '.anchor("/", $vars['settings']['poolname']).' en naar '.anchor("/user_info","Mijn Account").' te gaan.';
                $this->email->message($email);	
                $this->email->send();
                
            $vars['title'] = "Password reset";
            $vars['message'] = "Het wachtwoord voor ".$user->nickname." is gewijzigd. Er is een e-mail naar ".$user->email." gestuurd met de volgende tekst: <br/><br/>".$email;
            $vars['content_view'] = "success";
            $vars['settings'] = $this->settings_functions->settings();
    		$this->load->view('template', $vars);
            }
        else {
            // Current user is not an admin
            $vars['title'] = "Access denied";
            $vars['message'] = "You are not an administrator";
            $vars['content_view'] = "error";
            $vars['settings'] = $this->settings_functions->settings();
    		$this->load->view('template', $vars);
            }
    }
}
