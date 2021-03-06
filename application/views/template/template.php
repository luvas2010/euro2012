<?php
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <!-- Version <?php echo $this->poolconfig_model->item('version'); ?> -->    
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $title; ?></title>
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Ubuntu:400,700" />
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resource/css/960gs/960gs.css" />
    
    <!--NIEUW CSS switch gebruiker-beheerder START-->
    <?php if ($this->authentication->is_signed_in())
          {
    if($account_details->pool_style==null) { ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" /> 
    <?php } else { ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/<?php echo($account_details->pool_style)?>style.css" />
    <?php } ?>
    <?php } else { ?>
    <?php if (($this->poolconfig_model->item('pool_style')==null) or
              ($this->poolconfig_model->item('pool_style')!='orange') and
              ($this->poolconfig_model->item('pool_style')!='green') and
              ($this->poolconfig_model->item('pool_style')!='blue') and
              ($this->poolconfig_model->item('pool_style')!='purple') and
              ($this->poolconfig_model->item('pool_style')!='grey'))
         { ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" /> 
    <?php } else { ?>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/<?php echo($this->poolconfig_model->item('pool_style'))?>style.css" />
    <?php } ?>
    <?php } ?>
    <!--NIEUW CSS switch gebruiker-beheerder END-->
     
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/hoverIntent.js"></script> 
    <script type="text/javascript" src="<?php echo base_url(); ?>js/superfish.js"></script> 
    <script type="text/javascript" src="<?php echo base_url(); ?>js/supersubs.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/highcharts.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.uniform.min.js"></script>
    
    <!--NIEUW JS switch gebruiker-beheerder START-->
    <?php if ($this->authentication->is_signed_in())
          {
    if($account_details->pool_style!=null)  { ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/relativepinfooter.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/relativepinheader.js"></script> 
    <?php } else { ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/pinfooter.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/pinheader.js"></script> 
    <?php } ?>
    <?php } else { ?>
    <?php if (($this->poolconfig_model->item('pool_style')!=null) or
              ($this->poolconfig_model->item('pool_style')=='orange') and
              ($this->poolconfig_model->item('pool_style')=='green') and
              ($this->poolconfig_model->item('pool_style')=='blue') and
              ($this->poolconfig_model->item('pool_style')=='purple') and
              ($this->poolconfig_model->item('pool_style')=='grey'))
          { ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/relativepinfooter.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/relativepinheader.js"></script> 
    <?php } else { ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/pinfooter.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/pinheader.js"></script>
    <?php } ?>    
    <?php } ?>
    <!--NIEUW JS switch gebruiker-beheerder END-->
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/uniform.default.css" type="text/css" media="screen" charset="utf-8" />
    <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-1632660-5']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
   </script>
</head>
<body>

<!--NIEUW header-navigation inrichting switch gebruiker-beheerder START-->
<?php if ($this->authentication->is_signed_in())
          {
    if($account_details->pool_style!=null) { ?>
    <!--NIEUW  header aanroepen gebruiker START-->
    <div id='header' class='grid_12 alpha omega'>
    <?php $this->load->view('header'); ?>
    </div>
    <div class='clear'></div>
    <!--NIEUW  header aanroepen gebruiker END-->
    <!--NIEUW  navigation in grid plaatsen zodat flashwarning ook werkt gebruiker START-->
    <div id="navigation" class='grid_12 alpha omega'>
    <?php $this->load->view('navigation'); ?> 
    <div class='clear'></div>
    <!--NIEUW  navigation in grid plaatsen zodat flashwarning ook werkt gebruiker END-->
    <?php } else { ?>
    <div id="navigation">
    <div class="nav_container">
    <?php $this->load->view('navigation'); ?> 
    </div>
    <div class='clear'></div>
    <?php } ?>
    <?php } else { ?>
    <?php if (($this->poolconfig_model->item('pool_style')!=null) and
              ($this->poolconfig_model->item('pool_style')=='orange') or
              ($this->poolconfig_model->item('pool_style')=='green') or
              ($this->poolconfig_model->item('pool_style')=='blue') or
              ($this->poolconfig_model->item('pool_style')=='purple') or
              ($this->poolconfig_model->item('pool_style')=='grey'))
          { ?>
    <!--NIEUW  header aanroepen beheerder START-->
    <div id='header' class='grid_12 alpha omega'>
    <?php $this->load->view('header'); ?>
    </div>
    <div class='clear'></div>
    <!--NIEUW  header aanroepen beheerder END-->
    <!--NIEUW  navigation in grid plaatsen zodat flashwarning ook werkt beheerder START-->
    <div id="navigation" class='grid_12 alpha omega'>
    <?php $this->load->view('navigation'); ?> 
    <div class='clear'></div>
    <!--NIEUW  navigation in grid plaatsen zodat flashwarning ook werkt beheerder END-->
    <?php } else { ?>
    <div id="navigation">
    <div class="nav_container">
    <?php $this->load->view('navigation'); ?> 
    </div>
    <div class='clear'></div>
    <?php } ?>
    <?php } ?>
<!--NIEUW header-navigation inrichting switch gebruiker-beheerder END-->

      <?php 
        if ($this->authentication->is_signed_in())
        {
			$num_unverified = 0;
			$num_unpayed = 0;
            $admin_warning = 0;
			if (is_admin())
			{
				if ($this->poolconfig_model->item('verify_users'))
				{
					$sql_query = "SELECT * FROM `account` WHERE `verifiedon` IS NULL";
					$query = $this->db->query($sql_query);
					$num_unverified = $query->num_rows();
					if($num_unverified > 0)
					{
						$admin_warning = 1;
					}
				}
				if ($this->poolconfig_model->item('play_for_money'))
				{
					$sql_query = "SELECT * FROM `account` WHERE `payed` = 0";
					$query = $this->db->query($sql_query);
					$num_unpayed = $query->num_rows();
					if ($num_unpayed > 0)
					{
						$admin_warning = 1;
					}
				}	
				
			}	
				
			if (
                    ($not_payed = $account->payed == 0 && $this->poolconfig_model->item('play_for_money')) ||
                    (!get_total_goals($account->id)) ||
                    ($missing_teams =  get_missing_teams_list(array(
                            'heading'   => "<div class='error warning'><p>%heading%</p>",
                            'pre'       => "<ul class='matchlist'>",
                            'post'      => "</ul></div>",
                            'listitem'  => "<li>%matchlink%</li>")
                            )) ||
                    ($missing_results = get_missing_result_list(array(
                                'heading'   => "<div class='error warning'><p>%heading%</p>",
                                'pre'       => "<ul class='matchlist'>",
                                'post'      => "</ul></div>",
                                'listitem'  => "<li>%matchlink%</li>")
                                ))
					||
					$admin_warning == 1
					 
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
                <div class='error warning'><?php echo lang('not_payed_yet');?></div>
				<?php } ?>
            <?php
			if ($admin_warning == 1)
			{
				if ($num_unverified > 0)
				{ ?>
					<div class='error warning'><?php echo sprintf(lang('unverified_users_link'), $num_unverified, anchor('admin/users/unverified', lang('show_unverified_users')));?></div>
				<?php
				}	
				if ($num_unpayed > 0)
				{ ?>
					<div class='error warning'><?php echo sprintf(lang('unpayed_users_link'), $num_unpayed, anchor('admin/users/unpayed', lang('show_unpayed_users')));?></div>
				<?php 
				}
			} ?>	
            <?php
            if (!get_total_goals($account->id)) {
            ?>
                
                <div class='error warning'><?php echo lang('total_goals_missing'); ?><br/>
                <?php echo anchor('predictions/extra',lang('nav_extra')); ?> 
                </div>
            <?php } ?>
            <?php echo get_missing_teams_list(array(
                                'heading'   => "<div class='error warning'><p>%heading%</p>",
                                'pre'       => "<ul class='matchlist'>",
                                'post'      => "</ul></div>",
                                'listitem'  => "<li>%matchlink%</li>")
                                );
                  echo get_missing_result_list(array(
                                'heading'   => "<div class='error warning'><p>%heading%</p>",
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
