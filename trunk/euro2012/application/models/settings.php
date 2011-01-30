<?php

class Settings extends Doctrine_Record {
    
   public function setTableDefinition() {
        $this->hasColumn('setting', 'string', 255);
        $this->hasColumn('value', 'string', 255);
        $this->hasColumn('description', 'clob', array('notnull' => false));      
    }
    
    public function setUp() {

    }
    
}
