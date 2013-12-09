<? echo form::open(); ?>

<div class="container_12">

	<h2 class="grid_12">Login</h2>

	<div class="clear"></div>

	<? if(isset($errors) AND (sizeof($errors) > 0)): ?>
		<div class="grid_7">
			<p class="announcebox error">
				All fields are required.
				<? // echo (isset($errors) AND (sizeof($errors) > 0))? '<br />There were errors with your entry.' : ''; ?>
			</p>
		</div>
		<div class="clear"></div>
	<? endif; ?>

	<? echo form::label('email','Email:', 'class="grid_2"'); ?>
	<? echo form::input('email', $data['email'], (isset($errors['email']))? 'class="grid_4 errorfield"':'class="grid_4"'); ?>

	<?
	if (isset($errors['email']))
		echo '<div class="error">'.$errors['email'].'</div>';
	?>

	<div class="clear"></div>

	<? echo form::label('password','Password:', 'class="grid_2"'); ?>
	<? echo form::password('password', null, (isset($errors['password']))? 'class="grid_4 errorfield"':'class="grid_4"'); ?>
	<? if (isset($errors['password']))
		echo '<div class="error">'.$errors['password'].'</div>'; ?>

	<div class="grid_4 prefix_2">
		<? echo form::submit('submit', 'Login', 'class="submit button right"'); ?>
	</div>

</div>
<? echo form::close(); ?>