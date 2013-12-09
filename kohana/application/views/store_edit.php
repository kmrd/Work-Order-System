<? echo form::open(); ?>
<div class="container container_12">

	<h2 class="grid_10">Edit your store</h2>
	<div class="clear"></div>

	<? echo form::hidden('storeid', $store->id); ?>

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

	<? echo form::label('currency','Currency:','class="grid_2"'); ?>
	<? echo form::textarea('currency', $data['currency'], (isset($errors['currency']))? 'class="grid_4 errorfield"':'class="grid_4"'); ?>
	<?
		if (isset($errors['currency)']))
			echo '<div class="error">'.$errors['desc'].'</div>';
	?>
	<div class="clear"></div>

	<? echo form::label('country','Country Code:','class="grid_2"'); ?>
	<? echo form::textarea('country', $data['country'], (isset($errors['country']))? 'class="grid_4 errorfield"':'class="grid_4"'); ?>
	<?
		if (isset($errors['country']))
			echo '<div class="error">'.$errors['desc'].'</div>';
	?>

	<div class="clear sep"></div>

	<div class="prefix_2">
		<div id="uploadercontent" >
			<? if(sizeof($store->images) > 0 ): ?>
				<? foreach($store->images as $img) : ?>
					<img src="<? echo img::display_filename($img, 800, 2000); ?>" width="200" />
				<? endforeach; ?>
			<? else : ?>
				<img src="/assets/imgs/default-store.jpg" width="200">
			<? endif; ?>
		</div>

		<div id="uploader_btn">Upload new image</div>
		<div id="uploader" title="Upload Image">
			<p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
		</div>
	</div>

	<div class="clear sep"></div>

	<div class="grid_5 prefix_2">
		<? echo form::submit('submit', 'Save', 'class="submit button right"'); ?>
	</div>
	<div class="grid_5 prefix_2">
		<? echo form::submit('submitpost', 'Save & Post Item', 'class="submit button right"'); ?>
	</div>
</div>
<? echo form::close(); ?>