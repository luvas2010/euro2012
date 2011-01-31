<?php
class Home extends Controller {

	public function index() {
        // Get all matches    
        if (logged_in()) {
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
                          m.type_id,
                          th.name,
                          th.flag,
                          ta.name,
                          ta.flag,
                          p.*,
                          pth.name,
                          pth.flag,
                          pta.name,
                          pta.flag
                          ')
                ->from('Predictions p, p.Match m, p.TeamHome pth, p.TeamAway pta, m.TeamHome th, m.TeamAway ta, m.Venue v')
                ->where('p.user_id = '.$user_id)
                ->orderBy('m.match_time')
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY) //This makes it quicker, we don't need to update the database, just see the predictions
                ->execute();
        
            foreach ($vars['predictions'] as $prediction)
                {
                $num = $prediction['match_number'];
                if (mysql_to_unix($prediction['Match']['time_close']) > time()) {
                    $closed[$num] = 0;
                    }
                else {
                    $closed[$num] = 1;
                    }
                }

        $vars['closed'] = $closed;
        $vars['title'] = "Home";
		$vars['content_view'] = "match_list";
        $vars['settings'] = $this->settings_functions->settings();
		$this->load->view('template', $vars);
		}
    else {
	    // No user is logged in
        $vars['title'] = "Welcome";
        $vars['content_view'] = "welcome_message";
        $vars['settings'] = $this->settings_functions->settings();
		$this->load->view('template', $vars);
	    }
		
	}	

}
