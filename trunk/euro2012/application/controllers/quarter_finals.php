<?php

class Quarter_finals extends Controller {

	public function index() {
        
        $vars['matches'] = Doctrine_Query::create()
            ->select('m.match_name,
                      m.match_time,
                      m.home_goals,
                      m.away_goals,
                      m.home_id,
                      th.name,
                      ta.name,
                      v.name')
            ->from('Matches m, m.TeamHome th, m.TeamAway ta, m.Venue v')
            ->where('m.match_group = "QF"')
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
             ->where('t.team_group = "QF"')
             ->orderBy('t.points DESC, t.goals_for')
             ->execute();                

        
        //$this->load->helper('language');
        //$this->lang->load('nl', 'nl');  
        // Now load the home.php view, and pass the parameters
		
        $vars['title'] = "Quarter Finals Overview";
		$vars['content_view'] = "quarter_finals";		
		$vars['settings'] = $this->settings_functions->settings();
		$this->load->view('template', $vars);
	}
}
