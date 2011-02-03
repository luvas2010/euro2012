<?php $this->lang->load('navigation', language()); ?> 
    <div id="match_navigation">
        <p class="buttons">
            <?php echo anchor('groupa',$this->lang->line('group').' A'); ?>
            <?php echo anchor('groupb',$this->lang->line('group').' B'); ?>
            <?php echo anchor('groupc',$this->lang->line('group').' C'); ?>
            <?php echo anchor('groupd',$this->lang->line('group').' D'); ?>
            <?php echo anchor('knockoutphase',$this->lang->line('knockout_phase')); ?>
            <?php echo anchor('ranking', '<img src="'.base_url().'images/icons/rosette.png" alt="" />'.$this->lang->line('ranking')); ?>
        </p>
    </div>
