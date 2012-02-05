<?php
class Manual extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        $this->load->helper(array('language', 'url', 'form', 'ssl', 'pool', 'date'));
        $this->load->library(array('authentication'));
        $this->load->model(array('account_model','poolconfig_model'));
        $this->load->model(array('account_details_model'));
        $this->db->select('language');
        $query = $this->db->get_where('account_details', array('account_id' => $this->session->userdata('account_id')));
        $lang = $query->row_array();
        if (isset($lang['language']))  {$this->config->set_item('language',$lang['language']);}
        $this->lang->load(array('general','standings'));
    }
    
    function index()
    {
        if ($this->authentication->is_signed_in() && is_admin())
        {
                $data = array(
                            'account'   => $this->account_model->get_by_id($this->session->userdata('account_id')),
                            'account_details' => $this->account_details_model->get_by_account_id($this->session->userdata('account_id')),
                            'content_main' => 'admin/manual',
                            'title' => 'Handleiding'
                            );
               
                $this->load->view('template/template', $data);        
        }
        else
        {
            redirect('account/sign_in/?continue='.site_url('admin/manual'));
        }        
    
    
    }
}