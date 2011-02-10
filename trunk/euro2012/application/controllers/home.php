<?php
class Home extends Controller {

	public function index() {
            
        if ($user_id = logged_in()) {
            //show a 'portal'
            $u = Doctrine_Query::create()
                ->select('u.*')
                ->from('Users u INDEXBY u.id')
                ->where('u.active = 1')
                ->orderBy('u.position')
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();
                
            $q = Doctrine_Query::create()
                ->select('p.user_id,
                          u.position,
                          u.lastposition,
                          u.points,
                          u.nickname')
                ->addSelect('SUM(p.points_total_this_match) as total')
                ->addSelect('SUM(p.points_home_goals) as homegoals')
                ->addSelect('SUM(p.points_away_goals) as awaygoals')
                ->addSelect('SUM(p.points_toto) as toto')
                ->addSelect('SUM(p.points_exact) as exact')
                ->addSelect('SUM(p.points_yellow_cards) as yellow')
                ->addSelect('SUM(p.points_red_cards) as red')
                ->addSelect('SUM(p.points_toto) as toto')
                ->from('Predictions p, p.User u')
                ->groupBy('p.user_id')
                ->orderBy('u.position')
                ->limit(10)
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();
            
            $vars['topten'] = $q;
            $vars['settings'] = $this->settings_functions->settings();
            $vars['title'] = $vars['settings']['poolname'];
            $vars['u'] = $u;
            $vars['user'] = $u[$user_id];
            $vars['content_view'] = "home_page";
            $this->load->view('template', $vars);
		}
    else {
	    // No user is logged in

	    $vars['text'] = content('text_welcome_not_logged_in');
        $vars['title'] = "Welcome";
        $vars['content_view'] = "welcome_message";
        $vars['settings'] = $this->settings_functions->settings();
		$this->load->view('template', $vars);
	    }
		
	}	

}
