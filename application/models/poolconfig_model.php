<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Poolconfig_model extends CI_Model {

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
     * Get setting by id
     *
     * @access public
     * @param string $account_id
     * @return object account object
     */
	function get_by_id($setting_id)
    {
        return $this->db->get_where('pool_config', array('setting_uid' => $setting_id))->row();
    }
	
	 /**
     * Get setting by name
     *
     * @access public
     * @param string $username
     * @return object account object
     */
    function get_by_setting($setting)
    {
        return $this->db->get_where('pool_config', array('setting' => $setting))->row();
    }
	
	/* get a value by id 
	 * returns just the value!
	 */
	function value_by_id($setting_id)
    {
        $row = $this->db->get_where('pool_config', array('setting_uid' => $setting_id))->row_array();
		return $row['value'];
    }
	
	/* get a value by setting name
	 * return just the value!
	 */ 
	function get_value($setting)
	{
	    $row = $this->db->get_where('pool_config', array('setting' => $setting))->row_array();
		return $row['value'];
    }
	
	/* get all settings as an array */
	
	function get_all_settings()
	{
		return $this->db->get('pool_config')->result_array();
	}

	// to do: update setttings when saved
	// to do: batch update settings
	// to do: replace all $this->config->item('name') with $this->poolconfig_model->get_value('name')
	
}