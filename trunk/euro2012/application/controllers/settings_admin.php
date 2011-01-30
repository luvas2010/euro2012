<?php
// File: /system/application/controllers/settings_admin.php
// Version: 1.0
// Author: Schop

class Settings_admin extends Controller {

	public function index() {

        if(Current_User::user()){
            if(Current_User::user()->admin){
    
                 $vars['settings_ad'] = Doctrine_Query::create()
                ->select('*')
                ->from('Settings')
                ->execute();
                
                $vars['title'] = "Settings";
                $vars['content_view'] = "settings";
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
            $vars['title'] = "Not logged in";
            $vars['content_view'] = "not_logged_in";
            $vars['settings'] = $this->settings_functions->settings();
		    $this->load->view('template', $vars);
            }             
	}
	
	public function submit() {

        if(logged_in()){
            if(admin()){
                if ($this->_submit_validate() === FALSE) {
                    $this->index();
                    return;
                }
                
                $settings_ad = Doctrine_Query::create()
                    ->select('s.*')
                    ->from('Settings s')
                    ->execute();
                
                foreach ($settings_ad as $setting) {
                    // echo  $this->input->post('id'.$setting->id);
                    // Find the setting record
                    if ($s = Doctrine::getTable('Settings')->findOneById($this->input->post('id'.$setting->id))) {
                        
                        // Check if there's a value
                        if ($this->input->post('value'.$setting->id)<>'') {
                            $s->value = $this->input->post('value'.$setting->id);
                            }

                        // and save the result!                
                        $s->save();
                    }   
                }
                // Somehow this should automagically recalculate every users points, if you changed the rewards
                //if ($this->groupcalc->groupresults()) {
                    redirect('/settings_admin');
                //    }
            }
        }
	}
	
    private function _submit_validate() {


		    
		return true;

	}
	

}
