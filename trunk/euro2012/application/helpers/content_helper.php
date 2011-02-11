<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('content'))
{

	function content($textvar, $user_id = -1)
	{	
	    if ($user_id == -1) { $user_id = logged_in();}
        $text = Doctrine::getTable('Texts')->findOneByText_name($textvar);
	    if (language() == 'nederlands') {
	        $returntext = $text['text_nl'];
	        }
	    else {
	        $returntext = $text['text_en'];
	        }

        $settings = Doctrine::getTable('Settings')->findAll();
        foreach ($settings as $setting) {
            $replacekey = "[[".$setting['setting']."]]";
            $replacewith = $setting['value'];
            $returntext = str_replace($replacekey, $replacewith, $returntext);
            }
        
        if (logged_in()) {
            $user = Doctrine::getTable('Users')->findOneById($user_id);
                
            foreach ($user as $field => $value) {
                $replacekey = "[[".$field."]]";
                $replacewith = $value;
                $returntext = str_replace($replacekey, $replacewith, $returntext);
                }
            }
        return $returntext;         		
	}
}
