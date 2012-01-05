<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| General pool configuration
|--------------------------------------------------------------------------
*/
$config['version'] = '1.1'; // rev 150

$config['pool_name'] = 'Euro 2012 Voetbalpool';
// Time offset
$config['time_offset']  = '0'; // Time offset from CET (Central European Time) on the hosting server, in seconds
$config['predictions_open'] = TRUE; // If set to TRUE users can predict match results until the match starts. If set to FALSE, users can predict match results until Match #1 starts
$config['predictions_open_offset'] = '0'; //The amount of seconds predictions are closed before the start of a match. If 'predictions_open' is FALSE, the amount of seconds predictions are closed before Match #1 starts.

$config['public_predictions'] = FALSE; // TO DO: If set to TRUE, people can see other user's predictions.

$config['sign_up_email_admin'] = TRUE; // Send the admin account an e-mail when a new user signs up
$config['verify_users'] = TRUE; // Admin has to verify users before they can login
$config['email_from_address'] = 'info@voetbalpool2012.nl';  //e-mail address where emails are sent from. set this to your own (administrator) e-mail address

/* TO DO: Payment config */
$config['play_for_money'] = FALSE; // TO DO: Implement payout calculations
$config['payment_per_user'] = '10'; // TO DO: Amount payed per user

/* Set your payout schedule.
   If set like '50,30,20' the first ranked user will get 50%, second 30%, third 10%.
   Add as many as you want, for eacmple '30,20,15,10,5' is also possible.
   Numbers don't have to add up to 100. If you keep 10%, set it to '50, 25, 15', so it adds up to 90%
   If set like '50,30,20' and two players end first with the same amount of points, they will each get (50+30)/2 = 40%, third will get 20
*/
$config['payout_schedule'] = "50,30,20"; // TO DO: paypout schedule

/* Awarded points */
$config['pred_points_goals'] = '3'; // Points for predicting 'home' or 'away' goals correct
$config['pred_points_result'] = '2'; // Points for predicting correct who wins the match (or tie)
$config['pred_points_qf_team'] = '7'; // Points if predicting a team in the Quarter Finals correct
$config['pred_points_sf_team'] = '9'; // Points if predicting a team in the Semi Finals correct
$config['pred_points_f_team'] = '13'; // Points if predicting a team in the final correct
$config['pred_points_bonus'] = '15'; // Maximum Bonus points for total number of goals
$config['pred_points_champion'] = '20'; // Points for predicting the champion correct

/* Account settings */
    /*
    |--------------------------------------------------------------------------
    | Global
    |--------------------------------------------------------------------------
    */
    $config['ssl_enabled']                          = FALSE;

    /*
    |--------------------------------------------------------------------------
    | Sign In
    |--------------------------------------------------------------------------
    */
    $config['sign_in_recaptcha_enabled']            = FALSE;
    $config['sign_in_recaptcha_offset']             = 3;

    /*
    |--------------------------------------------------------------------------
    | Sign Up
    |--------------------------------------------------------------------------
    */
    $config['sign_up_recaptcha_enabled']            = TRUE;
    $config['sign_up_auto_sign_in']                 = FALSE;

    /*
    |--------------------------------------------------------------------------
    | Sign Out
    |--------------------------------------------------------------------------
    */
    $config['sign_out_view_enabled']                = TRUE;

    /*
    |--------------------------------------------------------------------------
    | OpenID
    |--------------------------------------------------------------------------
    */
    $config['openid_file_store_path']               = 'system/cache';
    $config['openid_google_discovery_endpoint']     = 'http://www.google.com/accounts/o8/id';
    $config['openid_yahoo_discovery_endpoint']      = 'http://www.yahoo.com/';

    /*
    |--------------------------------------------------------------------------
    | Third Party Auth
    |--------------------------------------------------------------------------
    */
    $config['third_party_auth_providers']           = array('facebook', 'twitter');
    $config['openid_what_is_url']                   = 'http://openidexplained.com/';

    /*
    |--------------------------------------------------------------------------
    | Password Reset
    |--------------------------------------------------------------------------
    |
    |   password_reset_expiration       Reset password form will be valid for 30 mins (default)
    |   password_reset_secret           Reset password token salt. See https://www.grc.com/passwords.htm
    |                                   * IMPORTANT * You should really change this to something different for your install
    |   password_reset_email            Reset password sender email
    */
    $config['password_reset_expiration']            = 1800;
    $config['password_reset_secret']                = 'ED95244060F22EE456022E091CBCE39BCD177E3992FFB61D1E3B455DAA4EF7B7';

/* End of account settings */

/*
|--------------------------------------------------------------------------
| reCAPTCHA
|--------------------------------------------------------------------------
|
| reCAPTCHA PHP Library - http://recaptcha.net/plugins/php/
|
| recaptcha_theme   'red' | 'white' | 'blackglass' | 'clean' | 'custom'
| it looks like these keys will work for any domain. If not, goto http://recaptcha.net to get your set of keys
*/
$config['recaptcha_public_key']         = "6LdFA8sSAAAAAOITG6KpgretCNakHS1aEciP2176";
$config['recaptcha_private_key']        = "6LdFA8sSAAAAAIJfViuwlcCsz72Dp6fnRxGo5UCn";
$config['recaptcha_theme']              = "clean";

/*
|--------------------------------------------------------------------------
| Twitter API
|--------------------------------------------------------------------------
|
| Twitter Applications - http://dev.twitter.com/apps
| You will have to get your own set of keys if you want people to be able to sign in and sign up with Twitter
*/
$config['twitter_consumer_key']         = "";
$config['twitter_consumer_secret']      = "";

/*
|--------------------------------------------------------------------------
| Facebook API
|--------------------------------------------------------------------------
|
| Facebook Applications - http://www.facebook.com/developers/createapp.php
| You will have to get your own set of keys if you want people to be able to sign in and sign up with Facebook
*/
$config['facebook_app_id']  = "";
$config['facebook_secret']  = "";


/* End of file pool.php */
/* Location: ./application/config/pool.php */


