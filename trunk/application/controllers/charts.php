<?php
class Charts extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        // Load the necessary stuff...
        $this->load->helper(array('language', 'url', 'form', 'ssl', 'pool', 'date'));
        $this->load->library(array('authentication'));
        $this->load->model(array('account_model','poolconfig_model'));
        $this->load->model(array('account_details_model'));
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
        $this->lang->load(array('general', 'predictions'));
    }
    
    
    function index()
    {
    }
    
    function top($num = 10)
    {
        if ($this->authentication->is_signed_in())
        {
            $this->load->library('pool');
            $topusers = $this->pool->get_top_ranking($num);
            $data = array(
                            'topusers'          => $topusers,
                            'num'               => $num,
                            'account'           => $this->account_model->get_by_id($this->session->userdata('account_id')),
                            'account_details'   => $this->account_details_model->get_by_account_id($this->session->userdata('account_id')),
                            'filter'            => $this->input->post('company')
                            );
                $data['content_main'] = "charts_topuser";
                $data['title'] = lang('standings');
        
                $this->load->view('template/template', $data);
        }
        else
        {
            redirect('account/sign_in/?continue='.site_url('charts/top/'.$num));
        }
    }
    
    function champion()
    {
        if ($this->authentication->is_signed_in())
        {
            $sql_query = "SELECT `pred_champion`, COUNT(`account_id`) as `number`
                          FROM `account_details`
                          WHERE `pred_champion` <> ''
                          AND   `pred_champion` <> 'NULL'
                          GROUP BY `pred_champion`";
            $query = $this->db->query($sql_query);
            $champions = $query->result_array();
            $total = 0;
            if ($query->num_rows() > 0)
            {
                foreach ($champions as $champion)
                {
                    $total = $total + $champion['number'];
                }
                reset($champions);
                foreach ($champions as $c)
                {
                    $percentage[$c['pred_champion']] = number_format(($c['number'] / $total) * 100, 1);
                    
                }
                //echo "<pre>"; print_r($percentage); echo "</pre>";
                //echo "<pre>"; print_r($champions); echo "</pre>";
                $data = array(
                                'percentage'        => $percentage,
                                'account'           => $this->account_model->get_by_id($this->session->userdata('account_id')),
                                'account_details'   => $this->account_details_model->get_by_account_id($this->session->userdata('account_id'))
                                );
             }
             else
             {
                $data = array(
                                'percentage'        => 0,
                                'account'           => $this->account_model->get_by_id($this->session->userdata('account_id')),
                                'account_details'   => $this->account_details_model->get_by_account_id($this->session->userdata('account_id'))
                                );
            }                  
                $data['content_main'] = "charts_champion";
                $data['title'] = lang('standings');
        
                $this->load->view('template/template', $data);
        }
        else
        {
            redirect('account/sign_in/?continue='.site_url('charts/champion'));
        }
    }

    function totalgoals()
    {
        
        if ($this->authentication->is_signed_in())
        {
            $sql_query = "SELECT `pred_total_goals`, COUNT(`account_id`) as `number`
                          FROM `account_details`
                          WHERE `pred_total_goals` > 0
                          AND   `pred_champion` <> 'NULL'
                          GROUP BY `pred_total_goals`";
            $query = $this->db->query($sql_query);
            $totalgoals = $query->result_array();
            if ($query->num_rows() > 0)
            { 
                foreach ($totalgoals as $total)
                {
                    $pred_goals[$total['pred_total_goals']] = $total['number'];
                }    
                
                
                $sql_query = "SELECT *
                              FROM `match`
                              WHERE `match_calculated` = 1";
                $query = $this->db->query($sql_query);
                $calculated_matches = $query->result_array();
                $num_calculated_matches = $query->num_rows();
                $goals_scored = 0;
                foreach ($calculated_matches as $match)
                {
                    $goals_scored = $goals_scored + $match['home_goals'] + $match['away_goals'];
                }
                if ($num_calculated_matches > 0)
                {
                    $average_goals = $goals_scored/$num_calculated_matches;
                }
                else
                {
                    $average_goals = 0;
                }    
                $total_with_average = $average_goals * 31;
                
                $data = array(
                                'pred_goals'        => $pred_goals,
                                'average_goals'     => $average_goals,
                                'num_matches'       => $num_calculated_matches,
                                'total_with_average' => $total_with_average,
                                'account'           => $this->account_model->get_by_id($this->session->userdata('account_id')),
                                'account_details'   => $this->account_details_model->get_by_account_id($this->session->userdata('account_id'))
                                );
            }
            else
            {
                $data = array(
                    'pred_goals'        => 0,
                    'average_goals'     => 0,
                    'num_matches'       => 0,
                    'total_with_average' => 0,
                    'account'           => $this->account_model->get_by_id($this->session->userdata('account_id')),
                    'account_details'   => $this->account_details_model->get_by_account_id($this->session->userdata('account_id'))
                    );
            }
                $data['content_main'] = "charts_total_goals";
                $data['title'] = lang('standings');
        
                $this->load->view('template/template', $data);
        }
        else
        {
            redirect('account/sign_in/?continue='.site_url('totalgoals'));
        }
    }
    
}
