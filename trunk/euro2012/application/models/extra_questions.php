<?php
class Extra_questions extends Doctrine_Record {
    
   public function setTableDefinition() {
		$this->hasColumn('question', 'string', 255, array('unique' => 'true'));
        $this->hasColumn('answer', 'string', 255,array('notnull' => false, 'default' => NULL));
        $this->hasColumn('points', 'integer',4);
        $this->hasColumn('question_type', 'integer',4); // not sure yet
        $this->hasColumn('active', 'boolean');
    }
    
    public function setUp() {
        $this->hasMany('Extra_answers as Answer', array(
			'local' => 'id',
			'foreign' => 'question_id'
		));
        $this->hasOne('Extra_questions_types as QType', array(
			'local' => 'question_type',
			'foreign' => 'id'
		));
    }
    
}
