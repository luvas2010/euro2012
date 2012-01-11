<?php
class Matches_edit extends CI_Controller {

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
        $this->lang->load(array('general','admin_matches'));
    }
    
    function index($action = NULL)
    {
        if ($this->authentication->is_signed_in() && is_admin())
        {
            $sql_query = "SELECT *
                          FROM `match`
                          ORDER BY `match`.`timestamp`";
            $query = $this->db->query($sql_query);
            $matches = $query->result_array();
            $num = $query->num_rows();
            
            $post_array = $this->input->post();
            
            if ($action == NULL)
            {
                $data = array(
                            'matches'   => $matches,
                            'account'   => $this->account_model->get_by_id($this->session->userdata('account_id')),
                            'account_details' => $this->account_details_model->get_by_account_id($this->session->userdata('account_id')),
                            'content_main' => 'admin/admin_matches_edit',
                            'title' => lang('edit_match_results')
                            );
               
                $this->load->view('template/template', $data);
            }

                        
            if ($action == 'save')
            {
            
            foreach ($post_array['delete'] as $match_uid => $value)
            {
                $this->load->library('pool');
                $this->pool->delete_calc($match_uid);
            }
            
            foreach ($post_array['save'] as $match_uid => $value)
            {

                for ($i=0;$i<$num;$i++)
                {
                    $match_uid = $post_array['match_uid'][$i];
                    if ($post_array['home_goals'][$i] != "")
                    {
                        $home_goals = $post_array['home_goals'][$i];
                        $home_goals_sql = "`home_goals` =  '$home_goals'";
                    }
                    else
                    {
                        $home_goals_sql = "`home_goals` =  NULL";
                    }
                    if ($post_array['away_goals'][$i] != "")
                    {
                        $away_goals = $post_array['away_goals'][$i];
                        $away_goals_sql = "`away_goals` =  '$away_goals'";
                    }
                    else
                    {
                        $away_goals_sql = "`away_goals` =  NULL";
                    }
                    $sql_query = "UPDATE `match`
                                  SET ".$home_goals_sql.",
                                       ".$away_goals_sql."
                                  WHERE `match_uid` = '$match_uid'";
                    $query = $this->db->query($sql_query);
                    
                    if ($match_uid == 31)
                    {
                        $champion = $this->input->post('champion');
                        $sql_query = "UPDATE `match`
                                      SET `winning_team` = '$champion'
                                      WHERE `match_uid` = '$match_uid'";
                        $query = $this->db->query($sql_query);              
                    }
                    
                }
                $this->load->library('pool');
                foreach ($post_array['save'] as $key => $value)
                {
                    if ($key >= 1  and $key <= 31)
                    {
                        $num_calc = $this->pool->calculate_match($key);
                        $this->session->set_flashdata('info', sprintf(lang('data_saved_and_calculated'), $num_calc));
                    }
                    elseif ($key == 99)
                    {
                        $this->session->set_flashdata('info', lang('data_saved'));
                    }
                    else
                    {
                        $this->session->set_flashdata('info', 'WTF?');
                    }
                }
            }
            
            redirect('admin/matches_edit');
            
            // $sql_query = "SELECT *
                              // FROM `match`
                              // ORDER BY `match`.`timestamp`";
                // $query = $this->db->query($sql_query);
                // $matches = $query->result_array();
                // $data = array(
                            // 'matches'   => $matches,
                            // 'account'   => $this->account_model->get_by_id($this->session->userdata('account_id')),
                            // 'account_details' => $this->account_details_model->get_by_account_id($this->session->userdata('account_id')),
                            // 'content_main' => 'admin/admin_matches_edit',
                            // 'info' => lang('data_saved'),
                            // 'title' => lang('edit_match_results')
                            // );
               
                // $this->load->view('template/template', $data);
            }
        }
        else
        {
            redirect('account/sign_in/?continue='.site_url('admin/matches_edit'));
        }
    }
    
}
?>
