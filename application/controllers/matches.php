<?php
class Matches extends CI_Controller {

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
        $this->lang->load(array('general','matches'));
    }
    
    function index()
    {
        maintain_ssl();
        
        if ($this->authentication->is_signed_in())
        {       
            $account_id = $this->session->userdata('account_id');
            $sql_query = "SELECT *
                            FROM `match`
                            JOIN `prediction`
                            ON `match`.`match_uid` = `prediction`.`pred_match_uid`
                            AND `prediction`.`account_id` = '$account_id'
                            ORDER BY `match`.`match_uid` ASC";
            $query = $this->db->query($sql_query);
            $matches = $query->result_array();
            $data = array(
                        'matches'           => $matches,
                        'account'           => $this->account_model->get_by_id($this->session->userdata('account_id')),
                        'account_details'   => $this->account_details_model->get_by_account_id($this->session->userdata('account_id'))
                        );
            $data['content_main'] = "matches";
            $data['title'] = lang('overview_matches');
            
            if (is_admin())
            {
                $data['admin'] = 1;
            }
            else
            {
                $data['admin'] = 0;
            }
            $this->load->view('template/template', $data);
        }
        else
        {
            redirect('account/sign_in/?continue='.urlencode(base_url().'/matches'));
        }
    }
    
    function result($match_uid, $action = NULL)
    {
        maintain_ssl();
        
        if ($this->authentication->is_signed_in())
        {   
            if (is_admin())
            {
                $sql_query = "SELECT *
                              FROM `match`
                              WHERE match.match_uid = '$match_uid'";
                $query = $this->db->query($sql_query);
                $match = $query->row_array();

                if ($action != 'save')
                {                    
                    $data = array(
                                'match'             => $match,
                                'account'           => $this->account_model->get_by_id($this->session->userdata('account_id')),
                                'account_details'   => $this->account_details_model->get_by_account_id($this->session->userdata('account_id'))
                                );
                    
                    $data['content_main'] = "match_result";
                    $data['title'] = "Edit Match ".get_team_name($match['home_team'])." - ".get_team_name($match['away_team']);
                    $this->load->view('template/template', $data);
                }
                else
                {
                    //save match data to database
                    $this->load->library('form_validation');
                    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
                    $this->form_validation->set_rules('home_goals','Home Goals','trim|is_natural');
                    $this->form_validation->set_rules('away_goals','Away Goals','trim|is_natural');
                    $this->form_validation->set_message('is_natural', '&lsquo;%s&rsquo; can only be 0 or a positive number.');
                    if ($this->form_validation->run() == FALSE)
                    {
                        //                        
                        $data = array(
                                    'match' => $match,
                                    'account'           => $this->account_model->get_by_id($this->session->userdata('account_id')),
                                    'account_details'   => $this->account_details_model->get_by_account_id($this->session->userdata('account_id'))
                                    );
                        
                        $data['content_main'] = "match_result";
                        $data['title'] = "Edit Match ".get_team_name($match['home_team'])." - ".get_team_name($match['away_team']);
                        $this->load->view('template/template', $data);
                    }
                    else
                    {
                        $home_goals = $this->input->post('home_goals');
                        $away_goals = $this->input->post('away_goals');
                        $match_uid = $this->input->post('match_uid');
                        $match_group = $this->input->post('match_group');
                        if ($home_goals == "")
                        {
                            $home_sql = "`home_goals` = NULL";
                        }
                        else
                        {
                            $home_sql = "`home_goals` = '$home_goals'";
                        }
                        
                        if ($away_goals == "")
                        {
                            $away_sql = "`away_goals` = NULL";
                        }
                        else
                        {
                            $away_sql = "`away_goals` = '$away_goals'";
                        }
                        
                        $sql_query = "UPDATE `match` SET ".$home_sql.",".$away_sql." WHERE `match`.`match_uid` = '$match_uid'";
                        $update = $this->db->query($sql_query);
                        $this->session->set_flashdata('info', lang('data_saved'));
                        redirect('group/show/'.strtoupper($match_group));

                    }                    
                }

            }
            else
            {
                redirect("/");
            }
        }
        else
        {
            redirect('account/sign_in/?continue='.urlencode(base_url().'/matches/result/'.$match_uid));
        }
    }
    
    
    function edit_prediction($match_uid, $action = NULL)
    {
        maintain_ssl();
        
        if ($this->authentication->is_signed_in())
        {
            if ($action != 'save')
            {
                $account_id = $this->session->userdata('account_id');
                $sql_query = "SELECT *
                              FROM `prediction`
                              WHERE `prediction`.`pred_match_uid` = '$match_uid'
                              AND   `prediction`.`account_id` = '$account_id'";
                $query = $this->db->query($sql_query);
                
                $data = array(
                    'account'           => $this->account_model->get_by_id($this->session->userdata('account_id')),
                    'account_details'   => $this->account_details_model->get_by_account_id($this->session->userdata('account_id')),
                    'title'             => sprintf(lang('edit_prediction_for'),get_match($match_uid)),
                    'content_main'      => "prediction_edit",
                    'prediction'        => $query->row_array()
            );

            $this->load->view('template/template', $data);
            }
            else
            {
                //save data
                $pred_home_goals = $this->input->post('pred_home_goals');
                $pred_away_goals = $this->input->post('pred_away_goals');
                $prediction_uid = $this->input->post('prediction_uid');
                $sql_query = "UPDATE `prediction`
                              SET `pred_home_goals` = '$pred_home_goals',
                                  `pred_away_goals` = '$pred_away_goals'
                              WHERE `prediction_uid` = '$prediction_uid'";
                $query = $this->db->query($sql_query);
                
                $account_id = $this->session->userdata('account_id');
                $sql_query = "SELECT *
                                FROM `prediction`
                                JOIN `match`
                                ON `prediction`.`pred_match_uid` = `match`.`match_uid` AND prediction.account_id = '$account_id'
                                ORDER BY `prediction`.`pred_match_uid` ASC
                                ";
                $query = $this->db->query($sql_query);
                
                $this->lang->load('predictions');
                $data = array(
                    'account'           => $this->account_model->get_by_id($this->session->userdata('account_id')),
                    'account_details'   => $this->account_details_model->get_by_account_id($this->session->userdata('account_id')),
                    'title'             => sprintf(lang('edit_prediction_for'),get_match($match_uid)),
                    'info'              => sprintf(lang('prediction_saved'),get_match($match_uid)),
                    'predictions'       => $query->result_array(),
                    'content_main'      => "predictions"
                    );

                $this->load->view('template/template', $data);
                
                //redirect ('/predictions/');
            }
                              
        }
        else
        {
            redirect('account/sign_in/?continue='.urlencode(base_url().'/matches/edit_prediction/'.$match_uid));
        }
    }
    
}
?>
