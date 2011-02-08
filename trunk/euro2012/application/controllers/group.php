<?php

class Group extends Controller {

	public function overview($group) {

        // Using Doctrine Query like below reduces it to only one query. Cool!
        
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
                      v.city')
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
                          u.*
                          ')
                ->from('Predictions p, p.Match m, m.TeamHome th, m.TeamAway ta, m.Venue v, p.User u, p.TeamHome pth, p.TeamAway pta')
                ->where('p.user_id = '.$user_id)
                ->andWhere('m.match_group = "'.$group.'"')
                ->orderBy('m.match_time, m.match_name')
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
            $vars['title'] = "Voorspellingen Groep ".strtoupper($group);
            $vars['content_view'] = "user_predictions";		
            $vars['settings'] = $this->settings_functions->settings();
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
