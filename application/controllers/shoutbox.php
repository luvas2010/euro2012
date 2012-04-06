<?php

class Shoutbox extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        
        //Load the necessary stuff...
        $this->load->helper(array('language', 'url', 'form', 'ssl'));
        $this->load->library(array('authentication'));
        $this->load->model(array('account_model','poolconfig_model'));
        $this->load->model(array('account_details_model'));
        $this->db->select('language');
        $query = $this->db->get_where('account_details', array('account_id' => $this->session->userdata('account_id')));
        $lang = $query->row_array();
        if ($lang['language'] == "") { $lang['language'] = $this->config->item('language'); }
        if (isset($lang['language'])) $this->config->set_item('language',$lang['language']);       
        $this->lang->load(array('general', 'welcome', 'shouts'));
    }
    
    function index()
    {

    }
    
    function addshout()
    {
        $this->load->library('session');
        $this->load->helper(array('language','date'));
        $this->load->model(array('account_model', 'account_details_model'));
        $user = $this->account_model->get_by_id($this->session->userdata('account_id'));
		$user_details = $this->account_details_model->get_by_account_id($this->session->userdata('account_id'));
		$this->db->select('language');
        $query = $this->db->get_where('account_details', array('account_id' => $this->session->userdata('account_id')));
        $lang = $query->row_array();
        if ($lang['language'] == "") { $lang['language'] = $this->config->item('language'); }
        if (isset($lang['language'])) $this->config->set_item('language',$lang['language']);        
        $this->lang->load(array('general', 'welcome', 'shouts'));
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
							`account_id`,
							`username`,
							`message`,
							`postedon`
							)
							VALUES (
							'$account_id', '$username', '$shout', '$timestamp'
							)";
			$query = $this->db->query($sql_query);
			}
		elseif ($doublepost >0)
		{
			
			echo "<div class='error centertext'>".lang('you_already_said_that')."</div>";
		}
		elseif ($freqpost >0)
        {
			echo "<div class='error centertext'>".lang('not_so_fast')."</div>";
		}
		elseif (strlen($shout > 255))
		{
			echo "<div class='error centertext'>".lang('message_too_long')."</div>";
		}
		echo $this->getshouts(5);

		
    }

    function getshouts($num)
    {
        $this->load->helper(array('date', 'url', 'text'));
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
                 if (substr($account_details->picture,0,4) == "http")
                    {    
                        $imgstring = "<img src='".$account_details->picture."' alt='' width='50px' height='50px' style='float:left;' />";
                    }
                    else
                    {
                        $imgstring = "<img src='".base_url()."resource/user/profile/".$account_details->picture."?t=".md5(time())."' alt='' width='50px' height='50px' style='float:left;' />";
                    }
            }
			else
			{
                    $imgstring = "<img src='".base_url()."resource/img/default-picture.gif' alt='' width='50px' height='50px'  style='float:left;'/>";
            }
            $shoutlink = anchor('shoutbox/showall#shout'.$shout['id'],character_limiter($shout['message'], 50));
            $html .= "<p><span class='boldtext'>".$shout['username'].", ".mdate("%d %M %Y %H:%i",$shout['postedon'])."</span></p>".$imgstring."<p>".$shoutlink."</p>";
            if ($shout['account_id'] == $this->session->userdata('account_id') || is_admin())
            {
                //$html .= "<div class='clear'></div><a href='".site_url('shoutbox/delete')."/".$shout['id']."' class='button comment_delete'>".lang('delete_shout')." </a><hr/>";
                $html .= "<hr/>";
            }
            else
            {
                $html .= "<hr/>";
            }    
        }    
        
        echo $html;

    }

    function delete($shout_id, $return = "")
    {
        $sql_query = "DELETE FROM `shoutbox` WHERE `id` = $shout_id";
        $query = $this->db->query($sql_query);
        $this->session->set_flashdata('info', lang('shout_deleted'));
        if ($return='box')
        {
			redirect('shoutbox/showall');
        }
        else
        {
            redirect('/');
        }
    }
	
	function showall()
	{
		if ($this->authentication->is_signed_in())
        {
			setlocale(LC_TIME, 'nl_NL');
			$sql_query = "SELECT * FROM `shoutbox` ORDER BY `postedon` DESC";
			$query = $this->db->query($sql_query);
			$shouts = $query->result_array();
			
		$data = array(
			'shouts'           => $shouts,
			'account'           => $this->account_model->get_by_id($this->session->userdata('account_id')),
			'account_details'   => $this->account_details_model->get_by_account_id($this->session->userdata('account_id')),
			'title'				=> lang('all_shouts'),
			'content_main'		=> 'shoutbox'
			);
        
        $this->load->view('template/template', $data);

		}
        else
        {
            redirect('account/sign_in/?continue='.site_url('shoutbox/showall'));
        }
	}
}


/* End of file rules.php */
/* Location: ./system/application/controllers/rules.php */
