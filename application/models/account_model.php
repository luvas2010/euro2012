<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        
        //$this->load->config('account');
        $this->load->library('session');
        $this->load->helper(array('language', 'url'));
        $this->db->select('language');
        $query = $this->db->get_where('account_details', array('account_id' => $this->session->userdata('account_id')));
        $lang = $query->row_array();
        if (isset($lang['language']))  {$this->config->set_item('language',$lang['language']);}
        $this->load->language(array('general', 'sign_up'));
    
    }
    
    /**
     * Get account by id
     *
     * @access public
     * @param string $account_id
     * @return object account object
     */
    function get_by_id($account_id)
    {
        return $this->db->get_where('account', array('id' => $account_id))->row();
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Get account by username
     *
     * @access public
     * @param string $username
     * @return object account object
     */
    function get_by_username($username)
    {
        return $this->db->get_where('account', array('username' => $username))->row();
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Get account by email
     *
     * @access public
     * @param string $email
     * @return object account object
     */
    function get_by_email($email)
    {
        return $this->db->get_where('account', array('email' => $email))->row();
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Get account by username or email
     *
     * @access public
     * @param string $username_email
     * @return object account object
     */
    function get_by_username_email($username_email)
    {
        return $this->db->from('account')->where('username', $username_email)->or_where('email', $username_email)->get()->row();
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Create an account
     *
     * @access public
     * @param string $username
     * @param string $hashed_password
     * @return int insert id
     */
    function create($username, $email = NULL, $password = NULL)
    {
        // Create password hash using phpass
        if ($password !== NULL)
        {
            $this->load->helper('phpass');
            $hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
            $hashed_password = $hasher->HashPassword($password);
        }
        
        $this->load->helper('date', 'url');
        
        $data = array(
            'username' => $username, 
            'email' => $email, 
            'password' => isset($hashed_password) ? $hashed_password : NULL, 
            'createdon' => mdate('%Y-%m-%d %H:%i:%s', now())
            );
        
        if (!$this->config->item('verify_users'))
            {
                // users are automatically verified in this case
                $data['verifiedon'] = mdate('%Y-%m-%d %H:%i:%s', now());
            }
        
        $this->db->insert('account', $data);
        
        $id = $this->db->insert_id();
        
        // Create predictions for this user
        $sql_query = "SELECT * FROM `match`";
        $query = $this->db->query($sql_query);
        $matches = $query->result_array();
        
            foreach ($matches as $match) {
                $match_uid = $match['match_uid'];
                $sql_query = "INSERT INTO `prediction` (`account_id`,`pred_match_uid`) VALUES ('$id', '$match_uid')";
                $insert = $this->db->query($sql_query);
            }
        
         if ($this->config->item('sign_up_email_admin')) // Need to send the admin account an e-mail
         {
            // Email administrator account
            
            // Load email library
            $this->load->library('email');
            $config['mailtype'] = 'html';

            $this->email->initialize($config);
            $sql_query = "SELECT `email`
                          FROM `account`
                          WHERE `is_admin` = 1";
            $query = $this->db->query($sql_query);
            $row = $query->row_array();
            if (isset($row['email']))
            {
                $admin_email = $row['email'];
                            
                // Send user sign up e-mail
                $this->email->from($this->config->item('email_from_address'), lang('reset_password_email_sender')); //same account as reset password e-mail
                $this->email->to($admin_email);
                $this->email->subject(lang('signup_email_subject'));
                
                $message = sprintf(lang('signup_email_message'), $username);
                if ($this->config->item('verify_users'))
                {
                    $verify_link = anchor('admin/users/unverified');
                    $message = $message.sprintf(lang('signup_verify_message'), $verify_link);
                }
                $message = $message.sprintf(lang('signup_email_footer'), lang('website_title'));
                $this->email->message($message);
                
                @$this->email->send();
            }
        }
        
        return $id;
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Change account username
     *
     * @access public
     * @param int $account_id
     * @param int $new_username
     * @return void
     */
    function update_username($account_id, $new_username)
    {
        $this->db->update('account', array('username' => $new_username), array('id' => $account_id));
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Change account email
     *
     * @access public
     * @param int $account_id
     * @param int $new_email
     * @return void
     */
    function update_email($account_id, $new_email)
    {
        $this->db->update('account', array('email' => $new_email), array('id' => $account_id));
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Change account password
     *
     * @access public
     * @param int $account_id
     * @param int $hashed_password
     * @return void
     */
    function update_password($account_id, $password_new)
    {
        $this->load->helper('phpass');
        $hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
        $new_hashed_password = $hasher->HashPassword($password_new);
        
        $this->db->update('account', array('password' => $new_hashed_password), array('id' => $account_id));
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Update account last signed in dateime
     *
     * @access public
     * @param int $account_id
     * @return void
     */
    function update_last_signed_in_datetime($account_id)
    {
        $this->load->helper('date');
        
        $this->db->update('account', array('lastsignedinon' => mdate('%Y-%m-%d %H:%i:%s', now())), array('id' => $account_id));
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Update password reset sent datetime
     *
     * @access public
     * @param int $account_id
     * @return int password reset time
     */
    function update_reset_sent_datetime($account_id)
    {
        $this->load->helper('date');
        
        $resetsenton = mdate('%Y-%m-%d %H:%i:%s', now());
        
        $this->db->update('account', array('resetsenton' => $resetsenton), array('id' => $account_id));
        
        return strtotime($resetsenton);
    }
    
    /**
     * Remove password reset datetime
     *
     * @access public
     * @param int $account_id
     * @return void
     */
    function remove_reset_sent_datetime($account_id)
    {
        $this->db->update('account', array('resetsenton' => NULL), array('id' => $account_id));
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Update account deleted datetime
     *
     * @access public
     * @param int $account_id
     * @return void
     */
    function update_deleted_datetime($account_id)
    {
        $this->load->helper('date');
        
        $this->db->update('account', array('deletedon' => mdate('%Y-%m-%d %H:%i:%s', now())), array('id' => $account_id));
    }
    
    /**
     * Remove account deleted datetime
     *
     * @access public
     * @param int $account_id
     * @return void
     */
    function remove_deleted_datetime($account_id)
    {
        $this->db->update('account', array('deletedon' => NULL), array('id' => $account_id));
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Update account suspended datetime
     *
     * @access public
     * @param int $account_id
     * @return void
     */
    function update_suspended_datetime($account_id)
    {
        $this->load->helper('date');
        
        $this->db->update('account', array('suspendedon' => mdate('%Y-%m-%d %H:%i:%s', now())), array('id' => $account_id));
    }
    
    /**
     * Remove account suspended datetime
     *
     * @access public
     * @param int $account_id
     * @return void
     */
    function remove_suspended_datetime($account_id)
    {
        $this->db->update('account', array('suspendedon' => NULL), array('id' => $account_id));
    }
    
}


/* End of file account_model.php */
/* Location: ./application/modules/account/models/account_model.php */
