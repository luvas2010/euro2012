<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/help_style.css" type="text/css" media="all" />
</head>
<body>
<!-- <?php echo $file; ?> -->
    <div id='container'>
        <?php $this->load->view($content_view); ?> 
        <a href="javascript:window.close()">Sluiten</a>
    </div> <!-- end container -->
</body>
</html>