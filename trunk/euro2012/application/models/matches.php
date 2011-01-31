<?php
class Matches extends Doctrine_Record {
    
   public function setTableDefinition() {
        $this->setTableName('matches');
        $this->hasColumn('match_name', 'string', 255);
        $this->hasColumn('match_number','integer', 4,array('unique'=>'true'));
        $this->hasColumn('home_id', 'integer', 4);
        $this->hasColumn('away_id', 'integer', 4);
        $this->hasColumn('venue_id', 'integer', 4);
        $this->hasColumn('match_time', 'timestamp');
        $this->hasColumn('type_id', 'integer', 4);
        $this->hasColumn('home_goals', 'integer', 4,array('notnull' => false));
        $this->hasColumn('away_goals', 'integer', 4,array('notnull' => false));
        $this->hasColumn('red_cards', 'integer', 4,array('notnull' => false));
        $this->hasColumn('yellow_cards', 'integer', 4,array('notnull' => false));
        $this->hasColumn('match_group', 'string', 255);
        $this->hasColumn('group_home', 'string', 255);
        $this->hasColumn('group_away', 'string', 255);
        $this->hasColumn('time_close', 'timestamp');
        $this->hasColumn('description', 'string', 255, array('notnull' => false));
        
       $this->index('home_id', array(
                'fields' => array('home_id')
            ));
        $this->index('away_id', array(
                'fields' => array('away_id')
            ));
        $this->index('match_number', array(
                'fields' => array('match_number'),
                'type' => 'unique'
            ));
    }
    
    public function setUp() {
		$this->hasOne('Venues as Venue', array(
			'local' => 'venue_id',
			'foreign' => 'venue_id'
		));
		$this->hasOne('Teams as TeamHome', array(
			'local' => 'home_id',
			'foreign' => 'team_id_home'
		));
		$this->hasOne('Teams as TeamAway', array(
			'local' => 'away_id',
			'foreign' => 'team_id_away'
		));
        $this->hasMany('Predictions as Prediction', array(
			'local' => 'match_number',
			'foreign' => 'match_number'
		));
    }
    
}
