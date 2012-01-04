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


<script src="<?php echo base_url(); ?>js/functions.js"></script>

</body>
</html>
