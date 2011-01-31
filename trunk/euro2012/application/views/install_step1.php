<h2><?php echo $title; ?></h2>
<div id='install'>
<h3>Please check your database configuration before proceeding:</h3>
    <ul class="info">
        <li>Hostname: <span class="bold"><?php echo $db_set->hostname; ?></span></li>
        <li>Database Name: <span class="bold"><?php echo $db_set->database; ?></span></li>
        <li>Table prefix: <span class="bold"><?php echo $db_set->dbprefix; ?></span></li>
        <li>User Name: <span class="bold"><?php echo $db_set->username; ?></span></li>
        <li>Database Password: <span class="bold"><?php echo $db_set->password; ?></span></li>
    </ul>
    <p>If this is correct, you can create the tables and proceed to the next step.</p>
    <p class='buttons'>
        <?php echo anchor('install/step2','<img src="'.base_url().'/images/icons/database_add.png" alt=""/ >Create tables and go to Step 2', 'class="positive"') ?>
    </p>
    <p>Otherwise, please check the settings in the database configuration file: <tt><?php echo base_url();?>application/config/database.php</tt>, and reload this page after making changes.</p>
    <p class='buttons'>
        <?php echo anchor('install/','<img src="'.base_url().'/images/icons/arrow_refresh.png" alt=""/ >Reload') ?>
    </p>
</div>
