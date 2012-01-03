<?php
class Group extends CI_Controller {

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
		$this->lang->load(array('general', 'group'));
	}
	
    function index() {
    }
    
    
	function show($group)
	{
		maintain_ssl();
        
		if ($this->authentication->is_signed_in())
		{
			//$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
            //$data['account_details'] = $this->account_details_model->get_by_account_id($this->session->userdata('account_id'));
            
            $this->load->library('pool');
            $account_id = $this->session->userdata('account_id');
            $sql_query = "SELECT *
                            FROM `match`
                            JOIN `prediction`
                            ON `match`.`match_uid` = `prediction`.`pred_match_uid`
                            AND `match`.`match_group` = '$group'
                            AND `prediction`.`account_id` = '$account_id'
                            ORDER BY `match_uid`";
            
            $query = $this->db->query($sql_query);
            $matches = $query->result_array();
            
           
            $data = array(
                        'results'	=> $this->pool->calculate_group($group),
                        'pred_results' => $this->pool->calculate_pred_group($group),
                        'matches'   => $matches,
                        'group'     => $group,
                        'account'   => $this->account_model->get_by_id($this->session->userdata('account_id')),
                        'account_details' => $this->account_details_model->get_by_account_id($this->session->userdata('account_id'))
                        );
           
            $data['content_main'] = "group";
            $data['title'] = sprintf(lang('group_name_overview'), $group);
            
            $this->load->view('template/template', $data);
        }
        else
        {
            redirect('account/sign_in/?continue='.site_url('group/show/'.$group));
        }    
	}
	

}
?>
