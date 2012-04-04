<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('tournament_done'))
{
	function tournament_done()
	{
		$CI =& get_instance();
		$sql_query = "SELECT * FROM `match` WHERE `match`.`match_uid` = 31";
		$query = $CI->db->query($sql_query);
		$row = $query->row_array();
		
		if ($row['match_calculated'] == 1)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}

if ( ! function_exists('is_admin'))
{
    function is_admin()
    {
        $CI =& get_instance();
        if ($CI->authentication->is_signed_in())
        {
            $sql_query = "SELECT * FROM `account` WHERE `is_admin` = '1'";
            $query = $CI->db->query($sql_query);
            $admins = $query->result_array();
            
            $account_id = $CI->session->userdata('account_id');
            $is_admin = FALSE;
            foreach ($admins as $admin)
            {
                if ($account_id == $admin['id'])
                {
                    $is_admin = TRUE;
                }
            }
        }
        else
        {
            $is_admin = FALSE;
        }
        
        return $is_admin;
    }
}

	function get_top_ranking_for_match($match_uid, $top = 10)
	{
		$CI =& get_instance();
		$sql_query = "SELECT *
					  FROM `prediction`
					  JOIN `account`
					  ON `prediction`.`account_id` = `account`.`id`
					  AND `prediction`.`pred_match_uid` = $match_uid
					  ORDER BY `prediction`.`pred_points_total` DESC
					  LIMIT $top";
		$query = $CI->db->query($sql_query);
		return $query->result_array();
	}	
	

if ( ! function_exists('get_team_name'))
{
    function get_team_name($team_uid)
    {
        $CI =& get_instance();
        $CI->load->helper(array('language'));
        $CI->load->language(array('general'));
        return lang($team_uid);
    }
}

if ( ! function_exists('get_away_shirt'))
{
    function get_away_shirt($team_uid, $link = FALSE)
    {
        $CI =& get_instance();
        $CI->load->helper(array('language'));
        $CI->load->language(array('general'));
        if ($team_uid[0] == 'W' or $team_uid[0] == 'R')
        {
            $team_uid = 'WA';
        }
        if ($link && !($team_uid == 'WA'))
        {
            return anchor('stats/view_team/'.$team_uid,"<img src='".base_url('css/flags')."/".$team_uid."_shirt_2.png' alt='".get_team_name($team_uid)." ".lang('away')."'/>", "title='".get_team_name($team_uid)."'");
        }
        else
        {
            return "<img src='".base_url('css/flags')."/".$team_uid."_shirt_2.png' title='".get_team_name($team_uid)." ".lang('away')."' alt='".get_team_name($team_uid)." ".lang('away')."' />";
        }
    }
}
if ( ! function_exists('get_home_shirt'))
{
    function get_home_shirt($team_uid, $link = FALSE)
    {
        $CI =& get_instance();
        $CI->load->helper(array('language'));
        $CI->load->language(array('general'));
        if ($team_uid[0] == 'W' or $team_uid[0] == 'R')
        {
            $team_uid = 'WA';
        }
        if ($link && !($team_uid == 'WA'))
        {
            return anchor('stats/view_team/'.$team_uid,"<img src='".base_url('css/flags')."/".$team_uid."_shirt_1.png' alt='".get_team_name($team_uid)." ".lang('home')."' />", "title='".get_team_name($team_uid)."'");
        }
        else
        {
            return "<img src='".base_url('css/flags')."/".$team_uid."_shirt_1.png' title='".get_team_name($team_uid)." ".lang('home')."' alt='".get_team_name($team_uid)." ".lang('home')."' />";
        }        
    }
}

if ( ! function_exists('get_match'))
{
    function get_match($match_uid)
    {
        $CI =& get_instance();
        $CI->load->helper(array('language'));
        $CI->load->language(array('general'));
        
        $sql_query = "SELECT * FROM `match`
                      WHERE `match`.`match_uid` = '$match_uid'";
        $query = $CI->db->query($sql_query);
        $match = $query->row_array();
        $home = get_team_name($match['home_team']);
        $away = get_team_name($match['away_team']);
                
        return $home." - ".$away;
    }
}

if ( ! function_exists('get_match_stats'))
{
    function get_match_stats($match_uid)
    {
        $CI =& get_instance();
        $CI->load->helper(array('language'));
        $CI->load->language(array('general'));
        
        $sql_query = "SELECT * FROM `prediction`
                      JOIN `match`
                      ON   `match`.`match_uid` = `prediction`.`pred_match_uid`
                      AND `match`.`match_uid` = '$match_uid'";
        $query = $CI->db->query($sql_query);
        $predictions = $query->result_array();
        $home = get_team_name($predictions[0]['home_team']);
        $away = get_team_name($predictions[0]['away_team']);
        $tie  = lang('tie');
        $stats = array( $home => 0, $tie => 0, $away => 0);
        foreach ($predictions as $prediction)
        {
            if ($prediction['pred_home_goals'] > $prediction['pred_away_goals'])
            {
                $stats[$home] = $stats[$home] + 1;
            }
            elseif ($prediction['pred_home_goals'] < $prediction['pred_away_goals'])
            {
                $stats[$away] = $stats[$away] + 1;
            }
            elseif ($prediction['pred_home_goals'] != NULL && $prediction['pred_away_goals'] != NULL)
            {   
                $stats[$tie] = $stats[$tie] + 1;
            }
        }
        return $stats;
    }
}

if ( ! function_exists('prediction_closed'))
{
    function prediction_closed($match_uid)
    {
        $CI =& get_instance();
        $CI->load->helper(array('date'));
        
        if ($CI->poolconfig_model->item('predictions_open'))
        {
            // Predictions can be made until the match starts (with optional offset)
            $sql_query = "SELECT * FROM `match`
                          WHERE `match`.`match_uid` = '$match_uid'";

        }
        else
        {
            // Predictions are closed when the tournament starts (Match #1)
            $sql_query = "SELECT * FROM `match`
                          WHERE `match`.`match_uid` = '1'";
           
        }
        
        $query = $CI->db->query($sql_query);
        $match = $query->row_array(); 
        
        // Calculate if it is past kick-off time, with the configured offset if necessary
        $time_offset = $CI->poolconfig_model->item('time_offset');
        $now = now() - $time_offset;
        $offset = $CI->poolconfig_model->item('predictions_open_offset');
        $closing_time = $match['timestamp'] - $time_offset - $offset;

        if ($now < $closing_time)
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
            
    }
}

if ( ! function_exists('admin_check_unverified') )
{
    function admin_check_unverified()
    {
        $CI =& get_instance();
        $sql_query = "SELECT *
                      FROM `account`
                      WHERE `verifiedon` IS NULL";
        $query = $CI->db->query($sql_query);
        $num = $query->num_rows();
        
        if ($num > 0)
        {
            //there are unverified users
            return $num;
        }
        else
        {
            return FALSE;
        }
    }
}
if ( ! function_exists('get_last_matches') )
{
    function get_last_matches($num, $format="<li>%matchtime%: %home% - %away% (%result%)</li>")
    {
        
        $CI =& get_instance();
        $CI->load->helper(array('language', 'date'));
        $CI->load->language(array('general'));
        $now = now();
        $account_id = $CI->session->userdata('account_id');
        $sql_query = "SELECT *
                      FROM `prediction`
                      JOIN `match`
                      ON `prediction`.`pred_match_uid` = `match`.`match_uid`
                      AND `match`.`timestamp` > $now
                      AND `prediction`.`account_id` = '$account_id'
					  AND `match`.`match_calculated` = 1
                      ORDER BY `match`.`timestamp` DESC
                      LIMIT $num";
        $query = $CI->db->query($sql_query);
        $matches = $query->result_array();
        
        $html = "";
        
        
        
        foreach ($matches as $match)
        {
            
            $homestring = "<span class='teamflag ".$match['home_team']."'>".anchor('stats/view_team/'.$match['home_team'],get_team_name($match['home_team']))."</span>";
            $awaystring = "<span class='teamflag ".$match['away_team']."'>".anchor('stats/view_team/'.$match['away_team'],get_team_name($match['away_team']))."</span>";
			$resultstring = anchor('predictions/edit_match/'.$match['match_uid'], $match['home_goals']." - ".$match['away_goals'], "title='".lang('match')." ".$match['match_uid']."'");
            $string = str_replace('%home%', $homestring, $format);
            $string = str_replace('%away%', $awaystring, $string);
			$string = str_replace('%homegoals%', $match['home_goals'], $string);
			$string = str_replace('%awaygoals%', $match['away_goals'], $string);
			$string = str_replace('%result%', $resultstring, $string);
			
			$string = str_replace('%total_points%', $match['pred_points_total'], $string);
            $string = str_replace('%matchtime%', mdate("%d %M %Y %H:%i",$match['timestamp']), $string);
            $string = str_replace('%result%', anchor('predictions/edit_match/'.$match['match_uid'], lang('result').": ".$match['home_goals']." - ".$match['away_goals']), $string);
            $string = str_replace('%group%', lang($match['match_group']), $string);
            
            $homeshirtstring = get_home_shirt($match['home_team'], 1);
            $awayshirtstring = get_away_shirt($match['away_team'], 1);
            
            $string = str_replace('%homeshirt%', $homeshirtstring, $string);
            $string = str_replace('%awayshirt%', $awayshirtstring, $string);

            $statsbutton = anchor('stats/view_match/'.$match['pred_match_uid'],lang('view_stats'), "class='button chart-bar'");
            $string = str_replace('%chart%', $statsbutton, $string);
                
            
            $html .= $string;
        }
             
        return ($html);
    }
}

if ( ! function_exists('get_next_matches') )
{
    function get_next_matches($num, $format="<li>%matchtime%: %home% - %away% (%prediction%)</li>")
    {
        
        $CI =& get_instance();
        $CI->load->helper(array('language', 'date'));
        $CI->load->language(array('general'));
        $now = now() + $CI->poolconfig_model->item('time_offset');
        $account_id = $CI->session->userdata('account_id');
        $sql_query = "SELECT *
                      FROM `prediction`
                      JOIN `match`
                      ON `prediction`.`pred_match_uid` = `match`.`match_uid`
                      AND `match`.`timestamp` > $now
                      AND `prediction`.`account_id` = '$account_id'
					  AND `match`.`match_calculated` = 0
                      ORDER BY `match`.`timestamp`
                      LIMIT $num";
        $query = $CI->db->query($sql_query);
        $matches = $query->result_array();
        
        $html = "";
        
        
        if ($query->num_rows() > 0)
		{
			foreach ($matches as $match)
			{
				
				$homestring = "<span class='teamflag ".$match['home_team']."'>".anchor('stats/view_team/'.$match['home_team'],get_team_name($match['home_team']))."</span>";
				$awaystring = "<span class='teamflag ".$match['away_team']."'>".anchor('stats/view_team/'.$match['away_team'],get_team_name($match['away_team']))."</span>";
				$string = str_replace('%home%', $homestring, $format);
				$string = str_replace('%away%', $awaystring, $string);
				$string = str_replace('%matchtime%', mdate("%d %M %Y %H:%i",$match['timestamp']), $string);
				$string = str_replace('%prediction%', lang('your_prediction').": ".$match['pred_home_goals']." - ".$match['pred_away_goals'], $string);
				$string = str_replace('%group%', lang($match['match_group']), $string);
				
				$homeshirtstring = get_home_shirt($match['home_team'], 1);
				$awayshirtstring = get_away_shirt($match['away_team'], 1);
				
				$string = str_replace('%homeshirt%', $homeshirtstring, $string);
				$string = str_replace('%awayshirt%', $awayshirtstring, $string);

				$statsbutton = anchor('predictions/edit_match/'.$match['pred_match_uid'],lang('view_stats')." &amp; ".lang('prediction'), "class='button chart-bar'");
				$string = str_replace('%chart%', $statsbutton, $string);
					
				
				$html .= $string;
			}
        }
		else
		{
			$html = "<p>".lang('no_more_matches')."</p>";
		}	
        return ($html);
    }
}

if ( ! function_exists('get_missing_result_list') )
{
    function get_missing_result_list($params)
    {
        $heading    = $params['heading'];
        $pre        = $params['pre'];
        $post       = $params['post'];
        $listitem   = $params['listitem'];
        
        $CI =& get_instance();
        $CI->load->helper(array('language', 'date', 'url'));
        $CI->load->language(array('general'));
        
        $now = now() + $CI->poolconfig_model->item('time_offset');
        $next_48_hours = $now + 172800;
        $account_id = $CI->session->userdata('account_id');
        $sql_query = "SELECT *
                      FROM `prediction`
                      JOIN `match`
                      ON `prediction`.`pred_match_uid` = `match`.`match_uid`
                      AND `prediction`.`account_id` = '$account_id'
                      AND `prediction`.`pred_calculated` = 0
                      ORDER BY `match`.`timestamp`";

        $query = $CI->db->query($sql_query);
        $predictions = $query->result_array();
        
        
        $missing_results_data = array();
        $missing_team_data = array();
        foreach ($predictions as $prediction)
        {
            if ($prediction['pred_home_goals'] == NULL || $prediction['pred_home_goals'] == "" || $prediction['pred_away_goals'] == NULL || $prediction['pred_away_goals'] == "")
            //if ($prediction['pred_home_goals']== NULL)
            {
                $missing_results_data[] = $prediction['match_uid'];
            }
        }
        $html = "";
        if (isset($missing_results_data[0]))
        {
            
            $html = str_replace('%heading%', lang('missing_results_heading'),$heading);
            $html .= $pre;
            foreach ($missing_results_data as $key => $value)
            {
                $sql_query = "SELECT `match_group` FROM `match` WHERE `match_uid` = $value";
                $query = $CI->db->query($sql_query);
                $row = $query->row_array();
                $html .= str_replace('%matchlink%', anchor('predictions/edit_match/'.$value, get_match($value))." (".anchor('predictions/editgroup/'.$row['match_group'],lang($row['match_group'])).")", $listitem);
                
            }
            $html .= $post;
        }
        
        return $html;
    }
}

if ( ! function_exists('get_missing_teams_list') )
{
    function get_missing_teams_list($params)
    {
        $heading    = $params['heading'];
        $pre        = $params['pre'];
        $post       = $params['post'];
        $listitem   = $params['listitem'];
        
        $CI =& get_instance();
        $CI->load->helper(array('language', 'date', 'url'));
        $CI->load->language(array('general'));
        $now = now();
        $account_id = $CI->session->userdata('account_id');
        $sql_query = "SELECT *
                      FROM `prediction`
                      JOIN `match`
                      ON `prediction`.`pred_match_uid` = `match`.`match_uid`
                      AND `prediction`.`account_id` = '$account_id'
                      AND `prediction`.`pred_match_uid` >= 25
                      ORDER BY `match`.`timestamp`";
        $query = $CI->db->query($sql_query);
        $predictions = $query->result_array();
        
        
        $missing_results_data = array();
        $missing_team_data = array();
        foreach ($predictions as $prediction)
        {
            if ($prediction['pred_home_team'] == NULL
                || $prediction['pred_home_team'] == ""
                || $prediction['pred_home_team'][0] == "W" || $prediction['pred_home_team'][0] == "R"
                || $prediction['pred_away_team'] == NULL
                || $prediction['pred_away_team'] == ""
                || $prediction['pred_away_team'][0] == "W" || $prediction['pred_away_team'][0] == "R")
            //if ($prediction['pred_home_goals']== NULL)
            {
                $missing_results_data[] = $prediction['match_uid'];
            }
        }
        $html = "";
        if (isset($missing_results_data[0]))
        {
            
            $html = str_replace('%heading%', lang('missing_teams_heading'),$heading);
            $html .= $pre;
            foreach ($missing_results_data as $key => $value)
            {
                $sql_query = "SELECT `match_group` FROM `match` WHERE `match_uid` = $value";
                $query = $CI->db->query($sql_query);
                $row = $query->row_array();
                $html .= str_replace('%matchlink%', anchor('predictions/edit_match/'.$value, '#'.$value)." (".anchor('predictions/editgroup/'.$row['match_group'],lang($row['match_group'])).")", $listitem);
                
            }
            $html .= $post;
        }
        
        return $html;
    }
}

if ( ! function_exists('get_user_points') )
{
    function get_user_points($account_id)
    {
        $CI =& get_instance();
        $sql_query = "SELECT `pred_points_total`
                      FROM `prediction`
                      WHERE `account_id` = '$account_id'
                      AND `pred_calculated` = 1";
        $query = $CI->db->query($sql_query);
        $predictions = $query->result_array();
        $points = 0;
        foreach ($predictions as $prediction) {
            $points = $points + $prediction['pred_points_total'];
        }
        return $points;
    }
}

if ( ! function_exists('get_total_goals') )
{
    function get_total_goals($account_id)
    {
        $CI =& get_instance();
        $sql_query = "SELECT 
                        *
                      FROM `account_details`
                      WHERE `account_id` = '$account_id'";
        $query = $CI->db->query($sql_query);
        $details = $query->row_array();
        
        if (!isset($details['pred_total_goals']) || $details['pred_total_goals'] == "" || $details['pred_total_goals'] == NULL)
        {
            return FALSE;
        }
        else
        {
            return $details['pred_total_goals'];
        }
    }
}

if ( ! function_exists('check_user') )
{
    function check_user($account_id)
    {

        $CI =& get_instance();
        $sql_query = "SELECT 
                        *
                      FROM `prediction`
                      WHERE `account_id` = '$account_id'";
        $query = $CI->db->query($sql_query);
        $predictions = $query->result_array();
        $complete = 1;
        foreach ($predictions as $prediction)
        {
            
            
            if (!isset($prediction['pred_home_goals']) || $prediction['pred_home_goals'] === ""  || $prediction['pred_home_goals'] === NULL || !isset($prediction['pred_away_goals']) || $prediction['pred_away_goals'] === NULL || $prediction['pred_away_goals'] === "")
            {  
                $complete = 0;
            }
            

            if ($prediction['pred_match_uid'] >= 25 &&
                    (
                        ($prediction['pred_home_team'] == NULL ||
                         $prediction['pred_home_team'] == "" ||
                         !isset($prediction['pred_home_team']) ||
                         $prediction['pred_home_team'][0] == "W" ||
                         $prediction['pred_home_team'][0] == "R")
                        ||
                        ($prediction['pred_away_team'] == NULL ||
                         $prediction['pred_away_team'] == "" ||
                         !isset($prediction['pred_away_team']) ||
                         $prediction['pred_away_team'][0] == "W" ||
                         $prediction['pred_away_team'][0] == "R")                    
                    )
                )
            {          
                $complete = 0;
            }
        }

        $sql_query = "SELECT 
                    *
                  FROM `account_details`
                  WHERE `account_id` = '$account_id'
                  LIMIT 1";
            $query = $CI->db->query($sql_query);
            $extras = $query->result_array();
       
        foreach ($extras as $extra)
        {
            if ($extra['pred_total_goals'] == NULL || $extra['pred_total_goals'] == "" || !isset($extra['pred_total_goals'])
                  ||
                $extra['pred_champion'] == NULL  || $extra['pred_champion'] == "" || !isset($extra['pred_champion'])
               )
            {
                $complete = 0;
            }    
        }
        
        return $complete;
    }
}


function cleanString($in,$offset=null)
{
    $out = trim($in);
    if (!empty($out))
    {
        $entity_start = strpos($out,'&',$offset);
        if ($entity_start === false)
        {
            // ideal
            return $out;   
        }
        else
        {
            $entity_end = strpos($out,';',$entity_start);
            if ($entity_end === false)
            {
                 return $out;
            }
            // zu lang um eine entity zu sein
            else if ($entity_end > $entity_start+7)
            {
                 // und weiter gehts
                 $out = cleanString($out,$entity_start+1);
            }
            // gottcha!
            else
            {
                 $clean = substr($out,0,$entity_start);
                 $subst = substr($out,$entity_start+1,1);
                 // &scaron; => "s" / &#353; => "_"
                 $clean .= ($subst != "#") ? $subst : "_";
                 $clean .= substr($out,$entity_end+1);
                 // und weiter gehts
                 $out = cleanString($clean,$entity_start+1);
            }
        }
    }
    return $out;
} 

/* End of file pool_helper.php */
/* Location: ./application/helpers/pool_helper.php */
