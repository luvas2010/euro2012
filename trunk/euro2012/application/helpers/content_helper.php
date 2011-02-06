<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('content'))
{
	function content($var)
	{	
	    $text = Doctrine::getTable('Texts')->findOneByText_name($var);
	    if (language() == 'nederlands') {
	        $returntext = $text['text_nl'];
	        }
	    else {
	        $returntext = $text['text_en'];
	        }

        $settings = Doctrine::getTable('Settings')->findAll();
        foreach ($settings as $setting) {
            $replacekey = "%".$setting['setting']."%";
            $replacewith = $setting['value'];
            $returntext = str_replace($replacekey, $replacewith, $returntext);
            }
        return $returntext;         		
	}
}
