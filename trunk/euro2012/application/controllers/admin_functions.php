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
                $teams = Doctrine_Query::create()
                    ->select('t.name')
                    ->from('Teams t INDEXBY t.id')
                    ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                    ->orderBy('t.name')
                    ->where('t.id < 17')
                    ->execute();
                foreach ($teams as $team) {
                    $vars['teams'][$team['id']] = $team['name'];
                    }
                    $vars['teams'][0] = "-";
                    asort($vars['teams']);                    
                $vars['saved'] = $saved;
                $vars['title'] = "Extra vragen";
                $vars['content_view'] = "extraquestions_admin";
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
        if (admin()) {
            $start = microtime(true);
            $users = Doctrine_Query::create()
                ->select('u.id')
                ->from('Users u')
                ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                ->execute();
            $count = 0;
                foreach ($users as $user) {
                    
                    $p_table = Doctrine::getTable('Predictions');
                    
                    $predictions = $p_table->findByUser_id($user['id']);
                    $group['a'] = array(1,2,3,4);
                    $group['b'] = array(5,6,7,8);
                    $group['c'] = array(8,9,10,11);
                    $group['d'] = array(12,13,14,15);
                    foreach ($predictions as $prediction) {
                        $prediction->home_goals = mt_rand(0, 4);
                        $prediction->away_goals = mt_rand(0, 4);
                        
                        //randomize predictions for teams. maybe this should be based on the score? for now, it's fancy enough.
                        if ($prediction->match_number > 49 && $prediction->match_number < 60) { //randomize prediction of teams as well, but in a 'possible' way
                            $g = strtolower($prediction['Match']['group_home']);
                            $random_key = array_rand($group[$g]);
                            $prediction->home_id = $group[$g][$random_key];
                            unset($group[$g][$random_key]); // since we've used this team, do not use it in the other quarterfinals, but do set it as a possible semi final
                            $g = strtolower($prediction['Match']['group_away']);
                            $random_key = array_rand($group[$g]);
                            $prediction->away_id = $group[$g][$random_key];
                            unset($group[$g][$random_key]); // since we've used this team, do not use it in the other quarterfinals
                            if ($prediction->match_number == 51) {
                                $qf1 = array($prediction->home_id, $prediction->away_id);
                            }
                            if ($prediction->match_number == 52) {
                                $qf2 = array($prediction->home_id, $prediction->away_id);
                            }                            
                            if ($prediction->match_number == 53) {
                                $qf3 = array($prediction->home_id, $prediction->away_id);
                            }
                            if ($prediction->match_number == 54) {
                                $qf4 = array($prediction->home_id, $prediction->away_id);
                            }
                        }    
                        if ($prediction->match_number == 61) {
                            $random_key = array_rand($qf1);
                            $prediction->home_id = $qf1[$random_key];
                            unset($qf1[$random_key]);
                            $random_key = array_rand($qf3);
                            $prediction->away_id = $qf3[$random_key];
                            unset($qf3[$random_key]);
                            $semi[1] = array($prediction->home_id, $prediction->away_id);
                            }
                        if ($prediction->match_number == 62) {
                            $random_key = array_rand($qf2);
                            $prediction->home_id = $qf2[$random_key];
                            unset($qf2[$random_key]);
                            $random_key = array_rand($qf4);
                            $prediction->away_id = $qf4[$random_key];
                            unset($qf4[$random_key]);
                            $semi[2] = array($prediction->home_id, $prediction->away_id);
                            }                        
                        if ($prediction->match_number == 99) {
                            $random_key_2 = array_rand($semi[1]);
                            $prediction->home_id = $semi[1][$random_key_2];
                            $random_key_2 = array_rand($semi[2]);
                            $prediction->away_id = $semi[2][$random_key_2];                            
                        }
                        $prediction->calculated = 0;
                        $count++;                    
                    }
                        $predictions->save();
                        $predictions->free();
                    }

                    $duration = microtime(true) - $start;
            $vars['message'] = 'Randomized '.$count.' predictions in '.$duration.' seconds.';
            $vars['title'] = "Randomizing predictions complete";
            $vars['content_view'] = "success";
            $vars['settings'] = $this->settings_functions->settings();
            $this->load->view('template', $vars); 
        }
    }

    
        function create_users() {
        if (admin()) {
            $conn = Doctrine_Manager::connection();
            $count = 0;
            $start = microtime(true);
            for ($i=151;$i<=200;$i++) {
                $u[$i] = new Users();
                $u[$i]->username = 'user'.$i;
                $u[$i]->password = 'user'.$i;
                $u[$i]->email = 'user'.$i.'@example.com';
                $u[$i]->nickname = 'User '.$i;
                $u[$i]->active = 1;
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
