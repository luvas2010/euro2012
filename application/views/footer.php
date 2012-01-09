        <div class='clear'></div>
        <div id="footer">
            <?php
                $this->load->helper('date');
                $sql_query = "SELECT `timestamp` FROM `match` WHERE `match_uid` = 1";
                $query = $this->db->query($sql_query);
                $match = $query->row_array();
                $first_match = $match['timestamp'];
                echo "<p>CET: ";
                $time_offset = $this->config->item('time_offset');
                $local_time = mdate("%l %d %F %Y %H:%i",now() - $time_offset);
                //$local_time = unix_to_human(now() - $time_offset, FALSE, 'eu');
                $unix_time =  now() - $time_offset;
                if ($unix_time < $first_match)
                {
                    echo $local_time." (".timespan($unix_time, $first_match).")</p>";
                }
                else
                {
                    echo $local_time."</p>";
                }
            ?>
			<?php echo "<p>".lang('number_of_users').": ".$this->db->count_all('account')."</p>"; ?>
        </div>
    </div> <!-- end wrapper -->


<script type="text/javascript" src="<?php echo base_url(); ?>js/functions.js"></script>

</body>
</html>
