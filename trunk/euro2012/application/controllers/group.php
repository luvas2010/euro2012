<?php

class Group extends Controller {


	public function overview($group) {
            
        $vars['matches'] = Doctrine_Query::create()
            ->select('m.match_name,
                      m.match_time,
                      m.home_goals,
                      m.away_goals,
                      m.home_id,
                      m.match_group,
                      m.match_number,
                      th.name,
                      th.flag,
                      ta.name,
                      ta.flag,
                      v.name,
                      v.city,
                      v.time_offset_utc')
            ->from('Matches m, m.TeamHome th, m.TeamAway ta, m.Venue v')
            ->where('m.match_group = "'.strtoupper($group).'"')
            ->orderBy('m.match_time')
            ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
            ->execute();
        
        $vars['results'] = Doctrine_Query::create()
            ->select('t.id,
                      t.name,
                      t.flag,
                      t.played,
                      t.won,
                      t.lost,
                      t.tie,
                      t.points,
                      t.goals_for,
                      t.goals_against')
             ->from('Teams t')
             ->where('t.team_group = "'.strtoupper($group).'"')
             ->orderBy('t.points DESC, t.goals_for')
             ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
             ->execute();
		
        $vars['title'] = "Group ".strtoupper($group)." Overview";
		$vars['content_view'] = "group";
		$vars['group'] = $group;
		$vars['settings'] = $this->settings_functions->settings();
		$this->load->view('template', $vars);
	}

	public function predictions($group) {
        if($user_id = logged_in()){
             // Lookup the matches in this group, and their predictions by this user
            $vars['predictions'] = Doctrine_Query::create()
                ->select('m.match_name,
                          m.match_number,
                          m.match_time,
                          m.home_goals,
                          m.away_goals,
                          m.home_id,
                          m.away_id,
                          m.type_id,
                          m.time_close,
                          m.match_group,
                          th.team_id_home,
                          th.name,
                          th.flag,
                          pth.name,
                          pth.flag,
                          ta.team_id_away,
                          ta.name,
                          ta.flag,
                          pta.name,
                          pta.flag,
                          p.home_goals,
                          p.away_goals,
                          p.points_total_this_match,
                          p.calculated,
                          v.time_offset_utc,
                          u.*
                          ')
                ->from('Predictions p, p.Match m, m.TeamHome th, m.TeamAway ta, m.Venue v, p.User u, p.TeamHome pth, p.TeamAway pta')
                ->where('p.user_id = '.$user_id)
                ->andWhere('m.match_group = "'.$group.'"')
                ->orderBy('m.match_time, m.match_name')
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();
            $settings = $this->settings_functions->settings();
            foreach ($vars['predictions'] as $prediction)
                {
                $num = $prediction['Match']['match_number'];
                if (mysql_to_unix($prediction['Match']['time_close']) - $prediction['Match']['Venue']['time_offset_utc'] + $settings['server_time_offset_utc'] > time())
                    {
                    $closed[$num] = 0;
                    }
                else
                    {
                    $closed[$num] = 1;
                    }
                }

            // create an array that holds results for each team
    	    foreach ($vars['predictions'] as $prediction) {
            $team[$prediction['Match']['TeamHome']['team_id_home']] = array(   'name' => $prediction['Match']['TeamHome']['name'],
                                                                   'flag' => $prediction['Match']['TeamHome']['flag'],
                                                                   'id' => $prediction['Match']['TeamHome']['team_id_home'],
                                                                   'played' => 0,
                                                                   'won' => 0, 
                                                                   'tie' => 0,
                                                                   'lost' => 0,
                                                                   'goals_for' => 0,
                                                                   'goals_against' => 0,
                                                                   'points' => 0);
            }
            
            foreach ($vars['predictions'] as $prediction) {
                $home = $prediction['Match']['TeamHome']['team_id_home'];
                $away = $prediction['Match']['TeamAway']['team_id_away'];
                if ($prediction['home_goals'] !== NULL && $prediction['away_goals'] !== NULL) {
                    $team[$home]['played'] = $team[$home]['played'] + 1;
                    $team[$away]['played'] = $team[$away]['played'] + 1;
                    $team[$home]['goals_for'] = $team[$home]['goals_for'] + $prediction['home_goals'];
                    $team[$home]['goals_against'] = $team[$home]['goals_against'] + $prediction['away_goals'];
                    $team[$away]['goals_for'] = $team[$away]['goals_for'] + $prediction['away_goals'];
                    $team[$away]['goals_against'] = $team[$away]['goals_against'] + $prediction['home_goals'];                    
                    }
                    if ($prediction['home_goals'] > $prediction['away_goals']) {
                        $team[$home]['won'] = $team[$home]['won'] + 1;
                        $team[$away]['lost'] = $team[$away]['lost'] + 1;
                        $team[$home]['points'] = $team[$home]['points'] +3;
                    }
                    if ($prediction['home_goals'] < $prediction['away_goals']) {
                        $team[$away]['won'] = $team[$away]['won'] + 1;
                        $team[$home]['lost'] = $team[$home]['lost'] + 1;
                        $team[$away]['points'] = $team[$away]['points'] +3;
                    }                    
                    if ($prediction['home_goals'] == $prediction['away_goals']) {
                        $team[$away]['tie'] = $team[$away]['tie'] + 1;
                        $team[$home]['tie'] = $team[$home]['tie'] + 1;
                        $team[$home]['points'] = $team[$home]['points'] + 1;
                        $team[$away]['points'] = $team[$away]['points'] + 1;
                    }                    
            }
            foreach ($team as $key => $row) {
                $points[$key] = $row['points'];
                $goals_for[$key] = $row['goals_for'];
                $goals_against[$key] = $row['goals_against'];
            }
            array_multisort($points, SORT_DESC, $goals_for, SORT_DESC, $goals_against, SORT_ASC, $team);
            
            $vars['results'] = $team;
            $vars['closed'] = $closed;    
            $vars['title'] = "Voorspellingen Groep ".strtoupper($group);
            $vars['content_view'] = "user_predictions_group";		
            $vars['settings'] = $settings;
		$this->load->view('template', $vars);
        }    
        else {
            // No user is logged in
            $vars['title'] = "Niet ingelogd";
            $vars['content_view'] = "not_logged_in";
            $vars['settings'] = $this->settings_functions->settings();
		$this->load->view('template', $vars);
            }             
	}
    
    public function admin($group) {
    
        if(logged_in()){
            if(admin()){
    
             // Lookup the matches in this group
             $vars['matches'] = Doctrine_Query::create()
                ->select('m.id,
                          m.match_number,
                          m.home_goals,
                          m.away_goals,
                          th.name,
                          th.flag,
                          ta.name,
                          ta.flag,
                          v.name')
                ->from('Matches m, m.TeamHome th, m.TeamAway ta, m.Venue v')
                ->where('m.match_group = "'.strtoupper($group).'"')
                ->orderBy('m.match_time')
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();
                
            $vars['title'] = "Group ".strtoupper($group)." Results Administration";
            $vars['content_view'] = "group_admin";		
            $vars['group'] = $group;
            $vars['settings'] = $this->settings_functions->settings();
		$this->load->view('template', $vars);
            }
        else {
            // Current user is not an admin
            $vars['title'] = "Access denied";
            $vars['content_view'] = "access_denied";
            $vars['settings'] = $this->settings_functions->settings();
		$this->load->view('template', $vars);
            }
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

	public function result_submit() {

        if(logged_in()){
            if(admin()){
                $arrPost = $this->input->post('post_array');
                if ($this->result_submit_validate($arrPost) === FALSE) {
                    $this->index();
                    return;
                }
                
                $matches = Doctrine_Query::create()
                    ->select('m.id,
                              m.home_goals,
                              m.away_goals,
                              m.match_group')
                    ->from('Matches m INDEXBY m.id')
                    ->execute();
                
                //print_r($matches->toArray());
                foreach ($arrPost as $id => $value) {
                    foreach ($value as $k => $v) {
                        if ($v!= NULL) {
                            $matches[$id][$k]=$v;
                            }
                        else {
                            $matches[$id][$k]=NULL;
                            }    
                        $group = strtolower($matches[$id]['match_group']);
                        }
                    }
                $matches->save();    
                
                // Now recalculate the standings, and go back to group overview
                if ($this->groupcalc->groupresults()) {
                    redirect('/group/overview/'.$group);
                    }
            }
        }
	}
	
    private function result_submit_validate($arrPost) {

        
        foreach ($arrPost as $value) {
		// validation rules

		    $this->form_validation->set_rules('home_goals'.$value['home_goals'], 'Home Goals',
			    'integer');
		    $this->form_validation->set_rules('away_goals'.$value['away_goals'], 'Away Goals',
			    'integer');
		    }
		return $this->form_validation->run();

	}
}
