<?php

class Groupd extends Controller {

	public function index() {

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
                      ta.name,
                      v.name')
            ->from('Matches m, m.TeamHome th, m.TeamAway ta, m.Venue v')
            ->where('m.match_group = "D"')
            ->orderBy('m.match_time')
            ->execute();
        
        $vars['results'] = Doctrine_Query::create()
            ->select('t.name,
                      t.played,
                      t.won,
                      t.lost,
                      t.tie,
                      t.points,
                      t.goals_for,
                      t.goals_against')
             ->from('Teams t')
             ->where('t.team_group = "D"')
             ->orderBy('t.points DESC, t.goals_for')
             ->execute();                

        
        //$this->load->helper('language');
        //$this->lang->load('nl', 'nl');  
        // Now load the home.php view, and pass the parameters
		
        $vars['title'] = "Group D Overview";
		$vars['content_view'] = "group";
		$vars['group'] = "d";
		$vars['settings'] = $this->settings_functions->settings();
		$this->load->view('template', $vars);
	}
}
