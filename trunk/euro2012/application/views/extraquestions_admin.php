<?php
// File: /system/application/views/extraquestions.php
// Version: 1.0
// Author: Schop 
// fetch language file
$this->lang->load('set', language() );

?>
        <h3>Extra Vragen</h3>

        <?php if ($saved): ?>
            <p class="success">Opgeslagen!</p>
        <?php endif; ?>    
        <?php echo form_open('admin_functions/extra_questions/submit'); ?>
	    <table>
            <thead>
                <th>Aktief</th>
                <th class='th-left'>Type</th>
                <th class='th-left'>Vraag</th>
                <th class='th-left'>Antwoord</th>
                <th>Punten</th>
            </thead>
            <tbody>
                <?php foreach ($questions as $question): ?>
                <tr>
                    <td><?php echo form_checkbox('post_array['.$question['id'].'][active]',1,$question['active']);?></td>
                    <td><?php echo $question['QType']['description']; ?></td>
                    <td><?php echo form_input('post_array['.$question['id'].'][question]',$question['question'], 'size="50"' );?></td>
                    <?php if ($question['QType']['id'] != 4) : ?>
                    <td><?php echo form_input('post_array['.$question['id'].'][answer]',$question['answer'], 'size="50"' );?></td>
                    <?php else : ?>
                    <td><?php echo form_dropdown('post_array['.$question['id'].'][answer]', $teams, $question['answer'] );?></td>
                    <?php endif; ?>
                    <td><?php echo form_input('post_array['.$question['id'].'][points]',$question['points'], 'size="4"' );?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p class='buttons'>
            <?php echo form_submit('submit',lang('save')); ?>
            <?php echo anchor('/','<img src="'.base_url().'images/icons/cross.png" alt="" />'.lang('cancel'), 'class="negative"'); ?>
        </p>
        <?php echo form_close();?>
