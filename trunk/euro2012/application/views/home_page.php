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
        </ul>
    </div>
    <div class="column_1">
     test
    </div>
    <div class="column_1">
     test
    </div>
    <div class="column_1">
     <?php if ($user['paid'] == 0): ?>
        <p class='error'>
            <strong>Je hebt nog niet betaald!</strong> Betaal zo snel mogelijk het inschrijfgeld van &euro;<?php echo $settings['payment_amount'];?>
        </p>
     <?php endif; ?>   
    </div>
</div>
<div class="home_row">
    <div class="column_1">
        <h3>Dummy tekst</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. At ille non pertimuit saneque fidenter: Istis quidem ipsis verbis, inquit; Si id dicis, vicimus. Sint modo partes vitae beatae. Iam id ipsum absurdum, maximum malum neglegi. Neminem videbis ita laudatum, ut artifex callidus comparandarum voluptatum diceretur. Quantum Aristoxeni ingenium consumptum videmus in musicis? Duo Reges: constructio interrete.
        </p>
    </div>
    <div class="column_2">
         <h3>Het laatste nieuws van <?php echo $settings['poolname'];?></h3>
         <p>
            Dit is een test. Hier zou je een soort nieuwsitem kunnen publiceren of zo. Ik noem maar iets. <a href="http"//www.windmillwebwork.com">Windmill Web Work </a>
         </p>   
    </div>
    <div class="column_1">
        <h3>Statistieken?</h3>
        <p>
            Dit is nog een test. Hier zou een stukje tekst kunnen komen, of de top tien, of een grafiekje. Uitslagen, wedstirjden, noem maar op.
        </p>
    </div>
</div>