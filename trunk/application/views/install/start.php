<div class='container_12'>
    <div class='container_10 alpha'>
        <p><?php echo $title;?></p>
        
        <?php
        $ok = 1;
        if (version_compare(PHP_VERSION, '5.1.6') >= 0)
        {
            echo "<div class='success'>PHP ".lang('version')." : ".PHP_VERSION." OK</div>";
        }
        else
        {
            echo "<div class='error'>PHP ".lang('version')." : ".PHP_VERSION." NOT OK.</div>";
            $ok = 0;
        }
        
        
        
        if ($dbid = @$this->load->database('',TRUE))
        {
            echo "<div class='success'>Database Connection to `".$dbid->database."` OK</div>";
        }
        else
        {
            echo "<div class='error'>Database Connection NOT OK.</div>";
            $ok = 0;
        }            
        
        ?>
        <?php if($ok == 1)
        {
        ?>
        <div class='buttons'>
            <?php echo anchor('install/install/step1', lang('start_installation'), "class='button save'"); ?>
        </div>
        <?php
         }
         else
         { ?>
         <div class='error'><?php echo lang('installation_not_possible');?></div>
         <?php } ?>
    </div>
    

</div>
