<?php
class Venues extends Doctrine_Record {
    
   public function setTableDefinition() {
        $this->hasColumn('venue_id', 'integer', 4);
        $this->hasColumn('name','string', 255);
        $this->hasColumn('city','string', 255, array('notnull'=>false));
        $this->hasColumn('capacity', 'integer');
        $this->hasColumn('time_offset_utc', 'integer', 4, array('unsigned' => false));
        
        $this->index('venue_id', array(
                'fields' => array('venue_id'),
                'type'   => 'unique'
            )
        );
    }
    
}
