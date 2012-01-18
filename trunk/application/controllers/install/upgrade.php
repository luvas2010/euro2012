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
        //$sql_query = "ALTER TABLE `prediction` ADD `pred_points_total` INT NULL DEFAULT '0' AFTER `pred_points_away_team`";
        if(!$this->db->field_exists('payed','account'))
        {
            $sql_query[] = "ALTER TABLE `account` ADD `payed` TINYINT NOT NULL DEFAULT '0'"; //to version 1.2
        }
        $sql_query[] = "CREATE TABLE IF NOT EXISTS `shoutbox` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `account_id` bigint(20) NOT NULL,
                          `username` varchar(24) NOT NULL,
                          `message` varchar(255) NOT NULL,
                          `postedon` int(11) NOT NULL,
                          PRIMARY KEY (`id`)
                        )";
        $timestamp = now();                
        $sql_query[] = "REPLACE INTO `shoutbox` (
                        `id` ,
                        `account_id` ,
                        `username` ,
                        `message` ,
                        `postedon`
                        )
                        VALUES (
                        NULL , '0', 'Schop', 'Installatie Versie 1.2 succesvol!', '$timestamp'
                        )";
        
        foreach ($sql_query as $query)
        {
            $q = $this->db->query($query);
        }
        
        echo "Upgraded to version 1.2";
    }
}


/* End of file upgrade.php */
/* Location: ./application/install/upgrade.php */
