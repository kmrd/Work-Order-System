<? echo form::open(); ?>

<div class="container container_16">

	<h2 class="grid_16">Sign Up</h2>

	<div class="grid_8">
		<p>Sign up, browse and post for free!</p>
	</div>

	<div class="grid_8">
		<? if(isset($errors) AND (sizeof($errors) > 0)): ?>
			<div class="grid_8">
				<p class="announcebox error">
					All fields are required.
					<? // echo (isset($errors) AND (sizeof($errors) > 0))? '<br />There were errors with your entry.' : ''; ?>
				</p>
			</div>
			<div class="clear"></div>
		<? endif; ?>


		<? echo form::label('email','Email:', 'class="grid_2"'); ?>
		<? echo form::input('email', $data['email'], (isset($errors['email']))? 'class="grid_5 errorfield"':'class="grid_5"'); ?>
		<? 
			if (isset($errors['email']))
				echo '<div class="error grid_6 prefix_2">'.$errors['email'].'</div>';
		?>
		
		<div class="clear sep"></div>

		<? echo form::label('password','Password:', 'class="grid_2"'); ?>
		<? echo form::password('password', $data['password'], (isset($errors['password']))? 'class="grid_5 errorfield"':'class="grid_5"'); ?>
		<? if (isset($errors['password']))
			echo '<div class="error grid_6 prefix_2">'.$errors['password'].'</div>';
		?>

		<div class="clear sep"></div>

		<div class="grid_4 prefix_3">
			<? echo form::submit('submit', 'Register for Free', 'class="submit button"'); ?>
		</div>
	</div>
</div>

<? echo form::close(); ?>