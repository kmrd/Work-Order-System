<? echo form::open(); ?>
<div class="container container_12">

	<h2 class="grid_10">Create your store</h2>
	<div class="clear"></div>

	<? if(isset($errors) AND (sizeof($errors) > 0)): ?>
		<p class="announcebox error">
			All fields are required.
			<? // echo (isset($errors) AND (sizeof($errors) > 0))? '<br />There were errors with your entry.' : ''; ?>
		</p>
	<? endif; ?>

	<? echo form::label('name','Store Name:','class="grid_2"'); ?>
	<? echo form::input('name', $data['name'], (isset($errors['name']))? 'class="grid_4 errorfield"':'class="grid_4"'); ?>
	<?
		if (isset($errors['name']))
			echo '<div class="error">'.$errors['name'].'</div>';
	?>
	<p><em>You can change this later on if you like</em></p>

	<div class="clear"></div>

	<? echo form::label('desc','Description:','class="grid_2"'); ?>
	<? echo form::textarea('desc', $data['desc'], (isset($errors['desc']))? 'class="grid_4 errorfield"':'class="grid_4"'); ?>
	<?
		if (isset($errors['desc']))
			echo '<div class="error">'.$errors['desc'].'</div>';
	?>
	<div class="clear"></div>

	<div class="grid_5 prefix_2">
		<? echo form::submit('submit', 'Save', 'class="submit button right"'); ?>
	</div>
</div>
<? echo form::close(); ?>