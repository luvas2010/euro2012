<?php
class Matchstats extends Controller {

//...
    function score($matchnum) {
    $matchTable = Doctrine::getTable('Matches');
    $vars['match'] = $matchTable->findOneByMatch_number($matchnum);
    $teamTable = Doctrine::getTable('Teams');
    $vars['hometeam'] = $teamTable->findOneByTeam_id_home($vars['match']->home_id);
    $vars['awayteam'] = $teamTable->findOneByTeam_id_home($vars['match']->away_id);        
    $vars['stats'] = $this->calculation_functions->matchstats($matchnum);  
    $vars['title'] = "Match ".$vars['hometeam']->name." - ".$vars['awayteam']->name." Scores";
    $vars['content_view'] = "matchscore";		
    $vars['settings'] = $this->settings_functions->settings();
    $this->load->view('template', $vars);
    }
}
