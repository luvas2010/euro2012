        <h3>Group <?php echo strtoupper($group); ?> Administration</h3>
       
        <?php echo form_open('group/result_submit'); ?>
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
                <td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $match['TeamHome']['flag'];?>" alt="" /></td>	            
	            <td>
	                <label for="post_array[<?php echo $match['id']; ?>][home_goals]"><?php echo $match['TeamHome']['name']; ?>:</label>
		        </td>
		        <td>
		            <?php echo form_input('post_array['.$match['id'].'][home_goals]',$match['home_goals'],'size=1'); ?>
	            </td>
	            <td><img src="<?php echo base_url(); ?>images/flags/24/<?php echo $match['TeamAway']['flag'];?>" alt="" /></td>
	            <td>
		            <label for="post_array[<?php echo $match['id']; ?>][away_goals]"><?php echo $match['TeamAway']['name']; ?>:</label>
		        </td>
		        <td>
		            <?php echo form_input('post_array['.$match['id'].'][away_goals]',$match['away_goals'], 'size=1'); ?>
	            </td>
	        </tr>
	<?php endforeach; ?>
	    </tbody>
    </table>
    <p class='buttons'>
	    <?php echo form_submit('submit','Save'); ?>
	    <?php echo anchor('group/overview/'.$group,'<img src="'.base_url().'images/icons/cross.png" alt="" />Cancel', 'class="negative"'); ?>
    </p>
    <?php echo form_close(); ?>
