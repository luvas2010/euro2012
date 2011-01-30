        <h3>Group <?php echo strtoupper($group); ?> Administration</h3>
        
	    <?php echo form_open('group'.$group.'_admin/submit'); ?>

	    <?php echo validation_errors('<p class="error">','</p>'); ?>
	    <table>
	        <thead>
	            <tr>
	                <th colspan=3>Home</th>
	                <th colspan=3>Away</th>
	            </tr>
	        </thead>
	        <tfoot>
                <tr>
                    <th colspan="6">Enter the final score after each match is played</th>                
                </tr>	        
	        </tfoot>
	        <tbody>
        <?php foreach ($matches as $match): ?>
		    <tr>
		    <?php echo form_hidden('match_number'.$match->match_number,$match->match_number); ?>
                <td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $match->TeamHome->flag;?>" alt="" /></td>	            
	            <td>
	                <label for="home_goals<?php echo $match->match_number; ?>"><?php echo $match->TeamHome->name; ?>:</label>
		        </td>
		        <td>
		            <?php echo form_input('home_goals'.$match->match_number,$match->home_goals,'size=1'); ?>
	            </td>
	            <td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $match->TeamAway->flag;?>" alt="" /></td>
	            <td>
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
	    <?php echo anchor('group'.$group,'<img src="'.base_url().'images/icons/cross.png" alt="" />Cancel', 'class="negative"'); ?>
    </p>
    <?php echo form_close(); ?>
