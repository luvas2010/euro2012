<?php
// File /system/application/views/info.php
// Version 1.0
// Author: Schop
?>

<p class="info">
    <?php echo $message; ?>
    <?php if (isset($links)): ?>
    <ul>
    <?php foreach ($links as $link) {
        echo "<li>".$link."</li>";
        } ?>
    </ul>
    <?php endif; ?>
</p>
