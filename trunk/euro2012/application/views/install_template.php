<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" type="text/css" media="all" />
    <link href='http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold' rel='stylesheet' type='text/css' />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>

    
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/tablestyle.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/installstyle.css" type="text/css" media="all" />

    
</head>
<body>
<div id='container'>
	<div id="content">
		<?php $this->load->view($content_view); ?>    
	</div> <!-- end content -->
	<div id="footer">
	    <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&amp;hosted_button_id=BTH8AYCVJLDD4">Doneren via PayPal</a>&nbsp;|&nbsp;<a href="http://voetbalpool2012.nl">Voetbalpool2012.nl</a>
	</div>
</div> <!-- end container -->
</body>
</html>
