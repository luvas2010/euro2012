<?php

class Settings_Hook
    {
        
        
        public function get_settings()
            {
            global $settings;
            
            $settings = Doctrine_Query::create()
            ->select('s.*')
            ->from('Settings s')
            ->where('s.id = 1')
            ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
            ->execute();
            
            print_r($settings);
            }
    }    