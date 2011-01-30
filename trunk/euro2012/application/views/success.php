<?php
// File /system/application/views/success.php
// Version 1.0
// Author: Schop
?>

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
