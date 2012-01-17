
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
        
        <?php 
        if ($this->authentication->is_signed_in())
        {
            if (
                    ($not_payed = $account->payed == 0 && $this->config->item('play_for_money')) ||
                    (!get_total_goals($account->id)) ||
                    ($missing_teams =  get_missing_teams_list(array(
                            'heading'   => "<div class='errorstay warning'><p>%heading%</p>",
                            'pre'       => "<ul class='matchlist'>",
                            'post'      => "</ul></div>",
                            'listitem'  => "<li>%matchlink%</li>")
                            )) ||
                    ($missing_results = get_missing_result_list(array(
                                'heading'   => "<div class='errorstay warning'><p>%heading%</p>",
                                'pre'       => "<ul class='matchlist'>",
                                'post'      => "</ul></div>",
                                'listitem'  => "<li>%matchlink%</li>")
                                ))
                 )
            { ?>
            <div class='warnings'>
                <h5><?php echo lang('warnings');?></h5>

            </div><?php }
        }
        ?>
            <div class='clear'></div>
        </div>
    <div id="wrapper">
        <div id="header">

        </div>

        <div class='clear'></div>
        <?php if ($this->authentication->is_signed_in())
        {
            if ($not_payed)
                {?>
                <div class='errorstay warning'><?php echo lang('not_payed_yet');?></div>
				<?php } ?>
                
            <?php
            if (!get_total_goals($account->id)) {
            ?>
                
                <div class='errorstay warning'><?php echo lang('total_goals_missing'); ?><br/>
                <?php echo anchor('predictions/extra',lang('nav_extra')); ?> 
                </div>
            <?php } ?>
            <?php echo get_missing_teams_list(array(
                                'heading'   => "<div class='errorstay warning'><p>%heading%</p>",
                                'pre'       => "<ul class='matchlist'>",
                                'post'      => "</ul></div>",
                                'listitem'  => "<li>%matchlink%</li>")
                                );
                  echo get_missing_result_list(array(
                                'heading'   => "<div class='errorstay warning'><p>%heading%</p>",
                                'pre'       => "<ul class='matchlist'>",
                                'post'      => "</ul></div>",
                                'listitem'  => "<li>%matchlink%</li>")
                                );
        } ?>
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
                $flasherror = $this->session->flashdata('error'); 
                if ($flasherror != '')
                {
                    echo "<div class='error'><p>".$flasherror."</p><span class='smalltext'>".lang('click_to_hide')."</span></div>";
                }
                      
            ?>                 
            <?php $this->load->view($content_main); ?> 
        </div>
        <div class='clear'></div>
    </div>    
            <?php $this->load->view('footer'); ?>
