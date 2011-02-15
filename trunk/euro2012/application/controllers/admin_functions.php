<?php
// File: /system/application/controllers/admin_functions.php
// Version: 1.0
// Author: Schop

class Admin_functions extends Controller {

	public function __construct() {
		parent::Controller();
		
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
	}

	public function index() {

        if(logged_in()){
            if (admin()) {
    
                 $vars['settings_ad'] = Doctrine_Query::create()
                ->select('*')
                ->from('Settings')
                ->execute();
                
                $vars['title'] = "Admin Functions";
                $vars['content_view'] = "admin_functions";
                $vars['settings'] = $this->settings_functions->settings();
        		$this->load->view('template', $vars);
                }
            else {
                // Current user is not an admin
                $vars['title'] = "Access denied";
                $vars['content_view'] = "access_denied";
                $vars['settings'] = $this->settings_functions->settings();
    	       	$this->load->view('template', $vars);
                }
             }    
         else {
            // No user is logged in
            $vars['title'] = "Not logged in";
            $vars['content_view'] = "not_logged_in";
            $vars['settings'] = $this->settings_functions->settings();
	       	$this->load->view('template', $vars);
            }             
	}
	
    public function extra_questions($action, $saved = false) {
        
        if ($action == 'edit'){
            if (admin()){
                $vars['questions'] = Doctrine_Query::create()
                    ->select('q.*,
                              qt.*')
                    ->from('Extra_questions q, q.QType qt')
                    ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                    ->execute();
                $vars['saved'] = $saved;
                $vars['title'] = "Extra vragen";
                $vars['content_view'] = "extraquestions";
                $vars['settings'] = $this->settings_functions->settings();
                $this->load->view('template', $vars);
            }
            else {
                // Current user is not an admin
                
                $vars['title'] = "Access denied";
                $vars['message'] = "You are not an administrator";
                $vars['content_view'] = "error";
                $vars['settings'] = $this->settings_functions->settings();
                $this->load->view('template', $vars);
            }
        }
        
        if ($action == 'submit'){
            if (admin()){
               
                
                $qTable = Doctrine::getTable('Extra_questions');
                $qTable->setAttribute(Doctrine::ATTR_COLL_KEY, 'id'); // make sure they get indexed by ID
                $questions = $qTable->findAll();
                $replace = false;
                $arrPost = $this->input->post('post_array');    //get all posted values in one array
                foreach ($arrPost as $id => $value) {           // $id represents the 'id' column in the user table
                    if (!array_key_exists('active',$value)) { $questions[$id]['active'] = 0;$replace=true; }
                    foreach ($value as $k => $v) {              // $k represents 'street', 'city' etc.  
                        
                        if ($questions[$id][$k]!= $v) { // iterate over all fields, see if one has changed
                            
                            if ($v != NULL) {
                                $questions[$id][$k]=$v;
                                }
                            else {
                                $questions[$id][$k]=NULL;
                                }
                            $replace = true;    // this record will have to be updated
                            }
                        }
                        if ($replace) {
                            $questions[$id]->replace(); // update the record
                            $replace= false;
                            }
                    }
                
                $questions->free();                
                
                $this->extra_questions('edit', true);
               // $vars['title'] = "Extra vragen";
               // $vars['content_view'] = "extraquestions";
               // $vars['settings'] = $this->settings_functions->settings();
               // $this->load->view('template', $vars);
            }
            else {
                // Current user is not an admin
                $vars['title'] = "Access denied";
                $vars['message'] = "You are not an administrator";
                $vars['content_view'] = "error";
                $vars['settings'] = $this->settings_functions->settings();
                $this->load->view('template', $vars);
            }
        }   
    }
    
	public function recalculate_all() {
	    $start = microtime(true);
	    if (admin()) {
	        $reset = $this->calculation_functions->reset_calculations();
	        if ($reset) {
	            $settings = $this->settings_functions->settings();
                $count = $this->calculation_functions->calculate_points($settings);
                $duration = microtime(true) - $start;
                $vars['message'] = 'Recalculated '.$count.' predictions in '.$duration.' seconds.';
                $vars['title'] = "Recalculation complete";
                $vars['content_view'] = "success";
                $vars['settings'] = $this->settings_functions->settings();
    		    $this->load->view('template', $vars);
                }
             }   
        else {
                        // Current user is not an admin
            $vars['title'] = "Access denied";
            $vars['content_view'] = "access_denied";
            $vars['settings'] = $this->settings_functions->settings();
    		$this->load->view('template', $vars);
            }        
    }

	public function calculate_new() {
	    $start = microtime(true);
	    if (admin()) {
            $settings = $this->settings_functions->settings();
            $count = $this->calculation_functions->calculate_points($settings);
            $duration = microtime(true) - $start;
            $vars['links'] = array(anchor('ranking','Bekijk de ranglijst'),anchor('/','Home'));
            $vars['message'] = $count.' voorspellingen berekend in '.$duration.' seconden.';
            $vars['title'] = "Recalculation complete";
            $vars['content_view'] = "success";
            $vars['settings'] = $this->settings_functions->settings();
		    $this->load->view('template', $vars);
            }   
        else {
            // Current user is not an admin
            $vars['title'] = "Access denied";
            $vars['message'] = "You are not an administrator";
            $vars['content_view'] = "error";
            $vars['settings'] = $this->settings_functions->settings();
    		$this->load->view('template', $vars);
            }        
    }

// Below are testing functions. Do not use in a pool, unless you are testing
    
    function randomize_predictions() {
        $start = microtime(true);
        //$conn = Doctrine_Manager::connection();
        $q = Doctrine_Query::create()
            ->select('p.home_goals,
                      p.away_goals,
                      p.calculated')
            ->from('Predictions p')
            ->where('p.match_number < 30')
            ->execute();
            
        foreach ($q as $prediction) {
            $prediction->home_goals = mt_rand(0, 4);
            $prediction->away_goals = mt_rand(0, 4);
            $prediction->calculated = 0;
            }
        $q->save();
        $q->free();
        
        $q = Doctrine_Query::create()
            ->select('p.home_goals,
                      p.away_goals,
                      p.calculated')
            ->from('Predictions p')
            ->where('p.match_number > 29')
            ->andWhere('p.match_number < 50')
            ->execute();
            
        foreach ($q as $prediction) {
            $prediction->home_goals = mt_rand(0, 4);
            $prediction->away_goals = mt_rand(0, 4);
            $prediction->calculated = 0;
            }
        $q->save();
        $q->free();
    
        $q = Doctrine_Query::create()
            ->select('p.home_goals,
                      p.away_goals,
                      p.calculated')
            ->from('Predictions p')
            ->where('p.match_number > 49')
            ->execute();
            
        foreach ($q as $prediction) {
            $prediction->home_goals = mt_rand(0, 4);
            $prediction->away_goals = mt_rand(0, 4);
            $prediction->calculated = 0;
            }
        $q->save();
        $q->free();
        
        //$conn->flush();
        $duration = microtime(true) - $start;
        $vars['message'] = 'Randomized all predictions in '.$duration.' seconds.';
        $vars['title'] = "Randomizing predictions complete";
        $vars['content_view'] = "success";
        $vars['settings'] = $this->settings_functions->settings();
	    $this->load->view('template', $vars);           
            

    }
    
        function create_users() {
        $conn = Doctrine_Manager::connection();
        $count = 0;
        $start = microtime(true);
        for ($i=151;$i<=200;$i++) {
            $u[$i] = new Users();
    		$u[$i]->username = 'user'.$i;
    		$u[$i]->password = 'user'.$i;
    		$u[$i]->email = 'user'.$i.'@example.com';
    		$u[$i]->nickname = 'User '.$i;
    		$u[$i]->save();
    		$count++;
    		
    		$matches = Doctrine_Query::create()
                ->select('m.match_number')
                ->from('Matches m')
                ->execute(); 
		
    		// Now create a new set of predictions for this user
    		// User gets a prediction record for each match
    		foreach ($matches as $match) {
    		    $y=1;
                $p[$y] = new Predictions();
                $p[$y]->user_id = $u[$i]['id'];
                $p[$y]->match_number = $match->match_number;
                $p[$y]->calculated = 0;
                //$p[$y]->save();
                $y++;
            }
         }
        	
        $conn->flush();
        $duration = microtime(true) - $start;
        $vars['message'] = 'Created '.$count.' test users in '.$duration.' seconds.';
        $vars['title'] = "Creating users complete";
        $vars['content_view'] = "success";
        $vars['settings'] = $this->settings_functions->settings();
	    $this->load->view('template', $vars);       
       }
       
       function clear_predictions() {
        $conn = Doctrine_Manager::connection();
        $countmatch = 0;
        $countpred = 0;
        $start = microtime(true);
            		
    		$predictions = Doctrine_Query::create()
                ->select('p.*')
                ->from('Predictions p')
                ->execute(); 
            
                foreach ($predictions as $prediction) {
                    $prediction['home_goals'] = NULL;
                    $prediction['away_goals'] = NULL;
                    $prediction['home_id'] = NULL;
                    $prediction['away_id'] = NULL;
                    $prediction['calculated'] = 0;
                    $prediction['points_home_goals'] = 0;
                    $prediction['points_away_goals'] = 0;
                    $prediction['points_toto'] = 0;
                    $prediction['points_exact'] = 0;
                    $prediction['points_home_id'] = 0;
                    $prediction['points_away_id'] = 0;
                    $prediction['points_total_this_match'] = 0;
                    $prediction['position_prev'] = 0;
                    $prediction['position_curr'] = 0;
                    $prediction['total_points_curr'] = 0;
                    $prediction['total_points_prev'] = 0;
                    $countpred++;
                    }

            $conn->flush();
            $duration = microtime(true) - $start;
            $vars['links'] = array(anchor('admin_functions/recalculate_all','Alles opnieuw berekenen'),anchor('/','Home'));
            $vars['message'] = $countpred.' voorspellingen gewist in '.$duration.' seconden. Punten en ranglijst zijn ook gewist.';
            $vars['title'] = "Clear predictions complete";
            $vars['content_view'] = "success";
            $vars['settings'] = $this->settings_functions->settings();
	        $this->load->view('template', $vars);           
            }



       function clear_results() {
        $conn = Doctrine_Manager::connection();
        $countmatch = 0;
        $countpred = 0;
        $start = microtime(true);
            		
    		$matches = Doctrine_Query::create()
                ->select('m.home_goals,
                          m.away_goals')
                ->from('Matches m')
                ->execute(); 
            
            foreach($matches as $match) {
                $match['home_goals'] = NULL;
                $match['away_goals'] = NULL;
                $countmatch++;
                }
            $users = Doctrine_Query::create()
                ->select('u.points,
                          u.previouspoints,
                          u.position,
                          u.lastposition')
                ->from('Users u')
                ->execute();
           foreach ($users as $user) {
                $user['points'] = 0;
                $user['previouspoints'] = 0;
                $user['position'] = 0;
                $user['lastposition'] = 0;
                }     
          $conn->flush();
          $users->free();
          $matches->free();
          $this->clear_predictions();
            $duration = microtime(true) - $start;
            $vars['links'] = array(anchor('admin_functions/recalculate_all','Recalculate all predictions'),anchor('/','Home'));
            $vars['message'] = 'Deleted '.$countmatch.' matchresults and '.$countpred.' predictions in '.$duration.' seconds. Also reset points and position for each user and prediction.';
            $vars['title'] = "Clear results complete";
            $vars['content_view'] = "success";
            $vars['settings'] = $this->settings_functions->settings();
	        $this->load->view('template', $vars);           
            }
                           
    public function backup() {
        // Load the DB utility class
        $filename = "backup_".time().".sql";
        $this->load->dbutil();
        $prefs = array( 'format'      => 'txt',             // gzip, zip, txt
                        'filename'    => $filename,    // File name - NEEDED ONLY WITH ZIP FILES
                        'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
                        'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
                        'newline'     => "\n"               // Newline character used in backup file
                      );
        // Backup your entire database and assign it to a variable
        $backup =& $this->dbutil->backup($prefs); 

        // Load the file helper and write the file to your server
        $this->load->helper('file');
        $data = "SET foreign_key_checks = 0;\n"; // Need this to be able to restore it later
        $backup = $data.$backup;
        //write_file('application/data_backup/'.$filename, $backup);
        //also offer a download
        $this->load->helper('download');
        force_download($filename, $backup);


        
            // $vars['message'] = 'Dumped all data in application/data_backup/'.$filename.'. You can restore the data using  tool like phpMyAdmin.';
            // $vars['title'] = "Data backup complete";
            // $vars['content_view'] = "success";
            // $vars['settings'] = $this->settings_functions->settings();
	        // $this->load->view('template', $vars); 
        
    }
    
    public function install_delete() {
    
        $file = base_url()."application/controllers/install.php";
        echo $file;
        if (file_exists($file)) {
            unlink($file);
            $vars['message'] = "Klaar. Je kunt nu ".anchor('login','inloggen')."!";
            $vars['title'] = "Installation complete";
            $vars['content_view'] = "success";
            $vars['settings'] = $this->settings_functions->settings();
	        $this->load->view('template', $vars);                    
            }
        }    
}
