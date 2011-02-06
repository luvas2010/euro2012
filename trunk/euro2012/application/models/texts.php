<?php

class Texts extends Doctrine_Record {
    
   public function setTableDefinition() {
        $this->hasColumn('text_name', 'string', 255, array('unique' => 'true'));
        $this->hasColumn('text_en', 'clob', array('notnull' => false));
        $this->hasColumn('text_nl', 'clob', array('notnull' => false));
        $this->hasColumn('text_default', 'clob', array('notnull' => false));            
    }
    
    public function setUp() {

    }
    
}
