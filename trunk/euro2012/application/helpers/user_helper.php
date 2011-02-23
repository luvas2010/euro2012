<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('admin'))
{
	function admin()
	{	
        if(Current_User::user()){
            if(Current_User::user()->admin){
                // user is an admin
                return true;
                }
            else {
                // user is not an admin
                return false;
                }
            }
        else {
            // user is not logged in
            return false;
            }           		
	}
}

if ( ! function_exists('logged_in'))
{
	function logged_in()
	{	
        if(Current_User::user())
            {
            // user is logged in, return the id
            return Current_User::user()->id;
            }
        else
            {
            // user is not logged in, return false
            return false;
            }           		
	}
}

if ( ! function_exists('language'))
{
    function language() {
        if (Current_User::user()) {
            return Current_User::user()->language;
            }
        else {
            $settings = Doctrine::getTable('Settings')->findOneBySetting('default_language');
            return $settings['value'];
            }
        }

}

if ( ! function_exists('started')) {
    function started() {
    $s = Doctrine_Query::create()
        ->select('MIN(m.match_time),
                  m.id,
                  v.id,
                  v.time_offset_utc')
        ->from('Matches m, m.Venue v')
        ->groupBy('m.match_time')
        ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
        ->execute();

        $server_offset = Doctrine::getTable('Settings')->findOneBySetting('server_time_offset_utc');
        // Get local time at the server. If the local time is later than (start time of the first match - timezone offset of the venue + server offset), the tournament has started. F*cking timezones driving me nuts. But it now even works if the first match would be moved to the Ukraine. Flexibility!
    if ((time()) > (mysql_to_unix($s[0]['MIN']) - $s[0]['Venue']['time_offset_utc'] + $server_offset['value'])) {
        return true;
        }
    else {
        return false;
        }
    }
}

if ( ! function_exists('finished')) {
    function finished() {

        $prediction = Doctrine::getTable('Predictions')->findOneByMatch_number(99);
        if ($prediction['calculated'] == 1) { //if the final has been calculated, the tournament must be done
            return true;
           }
        else {
            return false;
            }
    }
}    
/* End of file user_helper.php */
