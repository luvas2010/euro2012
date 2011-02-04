 <?php
// File: /system/application/views/matchedit.php
// Version: 1.0
// Author: Schop 
?>
<?php $this->lang->load('matchedit', language()); ?> 
       <h3><?php echo lang('edit_match_details'); ?></h3>
        
	    <?php echo form_open('match/match_submit'); ?>

	    <?php echo validation_errors('<p class="error">','</p>'); ?>
        
		    <?php echo form_hidden('id',$match[0]->id); ?>            
	    <div id='formtable'>
        <table>
            <thead>
                <tr>
                    <th colspan="4"><?php echo lang('edit_match_details'); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <label for="matchname"><?php echo lang('match_name');?>:</label>
                    </td>
                    <td colspan="3">
                        <?php echo form_input('matchname',$match[0]->match_name); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="teamhome"><?php echo lang('team_home');?>:</label>
                    </td>
                    <td>
                        <?php echo form_dropdown('teamhome',$teamshome,$match[0]['TeamHome']['team_id_home']); ?>
                    </td>
                    <td>
                        <label for="teamaway"><?php echo lang('team_away');?>:</label>
                    </td>
                    <td>
                        <?php echo form_dropdown('teamaway',$teamsaway,$match[0]['TeamAway']['team_id_away']); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="matchtime"><?php echo lang('match_time');?> (<?php echo lang('local');?>):</label>
                    </td>
                    <td colspan="3" >
                        <?php echo form_input('matchtime',$match[0]->match_time); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="matchtime"><?php echo lang('closing_time');?> (<?php echo lang('local');?>):</label>
                    </td>
                    <td colspan="3" >
                        <?php echo form_input('timeclose',$match[0]->time_close); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="venue"><?php echo lang('venue');?>:</label>
                    </td>
                    <td colspan="3">
                        <?php echo form_dropdown('venue',$venues,$match[0]['Venue']->venue_id); ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class='info'><?php echo lang('local_time_warning'); ?></p>
        
        <p class='buttons'>
	        <?php echo form_submit('submit','Save'); ?>
	        <?php echo anchor('/group'.strtolower($match[0]->match_group),'<img src="'.base_url().'images/icons/cross.png" alt="" />Cancel', 'class="negative"'); ?>
        </p>
        <?php echo form_close(); ?>
