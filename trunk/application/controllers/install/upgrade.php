<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upgrade extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('url','date', 'language'));
        $this->load->library(array('session', 'authentication'));
        $this->lang->load(array('install'));
        
    }

    public function index()
    {
        $sql_query = "ALTER TABLE `prediction` ADD `pred_points_total` INT NULL DEFAULT '0' AFTER `pred_points_away_team`";
        if ($query = $this->db->query($sql_query))
        {
            echo "Upgrade succesvol";
        }
        else
        {
            echo "Upgrade niet succesvol";
        }
    }
}


/* End of file upgrade.php */
/* Location: ./application/install/upgrade.php */
