<?php
class Teams extends Doctrine_Record {
    
   public function setTableDefinition() {
        
        $this->hasColumn('name','string', 255);
        $this->hasColumn('team_id_home','integer',4, array('unique'=>'true'));
        $this->hasColumn('team_id_away','integer',4, array('unique'=>'true'));
        $this->hasColumn('shortname','string', 255, array('notnull'=>false));
        $this->hasColumn('flag', 'string', 255, array('notnull'=>false ));
        $this->hasColumn('team_group', 'string', 255, array('notnull'=>false ));
        $this->hasColumn('played', 'integer',4);
        $this->hasColumn('won', 'integer',4);
        $this->hasColumn('tie', 'integer',4);
        $this->hasColumn('lost', 'integer',4);
        $this->hasColumn('points', 'integer',4);
        $this->hasColumn('goals_for', 'integer',4);
        $this->hasColumn('goals_against', 'integer',4);
        
        $this->index('team_id_home', array(
                'fields' => array('team_id_home'),
                'type'   => 'unique'
            )
        );
        $this->index('team_id_away', array(
               'fields' => array('team_id_away'),
                'type'   => 'unique'
            )
        );
    }
        
    public function setUp() {
		$this->hasMany('Matches as Match', array(
			'local' => 'team_id_home',
			'foreign' => 'home_id'
		));
		$this->hasMany('Matches as Match', array(
			'local' => 'team_id_away',
			'foreign' => 'away_id'
		));
		$this->hasMany('Predictions as Prediction', array(
			'local' => 'team_id_home',
			'foreign' => 'home_id'
		));
		$this->hasMany('Predictions as Prediction', array(
			'local' => 'team_id_away',
			'foreign' => 'away_id'
		));
    }
    
}
