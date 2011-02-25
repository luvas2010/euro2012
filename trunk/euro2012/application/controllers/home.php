<?php
class Home extends Controller {

	public function index() {
        $settings = $this->settings_functions->settings();    
        if ($user_id = logged_in()) {
            $curr_time = time();
            //show a 'portal'
            $u = Doctrine_Query::create()
                ->select('u.*')
                ->from('Users u INDEXBY u.id')
                ->where('u.active = 1')
                ->orderBy('u.position')
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();
            
            $vars['extra_answers'] = Doctrine_Query::create()
                ->select('ea.answer,
                          eq.active')
                ->from('Extra_answers ea, ea.Question eq')
                ->where('ea.user_id = '.$user_id)
                ->andWhere('eq.active = 1')
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();

            $vars['extra_q_warning'] = false;
            $vars['extra_q_unanswered'] = 0;
            foreach($vars['extra_answers'] as $answer) {
                if ($answer['answer'] == "-") {
                    $vars['extra_q_warning'] = true;
                    $vars['extra_q_unanswered']++;
                    }
                }
            
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
                ->addSelect('SUM(p.points_toto) as toto')
                ->from('Predictions p, p.User u')
                ->groupBy('p.user_id')
                ->orderBy('u.position')
                ->where('u.active = 1')
                ->limit(10)
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();
                
            $vars['nextmatches'] = Doctrine_Query::create()
                ->select('p.home_goals,
                          p.away_goals,
                          m.match_name,
                          m.match_time,
                          m.match_number,
                          th.name,
                          ta.name,
                          v.time_offset_utc')
                ->from('Predictions p, p.Match m, m.TeamHome th, m.TeamAway ta, m.Venue v')
                ->where('p.user_id = '.$user_id)
                ->andWhere('UNIX_TIMESTAMP(m.match_time) > '.$curr_time)
                ->orderBy('m.match_time')
                ->limit(4)
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();
            
            if (!started()) {
                
                $vars['warning_matches'] = Doctrine_Query::create()
                    ->select('m.match_name,
                              m.match_number,
                              p.match_number,
                              p.user_id')
                    ->from('Predictions p, p.Match m, p.User u')
                    ->where('(p.home_id = 0 OR p.away_id = 0) AND m.type_id < 6')
                    ->andWhere('p.user_id = '.$user_id)
                    ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                    ->execute();
                }
                

                $user_count = Doctrine_Query::create()
                    ->select('u.id')
                    ->from('Users u')
                    ->where('u.active = 1')
                    ->andWhere('u.paid = 1')
                    ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                    ->execute();
                    
                $count = count($user_count);
                $total_payout = $count * $settings['payment_amount'];
                $vars['total_payout'] = $total_payout;
                $payout_key  = explode(";",$settings['payout_key']);
                $winners_num = count($payout_key);
                foreach ($payout_key as $k => $v) {
                    $payout[$k+1] = $v;
                    }
                $vars['payout'] = $payout;
                $i = 1;
                while($i <= $winners_num) :
                    $winners = Doctrine_Query::create()
                        ->select('u.id,
                                 u.position,
                                 u.points,
                                 u.nickname')
                        ->from('Users u INDEXBY u.id')
                        ->where('u.position = '.$i)
                        ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                        ->execute();
                        
                $win_count[$i] = count($winners);
                if (count($winners) > 1) {
                    
                    $pay= 0;
                    for ($offset = 0;$offset <= count($winners)-1;$offset++) {
                        if (($i + $offset) < count($payout)+1) {
                            $pay = $pay + $payout[$i + $offset];
                            }
                        }
                    }    
                else {
                    $pay = $payout[$i];
                    }    
                    foreach($winners as $winner) {
                        $win_user[$winner['id']]['id'] = $winner['id'];
                        $win_user[$winner['id']]['nickname'] = $winner['nickname'];
                        $win_user[$winner['id']]['position'] = $winner['position'];
                        $win_user[$winner['id']]['pay'] = ($pay/100 * $total_payout)/count($winners);
                    }
                    $vars['winners'] = $win_user;
                    $i = $i + count($winners);
                endwhile;               
            $vars['win_count'] = $win_count;
            $vars['topten'] = $q;
            $vars['settings'] = $settings;
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
