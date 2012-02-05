<?php
/*
 * Reset_password Controller
 */
class Reset_password extends CI_Controller {
	
	/**
	 * Constructor
	 */
    function __construct()
    {
        parent::__construct();
		
		// Load the necessary stuff...
		//$this->load->config('account');
		$this->load->helper(array('date', 'language', 'ssl', 'url'));
        $this->load->library(array('authentication', 'recaptcha', 'form_validation'));
		$this->load->model(array('account_model','poolconfig_model'));
		$this->load->language(array('general', 'reset_password'));
	}
	
	/**
	 * Reset password
	 */
	function index() 
	{
		// Enable SSL?
		maintain_ssl($this->poolconfig_model->item("ssl_enabled"));
		
		// Redirect signed in users to homepage
		if ($this->authentication->is_signed_in()) redirect('');
		
		// Check recaptcha
		$recaptcha_result = $this->recaptcha->check();
		
		// User has not passed recaptcha
		if ($recaptcha_result !== TRUE)
		{
			if ($this->input->post('recaptcha_challenge_field')) 
			{
				$data['reset_password_recaptcha_error'] = $recaptcha_result ? lang('reset_password_recaptcha_incorrect') : lang('reset_password_recaptcha_required');
			}
			
			// Load recaptcha code
			$data['recaptcha'] = $this->recaptcha->load($recaptcha_result, $this->poolconfig_model->item("ssl_enabled"));
			
			// Load reset password captcha view
            $data['title'] = lang('reset_password_page_name');
            $data['content_main'] = "account/reset_password_captcha";
        
            $this->load->view('template/template', $data);
			//$this->load->view('reset_password_captcha', isset($data) ? $data : NULL);
			return;
		}
		
		// Get account by email
		if ($account = $this->account_model->get_by_id($this->input->get('id')))
		{
			// Check if reset password has expired
			if (now() < (strtotime($account->resetsenton) + $this->poolconfig_model->item("password_reset_expiration")))
			{
				// Check if token is valid
				if ($this->input->get('token') == sha1($account->id.strtotime($account->resetsenton).$this->poolconfig_model->item('password_reset_secret')))
				{
					// Remove reset sent on datetime
					$this->account_model->remove_reset_sent_datetime($account->id);
					
					// Upon sign in, redirect to change password page
					$this->session->set_userdata('sign_in_redirect', 'account/account_password');
					
					// Run sign in routine
					$this->authentication->sign_in($account->id);
				}
			}
		}
		
		// Load reset password unsuccessful view
		$this->load->view('reset_password_unsuccessful', isset($data) ? $data : NULL);
	}
	
}


/* End of file reset_password.php */
/* Location: ./application/modules/account/controllers/reset_password.php */
