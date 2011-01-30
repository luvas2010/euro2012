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
           

/* End of file user_helper.php */
