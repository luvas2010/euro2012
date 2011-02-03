<?php $this->lang->load('navigation', language()); ?> 
    <div id="match_navigation">
        <p class="buttons">
            <?php echo anchor('groupa',lang('group').' A'); ?>
            <?php echo anchor('groupb',lang('group').' B'); ?>
            <?php echo anchor('groupc',lang('group').' C'); ?>
            <?php echo anchor('groupd',lang('group').' D'); ?>
            <?php echo anchor('knockoutphase',lang('knockout_phase')); ?>
            <?php echo anchor('ranking', '<img src="'.base_url().'images/icons/rosette.png" alt="" />'.lang('ranking')); ?>
        </p>
    </div>
