<?php
class Home extends Controller {

	public function index() {
            
        if ($user_id = logged_in()) {
            //show a 'portal'
            $u = Doctrine_Query::create()
                ->select('u.*')
                ->from('Users u INDEXBY u.id')
                ->where('u.active = 1')
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();
            

            $vars['title'] = "Work in progress";
            $vars['u'] = $u;
            $vars['user'] = $u[$user_id];
            $vars['content_view'] = "home_page";
            $vars['settings'] = $this->settings_functions->settings();
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
