
<div id="content">
    <div class="container_12">
        <div class="grid_8 alpha">
            <?php echo sprintf(lang('intro_text'), anchor('account/sign_up', lang('website_sign_up')));?>
            <?php
            if ($this->poolconfig_model->item('play_for_money'))
			{
            $payout_schedule = explode(",",$this->poolconfig_model->item('payout_schedule'));
            $payout = "<ul>";
            $i = 1;
            foreach($payout_schedule as $pay)
            {
                $payout .= "<li>".$i."e ".lang('ranking').": ".$pay."%</li>";
                $i++;
            }    
            
            $payout .= "</ul>";
			echo sprintf(lang('intro_payed'), $this->poolconfig_model->item('currency')." ".$this->poolconfig_model->item('payment_per_user'), $payout);
			} ?>
        </div>
        <div class="grid_4 omega">
         <script type="text/javascript"><!--
google_ad_client = "ca-pub-2098404720901613";
/* pool */
google_ad_slot = "7735837555";
google_ad_width = 336;
google_ad_height = 280;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
        </div>
        <div class="clear"></div>
        <div class="grid_8">
        <?php $attributes = array('id' => 'validateMe'); ?>
            <?php echo form_open(uri_string().($this->input->get('continue')?'/?continue='.urlencode($this->input->get('continue')):''), $attributes); ?>
            <?php echo form_fieldset(); ?>
            <h3><?php echo lang('sign_in_heading'); ?></h3>
            <?php if (isset($sign_in_error)) : ?>
            <div class="grid_8 alpha omega">
                <div class="form_error"><?php echo $sign_in_error; ?></div>
            </div>
            <div class="clear"></div>
            <?php endif; ?>
            <?php if (isset($sign_in_verify_error)) : ?>
            <div class="grid_8 alpha omega">
                <div class="form_error"><?php echo $sign_in_verify_error; ?></div>
            </div>
            <div class="clear"></div>
            <?php endif; ?>
            
            <div class="grid_3 alpha align_right">
                <?php echo form_label(lang('sign_in_username_email'), 'sign_in_username_email'); ?>
            </div>
            <div class="grid_5 omega">
                <?php echo form_input(array(
                        'name' => 'sign_in_username_email',
                        'id' => 'sign_in_username_email',
                        'value' => set_value('sign_in_username_email'),
                        'maxlength' => '24',
                        'class' => 'text required'
                    )); ?>
                <?php echo form_error('sign_in_username_email'); ?>
                <?php if (isset($sign_in_username_email_error)) : ?>
                <span class="field_error"><?php echo $sign_in_username_email_error; ?></span>
                <?php endif; ?>
            </div>
            <div class="clear"></div>
            <div class="grid_3 alpha align_right">
                <?php echo form_label(lang('sign_in_password'), 'sign_in_password'); ?>
            </div>
            <div class="grid_5 omega">
                <?php echo form_password(array(
                        'name' => 'sign_in_password',
                        'id' => 'sign_in_password',
                        'value' => set_value('sign_in_password'),
                        'class' => 'text'
                    )); ?>
                <?php echo form_error('sign_in_password'); ?>
            </div>
            <div class="clear"></div>
            <?php if (isset($recaptcha)) : ?>
            <div class="prefix_3 grid_5 alpha omega">
                <?php echo $recaptcha; ?>
            </div>
            <?php if (isset($sign_in_recaptcha_error)) : ?>
            <div class="prefix_3 grid_5 alpha omega">
                <span class="field_error"><?php echo $sign_in_recaptcha_error; ?></span>
            </div>
            <?php endif; ?>
            <div class="clear"></div>
            <?php endif; ?>
            <div class="prefix_3 grid_5 alpha omega">
                <span>
                    <?php echo form_button(array(
                            'type' => 'submit',
                            'class' => 'button save',
                            'content' => lang('sign_in_sign_in')
                        )); ?>
                </span>
                <span>
                    <?php echo form_checkbox(array(
                            'name' => 'sign_in_remember',
                            'id' => 'sign_in_remember',
                            'value' => 'checked',
                            'checked' => $this->input->post('sign_in_remember'),
                            'class' => 'checkbox'
                        )); ?>
                    <?php echo form_label(lang('sign_in_remember_me'), 'sign_in_remember'); ?>
                </span>
            </div>
            <div class="clear"></div>
            <div class="prefix_3 grid_5 alpha omega">
                <p><?php echo anchor('account/forgot_password', lang('sign_in_forgot_your_password')); ?><br />
                <?php echo sprintf(lang('sign_in_dont_have_account'), anchor('account/sign_up', lang('sign_in_sign_up_now'))); ?></p>
            </div>
            <div class="clear"></div>
            <?php echo form_fieldset_close(); ?>
            <?php echo form_close(); ?>
        </div>
        <?php if ($this->poolconfig_model->item('third_party_auth_providers') != "")
		{ ?>
		<div class="grid_4">
		    <h3><?php echo sprintf(lang('sign_in_third_party_heading')); ?></h3>
            <ul>
                <?php $providers = explode(',',$this->poolconfig_model->item('third_party_auth_providers')); ?>
                <?php foreach($providers as $provider) : ?>
                <li class="third_party <?php echo $provider; ?>"><?php echo anchor('account/connect_'.$provider, lang('connect_'.$provider), 
                    array('title'=>sprintf(lang('sign_in_with'), lang('connect_'.$provider)))); ?></li>
                <?php endforeach; ?>
            </ul>
            <div class="clear"></div>
        </div>
		<?php } ?>
        <div class="clear"></div>
    </div>
</div>
