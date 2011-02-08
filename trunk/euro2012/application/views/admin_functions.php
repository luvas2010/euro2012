<?php
// File /system/application/views/admin_functions.php
// Version 1.0
// Author: Schop
?>
<p class='buttons'>
    <?php echo anchor('admin_functions/calculate_new', 'Calculate new results'); ?>
    <?php echo anchor('admin_functions/recalculate_all','Recalculate all predictions'); ?>
    <?php echo anchor('user_info/list_all','View all users'); ?>
    <?php echo anchor('text/view', 'See standard texts'); ?>
    <?php echo anchor('admin_functions/backup', 'Backup all data'); ?>
</p>
<h2>Testing functions (not for use in functioning pools)</h2>
<p class='warning'>Functions come with no warranty</p> 
<p class='buttons'>
    <?php echo anchor('admin_functions/create_users','Create 100 users'); ?>
    <?php echo anchor('admin_functions/randomize_predictions','Fill all predictions with random values'); ?>
</p> 
<p class='buttons'>
    <?php echo anchor('admin_functions/clear_results','Clear all results an set predictions to NOT calculated'); ?>
    <?php echo anchor('admin_functions/clear_predictions','Clear all predictions for every user'); ?>
</p>
