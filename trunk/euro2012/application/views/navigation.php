<?php $this->lang->load('navigation', language()); ?>
<?php $this->lang->load('match', language()); ?>  
        <ul class="sf-menu">
            <li><?php echo anchor('group/overview/a',lang('group').' A'); ?>
                <ul>
                    <li><?php echo anchor('group/overview/a',lang('overview').' '.lang('group').' A'); ?></li>
                    <li><?php echo anchor('group/predictions/a',lang('check').' '.lang('my_predictions').lang('for').lang('group').' A');?></li>
                </ul>
            </li>
            <li><?php echo anchor('groupb',lang('group').' B'); ?></li>
            <li><?php echo anchor('groupc',lang('group').' C'); ?></li>
            <li><?php echo anchor('groupd',lang('group').' D'); ?></li>
            <li><?php echo anchor('knockoutphase',lang('knockout_phase')); ?></li>
            <li><?php echo anchor('ranking', lang('ranking')); ?></li>
        </ul>