<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Check_settings extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url','date', 'language', 'form'));
        $this->load->model(array('account_model','poolconfig_model'));
        $this->load->model(array('account_details_model'));
        $this->load->library(array('session', 'authentication'));
        $this->db->select('language');
        $query = $this->db->get_where('account_details', array('account_id' => $this->session->userdata('account_id')));
        $lang = $query->row_array();
        if ($lang['language'] == "") { $lang['language'] = $this->config->item('language'); }
        if (isset($lang['language'])) $this->config->set_item('language',$lang['language']);
        $this->lang->load(array('general', 'poolconfig'));
        
    }

    public function index()
    {
        if ($this->authentication->is_signed_in() && is_admin())
        {
            $data = array(
                            'settings'  => $this->poolconfig_model->get_all_settings(),
                            'account'   => $this->account_model->get_by_id($this->session->userdata('account_id')),
                            'account_details' => $this->account_details_model->get_by_account_id($this->session->userdata('account_id')),
                            'content_main' => 'admin/check_settings',
                            'title' => lang('check_settings')
                            );

            $this->load->view('template/template', $data);
        }
        else
        {
            redirect('account/sign_in/?continue='.urlencode(site_url('admin/check_settings/cat/0')));
        }            
    }
    
    public function cat($category, $action= NULL)
    {
        if ($this->authentication->is_signed_in() && is_admin() && $action ==  'save')
        {
			//echo "<pre>";
			//print_r($this->input->post());
			//echo "</pre>";
			$settings = $this->input->post('setting');
			
			foreach($settings as $setting => $value)
			{
				$this->poolconfig_model->update_setting($setting, $value);
			}
			$this->session->set_flashdata('info',lang('data_saved'));
			redirect('admin/check_settings/cat/'.$category);
		
		}
		
		if ($this->authentication->is_signed_in() && is_admin() && $action == NULL)
        {
            $data = array(
                            'category'	=> $category,
							'settings'  => $this->poolconfig_model->get_all_settings($category),
                            'account'   => $this->account_model->get_by_id($this->session->userdata('account_id')),
                            'account_details' => $this->account_details_model->get_by_account_id($this->session->userdata('account_id')),
                            'content_main' => 'admin/check_settings',
                            'title' => lang('check_settings')
                            );

            $this->load->view('template/template', $data);
        }
        elseif(!$this->authentication->is_signed_in() || !is_admin())
        {
            redirect('account/sign_in/?continue='.urlencode(site_url('admin/check_settings/cat/'.$category)));
        }            
    }
    
    
}
