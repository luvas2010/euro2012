<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

if ( ! function_exists('prediction_closed'))
{
    function prediction_closed($match_uid)
    {
        $CI =& get_instance();
        $CI->load->helper(array('date'));
        
        if ($CI->config->item('predictions_open'))
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
        $now = now() - $CI->config->item('time_offset');
        $offset = $CI->config->item('predictions_open_offset');
        $closing_time = $match['timestamp'] - $offset;

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

if ( ! function_exists('get_next_matches') )
{
    function get_next_matches($num, $format="<li>%matchtime%: %home% - %away% (%prediction%)</li>")
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
                      ORDER BY `match`.`timestamp`
                      LIMIT $num";
        $query = $CI->db->query($sql_query);
        $matches = $query->result_array();
        
        $html = "";
        foreach ($matches as $match)
        {
            $string = str_replace('%home%', get_team_name($match['home_team']), $format);
            $string = str_replace('%away%', get_team_name($match['away_team']), $string);
            $string = str_replace('%matchtime%', mdate("%d-%m-%Y %H:%i",$match['timestamp']), $string);
            $string = str_replace('%prediction%', anchor('predictions/editgroup/'.$match['match_group'], lang('prediction').": ".$match['pred_home_goals']." - ".$match['pred_away_goals']), $string);
            $string = str_replace('%group%', lang($match['match_group']), $string);
            
            $html .= $string;
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
        $now = now();
        $account_id = $CI->session->userdata('account_id');
        $sql_query = "SELECT *
                      FROM `prediction`
                      JOIN `match`
                      ON `prediction`.`pred_match_uid` = `match`.`match_uid`
                      AND `prediction`.`account_id` = '$account_id'
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
                $html .= str_replace('%matchlink%', get_match($value)." (".anchor('predictions/editgroup/'.$row['match_group'],lang($row['match_group'])).")", $listitem);
                
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
            if ($prediction['pred_home_team'] == NULL || $prediction['pred_home_team'] == "" || $prediction['pred_away_team'] == NULL || $prediction['pred_away_team'] == "")
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
                $html .= str_replace('%matchlink%', get_match($value)." (".anchor('predictions/editgroup/'.$row['match_group'],lang($row['match_group'])).")", $listitem);
                
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
        $sql_query = "SELECT 
                        (pred_points_home_goals
                         + pred_points_away_goals
                         + pred_points_result
                         + pred_points_bonus
                         + pred_points_home_team
                         + pred_points_away_team) AS `total_points`
                      FROM `prediction`
                      WHERE `account_id` = '$account_id'
                      AND `pred_calculated` = 1";
        $query = $CI->db->query($sql_query);
        $predictions = $query->result_array();
        $points = 0;
        foreach ($predictions as $prediction) {
            $points = $points + $prediction['total_points'];
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