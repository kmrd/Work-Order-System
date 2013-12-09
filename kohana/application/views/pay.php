<? echo form::open('/eat/pay/'); ?>
<div class="container container_12">

	<h2 class="grid_10"><? echo $eat->name; ?></h2>
	<div class="clear"></div>

	<div class="grid_16">
		<? echo form::label('cardnum', 'Credit Card Number'); ?>
		<? if(isset($errors['cardnum'])): ?>
			<div class="error"><? echo $errors['cardnum']; ?></div>
		<? endif; ?>

		<? echo form::input('cardnum'); ?>
		<? echo form::hidden('eatid', security::scrambleint($eat->id)); ?>
		<? echo form::hidden('qty', $qty); ?>
		<div class="clear"></div>
		<? echo form::submit('buy','Pay Now'); ?>
	</div>

	<div class="clear"></div>
</div>
<? echo form::close(); ?>