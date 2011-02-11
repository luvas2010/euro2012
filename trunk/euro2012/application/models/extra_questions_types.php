<?php
class Extra_questions_types extends Doctrine_Record {
    
   public function setTableDefinition() {
        $this->hasColumn('description', 'string', 255);


    }
    
    public function setUp() {

    }
    
}
