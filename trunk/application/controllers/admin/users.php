<?php
class Users extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        $this->load->helper(array('language', 'url', 'form', 'ssl', 'pool', 'date'));
        $this->load->library(array('authentication'));
        $this->load->model(array('account_model','poolconfig_model'));
        $this->load->model(array('account_details_model'));
        $this->load->model(array('account_twitter_model'));
        $this->load->model(array('account_facebook_model'));
		$this->load->model(array('account_openid_model'));
        $this->db->select('language');
        $query = $this->db->get_where('account_details', array('account_id' => $this->session->userdata('account_id')));
        $lang = $query->row_array();
        if (isset($lang['language']))
        {
            if ($lang['language'] == "de" || $lang['language'] == "en" || $lang['language'] == "nl")
            {
                $this->config->set_item('language',$lang['language']);
            }
            else
            {
                $lang['language'] = $this->config->item('language');
                $this->config->set_item('language',$lang['language']);
            }
        }
        else
        {
            $lang['language'] = $this->config->item('language');
        }
        $this->lang->load(array('general','admin_users'));
    }
    
    function index()
    {
        if ($this->authentication->is_signed_in() && is_admin())
        {
            $sql_query = "SELECT *
                           FROM `account`
                           JOIN `account_details` ON `account`.`id` = `account_details`.`account_id`
                           LEFT JOIN `account_facebook` ON `account_facebook`.`account_id` = `account`.`id`
                           LEFT JOIN `account_twitter` ON `account_twitter`.`account_id` = `account`.`id`
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
            redirect('account/sign_in/?continue='.site_url('admin/users'));
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
                
                $this->session->set_flashdata('info', sprintf(lang('account_deleted'),$username));
                redirect('admin/users');
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
        else
        {
            redirect('account/sign_in');
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
        if ($this->authentication->is_signed_in() && is_admin())
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
                    $this->email->from($this->poolconfig_model->item('email_from_address'), lang('reset_password_email_sender')); //same account as reset password e-mail
                    $this->email->to($user_email);
                    $this->email->subject(lang('verified_email_subject'));
                    
                    $message = sprintf(lang('verified_email_message'), $username);

                    $signin_link = anchor('account/sign_in',lang('website_sign_in'));
                    $message = $message.sprintf(lang('verified_signin_link'), $signin_link);
                    $message = $message.sprintf(lang('verified_email_footer'), lang('website_title'));
                    $this->email->message($message);
                    
                    @$this->email->send();
                }                
                
                $this->session->set_flashdata('info', sprintf(lang('account_verified'),$username, $user_email));
                redirect('admin/users/unverified');
        }
        else
        {
            redirect('account/sign_in/?continue='.site_url('admin/users/unverified'));
        }
    }                              

    function user_payed($account_id)
    {
        if ($this->authentication->is_signed_in() && is_admin())
        {
                $sql_query = "UPDATE `account`
                              SET `payed` = 1
                              WHERE `account`.`id` = '$account_id'";
                $query = $this->db->query($sql_query);
                
                // Send e-mail to let user know the account was payed for
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
                    $this->email->from($this->poolconfig_model->item('email_from_address'), lang('reset_password_email_sender')); //same account as reset password e-mail
                    $this->email->to($user_email);
                    $this->email->subject(lang('payed_email_subject'));
                    
                    $message = sprintf(lang('payed_email_message'), $username);

                    $signin_link = anchor('account/sign_in',lang('website_sign_in'));
                    $message = $message.sprintf(lang('payed_signin_link'), $signin_link);
                    $message = $message.sprintf(lang('payed_email_footer'), lang('website_title'));
                    $this->email->message($message);
                    
                    @$this->email->send();
                }                
                
                $this->session->set_flashdata('info', sprintf(lang('account_payed'),$username, $user_email));
                redirect('admin/users/unpayed');

        }
        else
        {
            redirect('account/sign_in/?continue='.site_url('admin/users/unpayed'));
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
                           LEFT JOIN `account_facebook` ON `account_facebook`.`account_id` = `account`.`id`
                           LEFT JOIN `account_twitter` ON `account_twitter`.`account_id` = `account`.`id`
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
            redirect('account/sign_in/?continue='.site_url('admin/users/unverified'));
            }
        }
        else
        {
            redirect('account/sign_in/?continue='.site_url('admin/users/unverified'));
        }
    }

    function unpayed()
    {
        

        if ($this->authentication->is_signed_in())
        {
            if (is_admin())
            {
                $sql_query = "SELECT *
                           FROM `account`
                           JOIN `account_details` ON `account`.`id` = `account_details`.`account_id`
                           AND `account`.`payed` = 0
                           LEFT JOIN `account_facebook` ON `account_facebook`.`account_id` = `account`.`id`
                           LEFT JOIN `account_twitter` ON `account_twitter`.`account_id` = `account`.`id`
                           ORDER BY `account`.`username`";
                $query = $this->db->query($sql_query);
                $users = $query->result_array();

                $this->load->library('pool');
               
                $data = array(
                            'users'   => $users,
                            'account'   => $this->account_model->get_by_id($this->session->userdata('account_id')),
                            'account_details' => $this->account_details_model->get_by_account_id($this->session->userdata('account_id')),
                            'content_main' => 'admin/admin_users',
                            'title' => lang('unpayed_users')
                            );
               
                $this->load->view('template/template', $data);
            }
            else
            {
            redirect('account/sign_in/?continue='.site_url('admin/users/unpayed'));
            }
        }
        else
        {
            redirect('account/sign_in/?continue='.site_url('admin/users/unpayed'));
        }
    }
    function edit($account_id, $action = "")
    {
        if ($this->authentication->is_signed_in() && is_admin())
        {
            if ($action == 'save')
            {
                //echo "<pre>";print_r($this->input->post('account'));echo "</pre>";
                $account = $this->input->post('account');
                $sql_query = "SELECT * FROM `account` WHERE `id` = $account_id";
                $query = $this->db->query($sql_query);
                $user_ex = $query->row_array();
                
                if($account['username'] != $user_ex['username'])
                {
                    $this->account_model->update_username($account_id, $account['username']);
                } 

                if($account['email'] != $user_ex['email'])
                {
                    $this->account_model->update_email($account_id, $account['email']);
                }
                 
                
                if (is_array($this->input->post('details')))
                {
                    $details = $this->input->post('details');
                }
                
                if(isset($details))
                {
                    $this->account_details_model->update($account_id, $details);
                }

                $this->session->set_flashdata('info', lang('data_saved'));
                redirect ('admin/users/edit/'.$account_id);                
                
            }
            else
            {
            
            $sql_query = "SELECT `id`,`username`,`email` FROM `account` WHERE `id` = '$account_id'";
            $query = $this->db->query($sql_query);
            $user = $query->row_array();
            //print_r($user);
            
            $sql_query = "SELECT `fullname`, `firstname`, `lastname`, `pred_total_goals`, `pred_champion`, `company`, `dateofbirth`, `gender`, `postalcode`, `country`, `language`, `timezone`, `picture` FROM `account_details` WHERE `account_id` = '$account_id'";
            $query = $this->db->query($sql_query);
            $user_details = $query->row_array();
            //print_r($user_details);

            $sql_query = "SELECT `facebook_id`,`linkedon` FROM `account_facebook` WHERE `account_id` = '$account_id'";
            $query = $this->db->query($sql_query);
            $user_facebook = $query->row_array();

            $sql_query = "SELECT `twitter_id`,`oauth_token`,`oauth_token_secret`, `linkedon` FROM `account_twitter` WHERE `account_id` = '$account_id'";
            $query = $this->db->query($sql_query);
            $user_twitter = $query->row_array();
            
            $data = array(
                        'user'   => $user,
                        'user_details' =>$user_details,
                        'user_facebook' => $user_facebook,
                        'user_twitter' => $user_twitter,
                        'account'   => $this->account_model->get_by_id($this->session->userdata('account_id')),
                        'account_details' => $this->account_details_model->get_by_account_id($this->session->userdata('account_id')),
                        'content_main' => 'admin/admin_user_edit',
                        'title' => "Edit user"
                        );
           
            $this->load->view('template/template', $data);
            }
        
        }
        else
        {
            redirect('account/sign_in/?continue='.site_url('admin/users/unpayed'));
        }        
    
    
    }
}
?>
