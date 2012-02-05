<?php
/*
 * Sign_out Controller
 */
class Sign_out extends CI_Controller {
    
    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        
        // Load the necessary stuff...
        $this->load->helper(array('language', 'url'));
		$this->load->model('poolconfig_model');
        //$this->load->config('account');
        $this->load->language(array('general', 'sign_out'));
        $this->load->library(array('authentication'));
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Account sign out
     *
     * @access public
     * @return void
     */
    function index()
    {
        // Redirect signed out users to homepage
        if ( ! $this->authentication->is_signed_in()) redirect('');
        
        // Run sign out routine
        $this->authentication->sign_out();
        
        // Redirect to homepage
        if ( ! $this->poolconfig_model->item("sign_out_view_enabled")) redirect('');
        
        // Load sign out view
        $data['title'] = lang('sign_out_successful');
        $data['content_main'] = "account/sign_out";
        
        $this->load->view('template/template', $data);
        
        //$this->load->view('sign_out');
    }
    
}


/* End of file sign_out.php */
/* Location: ./application/modules/account/controllers/sign_out.php */
