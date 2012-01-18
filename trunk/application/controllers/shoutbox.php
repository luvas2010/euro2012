<?php

class Shoutbox extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        
        // Load the necessary stuff...
        $this->load->helper(array('language', 'url', 'form', 'ssl'));
        $this->load->library(array('authentication'));
        $this->load->model(array('account_model'));
        $this->load->model(array('account_details_model'));
        $this->db->select('language');
        $query = $this->db->get_where('account_details', array('account_id' => $this->session->userdata('account_id')));
        $lang = $query->row_array();
        if (isset($lang['language'])) $this->config->set_item('language',$lang['language']);        
        $this->lang->load(array('general', 'welcome'));
    }
    
    function index()
    {

    }
    
    function add()
    {
        $this->load->library('session');
        $this->load->helper('date');
        $this->load->model(array('account_model', 'account_details_model'));
        $user = $this->account_model->get_by_id($this->session->userdata('account_id'));
		$user_details = $this->account_details_model->get_by_account_id($this->session->userdata('account_id'));
        $shout = addslashes(strip_tags(trim($this->input->post('shouttxt'))));
        $account_id = $user->id;
        $username = $user->username;
        $timestamp = time();
		$sql_query = "SELECT * FROM `shoutbox` WHERE `account_id` = '$account_id' AND `message` = '$shout' AND `postedon` > $timestamp - 600"; // can't post the same exact message within 10 minutes
		$query = $this->db->query($sql_query);
		$doublepost = $query->num_rows();
		
		$sql_query = "SELECT * FROM `shoutbox` WHERE `account_id` = '$account_id' AND `postedon` > $timestamp - 60"; // can't post messages within 1 minute from each other
		$query = $this->db->query($sql_query);
		$freqpost = $query->num_rows();
		if($doublepost == 0 && $freqpost == 0 && strlen($shout) <= 255 && strlen($shout) > 2)
		{
			$sql_query = "INSERT INTO `shoutbox` (
							`account_id` ,
							`username` ,
							`message` ,
							`postedon`
							)
							VALUES (
							'$account_id', '$username', '$shout', '$timestamp'
							)";
			$query = $this->db->query($sql_query);
			}
		elseif ($doublepost >0)
		{
			
			echo "<p class='error centertext'>you already said that</p>";
		}
		elseif ($freqpost >0)
        {
			echo "<p class='error centertext'>Not so fast</p>";
		}
		elseif (strlen($shout > 255))
		{
			echo "<p class='error centertext'>Too long!</p>";
		}
		echo $this->getshouts(5);
		
    }

    function getshouts($num)
    {
        $this->load->helper(array('date', 'url'));
		$this->load->model(array('account_model', 'account_details_model'));
		$user = $this->account_model->get_by_id($this->session->userdata('account_id'));
		
        $sql_query = "SELECT * FROM `shoutbox` ORDER BY `postedon` DESC LIMIT $num";
        $query = $this->db->query($sql_query);
        $shouts = $query->result_array();
        $html ="";
        foreach ($shouts as $shout)
        {
			$account_details = $this->account_details_model->get_by_account_id($shout['account_id']);
			if (isset($account_details->picture))
			{
                    $imgstring = "<img src='".base_url()."resource/user/profile/".$account_details->picture."?t=".md5(time())."' alt='' width='50px' height='50px' style='float:left;' />";
            }
			else
			{
                    $imgstring = "<img src='".base_url()."resource/img/default-picture.gif' alt='' width='50px' height='50px'  style='float:left;'/>";
            }
            $html .= "<p><span class='boldtext'>".$shout['username'].", ".mdate("%d %M %Y %H:%i",$shout['postedon'])."</span></p>".$imgstring."<p>".$shout['message']."</p>";
            if ($shout['account_id'] == $this->session->userdata('account_id'))
            {
                $html .= "<a href='".site_url('shoutbox/delete')."/".$shout['id']."'>Delete</a><hr/>";
            }
            else
            {
                $html .= "<hr/>";
            }    
        }    
        
        echo $html;

    }

    function delete($shout_id)
    {
        $sql_query = "DELETE FROM `shoutbox` WHERE `id` = $shout_id";
        $query = $this->db->query($sql_query);
        $this->session->set_flashdata('info', lang('shout_deleted'));
        redirect('/');
    }
}


/* End of file rules.php */
/* Location: ./system/application/controllers/rules.php */
