 <?php
// File: /system/application/views/matchresultedit.php
// Version: 1.0
// Author: Schop 
?>
<?php $this->lang->load('matchedit', language()); ?> 
       <h3><?php echo lang('edit_match_result'); ?></h3>
        
	    <?php echo form_open('match/match_result_submit'); ?>

	    <?php echo validation_errors('<p class="error">','</p>'); ?>
        
		    <?php echo form_hidden('id',$match[0]['id']); ?>            
	    <div id='formtable'>
        <table>
            <thead>
                <tr>
                    <th colspan="6"><?php echo $match[0]['match_name']; ?></th>
                </tr>
                <tr>
                    <th colspan="2"><?php echo lang('team_home'); ?></th>
                    <th>Goals</th>
                    <th colspan="2"><?php echo lang('team_away'); ?></th>
                    <th>Goals</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th class="info" colspan="6"><?php echo lang('dont_forget_to_calc'); ?></th>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <td>
                        <?php echo '<img src="'.base_url().'images/flags/24/'.$match[0]['TeamHome']['flag'].'" alt="" />'; ?>    
                    </td>
                    <td>
                        <?php echo $match[0]['TeamHome']['name']; ?>
                    </td>
                    <td>
                        <?php echo form_input('homegoals',$match[0]['home_goals'], 'size="2"'); ?>
                    </td>
                    <td>
                        <?php echo '<img src="'.base_url().'images/flags/24/'.$match[0]['TeamAway']['flag'].'" alt="" />'; ?>
                    </td>
                    <td>
                        <?php echo $match[0]['TeamAway']['name']; ?>
                    </td>
                    <td>
                        <?php echo form_input('awaygoals',$match[0]['away_goals'], 'size="2"'); ?>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <p class='buttons'>
	        <?php echo form_submit('submit','Save'); ?>
	        <?php echo anchor('/group'.strtolower($match[0]['match_group']),'<img src="'.base_url().'images/icons/cross.png" alt="" />Cancel', 'class="negative"'); ?>
        </p>
        <?php echo form_close(); ?>
