<?php
class User_predictions_a extends Controller {

	public function __construct() {
		parent::Controller();
		
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
	}

	public function index() {

        if(Current_User::user()){
            $user_id = Current_User::user()->id;
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
                          p.calculated
                          ')
                ->from('Predictions p, p.Match m, m.TeamHome th, m.TeamAway ta, m.Venue v')
                ->where('p.user_id = '.$user_id.' AND m.match_group = "A"')
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
            $vars['title'] = "Predictions Group A";
            $vars['content_view'] = "user_predictions";		
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
