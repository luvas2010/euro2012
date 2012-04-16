<?php
/*
 * Sign_up Controller
 */
class Sign_up extends CI_Controller {
    
    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        
        // Load the necessary stuff...
        //$this->load->config('account');
        $this->load->helper(array('language', 'ssl', 'url'));
        $this->load->library(array('authentication', 'recaptcha', 'form_validation'));
        $this->load->model(array('account_model', 'account_details_model','poolconfig_model'));
        $this->load->language(array('general', 'sign_up', 'connect_third_party'));
    }
    
    /**
     * Account sign up
     *
     * @access public
     * @return void
     */
    function index()
    {
        // Enable SSL?
        maintain_ssl($this->poolconfig_model->item("ssl_enabled"));
        
        // Redirect signed in users to homepage
        if ($this->authentication->is_signed_in()) redirect('');
        
        // Check recaptcha
        $recaptcha_result = $this->recaptcha->check();
        
        // Store recaptcha pass in session so that users only needs to complete captcha once
        if ($recaptcha_result === TRUE) $this->session->set_userdata('sign_up_recaptcha_pass', TRUE);
        
        // Setup form validation
        $this->form_validation->set_error_delimiters('<span class="field_error">', '</span>');
        $this->form_validation->set_rules(array(
            array('field'=>'sign_up_username', 'label'=>'lang:sign_up_username', 'rules'=>'trim|required|alpha_dash|min_length[2]|max_length[24]'),
            array('field'=>'sign_up_password', 'label'=>'lang:sign_up_password', 'rules'=>'trim|required|min_length[6]'),
            array('field'=>'sign_up_email', 'label'=>'lang:sign_up_email', 'rules'=>'trim|required|valid_email|max_length[160]')
        ));
        
        // Run form validation
        if ($this->form_validation->run() === TRUE) 
        {
            // Check if user name is taken
            if ($this->username_check($this->input->post('sign_up_username')) === TRUE)
            {
                $data['sign_up_username_error'] = lang('sign_up_username_taken');
            }
            // Check if email already exist
            elseif ($this->email_check($this->input->post('sign_up_email')) === TRUE)
            {
                $data['sign_up_email_error'] = lang('sign_up_email_exist');
            }
            // Either already pass recaptcha or just passed recaptcha
            elseif ( ! ($this->session->userdata('sign_up_recaptcha_pass') == TRUE || $recaptcha_result === TRUE) && $this->poolconfig_model->item("sign_up_recaptcha_enabled") == 1)
            {
                $data['sign_up_recaptcha_error'] = $this->input->post('recaptcha_response_field') ? lang('sign_up_recaptcha_incorrect') : lang('sign_up_recaptcha_required');
            }
            else 
            {
                // Remove recaptcha pass
                $this->session->unset_userdata('sign_up_recaptcha_pass');
                
                // Create user
                $user_id = $this->account_model->create($this->input->post('sign_up_username'), $this->input->post('sign_up_email'), $this->input->post('sign_up_password'));
                
                // Add user details (auto detected country, language, timezone)
                $attributes = array('firstname' => $this->input->post('sign_up_firstname'),
                                    'lastname' => $this->input->post('sign_up_lastname'),
                                    'fullname' => $this->input->post('sign_up_firstname')." ".$this->input->post('sign_up_lastname'),
                                    'pool_style'=> $this->poolconfig_model->item('pool_style'),
                                    'company' => $this->input->post('sign_up_company')
                                    );

                $this->account_details_model->update($user_id, $attributes);
                
                // Auto sign in?
                if ($this->poolconfig_model->item("sign_up_auto_sign_in") && !$this->poolconfig_model->item('verify_users'))
                {
                    // Run sign in routine
                    $this->authentication->sign_in($user_id);
                }
                if (!$this->poolconfig_model->item('verify_users'))
                {
                    redirect('account/sign_in');
                }
                else
                {
                    //user has to be verified first
                    $data['title'] = lang('website_title');
                    $data['content_main'] = "home";
                    $this->session->set_flashdata('info',lang('verify_before_signin'));
					$this->load->view('template/template', $data);
                    $skip = 1;
                }
            }
        }
        
        if (!isset($skip)) {
            // Load recaptcha code
            if ($this->poolconfig_model->item("sign_up_recaptcha_enabled") == 1)
                if ($this->session->userdata('sign_up_recaptcha_pass') != TRUE) 
                    $data['recaptcha'] = $this->recaptcha->load($recaptcha_result, $this->poolconfig_model->item("ssl_enabled"));
            
            // Load sign up view
            $data['title'] = lang('sign_up_page_name');
            $data['content_main'] = "account/sign_up";
            
            $this->load->view('template/template', $data);
            //$this->load->view('sign_up', isset($data) ? $data : NULL);
        }
    }
    
    /**
     * Check if a username exist
     *
     * @access public
     * @param string
     * @return bool
     */
    function username_check($username)
    {
        return $this->account_model->get_by_username($username) ? TRUE : FALSE;
    }
    
    /**
     * Check if an email exist
     *
     * @access public
     * @param string
     * @return bool
     */
    function email_check($email)
    {
        return $this->account_model->get_by_email($email) ? TRUE : FALSE;
    }
    
}


/* End of file sign_up.php */
/* Location: ./application/modules/account/controllers/sign_up.php */
