<?php
class Results extends CI_Controller {

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
        $this->lang->load(array('general','standings'));
    }
    
    function index()
    {
    }
    
    function show($match_uid)
    {
        maintain_ssl();
        
        if ($this->authentication->is_signed_in())
        {       
            $account_id = $this->session->userdata('account_id');
            
            $sql_query = "SELECT *,
                          ( pred_points_home_goals + pred_points_away_goals + pred_points_result + pred_points_home_team + pred_points_away_team +pred_points_bonus) AS total_points
                          FROM `prediction`
                          JOIN `match`
                          ON `match`.`match_uid` = `prediction`.`pred_match_uid`
                          AND `match`.`match_uid` = $match_uid
                          JOIN `account`
                          ON `account`.`id` = `prediction`.`account_id`
                          ORDER BY `total_points` DESC";
            
            $query = $this->db->query($sql_query);
            $results = $query->result_array();
            
            $data['match_uid'] = $match_uid;
            $data['results'] = $results;
            $data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
            $data['account_details'] = $this->account_details_model->get_by_account_id($this->session->userdata('account_id'));
            $data['title'] = sprintf(lang('results_for_match'), get_match($match_uid))." (".$results[0]['home_goals']." - ".$results[0]['away_goals'].")";
            $data['content_main'] = "show_results";
            
            $data['share_url']  = base_url().'results/show/'.$match_uid;
            if (!isset($results[0]['username']) || !isset($results[1]['username']) || !isset($results[2]['username']))
            {
                $data['share_text_twitter'] = sprintf(lang('share_text_twitter'),get_match($match_uid), '?', '?', '?');
                $data['share_text_facebook'] = sprintf(lang('share_text_facebook'), get_match($match_uid), '?', '?', '?');
            }
            else
            {
                $data['share_text_twitter'] = sprintf(lang('share_text_twitter'),get_match($match_uid), $results[0]['username'], $results[1]['username'], $results[2]['username']);
                $data['share_text_facebook'] = sprintf(lang('share_text_facebook'), get_match($match_uid), $results[0]['username'], $results[1]['username'], $results[2]['username']);
            }
            $this->load->view('template/template', $data);
        }
        else
        {
            redirect('account/sign_in/?continue='.site_url('results/show/'.$match_uid));
        }
    } 
}
