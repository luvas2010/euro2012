<?php
class Users extends Doctrine_Record {

	public function setTableDefinition() {  
		$this->hasColumn('username', 'string', 255, array('unique' => 'true'));
		$this->hasColumn('password', 'string', 255);
		$this->hasColumn('email', 'string', 255, array('unique' => 'true'));
		$this->hasColumn('nickname', 'string', 255, array('unique' => 'true'));
		$this->hasColumn('street', 'string', 255, array('notnull' => false));
		$this->hasColumn('zipcode', 'string', 10, array('notnull' => false));
		$this->hasColumn('city', 'string', 255, array('notnull' => false));
		$this->hasColumn('phone', 'string', 255, array('notnull' => false));
		$this->hasColumn('poolgroup', 'string', 255, array('notnull' => false));
        $this->hasColumn('language', 'string', 255, array('default' => 'nederlands'));
		$this->hasColumn('admin', 'int',1, array('notnull' => false));
		$this->hasColumn('paid', 'int',1, array('notnull' => false));
		$this->hasColumn('active', 'int',1, array('notnull' => false));
		$this->hasColumn('lastlogin', 'timestamp');
		$this->hasColumn('activecode', 'string', 255);
        $this->hasColumn('resetcode', 'string', 255);
		$this->hasColumn('points', 'integer',4);
		$this->hasColumn('previouspoints', 'integer',4);
		$this->hasColumn('position', 'integer',4);
		$this->hasColumn('lastposition', 'integer',4);
		$this->hasColumn('pred_total_goals', 'integer',4, array('notnull' => false));
	}

	public function setUp() {
		$this->setTableName('users');
		$this->actAs('Timestampable');
		$this->hasMutator('password', '_encrypt_password');
        $this->hasMany('Predictions as Prediction', array(
			'local' => 'id',
		    'foreign' => 'user_id'
            ));
        $this->hasMany('Extra_answers as Answer', array(
			'local' => 'id',
		    'foreign' => 'user_id'
            ));
	}

	protected function _encrypt_password($value) {
		$salt = '#*seCrEt!@-*%';
        //$salt = 'auhf24rh98y&hggGK';
		$this->_set('password', md5($salt . $value));
	}
}
