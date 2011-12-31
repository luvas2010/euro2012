
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <!-- Version <?php echo $this->config->item('version'); ?> -->    
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $title; ?></title>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:400,700&subset=latin' rel='stylesheet' type='text/css'>
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Ubuntu:400,700" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resource/css/960gs/960gs.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" />
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>

</head>
<body>
    
    <div id="wrapper">
        <div id="installheader">
            <h1><?php echo sprintf(lang('installation_script_running'), $this->config->item('pool_name')); ?></h1>
        </div>
        <div class='clear'></div>
        <div id="main">
            <?php
                if (isset($error))
                {
                    echo "<div class='error'><p>".$error."</p><span class='smalltext'>".lang('click_to_hide')."</span></div>";
                }    
                if (isset($info))
                {
                    echo "<div class='info'><p>".$info."</p><span class='smalltext'>".lang('click_to_hide')."</span></div>";
                }
                $flashinfo = $this->session->flashdata('info'); 
                if ($flashinfo != '')
                {
                    echo "<div class='flashinfo'><p>".$flashinfo."</p><span class='smalltext'>".lang('click_to_hide')."</span></div>";
                }                
                      
            ?>                 
            <?php $this->load->view($content_main); ?> 
        </div>
        <div class='clear'></div>
        
        <div class='clear'></div>
        <div id="footer">
            <?php
                $this->load->helper('date');
                echo "<p>CET: ";
                $time_offset = $this->config->item('time_offset');
                $local_time = mdate("%l %d %F %Y %H:%i",now() - $time_offset);
                //$local_time = unix_to_human(now() - $time_offset, FALSE, 'eu');
                $unix_time =  now() - $time_offset;
                echo $local_time."</p>";
            ?>
        </div>
    </div> <!-- end wrapper -->


<script src="<?php echo base_url(); ?>js/install_functions.js"></script>

</body>
</html>

