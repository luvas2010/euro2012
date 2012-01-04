<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Check_settings extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url','date', 'language'));
        $this->load->library(array('session', 'authentication'));
        $this->lang->load(array('general','install'));
        
    }

    public function index()
    {
        if ($this->authentication->is_signed_in() && is_admin())
        {
            $data['title'] = lang('check_settings');
            $data['content_main'] = 'admin/check_settings';
            $this->load->view('template/template', $data);
        }
        else
        {
            redirect('account/sign_in/?continue='.urlencode(site_url('admin/check_settings')));
        }            
    }
}
