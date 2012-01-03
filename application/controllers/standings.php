<?php
class Standings extends CI_Controller {

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
        maintain_ssl();
        
        if ($this->authentication->is_signed_in())
        {       
            $account_id = $this->session->userdata('account_id');
            
            $sql_query = "SELECT *,
                            ( pred_points_home_goals + pred_points_away_goals + pred_points_result + pred_points_home_team + pred_points_away_team +pred_points_bonus) AS total_points
                            FROM `prediction`
                            JOIN `account`
                            ON  `account`.`id` = `prediction`.`account_id`
                            JOIN `match`
                            ON `match`.`match_uid` = `prediction`.`pred_match_uid`
                            AND `pred_calculated` = 1
                            GROUP BY `pred_match_uid`,`account_id`";
            
            $query = $this->db->query($sql_query);
            $results = $query->result_array();
            $num = $query->num_rows();
            if ($num>0)
            {
                foreach($results as $result)
                {
                    $points[$result['account_id']]['total_points'] =  0;
                    $points[$result['account_id']]['matches'][$result['match_group']] = 0;
                    $points[$result['account_id']]['username'] =  $result['username'];
                    $points[$result['account_id']]['account_id'] =  $result['account_id'];
                }
                foreach($results as $result)
                {
                    $points[$result['account_id']]['total_points'] = $points[$result['account_id']]['total_points'] + $result['total_points'];
                    $points[$result['account_id']]['matches'][$result['match_group']] = $points[$result['account_id']]['matches'][$result['match_group']] + $result['total_points'];
                }
                
                // Sort on total points
                foreach ($points as $key => $row) {
                    $total_points[$key]  = $row['total_points'];

                }

                // Sort the data with total_points descending
                array_multisort($total_points, SORT_DESC, $points);            
            }
            else
            {
                $points = 0;
            }
            //echo "<pre>";print_r($points); echo "</pre>";
            $data = array(
                        'points'           => $points,
                        'num'               => $num,
                        'account'           => $this->account_model->get_by_id($this->session->userdata('account_id')),
                        'account_details'   => $this->account_details_model->get_by_account_id($this->session->userdata('account_id'))
                        );
            $data['content_main'] = "standings";
            $data['title'] = lang('standings');
    
            $this->load->view('template/template', $data);
        }
        else
        {
            redirect('account/sign_in/?continue='.site_url('standings'));
        }
    }
    
    function show($view_account_id, $group)
    {

        if ($this->authentication->is_signed_in())
        {       
            $sql_query = "SELECT *
                          FROM `prediction`
                          JOIN `match`
                          ON `match`.`match_uid` = `prediction`.`pred_match_uid`
                          AND `match`.`match_group` = '$group'
                          AND `prediction`.`account_id` = '$view_account_id'
                          AND `prediction`.`pred_calculated` = 1
                          ORDER BY `prediction`.`pred_match_uid`";
            $query = $this->db->query($sql_query);
            $predictions = $query->result_array();
            $view_account = $this->account_model->get_by_id($view_account_id);
            //echo "<pre>";print_r($predictions);echo "</pre>";
            $data = array(
                        'account'           => $this->account_model->get_by_id($this->session->userdata('account_id')),
                        'account_details'   => $this->account_details_model->get_by_account_id($this->session->userdata('account_id')),
                        'predictions'       => $predictions,
                        'content_main'      => "show_user_pred",
                        'title'             => sprintf(lang('overview_of_points_for'), $view_account->username, lang($group)),
                        'view_account'       => $view_account
                        );
    
            $this->load->view('template/template', $data);
        }
        else
        {
            redirect('account/sign_in/?continue='.site_url('standings'));
        }
    } 
}
