<div class='container_12'>
    <div class='grid_12 alpha omega'>
        <h2><?php echo $title;?></h2>
        <div class='clear'></div>
        <div class='buttons'>
            <?php echo anchor('admin/check_settings/cat/0', lang('category_0'), 'class="button"');?>
            <?php echo anchor('admin/check_settings/cat/1', lang('category_1'), 'class="button"');?>
            <?php echo anchor('admin/check_settings/cat/2', lang('category_2'), 'class="button"');?>
            <?php echo anchor('admin/check_settings/cat/3', lang('category_3'), 'class="button"');?>
        </div>
        <div class='clear'></div>
        <div class='grid_4 alpha'><h3>Setting</h3></div>
        <div class='grid_4'><h3>Value</h3></div>
        <div class='grid_4 omega'><h3>Info</h3></div>
        <div class='clear'></div>
        <?php foreach ($settings as $setting) { ?>
        <div class='settingrow'>
            <div class='grid_4 alpha'><?php echo $setting['setting']; ?></div>
            <div class='grid_4'>
            <?php if(!$setting['is_writeable']) { ?>
                    <?php echo $setting['value']; ?>
                    <?php } else { ?>
                    <?php $data = array(
                      'name'        => 'setting['.$setting['setting'].']',
                      'value'       => $setting['value'],
                      'style'       => 'width:100%'
                    );
                    ?>
                    <?php echo form_input($data);?>
                    <?php } ?>
            </div>
            <div class="grid_4 omega"><?php echo lang($setting['setting']); ?></div>
            <div class='clear'></div>
        </div>
        
        <?php  } ?>
        <div class='clear'></div>
    </div>    
</div>
