<?php
// fetch language file
$this->lang->load('welcome', language() );
?>
<?php foreach ($texts as $text): ?>
    <p>
        Text name: <strong><?php echo $text['text_name']; ?></strong>
    </p>
    <p>Text English:</p>
    <div class="textview">
        <?php echo $text['text_en']; ?>
    </div>
    <p>Tekst Nederlands:</p>
    <div class="textview">
        <?php echo $text['text_nl']; ?>
    </div>
    <p class="buttons"><?php echo anchor('text/edit/'.$text['id'], 'Edit Text'); ?></p>
    <hr />
<?php endforeach; ?>    