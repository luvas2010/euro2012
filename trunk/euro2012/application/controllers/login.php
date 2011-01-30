<?php
class Login extends Controller {

	public function __construct() {
		parent::Controller();

		$this->load->helper(array('form','url'));
		$this->load->library('form_validation');
	}

	public function index() {
        $vars['title'] = "Login";
		$vars['content_view'] = "login_form";		
		$vars['settings'] = $this->settings_functions->settings();
		$this->load->view('template', $vars);
	}

	public function submit() {

		if ($this->_submit_validate() === FALSE) {
			$this->index();
			return;
		}
        $u = Doctrine::getTable('Users')->findOneByUsername($this->input->post('username'));
        $datestring = "%Y-%m-%d %h:%i:%s";
        $u->lastlogin = mdate($datestring, time());
        $u->save();
		redirect('/');

	}

	private function _submit_validate() {

		$this->form_validation->set_rules('username', 'Username',
			'trim|required|callback_authenticate');

		$this->form_validation->set_rules('password', 'Password',
			'trim|required');

		$this->form_validation->set_message('authenticate','Invalid login, or account not activated. Please try again.');

		return $this->form_validation->run();

	}

	public function authenticate() {

		return Current_User::login($this->input->post('username'),
					   $this->input->post('password'));

	}

}

