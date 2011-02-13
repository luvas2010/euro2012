<?php
// File /system/application/views/success.php
// Version 1.0
// Author: Schop
?>
<?php if (isset($time_warning)) : //this is only set & true if somebody tries to predict a closed match ?>
    <?php if ($time_warning) : ?>
        <p class='error'>Van tenminste &eacute;&eacute;n van de ingevulde wedstrijden is de tijdslimiet inmiddels verstreken. Waarschijnlijk is de wedstrijd begonnen voordat je hebt opgeslagen. Je oude voorspelling voor die wedstrijd(en) is daarom geldig.</p>
    <?php endif; ?>    
<?php endif; ?>
<p class="success">
    <?php echo $message; ?>
    <?php if (isset($links)): ?>
    <ul>
    <?php foreach ($links as $link) {
        echo "<li>".$link."</li>";
        } ?>
    </ul>
    <?php endif; ?>
</p>
