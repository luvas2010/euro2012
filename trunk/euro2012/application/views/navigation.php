<?php $this->lang->load('navigation', language()); ?>
<?php $this->lang->load('match', language()); ?>  
        <ul class="sf-menu">
            <li><?php echo anchor('group/overview/a',lang('group').' A'); ?>
                <ul>
                    <li><?php echo anchor('group/overview/a',lang('overview').' '.lang('group').' A'); ?></li>
                    <li><?php echo anchor('group/predictions/a',lang('check').' '.lang('my_predictions').lang('for').lang('group').' A');?></li>
                </ul>
            </li>
            <li><?php echo anchor('group/overview/b',lang('group').' B'); ?>
                <ul>
                    <li><?php echo anchor('group/overview/b',lang('overview').' '.lang('group').' B'); ?></li>
                    <li><?php echo anchor('group/predictions/b',lang('check').' '.lang('my_predictions').lang('for').lang('group').' B');?></li>
                </ul>
            </li>
            <li><?php echo anchor('group/overview/c',lang('group').' C'); ?>
                <ul>
                    <li><?php echo anchor('group/overview/c',lang('overview').' '.lang('group').' C'); ?></li>
                    <li><?php echo anchor('group/predictions/c',lang('check').' '.lang('my_predictions').lang('for').lang('group').' C');?></li>
                </ul>
            </li>
            <li><?php echo anchor('group/overview/d',lang('group').' D'); ?>
                <ul>
                    <li><?php echo anchor('group/overview/d',lang('overview').' '.lang('group').' D'); ?></li>
                    <li><?php echo anchor('group/predictions/d',lang('check').' '.lang('my_predictions').lang('for').lang('group').' D');?></li>
                </ul>
            </li>
            <li><?php echo anchor('knockoutphase',lang('knockout_phase')); ?></li>
            <li><?php echo anchor('ranking', lang('ranking')); ?></li>
        </ul>