<?php
// File: /system/application/controllers/text.php
// Version: 1.0
// Author: Schop

class Text extends Controller {

    public function edit($id) {
        
        if (admin()) {
        
            $vars['text'] = Doctrine::getTable('Texts')->findOneById($id);
            
            $vars['title'] = "Text Edit";
            $vars['content_view'] = "textedit";
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
    
    public function submit() {
        $text = Doctrine::getTable('Texts')->findOneById($this->input->post('id'));
        $text['text_en'] = $this->input->post('text_english');   
        $text['text_nl'] = $this->input->post('text_nederlands');
        $text->save();
        }
        
    public function view() {
        if (admin()) {
            $vars['texts'] = Doctrine_Query::create()
                    ->select('t.*
                              ')
                    ->from('Texts t')
                    ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                    ->execute();
                $vars['title'] = "Text overview";
                $vars['content_view'] = "textview";
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
        
}
