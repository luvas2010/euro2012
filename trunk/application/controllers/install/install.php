<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Install extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url','date', 'language'));
        $this->load->library(array('session', 'authentication'));
        $this->lang->load(array('install'));
        
    }

    public function index()
    {
        $data['title'] = lang('start');
        $data['content_main'] = 'install/start';
        $this->load->view('install/install_template', $data);
    }
    
    public function step1()
    {
        $data['title'] = lang('step1');
        $data['content_main'] = 'install/step1';
        $this->load->view('install/install_template', $data);
    }

    public function step2()
    {
        $data['title'] = lang('step2');
        $data['content_main'] = 'install/step2';
        $this->load->view('install/install_template', $data);
    }
    
    public function create_admin()
    {
        
        $this->load->model(array('account_model'));
        $this->load->model(array('account_details_model'));
        $username   = $this->input->post('username');
        $email      = $this->input->post('email');
        $password   = $this->input->post('password');
        $first_name = $this->input->post('first_name');
        $last_name  = $this->input->post('last_name');
        $full_name  = $first_name." ".$last_name;
        
        // Create user
        $user_id = $this->account_model->create($username, $email, $password);
        
        // Make admin & verified
        $this->load->helper('date', 'url');
        $this->db->update('account', array('is_admin' => '1', 'verifiedon' => mdate('%Y-%m-%d %H:%i:%s', now())), array('id' => $user_id));
        //$this->db->update('account_details', array('firstname' => $first_name, 'lastname' => $last_name, 'fullname' => $full_name), array('account_id' => $user_id));
        $this->account_details_model->update($user_id, array('firstname' => $first_name, 'lastname' => $last_name, 'fullname' => $full_name));
        $this->load->library('email');
        $config['mailtype'] = 'html';

        $this->email->initialize($config);
        
        // Send user sign up e-mail
        $this->email->from($this->config->item('email_from_address'), 'Install script'); //same account as reset password e-mail
        $this->email->to('info@voetbalpool2012.nl');
        $this->email->subject('Voetbalpool geinstalleerd');

        $message = 'Voetbalpool geinstalleerd op '.base_url().' '.mdate('%Y-%m-%d %H:%i:%s', now());
        $this->email->message($message);
        @$this->email->send();
        
        $this->session->set_flashdata('info', sprintf(lang('user_created'),$username));
        redirect('/install/install/step2');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
