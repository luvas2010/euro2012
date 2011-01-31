<?php
// install script

class Install extends Controller {
    function index() {
    
    $this->load->database();
        $vars['db_set'] = $this->db;
        //print_r ($db_set);
    $vars['title'] = "Installation Step 1";
    $vars['content_view'] = "install_step1";
    $this->load->view('install_template', $vars);
    
    }
    
    function step2() {
        $conn = Doctrine_Manager::connection();
        Doctrine::createTablesFromModels();
        $vars['models'] = Doctrine::getLoadedModels();
        $vars['title'] = "Installation Step 2";
        $vars['content_view'] = "install_step2";
        $this->load->view('install_template', $vars);
        
    }
}        