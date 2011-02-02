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
}
