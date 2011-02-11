<?php
// fetch language file
$this->lang->load('welcome', language() );
?>
<div class="home_row">
    <div class="column_1">
        <h3><?php echo $user['nickname']; ?></h3>
        <ul>
            <li>Positie: <?php echo $user['position']; ?></li>
            <li>Punten: <?php echo $user['points']; ?></li>
            <li>Vorige positie: <?php echo $user['lastposition']; ?></li>
        </ul>
        <?php if ($user['paid'] == 0): ?>
        <p class='error'>
            <strong>Je hebt nog niet betaald!</strong> Betaal zo snel mogelijk het inschrijfgeld van &euro;<?php echo $settings['payment_amount'];?>. Heb je w&eacute;l betaald, maar zie je nog steeds deze melding, neem dan contact op met <?php echo safe_mailto($settings['admin_email'], 'de beheerder'); ?>.
        </p>
     <?php endif; ?>  
    </div>
    <div class="column_1">
        <h3>Top Tien</h3>
        <ul>
            <?php foreach ($topten as $topuser) { ?>
                <li><?php echo $topuser['User']['position'].". ".$topuser['User']['nickname']." (".$topuser['User']['points']." pnt)";?></li>
            <?php } ?>    
        </ul>    
    </div>
    <div class="column_1">
     test
    </div>
    <div class="column_1">
        <p class='info'>Hier komen wat waarschuwingen, bijvoorbeeld als iemand nog geen landen voorspellingen heeft ingevuld, of nog geen uitslag heeft voorspeld en het is bijna sluitingstijd.</p> 
    </div>
</div>
<div class="home_row">
    <div class="column_2">
         <?php echo content('text_news'); ?>
         <?php if (admin()) : ?>
            <?php echo anchor('text/edit/3','Tekst veranderen'); ?>
         <?php endif; ?>
    </div>
    <div class="column_1">
        <h3>Dummy tekst</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. At ille non pertimuit saneque fidenter: Istis quidem ipsis verbis, inquit; Si id dicis, vicimus. Sint modo partes vitae beatae. Iam id ipsum absurdum, maximum malum neglegi. Neminem videbis ita laudatum, ut artifex callidus comparandarum voluptatum diceretur. Quantum Aristoxeni ingenium consumptum videmus in musicis? Duo Reges: constructio interrete.
        </p>
    </div>
    <div class="column_1">
        <h3>Statistieken?</h3>
        <p>
            Dit is nog een test. Hier zou een stukje tekst kunnen komen, of de top tien, of een grafiekje. Uitslagen, wedstirjden, noem maar op.
        </p>
    </div>
</div>
