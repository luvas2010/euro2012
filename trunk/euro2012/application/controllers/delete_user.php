<?php

class Delete_user extends Controller {


	public function index() {
	
	$user_id = Current_User::user()->id;
	$q = Doctrine_Query::create()
    ->delete('Users u')
    ->where('u.id = '.$user_id)
	->execute();
	
	$p = Doctrine_Query::create()
    ->delete('Predictions p')
    ->where('p.user_id = '.$user_id)
	->execute();	
	
    $this->load->view('submit_success');
	}

}
