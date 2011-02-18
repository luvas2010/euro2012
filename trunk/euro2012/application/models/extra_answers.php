<?php
class Extra_answers extends Doctrine_Record {
    
   public function setTableDefinition() {
		$this->hasColumn('question_id', 'integer',4);
        $this->hasColumn('user_id', 'integer',4);
        $this->hasColumn('answer', 'string', 255);
        $this->hasColumn('points', 'integer', 4);
    }
    
    public function setUp() {
		$this->hasOne('Users as User', array(
			'local' => 'user_id',
			'foreign' => 'id'
		));
		$this->hasOne('Extra_questions as Question', array(
			'local' => 'question_id',
			'foreign' => 'id'
		));
    }
    
}
