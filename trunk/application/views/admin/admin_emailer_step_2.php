	<script language="JavaScript" type="text/javascript" src="<?php echo base_url(); ?>resource/cbrte/html2xhtml.min.js"></script>
	<script language="JavaScript" type="text/javascript" src="<?php echo base_url(); ?>resource/cbrte/richtext_compressed.js"></script>
<div class="container_12">
    <div class="grid_12 alpha omega">
        <h2><?php echo $title; ?></h2>
        <!-- START Demo Code -->
        <?php
            $attributes = array('id' => 'validateMe', 'name' => "RTE", 'onsubmit' => "return submitForm();");
            echo form_open('admin/emailer/send_step2', $attributes);
        ?>
        <div class="grid_2 alpha">
            Subject:
        </div>    
        <div class="grid_10 omega">
        <?php
        $data = array(
              'name'        => 'subject',
              'id'          => 'subject',
              'value'       => '',
              'style'       => 'width:100%'
            );

        echo form_input($data);
        ?>
        </div>
        <div class="grid_2 alpha">
            To:
        </div>    
        <div class="grid_10 omega">
        <?php
        $data = array(
              'name'        => 'to',
              'id'          => 'to',
              'value'       => $emails_to,
              'style'       => 'width:100%'
            );

        echo form_input($data);
        ?>
        </div>        
        <div class="grid_2 alpha">
            CC:
        </div>    
        <div class="grid_10 omega">
        <?php
        $data = array(
              'name'        => 'cc',
              'id'          => 'cc',
              'value'       => $emails_cc,
              'style'       => 'width:100%'
            );

        echo form_input($data);
        ?>
        </div>   

        <div class="grid_2 alpha">
            BCC:
        </div>
        <div class="grid_10 omega">
        <?php
        $data = array(
              'name'        => 'bcc',
              'id'          => 'bcc',
              'value'       => $emails_bcc,
              'style'       => 'width:100%'
            );

        echo form_input($data);
        ?>
        </div>
        <div class='clear'></div>
        <script language="JavaScript" type="text/javascript">
<!--
function submitForm() {
	//make sure hidden and iframe values are in sync for all rtes before submitting form
	updateRTEs();
	
	return true;
}

//Usage: initRTE(imagesPath, includesPath, cssFile, genXHTML, encHTML)
initRTE("<?php echo base_url(); ?>resource/cbrte/images/", "<?php echo base_url(); ?>resource/cbrte/", "", true);
//-->
</script>
<noscript><p><b>Javascript must be enabled to use this form.</b></p></noscript>

<script language="JavaScript" type="text/javascript">
<!--
//build new richTextEditor
var rte1 = new richTextEditor('rte1');
<?php
//format content for preloading
if (!(isset($_POST["rte1"]))) {
	$content = "";
	$content = rteSafe($content);
} else {
	//retrieve posted value
	$content = rteSafe($_POST["rte1"]);
}
?>
rte1.html = '<?=$content;?>';
rte1.width = '100%';
//rte1.toggleSrc = false;
rte1.build();
//-->
</script>
<p><input type="submit" name="submit" value="Submit" /></p>
</form>
<?php
function rteSafe($strText) {
	//returns safe code for preloading in the RTE
	$tmpString = $strText;
	
	//convert all types of single quotes
	$tmpString = str_replace(chr(145), chr(39), $tmpString);
	$tmpString = str_replace(chr(146), chr(39), $tmpString);
	$tmpString = str_replace("'", "&#39;", $tmpString);
	
	//convert all types of double quotes
	$tmpString = str_replace(chr(147), chr(34), $tmpString);
	$tmpString = str_replace(chr(148), chr(34), $tmpString);
//	$tmpString = str_replace("\"", "\"", $tmpString);
	
	//replace carriage returns & line feeds
	$tmpString = str_replace(chr(10), " ", $tmpString);
	$tmpString = str_replace(chr(13), " ", $tmpString);
	
	return $tmpString;
}
?>
<!-- END Demo Code -->
    </div>    
</div>
    