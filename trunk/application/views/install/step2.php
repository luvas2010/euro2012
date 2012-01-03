<div class='container_12'>
    <div class='grid_12 alpha omega'>
        <h2><?php echo $title;?></h2>
        <div class='grid_12 alpha omega'><?php echo anchor('/', lang('done_take_me_home'), "class='button save'"); ?></div>
        <div class='clear'></div>
        <div class='info'><?php echo lang('config_change');?></div>
        <div class='grid_6 alpha'>
            <p>
                <span class='code'>$config['time_offset']  = '<?php echo $this->config->item('time_offset');?>';</span><br />
            </p>
        </div>
        <div class='grid_6 omega'>
            <p>
            <?php echo sprintf(lang('time_offset_check'), $this->config->item('time_offset')); ?>
            <br/>
            <?php echo sprintf(lang('timezone_check'), date_default_timezone_get())." "; ?>
            
            <?php $Date = new DateTime(); echo sprintf(lang('try_this_offset'), timezone_offset_get(timezone_open(date_default_timezone_get()), $Date) - 3600);?>
            </p>
        </div>
        <div class='clear'></div>
        <div class='grid_6 alpha'>
            <p>
                <span class='code'>$config['predictions_open']  = '<?php echo $this->config->item('predictions_open');?>';</span><br />
            </p>
        </div>
        <div class='grid_6 omega'>
            <p>
            <?php echo lang('predictions_open'); ?>
            </p>
        </div>
        <div class='clear'></div>
        <div class='grid_6 alpha'>
            <p>
                <span class='code'>$config['sign_up_email_admin']  = '<?php echo $this->config->item('sign_up_email_admin');?>';</span><br />
            </p>
        </div>
        <div class='grid_6 omega'>
            <p>
            <?php echo lang('sign_up_email_admin'); ?>
            </p>
        </div>
        <div class='clear'></div>
        <div class='grid_6 alpha'>
            <p>
                <span class='code'>$config['verify_users']  = '<?php echo $this->config->item('verify_users');?>';</span><br />
            </p>
        </div>
        <div class='grid_6 omega'>
            <p>
            <?php echo lang('verify_users'); ?>
            </p>
        </div>
        <div class='clear'></div>
        <div class='grid_6 alpha'>
            <p>
                <span class='code'>$config['email_from_address']  = '<?php echo $this->config->item('email_from_address');?>';</span><br />
            </p>
        </div>
        <div class='grid_6 omega'>
            <p>
            <?php echo lang('email_from_address'); ?>
            </p>
        </div>
        <div class='clear'></div>       <div class='grid_6 alpha'>
            <p>
                <span class='code'>$config['pred_points_goals']  = '<?php echo $this->config->item('pred_points_goals');?>';</span><br />
            </p>
        </div>
        <div class='grid_6 omega'>
            <p>
            <?php echo lang('pred_points_goals'); ?>
            </p>
        </div>
        <div class='clear'></div>
        <div class='grid_6 alpha'>
            <p>
                <span class='code'>$config['pred_points_result']  = '<?php echo $this->config->item('pred_points_result');?>';</span><br />
            </p>
        </div>
        <div class='grid_6 omega'>
            <p>
            <?php echo lang('pred_points_result'); ?>
            </p>
        </div>
        <div class='clear'></div>
        <div class='grid_6 alpha'>
            <p>
                <span class='code'>$config['pred_points_qf_team']  = '<?php echo $this->config->item('pred_points_qf_team');?>';</span><br />
            </p>
        </div>
        <div class='grid_6 omega'>
            <p>
            <?php echo lang('pred_points_qf_team'); ?>
            </p>
        </div>
        <div class='clear'></div> 
        <div class='grid_6 alpha'>
            <p>
                <span class='code'>$config['pred_points_sf_team']  = '<?php echo $this->config->item('pred_points_sf_team');?>';</span><br />
            </p>
        </div>
        <div class='grid_6 omega'>
            <p>
            <?php echo lang('pred_points_sf_team'); ?>
            </p>
        </div>
        <div class='clear'></div> 
        <div class='grid_6 alpha'>
            <p>
                <span class='code'>$config['pred_points_f_team']  = '<?php echo $this->config->item('pred_points_f_team');?>';</span><br />
            </p>
        </div>
        <div class='grid_6 omega'>
            <p>
            <?php echo lang('pred_points_f_team'); ?>
            </p>
        </div>
        <div class='clear'></div> 
        <div class='grid_6 alpha'>
            <p>
                <span class='code'>$config['pred_points_bonus']  = '<?php echo $this->config->item('pred_points_bonus');?>';</span><br />
            </p>
        </div>
        <div class='grid_6 omega'>
            <p>
            <?php echo lang('pred_points_bonus'); ?>
            </p>
        </div>
        <div class='clear'></div> 
        <div class='grid_6 alpha'>
            <p>
                <span class='code'>$config['pred_points_champion']  = '<?php echo $this->config->item('pred_points_champion');?>';</span><br />
            </p>
        </div>
        <div class='grid_6 omega'>
            <p>
            <?php echo lang('pred_points_champion'); ?>
            </p>
        </div>
        <div class='clear'></div>
    </div>
    <div class='grid_12 alpha omega'>
        <?php echo lang('account_settings');?>
    </div>
    <div class='grid_12 alpha omega'><?php echo anchor('/', lang('done_take_me_home'), "class='button save'"); ?></div>
    
</div>
