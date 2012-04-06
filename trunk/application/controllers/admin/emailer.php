<?php
class Emailer extends CI_Controller {

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
        if ($lang['language'] == "") { $lang['language'] = $this->config->item('language'); }
        if (isset($lang['language'])) $this->config->set_item('language',$lang['language']);
        $this->lang->load(array('general','admin_emailer'));
    }
    
    function index()
    {
        if ($this->authentication->is_signed_in() && is_admin())
        {
        
            $data = array(
                    'account'   => $this->account_model->get_by_id($this->session->userdata('account_id')),
                    'account_details' => $this->account_details_model->get_by_account_id($this->session->userdata('account_id')),
                    'users' => $this->account_model->get_all(),
                    'content_main' => 'admin/admin_emailer',
                    'title' => lang('select_addresses')
                    );
       
            $this->load->view('template/template', $data);

        }
        else
        {
            redirect('account/sign_in/?continue='.urlencode(site_url('admin/emailer')));
        }
            
    }
    
    function send()
    {
        if ($this->authentication->is_signed_in() && is_admin())
        {
            
            if (is_array($this->input->post('to')))
            {
                $ids_to = $this->input->post('to');
                $in_string = implode(",", $ids_to);
                $sql_query = "SELECT `email` FROM `account` WHERE `id` IN ($in_string)";
                $query = $this->db->query($sql_query);
                $email_addresses = $query->result_array();
                $emails_to = "";
                foreach ($email_addresses as $address)
                {
                    $emails_to .= $address['email'].", ";
                }
                $emails_to = rtrim($emails_to,", ");
            }
            else
            {
                $emails_to = "";
            }
            
            if (is_array($this->input->post('cc')))
            {
                $ids_cc = $this->input->post('cc');
                $in_string = implode(",", $ids_cc);
                $sql_query = "SELECT `email` FROM `account` WHERE `id` IN ($in_string)";
                $query = $this->db->query($sql_query);
                $email_addresses = $query->result_array();
                $emails_cc = "";
                foreach ($email_addresses as $address)
                {
                    $emails_cc .= $address['email'].", ";
                }
                $emails_cc = rtrim($emails_cc,", ");
            }
            else
            {
                $emails_cc= "";
            }    
            
            if (is_array($this->input->post('bcc')))
            {            
                $ids_bcc = $this->input->post('bcc');
                $in_string = implode(",", $ids_bcc);
                $sql_query = "SELECT `email` FROM `account` WHERE `id` IN ($in_string)";
                $query = $this->db->query($sql_query);
                $email_addresses = $query->result_array();
                $emails_bcc = "";
                foreach ($email_addresses as $address)
                {
                    $emails_bcc .= $address['email'].", ";
                }
                $emails_bcc = rtrim($emails_bcc,", ");
            }
            else
            {
                $emails_bcc = "";
            }    
            
            $data = array(
                    'account'   => $this->account_model->get_by_id($this->session->userdata('account_id')),
                    'account_details' => $this->account_details_model->get_by_account_id($this->session->userdata('account_id')),
                    'emails_to' => $emails_to,
                    'emails_cc' => $emails_cc,
                    'emails_bcc' => $emails_bcc,
                    'content_main' => 'admin/admin_emailer_step_2',
                    'title' => lang('send_an_email')
                    );
       
            $this->load->view('template/template', $data);
        }    
    }

    function send_step2()
    {
        if ($this->authentication->is_signed_in() && is_admin())
        {
            //echo "<pre>";print_r($this->input->post());echo "</pre>";
            
            // Load email library
            $this->load->library('email');
            $config['mailtype'] = 'html';

            $this->email->initialize($config);

                            
                // Send user sign up e-mail
                $this->email->from($this->poolconfig_model->item('email_from_address'), lang('reset_password_email_sender')); //same account as reset password e-mail
                $this->email->to($this->input->post('to'));
                $this->email->cc($this->input->post('cc'));
                $this->email->bcc($this->input->post('bcc'));
                $this->email->subject($this->input->post('subject'));
                
                $this->email->message($this->input->post('rte1'));
                
                @$this->email->send();
                
            $data = array(
                    'account'   => $this->account_model->get_by_id($this->session->userdata('account_id')),
                    'account_details' => $this->account_details_model->get_by_account_id($this->session->userdata('account_id')),
                    'debug_info' => $this->email->print_debugger(),
                    'content_main' => 'admin/admin_emailer_finished',
                    'title' => "Finished"
                    );
       
            $this->load->view('template/template', $data);        
        }    
    }     
    
}
?>
