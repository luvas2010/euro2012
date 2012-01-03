<?php
/*
 * Account_delete Controller
 */
class Account_delete extends CI_Controller {
	
	/**
	 * Constructor
	 */
    function __construct()
    {
        parent::__construct();
		
		// Load the necessary stuff...
		//$this->load->config('account');
		$this->load->helper(array('language', 'ssl', 'url'));
        $this->load->library(array('authentication', 'form_validation'));
		$this->load->model(array('account_model', 'account_details_model'));
		$this->load->language(array('general', 'account_profile'));
	}
	
	/**
	 * Account profile
	 */
	function index($action = NULL)
	{
		// Enable SSL?
		maintain_ssl($this->config->item("ssl_enabled"));
		
		// Redirect unauthenticated users to signin page
		if ( ! $this->authentication->is_signed_in()) 
		{
			redirect('account/sign_in/?continue='.urlencode(site_url('account/account_profile')));
		}
		
		// Retrieve sign in user
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
		$data['account_details'] = $this->account_details_model->get_by_account_id($this->session->userdata('account_id'));
		
		// Delete account
		if ($action == 'delete')
		{
			$account_id = $data['account']->id;
            $sql_query = "DELETE FROM `account` WHERE `account`.`id` = '$account_id'";
            $query = $this->db->query($sql_query);
			$sql_query = "DELETE FROM `account_details` WHERE `account_id` = '$account_id'";
            $query = $this->db->query($sql_query);
            $sql_query = "DELETE FROM `account_facebook` WHERE `account_id` = '$account_id'";
            $query = $this->db->query($sql_query);
            $sql_query = "DELETE FROM `account_openid` WHERE `account_id` = '$account_id'";
            $query = $this->db->query($sql_query);
            $sql_query = "DELETE FROM `account_twitter` WHERE `account_id` = '$account_id'";
            $query = $this->db->query($sql_query);
            $sql_query = "DELETE FROM `prediction` WHERE `account_id` = '$account_id'";
            $query = $this->db->query($sql_query);
            redirect ('/');
		}
		
		
		$data['title'] = lang('profile_page_name');
        $data['content_main'] = "account/account_delete";
        
		$this->load->view('template/template', $data);
		//$this->load->view('account/account_profile', $data);
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
	
}


/* End of file account_profile.php */
/* Location: ./application/modules/account/controllers/account_profile.php */
