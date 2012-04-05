
<div class="container_12">
    <div class="grid_12 alpha omega">
        <h2><?php echo $title; ?></h2>
        <?php
        $attributes = array('id' => 'validateMe');
        echo form_open("admin/users/edit/".$user['id']."/save", $attributes); ?>
                <div class="grid_6 alpha omega">
                <?php echo form_button(array(
                        'type' => 'submit',
                        'class' => 'button save',
                        'content' => "Save"
                    )); ?>
            </div>
            <div class="clear"></div>
        <table id="userdata" class="stripeMe">
            <tr>
                <th>Key</th>
                <th>Value</th>
            </tr>
        <?php
        foreach($user as $key => $value)
        {
            ?>
            
            <?php if ($key != 'id')
            {
            ?>
            <tr>
                <td>
                    <?php
                    $data = array (
                                'name' => "account[".$key."]",
                                'id' => $key,
                                'size' => 64,
                                'value' => $value
                                );
                    
                    echo form_label($key,$key);
                    ?>
                </td>    
                <td>
                    <?php echo form_input($data); ?>
                </td>
            </tr>
            <?php
            }
            else
            {
            ?>
            <tr>
                <td>
                    <?php echo $key;?>
                </td>    
                <td>
                    <?php echo $value; ?>
                </td>
            </tr>
            <?php
            }
            
        }
        ?>
        <tr><td class="centertext boldtext mediumtext" colspan="2">Details</td></tr>
        <?php
        foreach($user_details as $key => $value)
        {
            ?>
            <tr>
                <td>
                    <?php
                    $data = array (
                                'name' => "details[".$key."]",
                                'id' => $key,
                                'size' => 64,
                                'value' => $value
                                );
                    
                    echo form_label($key,$key);
                    ?>
                </td>    
                <td>
                    <?php echo form_input($data); ?>
                </td>
            </tr>    
            <?php
        }
        if(is_array($user_facebook))
        {
        ?>
        <tr><td class="centertext boldtext mediumtext" colspan="2">Facebook</td></tr>
        <?php

            foreach($user_facebook as $key => $value)
            {
                ?>
                <tr>
                    <td>
                        <?php
                        echo $key;
                        ?>
                    </td>    
                    <td>
                        <?php echo $value; ?>
                    </td>
                </tr>    
                <?php
            }
        }
        if (is_array($user_twitter))
        {
        ?>
            <tr><td class="centertext boldtext mediumtext" colspan="2">Twitter</td></tr>
            <?php        
            foreach($user_twitter as $key => $value)
            {
                ?>
                <tr>
                    <td>
                        <?php
                        echo $key;
                        ?>
                    </td>    
                    <td>
                        <?php echo $value; ?>
                    </td>
                </tr>    
                <?php
            }
        }        
        ?>
        </table>
        <div class="grid_6 alpha omega">
                <?php echo form_button(array(
                        'type' => 'submit',
                        'class' => 'button save',
                        'content' => "Save"
                    )); ?>
            </div>
            <div class="clear"></div>
            
            <?php echo form_close(); ?>
    </div>    
</div>
