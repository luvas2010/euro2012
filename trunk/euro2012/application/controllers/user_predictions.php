<?php
class User_predictions extends Controller {

	public function __construct() {
		parent::Controller();
		
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
	}

    public function index(){
    
    }
    
	public function view($user_id) {
        $settings = $this->settings_functions->settings();
        if (logged_in()) {
            if (($user_id == Current_User::user()->id) || ($settings['view_other_users'])) {
                 // Lookup the matches in this group, and their predictions by this user
                $vars['predictions'] = Doctrine_Query::create()
                    ->select('m.match_name,
                              m.match_number,
                              m.match_time,
                              m.home_goals,
                              m.away_goals,
                              m.home_id,
                              m.time_close,
                              m.match_group,
                              th.name,
                              ta.name,
                              p.home_goals,
                              p.away_goals,
                              p.points_total_this_match,
                              p.calculated,
                              u.nickname
                              ')
                    ->from('Predictions p, p.Match m, m.TeamHome th, m.TeamAway ta, m.Venue v, p.User u')
                    ->where('p.user_id = '.$user_id)
                    ->orderBy('m.match_time')
                    ->execute();
                
                foreach ($vars['predictions'] as $prediction)
                    {
                    $num = $prediction->Match->match_number;
                    if (mysql_to_unix($prediction->Match->time_close) > time())
                        {
                        $closed[$num] = 0;
                        }
                    else
                        {
                        $closed[$num] = 1;
                        }
                    }
                $vars['closed'] = $closed;    
                $vars['title'] = "Predictions Overview";
                $vars['content_view'] = "user_predictions";		
                $vars['settings'] = $this->settings_functions->settings();
		    $this->load->view('template', $vars);
		    }
		    elseif (!$settings['view_other_users']) {
                $vars['message'] = "You are not allowed to see other users predictions!";
                $vars['title'] = "Not allowed";
                $vars['content_view'] = "error";
                $vars['settings'] = $this->settings_functions->settings();
		        $this->load->view('template', $vars);		        
        }    
        else {
            // No user is logged in
            // Current user is not an admin
            $vars['title'] = "Not logged in";
            $vars['content_view'] = "not_logged_in";
            $vars['settings'] = $this->settings_functions->settings();
		    $this->load->view('template', $vars);
            }
        }                
	}
	
	
	public function edit() {
        $settings = $this->settings_functions->settings();
        if (logged_in()) {
            $user_id = logged_in();
             // Lookup the matches in this group, and their predictions by this user
            $vars['predictions'] = Doctrine_Query::create()
                ->select('m.match_name,
                          m.match_number,
                          m.match_time,
                          m.home_goals,
                          m.away_goals,
                          m.home_id,
                          m.time_close,
                          m.match_group,
                          m.type_id,
                          th.name,
                          th.flag,
                          ta.name,
                          ta.flag,
                          p.home_goals,
                          p.away_goals,
                          p.points_total_this_match,
                          p.calculated,
                          p.home_id,
                          p.away_id,
                          u.nickname,
                          v.name,
                          v.time_offset_utc
                          ')
                ->from('Predictions p, p.Match m, m.TeamHome th, m.TeamAway ta, m.Venue v, p.User u')
                ->where('p.user_id = '.$user_id)
                ->orderBy('m.match_time')
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();
            
            foreach ($vars['predictions'] as $prediction)
                {
                $num = $prediction['Match']['match_number'];
                if (mysql_to_unix($prediction['Match']['time_close']) > time())
                    {
                    $closed[$num] = 0;
                    }
                else
                    {
                    $closed[$num] = 1;
                    }
                }
            $vars['closed'] = $closed;    
            $vars['title'] = "Change your predictions";
            $vars['content_view'] = "user_predictions_edit";		
            $vars['settings'] = $this->settings_functions->settings();
		    $this->load->view('template', $vars);
            }
        else {
            // No user is logged in
            // Current user is not an admin
            $vars['title'] = "Not logged in";
            $vars['content_view'] = "not_logged_in";
            $vars['settings'] = $this->settings_functions->settings();
		    $this->load->view('template', $vars);
            }                
	}
}
