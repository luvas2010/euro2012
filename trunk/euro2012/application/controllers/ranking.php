<?php
// File: /system/application/controllers/ranking.php
// Version: 1.0
// Author: Schop

class Ranking extends Controller {

    public function index() {
        if (logged_in()) {
            $q = Doctrine_Query::create()
                ->select('p.user_id,
                          u.nickname')
                ->addSelect('SUM(p.points_total_this_match) as total')
                ->addSelect('SUM(p.points_home_goals) as homegoals')
                ->addSelect('SUM(p.points_away_goals) as awaygoals')
                ->addSelect('SUM(p.points_toto) as toto')
                ->addSelect('SUM(p.points_yellow_cards) as yellow')
                ->addSelect('SUM(p.points_red_cards) as red')
                ->addSelect('SUM(p.points_toto) as toto')
                ->from('Predictions p, p.User u')
                ->groupBy('p.user_id')
                ->orderBy('total DESC')
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();
            $vars['rankings'] = $q;
            $vars['title'] = "Ranking";
            $vars['content_view'] = "ranking";
            $vars['settings'] = $this->settings_functions->settings();
            $this->load->view('template', $vars);    
        }
        else {
            // No user is logged in
            $vars['title'] = "Not logged in";
            $vars['content_view'] = "not_logged_in";
            $vars['settings'] = $this->settings_functions->settings();
            $this->load->view('template', $vars);    
        }
    }
}