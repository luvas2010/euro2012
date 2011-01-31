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
             // Lookup the matches in the group phase, and their predictions by this user
            $vars['predictions_group_phase'] = Doctrine_Query::create()
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
                ->andWhere('m.type_id = 6') // group matches
                ->orderBy('m.match_time')
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();
                
            $vars['predictions_qf'] = Doctrine_Query::create()
                ->select('m.match_name,
                          m.match_number,
                          m.match_time,
                          m.home_goals,
                          m.away_goals,
                          m.home_id,
                          m.time_close,
                          m.match_group,
                          m.group_home,
                          m.group_away,
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
                          pth.name,
                          pth.flag,
                          pta.name,
                          pta.flag,
                          u.nickname,
                          v.name,
                          v.time_offset_utc
                          ')
                ->from('Predictions p, p.Match m, m.TeamHome th, m.TeamAway ta, p.TeamHome pth, p.TeamAway pta, m.Venue v, p.User u')
                ->where('p.user_id = '.$user_id)
                ->andWhere('m.type_id = 4') // quarter final matches
                ->orderBy('m.match_time')
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();
                
            $vars['predictions_sf'] = Doctrine_Query::create()
                ->select('m.match_name,
                          m.match_number,
                          m.match_time,
                          m.home_goals,
                          m.away_goals,
                          m.home_id,
                          m.time_close,
                          m.match_group,
                          m.group_home,
                          m.group_away,
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
                          pth.name,
                          pth.flag,
                          pta.name,
                          pta.flag,
                          u.nickname,
                          v.name,
                          v.time_offset_utc
                          ')
                ->from('Predictions p, p.Match m, m.TeamHome th, m.TeamAway ta, p.TeamHome pth, p.TeamAway pta, m.Venue v, p.User u')
                ->where('p.user_id = '.$user_id)
                ->andWhere('m.type_id = 2') // semi final matches
                ->orderBy('m.match_time')
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();
                
            $vars['predictions_f'] = Doctrine_Query::create()
                ->select('m.match_name,
                          m.match_number,
                          m.match_time,
                          m.home_goals,
                          m.away_goals,
                          m.home_id,
                          m.time_close,
                          m.match_group,
                          m.group_home,
                          m.group_away,
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
                          pth.name,
                          pth.flag,
                          pta.name,
                          pta.flag,
                          u.nickname,
                          v.name,
                          v.time_offset_utc
                          ')
                ->from('Predictions p, p.Match m, m.TeamHome th, m.TeamAway ta, p.TeamHome pth, p.TeamAway pta, m.Venue v, p.User u')
                ->where('p.user_id = '.$user_id)
                ->andWhere('m.type_id = 1') // final match
                ->orderBy('m.match_time')
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();
                
                // Get the teams, and pass them on for the dropdown
                $teams = Doctrine_Query::create()
                    ->select('t.name,
                              t.team_group,
                              t.team_id_home')
                    ->from('Teams t')
                    ->where('t.team_id_home < 50')
                    ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                    ->execute();
                foreach ($teams as $team) {
                    $vars['teams'.strtolower($team['team_group'])][$team['team_id_home']] = $team['name'];
                    }
                $vars['teamsa'][0] = "-";
                $vars['teamsb'][0] = "-";
                $vars['teamsc'][0] = "-";
                $vars['teamsd'][0] = "-";
                
                //$vars['teamsab'] = array_replace($vars['teamsa'], $vars['teamsb']);
                foreach ($vars['teamsa'] as $k => $v) {
                    $vars['teamsab'][$k] = $v;
                    }
                foreach ($vars['teamsb'] as $k => $v) {
                    $vars['teamsab'][$k] = $v;
                    }
                foreach ($vars['teamsc'] as $k => $v) {
                    $vars['teamscd'][$k] = $v;
                    }
                foreach ($vars['teamsd'] as $k => $v) {
                    $vars['teamscd'][$k] = $v;
                    }
                foreach ($vars['teamsab'] as $k => $v) {
                    $vars['teamsabcd'][$k] = $v;
                    }
                foreach ($vars['teamscd'] as $k => $v) {
                    $vars['teamsabcd'][$k] = $v;
                    }        
                    ksort($vars['teamsab']);
                //$vars['teamscd'] = array_replace($vars['teamsc'], $vars['teamsd']);
                    ksort($vars['teamscd']);
                //$vars['teamsabcd'] = array_replace($vars['teamsab'], $vars['teamscd']);
                    ksort($vars['teamsabcd']);
            foreach ($vars['predictions_group_phase'] as $prediction)
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
	
	public function submit() {

        if(logged_in()){
            $user_id = logged_in();
            $predictions = Doctrine_Query::create()
                ->select('p.id,
                          p.home_goals,
                          p.away_goals,
                          p.home_id,
                          p.away_id,
                          p.match_number,
                          m.match_number,
                          m.time_close,
                          m.venue_id,
                          v.venue_id,
                          v.time_offset_utc
                          ')
                ->from('Predictions p INDEXBY p.id, p.Match m, m.Venue v')
                ->where('p.user_id = '.$user_id)
                ->orderBy('m.match_time')
                ->execute();

        $arrPost = $this->input->post('post_array');    //get all posted values in one array
        foreach ($arrPost as $id => $value) {           // $id represents the 'id' column in the predictions table
            foreach ($value as $k => $v) {              // $k represents 'home_goals', 'away_goals' etc.  
                $predictions[$id][$k]=$v;
                }
            }
        $predictions->save();
        $vars['title'] = "Predictions Saved";
        $vars['message'] = "All your predictions were saved";
        $vars['content_view'] = "success";
        $vars['settings'] = $this->settings_functions->settings();
        $this->load->view('template', $vars);


//                if ($this->_submit_validate() === FALSE) {
//                    $this->index();
//                    return;
//                    }
//                
//                    if ($team = Doctrine::getTable('Teams')->findOneById($this->input->post('id'))) {
//                        
//                            $team->name = $this->input->post('teamname');
//                            $team->flag = $this->input->post('teamflag');
//                        
//                        // and save the result!                
//                        $team->save();
//                        $vars['message'] = "Team ".$team->name." changed!";
//                        $vars['title'] = "Team Changed";
//                        $vars['content_view'] = "success";
//                        $vars['settings'] = $this->settings_functions->settings();
//            		    $this->load->view('template', $vars);
//                    }
                } else {        
                // Nobody is logged in
                $vars['title'] = "Not logged in";
                $vars['content_view'] = "not_logged_in";
                $vars['settings'] = $this->settings_functions->settings();
	            $this->load->view('template', $vars);
                }
	}

}
