<?php

class Home extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        
        // Load the necessary stuff...
        $this->load->helper(array('language', 'url', 'form', 'ssl'));
        $this->load->library(array('authentication'));
        $this->load->model(array('account_model'));
        $this->load->model(array('account_details_model'));
        $this->db->select('language');
        $query = $this->db->get_where('account_details', array('account_id' => $this->session->userdata('account_id')));
        $lang = $query->row_array();
        if (isset($lang['language'])) $this->config->set_item('language',$lang['language']);        
        $this->lang->load(array('general', 'welcome'));
    }
    
    function index()
    {
        maintain_ssl();
        
        if ($this->authentication->is_signed_in())
        {
            $data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
            $data['account_details'] = $this->account_details_model->get_by_account_id($this->session->userdata('account_id'));
        }
        
        $data['title'] = lang('website_title');
        $data['content_main'] = "home";
        
        $this->load->view('template/template', $data);
    }
    
}


/* End of file home.php */
/* Location: ./system/application/controllers/home.php */
