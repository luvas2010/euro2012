<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" type="text/css" media="all" />
    <link href='http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold' rel='stylesheet' type='text/css' />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.tablesorter.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jExpand.js"></script>
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/tablestyle.css" type="text/css" media="all" />
    <script type="text/javascript">
        $(document).ready(function() {
            $("table:not(#home_table) tr:odd").addClass("odd");
            $("table:not(#home_table) tr:even").addClass("even");
            $("#match-stats-table").tablesorter(
                {sortList: [[2,1]]});
            $("#ranking").tablesorter(
                {sortList: [[2,1]]});
            $("#home_table").jExpand(); 
        });
    </script>
    
</head>
<body>
<div id='container'>
	<div id='user-controls'>
		<?php $this->load->view('user_controls'); ?>
	</div> <!-- end user-controls -->
	<div id='navigation'>
		<?php $this->load->view('navigation'); ?>
	</div> <!-- end navigation -->
	<div id="content">
		<?php $this->load->view($content_view); ?>    
	</div> <!-- end content -->
	<div id="footer">
	    <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&amp;hosted_button_id=BTH8AYCVJLDD4">Doneren via PayPal</a>&nbsp;|&nbsp;<?php echo $settings['poolname'];?>&nbsp;|&nbsp;Version <?php echo $settings['version'];?>
        <p>
            <a href="http://validator.w3.org/check?uri=referer"><img
                src="http://www.w3.org/Icons/valid-xhtml10-blue"
                alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a>
          </p>	
	</div>
</div> <!-- end container -->
</body>
</html>

