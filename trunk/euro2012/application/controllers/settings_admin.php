<?php
// File: /system/application/controllers/settings_admin.php
// Version: 1.0
// Author: Schop

class Settings_admin extends Controller {

	public function index() {

        if(logged_in()){
            if(admin()){
    
                 $vars['settings_ad'] = Doctrine_Query::create()
                ->select('*')
                ->from('Settings')
                ->execute();
                
                $vars['title'] = lang('settings');
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
    
    public function add_setting_submit() {
    
        if (admin()) {
            
            if ($this->_add_settings_validate() === FALSE) {
                    $this->index();
                    return;
                }
            $setting = New Settings();
            $setting['setting'] = $this->input->post('settingnew');
            $setting['value'] = $this->input->post('valuenew');
            $setting['description'] = $this->input->post('descriptionnew');
            $setting->save();
            $this->index();
            }
    }
	
    public function delete($id) {
    if (admin()) {
        $q = Doctrine_Query::create()
            ->delete('Settings s')
            ->where('s.id = '.$id)
            ->execute();
        $this->index();
        }
    }
    
    
    private function _add_settings_validate() {

		// validation rules
		$this->form_validation->set_rules('settingnew', 'Setting',
			'required|alpha_dash|min_length[1]|max_length[40]|unique[Settings.setting]');
        
		$this->form_validation->set_rules('valuenew', 'Value',
			'required');
		$this->form_validation->set_message('required', 'Je moet een waarde in vullen voor "%s"');
        $this->form_validation->set_message('alpha_dash', '"%s" mag geen spaties of andere tekens hebben, behalve "_" en "-".');
		return $this->form_validation->run();
		    
		return true;

	}
    private function _submit_validate() {

		// validation rules
		    
		return true;

	}	

}
