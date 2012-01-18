<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Check_settings extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url','date', 'language'));
        $this->load->model(array('account_model'));
        $this->load->model(array('account_details_model'));
        $this->load->library(array('session', 'authentication'));
        $this->db->select('language');
        $query = $this->db->get_where('account_details', array('account_id' => $this->session->userdata('account_id')));
        $lang = $query->row_array();
        if (isset($lang['language']))  {$this->config->set_item('language',$lang['language']);}
        $this->lang->load(array('general','install'));
        
    }

    public function index()
    {
        if ($this->authentication->is_signed_in() && is_admin())
        {
            $data = array(
                            'account'   => $this->account_model->get_by_id($this->session->userdata('account_id')),
                            'account_details' => $this->account_details_model->get_by_account_id($this->session->userdata('account_id')),
                            'content_main' => 'admin/check_settings',
                            'title' => lang('check_settings')
                            );

            $this->load->view('template/template', $data);
        }
        else
        {
            redirect('account/sign_in/?continue='.urlencode(site_url('admin/check_settings')));
        }            
    }
}
