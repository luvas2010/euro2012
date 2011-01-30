<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Settings_functions {

    function settings()
    {
    $settings = Doctrine_Query::create()
        ->select('*')
        ->from('Settings')
        ->execute();
    
    foreach ($settings as $setting) {
        $name = $setting->setting;
        $value = $setting->value;
        $set_array[$name] = $value;
        }
    
    return $set_array;
    }
}

?>
