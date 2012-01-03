<?php
class Users extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        $this->load->helper(array('language', 'url', 'form', 'ssl', 'pool', 'date'));
        $this->load->library(array('authentication'));
        $this->load->model(array('account_model'));
        $this->load->model(array('account_details_model'));
        $this->db->select('language');
        $query = $this->db->get_where('account_details', array('account_id' => $this->session->userdata('account_id')));
        $lang = $query->row_array();
        if (isset($lang['language']))  {$this->config->set_item('language',$lang['language']);}
        $this->lang->load(array('general','admin_users'));
    }
    
    function index()
    {
        if ($this->authentication->is_signed_in() && is_admin())
        {
            $sql_query = "SELECT *
                           FROM `account`
                           JOIN `account_details` ON `account`.`id` = `account_details`.`account_id`
                           ORDER BY `account`.`username`";
            $query = $this->db->query($sql_query);
            $users = $query->result_array();

            $this->load->library('pool');
           
            $data = array(
                        'users'   => $users,
                        'account'   => $this->account_model->get_by_id($this->session->userdata('account_id')),
                        'account_details' => $this->account_details_model->get_by_account_id($this->session->userdata('account_id')),
                        'content_main' => 'admin/admin_users',
                        'title' => lang('usermanagement')
                        );
           
            $this->load->view('template/template', $data);
        }
        else
        {
            redirect('account/sign_in/?continue='.urlencode(base_url().'/admin/users'));
        }
    }
    
    function delete($account_id)
    {
        if ($this->authentication->is_signed_in())
        {
            if (is_admin())
            {
                $sql_query = "SELECT `username`,`email`
                              FROM `account`
                              WHERE `id` = '$account_id'";
                $query = $this->db->query($sql_query);
                $row = $query->row_array();
                $username = $row['username'];                
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

                $sql_query = "SELECT *
                               FROM `account`
                               JOIN `account_details` ON `account`.`id` = `account_details`.`account_id`
                               ORDER BY `account`.`username`";
                $query = $this->db->query($sql_query);
                $users = $query->result_array();

                $this->load->library('pool');
               
                $data = array(
                            'users'   => $users,
                            'account'   => $this->account_model->get_by_id($this->session->userdata('account_id')),
                            'account_details' => $this->account_details_model->get_by_account_id($this->session->userdata('account_id')),
                            'content_main' => 'admin/admin_users',
                            'title' => lang('usermanagement'),
                            'info' => sprintf(lang('account_deleted'),$username)
                            );
               
                $this->load->view('template/template', $data);
            }
            else
            {
                $sql_query = "SELECT `username`,`email`
                              FROM `account`
                              WHERE `id` = '$account_id'";
                $query = $this->db->query($sql_query);
                $row = $query->row_array();
                $username = $row['username'];                
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

                $sql_query = "SELECT *
                               FROM `account`
                               JOIN `account_details` ON `account`.`id` = `account_details`.`account_id`
                               ORDER BY `account`.`username`";
                $query = $this->db->query($sql_query);
                $users = $query->result_array();
                $this->authentication->sign_out();
                $this->session->set_flashdata('info', sprintf(lang('account_deleted'),$username));
                redirect('/');
            }
        }
    }
    
    function make_admin($account_id)
    {
        if ($this->authentication->is_signed_in())
        {
            if (is_admin())
            {
                $sql_query = "UPDATE `account`
                              SET `is_admin` =  '0'
                              WHERE  `is_admin` = '1'";
                $query = $this->db->query($sql_query);

                $sql_query = "UPDATE `account`
                              SET `is_admin` =  '1'
                              WHERE  `account`.`id` = '$account_id'";
                $query = $this->db->query($sql_query);
                
                redirect('/');
            }
        }
    }
    
    function verify_user($account_id)
    {
        if ($this->authentication->is_signed_in())
        {
            if (is_admin())
            {
                $now = mdate('%Y-%m-%d %H:%i:%s', now());
                $sql_query = "UPDATE `account`
                              SET `verifiedon` = '$now'
                              WHERE `account`.`id` = '$account_id'";
                $query = $this->db->query($sql_query);
                
                // Send e-mail to let user know the account was verified
                // Load email library
                $this->load->library('email');
                $config['mailtype'] = 'html';

                $this->email->initialize($config);
                $sql_query = "SELECT `username`,`email`
                              FROM `account`
                              WHERE `id` = '$account_id'";
                $query = $this->db->query($sql_query);
                $row = $query->row_array();
                $username = $row['username'];
                if (isset($row['email']))
                {
                    $user_email = $row['email'];
                                
                    // Send user sign up e-mail
                    $this->email->from($this->config->item('email_from_address'), lang('reset_password_email_sender')); //same account as reset password e-mail
                    $this->email->to($user_email);
                    $this->email->subject(lang('verified_email_subject'));
                    
                    $message = sprintf(lang('verified_email_message'), $username);

                    $signin_link = anchor('account/signin',lang('website_sign_in'));
                    $message = $message.sprintf(lang('verified_signin_link'), $signin_link);
                    $message = $message.sprintf(lang('verified_email_footer'), lang('website_title'));
                    $this->email->message($message);
                    
                    @$this->email->send();
                }                
                

                $sql_query = "SELECT *
                               FROM `account`
                               JOIN `account_details` ON `account`.`id` = `account_details`.`account_id`
                               ORDER BY `account`.`username`";
                $query = $this->db->query($sql_query);
                $users = $query->result_array();

                $this->load->library('pool');
               
                $data = array(
                            'users'   => $users,
                            'account'   => $this->account_model->get_by_id($this->session->userdata('account_id')),
                            'account_details' => $this->account_details_model->get_by_account_id($this->session->userdata('account_id')),
                            'content_main' => 'admin/admin_users',
                            'title' => lang('usermanagement'),
                            'info' => sprintf(lang('account_verified'),$username, $user_email)
                            );
               
                $this->load->view('template/template', $data);
            }
        }
    }                              
                            
    function unverified()
    {
        

        if ($this->authentication->is_signed_in())
        {
            if (is_admin())
            {
                $sql_query = "SELECT *
                               FROM `account`
                               JOIN `account_details` ON `account`.`id` = `account_details`.`account_id`
                               AND `account`.`verifiedon` IS NULL
                               ORDER BY `account`.`username`";
                $query = $this->db->query($sql_query);
                $users = $query->result_array();

                $this->load->library('pool');
               
                $data = array(
                            'users'   => $users,
                            'account'   => $this->account_model->get_by_id($this->session->userdata('account_id')),
                            'account_details' => $this->account_details_model->get_by_account_id($this->session->userdata('account_id')),
                            'content_main' => 'admin/admin_users',
                            'title' => lang('unverified_users')
                            );
               
                $this->load->view('template/template', $data);
            }
            else
            {
            redirect('account/sign_in/?continue='.urlencode(base_url().'/admin/users/unverified'));
            }
        }
        else
        {
            redirect('account/sign_in/?continue='.urlencode(base_url().'/admin/users/unverified'));
        }
    }
    
}
?>
