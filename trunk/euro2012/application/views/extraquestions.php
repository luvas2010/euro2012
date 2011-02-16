<?php
// File: /system/application/views/extraquestions.php
// Version: 1.0
// Author: Schop 
?>
<?php echo form_open('user_predictions/extra_questions/submit'); ?>
<p class='info'>De extra vragen moeten worden beantwoord voordat het toernooi begint. Eventuele punten voor deze vragen worden toegekend zodra de uitslag van de finale bekend is.</p>
<table width="100%">
    <thead>
        <tr>
            <th class='th-left'>Vraag</th>
            <th class='th-left'>Jouw antwoord</th>
            <th>Waardering</th>
            <th class='th-left'>Info</th>
        </tr>    
    </thead>  
    <tbody>
        <?php foreach ($answers as $answer) : ?>
        <?php $id = $answer['id']; echo form_hidden('post['.$id.'][id]', $id);?>
        <tr>
            <td><?php echo $answer['Question']['question'] ;?></td>
            <?php if (!started()) : ?>
                <?php if ($answer['Question']['QType']['id'] < 3) : ?>
                <td><?php echo form_input('post['.$id.'][answer]', $answer['answer']);?></td>
                <?php else: ?>
                <?php
                    $answerstring = str_replace("+", "",$answer['Question']['answer']); //get possible answers, and remove the '+' that indicates the right one
                    $arrAnswers = explode(",", $answerstring); // make an array out of the comma delimited string
                    $dropdown[$id]['-'] = "-";
                    foreach ($arrAnswers as $key => $value){
                        $dropdown[$id][$value] = $value;
                        }
                    ?>
                <td><?php echo form_dropdown('post['.$id.'][answer]', $dropdown[$id], $answer['answer']); ?></td>
                <?php endif; ?>
            <?php else: ?>
                <td><?php echo $answer['answer']; ?>
            <?php endif; ?>    
            <td class='td-center'><?php echo $answer['Question']['points']; ?> punten</td>
            <td>
            <?php switch($answer['Question']['QType']['id']) { 
                    case 1:
                        echo "Geef een exact antwoord";
                        break;
                    case 2:
                        echo "Probeer zo nauwkeurig mogelijk te antwoorden.<br />Hoe dichter je bij het juiste antwoord zit, hoe meer punten je krijgt.";
                        break;
                    case 3:
                        echo "Kies het juiste antwoord";
                        break; } ?>
            </td>    
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<p class='buttons'><?php echo form_submit('submit','Opslaan'); ?></p>
<?php echo form_close(); ?>
