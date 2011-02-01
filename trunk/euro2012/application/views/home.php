<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $settings['pool_name']; ?></title>
	<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css"
		type="text/css" media="all"> -->
	</head>
<body>
<div>
	<?php if(Current_User::user()): ?>
		<h3>Hello <em><?php echo Current_User::user()->nickname; ?></em>, welcome to <?php echo $settings['pool_name']; ?></h3>
		<h3><?php echo anchor('logout','Logout'); ?></h3>
        <?php if(Current_User::user()->admin): ?>
            <h2>You are an admin!</h2>
        <?php  endif; ?>
	<?php else: ?>
		<h3>New Users: <?php echo anchor('signup','Create an Account'); ?>.</h3>
		<h3>Members: <?php echo anchor('login','Login'); ?>.</h3>
	<?php endif; ?>

</div>
<ul>
	<li><?php echo anchor('groupa','Group A','Group A Overview'); ?></li>
	<li><?php echo anchor('groupb','Group B','Group B Overview'); ?></li>
	<li><?php echo anchor('groupc','Group C','Group C Overview'); ?></li>
	<li><?php echo anchor('groupd','Group D','Group D Overview'); ?></li>
	<li><?php echo anchor('allmatches', 'All Matches', 'See all matches'); ?></li>
</ul>
<div>
	<h3>Matches</h3>
	<table>
        <tr>
            <th>Match</th>
            <th>Home</th>
            <th>Away</th>
            <th>Result</th>
            <th>Venue</th>
            <th>Time</th>
        </tr>
        <?php foreach($matches as $match): ?>
	    <tr>
            <td><?php echo $match->match_name; ?></td>
            <td><?php echo $match->TeamHome->name; ?></td>
            <td><?php echo $match->TeamAway->name; ?></td>
            <td><?php echo $match->home_goals." - ".$match->away_goals; ?></td>
            <td><?php echo $match->Venue->name; ?></td>
            <td><?php echo $match->match_time; ?></td>
        </tr>
        <?php endforeach; ?>
        </table>        
</div>

</body>
</html>

