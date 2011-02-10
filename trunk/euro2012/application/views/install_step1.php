<h2><?php echo $title; ?></h2>
<div id='install'>
<h3>Controleer de database gegevens voordat je verder gaat:</h3>
    <ul class="info">
        <li>Hostname: <span class="bold"><?php echo $db_set->hostname; ?></span></li>
        <li>Database Name: <span class="bold"><?php echo $db_set->database; ?></span></li>
        <li>Table prefix: <span class="bold"><?php echo $db_set->dbprefix; ?></span></li>
        <li>User Name: <span class="bold"><?php echo $db_set->username; ?></span></li>
        <li>Database Password: <span class="bold"><?php echo $db_set->password; ?></span></li>
    </ul>
    <?php if ($warning): ?>
        <div class='error'>
            <p class='bold'>De database bevat reeds de volgende tabellen:</p>
            <ul><?php foreach ($tables as $table) {echo "<li>".$table."</li>";} ?></ul>
            <p>Om overschrijven van data te voorkomen, zou je een andere 'table prefix' in moeten vullen in <tt>application/config/database.php</tt>, en dan de installatie opnieuw starten door deze pagina te verversen. Je oude data blijft dan bewaard.</p>
            <p>Als je de bestaande tabellen wilt overschrijven, ga dan door naar stap 2. Je kunt nog wel <?php echo anchor('admin_functions/backup', 'eerst een backup maken'); ?>.</p>
        </div>
    <?php endif; ?>

    <p>Als de informatie hierboven juist is, kun je door naar stap 2.</p>
    <p class='buttons'>
        <?php echo anchor('install/step2','<img src="'.base_url().'/images/icons/database_add.png" alt=""/ >Maak de tabellen aan, en ga naar Stap 2', 'class="positive"') ?>
    </p>
    <p>Is de informatie niet correct, verander dan de instellingen in: <tt><?php echo base_url();?>application/config/database.php</tt>, en ververs deze pagina nadat je wijzigingen hebt gemaakt.</p>
    <p class='buttons'>
        <?php echo anchor('install/','<img src="'.base_url().'/images/icons/arrow_refresh.png" alt=""/ >Verversen') ?>
    </p>
</div>
