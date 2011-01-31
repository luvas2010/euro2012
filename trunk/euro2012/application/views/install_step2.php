<h2><?php echo $title; ?></h2>
<div id='install'>
    <div class='success'>
        <h3>Tables were created for data models:</h3>
            <ul>
            <?php $this->load->database(); foreach ($models as $k => $table): ?>
                <li><?php echo $table; ?></li>
            <?php endforeach; ?>
            </ul>
    </div>
    <h3>Create the first user (administrator)</h3>
    <?php form_open('install/create_user'); ?>
    
    
    
    <p class='buttons'><?php echo anchor('install/step3','<img src="'.base_url().'/images/icons/database_table.png" alt=""/ >Populate tables and go to Step 3', 'class="positive"')?></p>
    
</div>
