<?php
class Predictions extends Doctrine_Record {
    
   public function setTableDefinition() {
        $this->hasColumn('user_id', 'integer',4);
        $this->hasColumn('match_number', 'integer',4);
        $this->hasColumn('home_goals', 'integer',4,array('notnull' => false));
        $this->hasColumn('away_goals', 'integer',4,array('notnull' => false));
        $this->hasColumn('red_cards', 'integer',4,array('notnull' => false));
        $this->hasColumn('home_id', 'integer',4,array('notnull' => false));
        $this->hasColumn('away_id', 'integer',4,array('notnull' => false));
        $this->hasColumn('yellow_cards', 'integer',4,array('notnull' => false));
        $this->hasColumn('points_home_goals', 'integer',4,array('notnull' => false));
        $this->hasColumn('points_away_goals', 'integer',4,array('notnull' => false));
        $this->hasColumn('points_toto', 'integer',4,array('notnull' => false));
        $this->hasColumn('points_exact', 'integer',4,array('notnull' => false));
        $this->hasColumn('points_red_cards', 'integer',4,array('notnull' => false));
        $this->hasColumn('points_yellow_cards', 'integer',4,array('notnull' => false));
        $this->hasColumn('points_home_id', 'integer',4,array('notnull' => false));
        $this->hasColumn('points_away_id', 'integer',4,array('notnull' => false));
        $this->hasColumn('points_total_this_match', 'integer',4,array('notnull' => false));
        $this->hasColumn('position_prev', 'integer',4,array('notnull' => false));
        $this->hasColumn('position_curr', 'integer',4,array('notnull' => false));
        $this->hasColumn('total_points_curr', 'integer',4,array('notnull' => false));
        $this->hasColumn('total_points_prev', 'integer',4,array('notnull' => false));
        $this->hasColumn('calculated', 'boolean', array('default' => 0));
                                
        $this->index('user_id', array(
                'fields' => array('user_id')
            )
        );
        $this->index('match_number', array(
               'fields' => array('match_number')
            )
        );
    }
    
    public function setUp() {
		$this->hasOne('Users as User', array(
			'local' => 'user_id',
			'foreign' => 'id'
		));
		$this->hasOne('Matches as Match', array(
			'local' => 'match_number',
			'foreign' => 'match_number'
		));
		$this->hasOne('Teams as TeamHome', array(
			'local' => 'home_id',
			'foreign' => 'team_id_home'
		));
		$this->hasOne('Teams as TeamAway', array(
			'local' => 'away_id',
			'foreign' => 'team_id_away'
		));
    }
    
}
