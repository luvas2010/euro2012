
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <!-- Version <?php echo $this->config->item('pool_version'); ?> -->    
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $title; ?></title>
    
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Ubuntu:400,700" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resource/css/960gs/960gs.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" />
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/hoverIntent.js"></script> 
    <script type="text/javascript" src="<?php echo base_url(); ?>js/superfish.js"></script> 
    <script type="text/javascript" src="<?php echo base_url(); ?>js/supersubs.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/highcharts.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/pinfooter.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/pinheader.js"></script>
</head>
<body>
        <div id="navigation">
            <div class="nav_container">
                <?php $this->load->view('navigation'); ?> 
            </div>    
        </div>
    <div id="wrapper">
        <div id="header">
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
    </div>    
            <?php $this->load->view('footer'); ?>
