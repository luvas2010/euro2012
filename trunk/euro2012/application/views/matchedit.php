 <?php
// File: /system/application/views/matchedit.php
// Version: 1.0
// Author: Schop 
?>
       <h3>Edit Match Details</h3>
        
	    <?php echo form_open('match/match_submit'); ?>

	    <?php echo validation_errors('<p class="error">','</p>'); ?>
        
		    <?php echo form_hidden('id',$match[0]->id); ?>            
	    <div id='formtable'>
        <table>
            <thead>
                <tr>
                    <th colspan="4">Edit Match Details</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <label for="matchname">Match Name:</label>
                    </td>
                    <td colspan="3">
                        <?php echo form_input('matchname',$match[0]->match_name); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="teamhome">Team Home:</label>
                    </td>
                    <td>
                        <?php echo form_dropdown('teamhome',$teamshome,$match[0]['TeamHome']['team_id_home']); ?>
                    </td>
                    <td>
                        <label for="teamaway">Team Away:</label>
                    </td>
                    <td>
                        <?php echo form_dropdown('teamaway',$teamsaway,$match[0]['TeamAway']['team_id_away']); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="matchtime">Match Time (local):</label>
                    </td>
                    <td colspan="3" >
                        <?php echo form_input('matchtime',$match[0]->match_time); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="matchtime">Closing Time (local):</label>
                    </td>
                    <td colspan="3" >
                        <?php echo form_input('timeclose',$match[0]->time_close); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="venue">Venue:</label>
                    </td>
                    <td colspan="3">
                        <?php echo form_dropdown('venue',$venues,$match[0]['Venue']->venue_id); ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class='info'>Make sure you use the local time at the venue! Venues have their own time zone, and the match time will automatically be calculated to your server's local time.</p>
        
        <p class='buttons'>
	        <?php echo form_submit('submit','Save'); ?>
	        <?php echo anchor('/group'.strtolower($match[0]->match_group),'<img src="'.base_url().'images/icons/cross.png" alt="" />Cancel', 'class="negative"'); ?>
        </p>
        <?php echo form_close(); ?>
