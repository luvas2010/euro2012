<?php
class Teams extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('Facebook_model');
	}
	
	function index()
	{
		$fb_data = $this->session->userdata('fb_data');
		$sql_query = "SELECT * FROM team WHERE 'team_uid' < 300";
		$query = $this->db->query($sql_query);
		$teams = $query->result_array();
		$data = array(
					'fb_data'	=> $fb_data,
					'teams'		=> $teams
					);
        $data['content_main'] = "teams";
		$data['title'] = "Teams";
		$this->load->view('template/template', $data);
	}
	

}
?>
