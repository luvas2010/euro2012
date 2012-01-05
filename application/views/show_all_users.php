    <h2><?php echo $title; ?></h2>

    <table class='stripeMe'>
        <tr>
            <th><?php echo lang('username'); ?></th>
        </tr>
        <?php foreach($users as $user) { ?>
        <tr>
            <td><?php echo $user['username']; ?></td>
        </tr>
        <?php } ?>  
    </table>
