<?php
class Allmatches extends Controller {

	public function index() {
	
        // This used to be:
		// $vars['matches'] = Doctrine::getTable('Matches')->findAll();
        // but that results in a lot of queries.
        
        // Using Doctrine Query like below reduces it to only one query. Cool!
        
        $vars['matches'] = Doctrine_Query::create()
            ->select('m.match_name, m.match_time,m.home_goals,
                      m.away_goals, m.description, th.name, ta.name, v.name')
            ->from('Matches m, m.TeamHome th, m.TeamAway ta, m.Venue v')
            ->execute(); 
        
        //$this->load->helper('language');
        //$this->lang->load('nl', 'nl');
          
        // Now load the matches.php view, and pass the parameters
		$vars['title'] = "All Euro 2012 Matches Overview";
		$vars['content_view'] = "match_list";		
		$vars['settings'] = $this->settings_functions->settings();
		$this->load->view('template', $vars);
	}	

}
