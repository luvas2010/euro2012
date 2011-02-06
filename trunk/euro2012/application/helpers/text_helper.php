<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('text'))
{
	function text($var)
	{	
	    $text = Doctrine::getTable('Texts')->findOneByText_name($var);
	    if (language() == 'nederlands') {
	        $returntext = $text['text_nl'];
	        }
	    else {
	        $returntext = $text['text_en'];
	        }

        $vars['settings'] = $this->settings_functions->settings();
        foreach ($vars['settings'] as $k => $v) {
            $replacekey = "%".$k."%";
            $replacewith = $v;
            $returntext = str_replace($replacekey, $replacewith, $returntext);
            }         		
	}
}
