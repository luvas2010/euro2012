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

        if ($this->authentication->is_signed_in() && is_admin())
        {
    //$sql_query = "ALTER TABLE `prediction` ADD `pred_points_total` INT NULL DEFAULT '0' AFTER `pred_points_away_team`";
        
        if(!$this->db->field_exists('pred_points_total', 'prediction'))
        {
            $sql_query[] = "ALTER TABLE `prediction` ADD `pred_points_total` INT NULL DEFAULT '0' AFTER `pred_points_away_team`"; //to version 1.1
        }
        
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
                        NULL , '0', 'Schop', 'Installatie Versie 1.3 succesvol!', '$timestamp'
                        )";

        if(!$this->db->field_exists('active','ref_language'))
        {
            $sql_query[] = "ALTER TABLE `ref_language` ADD `active` TINYINT NOT NULL DEFAULT '0'"; //to version 1.3
        }
                        
		$sql_query[] = "REPLACE INTO `ref_language` (`one`, `two`, `language`, `native`, `active`) VALUES
                        ('nl', 'nld', 'Nederlands', 'Dutch', 1),
                        ('en', 'eng', 'English', 'English', 1),
                        ('pl', 'pol', 'Polska', 'Polish',0),
                        ('fr', 'fra', 'Français', 'French',0),
                        ('es', 'esp', 'Español', 'Spanish',0),
                        ('it', 'ita', 'Italiano', 'Italian',0),
                        ('de', 'deu', 'Deutsch', 'German', 1)";
                           
		$sql_query[] = "CREATE TABLE IF NOT EXISTS `pool_config` (
                          `setting_uid` int(11) NOT NULL AUTO_INCREMENT,
                          `setting` varchar(255) NOT NULL,
                          `value` varchar(255) DEFAULT NULL,
                          `is_writeable` int(11) NOT NULL DEFAULT '1',
                          `category` int(11) NOT NULL DEFAULT '0',
                          PRIMARY KEY (`setting_uid`),
                          UNIQUE KEY `setting` (`setting`)
                        )";
		$third_party_auth_providers = implode(',',$this->config->item('third_party_auth_providers'));
        echo "Version ".floatval($this->poolconfig_model->item('version'))." <br/>";
        if(floatval($this->poolconfig_model->item('version')) < 1.2)
        {
            
            $sql_query[] = "REPLACE INTO `pool_config`
                          (`setting`,`value`, `is_writeable`, `category`)
                          VALUES
                          ('version','1.2',0,0),
                          ('pool_name','".$this->config->item('pool_name')."',1,0),
                          ('time_offset','".$this->config->item('time_offset')."',1,0),
                          ('predictions_open','".$this->config->item('predictions_open')."',1,0),
                          ('predictions_open_offset','".$this->config->item('predictions_open_offset')."',1,0),
                          ('public_predictions','".$this->config->item('public_predictions')."',1,0),
                          ('public_social_links','".$this->config->item('public_social_links')."',1,0),
                          ('sign_up_email_admin','".$this->config->item('sign_up_email_admin')."',1,0),
                          ('verify_users','".$this->config->item('verify_users')."',1,0),
                          ('email_from_address','".$this->config->item('email_from_address')."',1,0),
                          ('play_for_money','".$this->config->item('play_for_money')."',1,0),
                          ('payment_per_user','".$this->config->item('payment_per_user')."',1,0),
                          ('currency','€',1,0),
                          ('payout_schedule','".$this->config->item('payout_schedule')."',1,0),
                          ('enable_shoutbox','1',1,0),
                          ('pred_points_goals','".$this->config->item('pred_points_goals')."',1,1),
                          ('pred_points_result','".$this->config->item('pred_points_result')."',1,1),
                          ('pred_points_qf_team','".$this->config->item('pred_points_qf_team')."',1,1),
                          ('pred_points_sf_team','".$this->config->item('pred_points_sf_team')."',1,1),
                          ('pred_points_f_team','".$this->config->item('pred_points_f_team')."',1,1),
                          ('pred_points_bonus','".$this->config->item('pred_points_bonus')."',1,1),
                          ('pred_points_champion','".$this->config->item('pred_points_champion')."',1,1),
                          ('ssl_enabled','".$this->config->item('ssl_enabled')."',1,2),
                          ('sign_in_recaptcha_enabled','".$this->config->item('sign_in_recaptcha_enabled')."',1,2),
                          ('sign_in_recaptcha_offset','".$this->config->item('sign_in_recaptcha_offset')."',1,2),
                          ('sign_up_recaptcha_enabled','".$this->config->item('sign_up_recaptcha_enabled')."',1,02),
                          ('sign_up_auto_sign_in','".$this->config->item('sign_up_auto_sign_in')."',1,2),
                          ('sign_out_view_enabled','".$this->config->item('sign_out_view_enabled')."',1,2),
                          ('openid_file_store_path','".$this->config->item('openid_file_store_path')."',1,3),
                          ('openid_google_discovery_endpoint','".$this->config->item('openid_google_discovery_endpoint')."',1,3),
                          ('openid_yahoo_discovery_endpoint','".$this->config->item('openid_yahoo_discovery_endpoint')."',1,3),
                          ('third_party_auth_providers','".$third_party_auth_providers."',1,3),
                          ('openid_what_is_url','".$this->config->item('openid_what_is_url')."',1,3),
                          ('password_reset_expiration','".$this->config->item('password_reset_expiration')."',1,2),
                          ('password_reset_secret','".$this->config->item('password_reset_secret')."',1,2),
                          ('recaptcha_public_key','".$this->config->item('recaptcha_public_key')."',1,2),
                          ('recaptcha_private_key','".$this->config->item('recaptcha_private_key')."',1,2),
                          ('recaptcha_theme','".$this->config->item('recaptcha_theme')."',1,2),
                          ('twitter_consumer_key','".$this->config->item('twitter_consumer_key')."',1,3),
                          ('twitter_consumer_secret','".$this->config->item('twitter_consumer_secret')."',1,3),
                          ('facebook_app_id','".$this->config->item('facebook_app_id')."',1,3),
                          ('facebook_secret','".$this->config->item('facebook_secret')."',1,3)";
        }
        else
        {
                    $sql_query[] = "UPDATE `pool_config` SET `value` = '1.3' WHERE `setting` = 'version'";
                          
        }
        
        foreach ($sql_query as $query)
        {
            $q = $this->db->query($query);
        }
        
        echo "Upgraded to version 1.3";
        }
    
    else
        {
        echo "You are not logged in as an administrator";
        }
    }    
}


/* End of file upgrade.php */
/* Location: ./application/install/upgrade.php */
