    
	    <?php echo form_open('groupd_admin/submit'); ?>

	    <?php echo validation_errors('<p class="error">','</p>'); ?>
	    <table>
	        <thead>
	            <tr>
	                <th colspan='2'>Home</th>
	                <th colspan='2'>Away</th>
	            </tr>
	        </thead>
	        <tbody>
        <?php foreach ($matches as $match): ?>
		    <tr>
		    <?php echo form_hidden('match_number'.$match->match_number,$match->match_number); ?>
	            <td class='td-right'>
	                <label for="home_goals<?php echo $match->match_number; ?>"><?php echo $match->TeamHome->name; ?>:</label>
		        </td>
		        <td>
		            <?php echo form_input('home_goals'.$match->match_number,$match->home_goals,'size=1'); ?>
	            </td>
	            <td class='td-right'>
		            <label for="away_goals<?php echo $match->match_number; ?>>"><?php echo $match->TeamAway->name; ?>:</label>
		        </td>
		        <td>
		            <?php echo form_input('away_goals'.$match->match_number,$match->away_goals, 'size=1'); ?>
	            </td>
	        </tr>
	<?php endforeach; ?>
	    </tbody>
    </table>
    <p class='buttons'>
	    <?php echo form_submit('submit','Save'); ?>
	    <?php echo anchor('groupd','<img src="images/icons/cross.png" alt="" />Cancel', 'class="negative"'); ?>
    </p>
    <?php echo form_close(); ?>
