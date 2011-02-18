<?php
class Help extends Controller {

    public function page($page){
    $file = "application/views/help_".language()."/help_".$page.".php";
    if (file_exists($file)) {
        $vars['content_view'] = "help_".language()."/help_".$page;
        }
    else {
        $vars['content_view'] = "help_".language()."/help_none";
        }
    $vars['file'] = $file;
    $vars['title'] = "Help";
    $this->load->view('help_template', $vars);
    
    }
}