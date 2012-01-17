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
        $this->lang->load(array('general', 'rules'));
    }
    
    function index()
    {

    }
    
    function loadshouts()
    {
        $action = $_POST['shout'];
        $sql_query = "SELECT * FROM `shoutbox`";
        $query = $this->db->query($sql_query);
        $data['shouts'] = $query->result_array();
        //return $shouts;
        $this->load->view('shoutbox_view', $data);
    }
    
    function add()
    {
        $this->load->library('session');
        $this->load->helper('date');
        $this->load->model(array('account_model'));
        $user = $this->account_model->get_by_id($this->session->userdata('account_id'));
        $shout = htmlspecialchars(strip_tags(trim($this->input->post('shouttxt'))));
        $account_id = $user->id;
        $username = $user->username;
        $timestamp = time();
        $sql_query = "INSERT INTO `euro2012`.`shoutbox` (
                        `account_id` ,
                        `username` ,
                        `message` ,
                        `postedon`
                        )
                        VALUES (
                        '$account_id', '$username', '$shout', '$timestamp'
                        )";
        $query = $this->db->query($sql_query);
        
        $this->getshouts(5);
    }

    function getshouts($num)
    {
        $this->load->helper('date');
        $sql_query = "SELECT * FROM `shoutbox` ORDER BY `postedon` DESC LIMIT $num";
        $query = $this->db->query($sql_query);
        $shouts = $query->result_array();
        $html ="";
        foreach ($shouts as $shout)
        {
            $html .= "<p><span class='boldtext'>".$shout['username'].", ".mdate("%d %M %Y %H:%i",$shout['postedon'])."</span></p><p>".$shout['message']."</p><hr/>";
        }    
        
        echo $html;

    }    
}


/* End of file rules.php */
/* Location: ./system/application/controllers/rules.php */
