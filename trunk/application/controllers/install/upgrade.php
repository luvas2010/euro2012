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
                        NULL , '0', 'Schop', 'Installatie Versie 1.2 succesvol!', '$timestamp'
                        )";
						
		$sql_query[] = "CREATE TABLE IF NOT EXISTS `pool_config` (
						  `setting_uid` int(11) NOT NULL AUTO_INCREMENT,
						  `setting` varchar(255) NOT NULL,
						  `value` varchar(255) DEFAULT NULL,
						  PRIMARY KEY (`setting_uid`)
						)";
		$third_party_auth_providers = implode(',',$this->config->item('third_party_auth_providers'));
		$sql_query[] = "REPLACE INTO `pool_config`
					  (`setting`,`value`)
					  VALUES
					  ('version','".$this->config->item('pool_version')."'),
					  ('pool_name','".$this->config->item('pool_name')."'),
					  ('time_offset','".$this->config->item('time_offset')."'),
					  ('predictions_open','".$this->config->item('predictions_open')."'),
					  ('predictions_open_offset','".$this->config->item('predictions_open_offset')."'),
					  ('public_predictions','".$this->config->item('public_predictions')."'),
					  ('public_social_links','".$this->config->item('public_social_links')."'),
					  ('sign_up_email_admin','".$this->config->item('sign_up_email_admin')."'),
					  ('verify_users','".$this->config->item('verify_users')."'),
					  ('email_from_address','".$this->config->item('email_from_address')."'),
					  ('play_for_money','".$this->config->item('play_for_money')."'),
					  ('payment_per_user','".$this->config->item('payment_per_user')."'),
					  ('currency','".$this->config->item('currency')."'),
					  ('payout_schedule','".$this->config->item('payout_schedule')."'),
					  ('pred_points_goals','".$this->config->item('pred_points_goals')."'),
					  ('pred_points_result','".$this->config->item('pred_points_result')."'),
					  ('pred_points_qf_team','".$this->config->item('pred_points_qf_team')."'),
					  ('pred_points_sf_team','".$this->config->item('pred_points_sf_team')."'),
					  ('pred_points_f_team','".$this->config->item('pred_points_f_team')."'),
					  ('pred_points_bonus','".$this->config->item('pred_points_bonus')."'),
					  ('pred_points_champion','".$this->config->item('pred_points_champion')."'),
					  ('ssl_enabled','".$this->config->item('ssl_enabled')."'),
					  ('sign_in_recaptcha_enabled','".$this->config->item('sign_in_recaptcha_enabled')."'),
					  ('sign_in_recaptcha_offset','".$this->config->item('sign_in_recaptcha_offset')."'),
					  ('sign_up_recaptcha_enabled','".$this->config->item('sign_up_recaptcha_enabled')."'),
					  ('sign_up_auto_sign_in','".$this->config->item('sign_up_auto_sign_in')."'),
					  ('sign_out_view_enabled','".$this->config->item('sign_out_view_enabled')."'),
					  ('openid_file_store_path','".$this->config->item('openid_file_store_path')."'),
					  ('openid_google_discovery_endpoint','".$this->config->item('openid_google_discovery_endpoint')."'),
					  ('openid_yahoo_discovery_endpoint','".$this->config->item('openid_yahoo_discovery_endpoint')."'),
					  ('third_party_auth_providers','".$third_party_auth_providers."'),
					  ('openid_what_is_url','".$this->config->item('openid_what_is_url')."'),
					  ('password_reset_expiration','".$this->config->item('password_reset_expiration')."'),
					  ('password_reset_secret','".$this->config->item('password_reset_secret')."'),
					  ('recaptcha_public_key','".$this->config->item('recaptcha_public_key')."'),
					  ('recaptcha_private_key','".$this->config->item('recaptcha_private_key')."'),
					  ('recaptcha_theme','".$this->config->item('recaptcha_theme')."'),
					  ('twitter_consumer_key','".$this->config->item('twitter_consumer_key')."'),
					  ('twitter_consumer_secret','".$this->config->item('twitter_consumer_secret')."'),
					  ('facebook_app_id','".$this->config->item('facebook_app_id')."'),
					  ('facebook_secret','".$this->config->item('facebook_secret')."')";
        
        foreach ($sql_query as $query)
        {
            $q = $this->db->query($query);
        }
        
        echo "Upgraded to version 1.2";
    }
}


/* End of file upgrade.php */
/* Location: ./application/install/upgrade.php */
