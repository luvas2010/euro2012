
<div class="container_12">
    <div class="grid_12 alpha omega">
    <script language="javascript">

        function set_unpayed() {
         
            $('input#bcc.checkbox.unpayed').attr('checked', 'checked');
        }

        function set_incomplete() {
         
            $('input#bcc.checkbox.incomplete').attr('checked', 'checked');
        }
        
        function set_all() {
         
            $('input#bcc.checkbox').attr('checked', 'checked');
        }
        
        function unset_all() {
         
            $('input#bcc.checkbox').removeAttr('checked');
        }
    </script>
    

        <h2><?php echo $title; ?></h2>
                <?php
            $attributes = array('id' => 'validateMe');
            echo form_open('admin/emailer/send', $attributes);
        ?>
                    <?php
            
            echo form_submit('send',lang('create_email'), 'class="button email_go"');
            ?>
        <hr/>
        <div class='clear'></div>
<input type="button" onclick="set_all()" value = "<?php echo lang('select_all'); ?>" class="button email_add" />
        <?php if($this->poolconfig_model->item('play_for_money'))
              { ?>
        <input type="button" onclick="set_unpayed()" value = "<?php echo lang('select_unpayed'); ?>" class="button money_add"/>
        <?php } ?>
        <input type="button" onclick="set_incomplete()" value = "<?php echo lang('select_incomplete'); ?>" class="button exclamation"/>
        
        <input type="button" onclick="unset_all()" value = "<?php echo lang('deselect_all'); ?>" class="button email_delete"/>
        

        <table class="stripeMe">
        <tr>
            <th><?php echo lang('user_name'); ?></th>
            <th>Email</th>
            <th>To</th>
            <th>CC</th>
            <th>BCC</th>
        </tr>
        
        <?php
        foreach ($users as $user)
        { 
            $class= "checkbox";
        ?>
        
        <tr>
            <td><?php echo $user['username'];?></td>
            <td><?php echo $user['email'];?></td>
            <td>
            <?php
            $data = array(
                'name'        => 'to['.$user['id'].']',
                'id'          => 'to',
                'value'       => $user['id'],
                'checked'     => FALSE
                );

            echo form_checkbox($data);
            ?>
            </td>
            <td>
            <?php
            $data = array(
                'name'        => 'cc['.$user['id'].']',
                'id'          => 'cc',
                'value'       => $user['id'],
                'checked'     => FALSE
                );

            echo form_checkbox($data);
            ?>
            </td>
            <td>
            <?php

            if ($user['payed']  == 0)
            {
                $class .= ' unpayed';
            }
            
            if (check_user($user['id']) == 0)
            {
                $class .= ' incomplete';
            }    
            
            $data = array(
                'name'        => 'bcc['.$user['id'].']',
                'id'          => 'bcc',
                'value'       => $user['id'],
                'checked'     => FALSE,
                'class'       => $class
                );

            echo form_checkbox($data);
            ?>
            </td>            
            </tr>    
        <?php
        }
        ?>
        </table>

            <div class='clear'></div>
            <?php
            
            echo form_submit('send',lang('create_email'), 'class="button email_go"');
            ?>
    </div>    
</div>
    