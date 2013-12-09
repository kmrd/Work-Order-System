<? echo form::open(null, array('class' => 'form-horizontal')); ?>
<div class="container container_12">

	<h2>Edit Car</h2>
	<p><a href="/customer/view/<? echo $car->customer->id; ?>" class="btn btn-primary">Back to Customer</a></p>

	<div class="clear"></div>

	<? if(isset($errors) AND (sizeof($errors) > 0)): ?>
		<p class="alert alert-danger">
			All fields are required.
			<? // echo (isset($errors) AND (sizeof($errors) > 0))? '<br />There were errors with your entry.' : ''; ?>
		</p>
	<? endif; ?>

	<div class="form-group <? echo (isset($errors['year'])) ? 'has-error' : ''; ?>">
		<? echo form::label('year','Year:','class="col-sm-2 control-label"'); ?>
		<div class="col-sm-6">
			<? echo form::input('year', $data['year'], 'class="form-control"'); ?>
		</div>
		<? if(isset($errors['year'])) : ?>
			<p class="col-sm-4 help-block"><? echo $errors['year']; ?></p>
		<? endif; ?>
	</div>

	<div class="form-group <? echo (isset($errors['make'])) ? 'has-error' : ''; ?>">
		<? echo form::label('make','Make:','class="col-sm-2 control-label"'); ?>
		<div class="col-sm-6">
			<? echo form::input('make', $data['make'], 'class="form-control" placeholder="Hyundai / Honda / Toyota"'); ?>
		</div>
		<? if(isset($errors['make'])) : ?>
			<p class="col-sm-4 help-block"><? echo $errors['make']; ?></p>
		<? endif; ?>
	</div>

	<div class="form-group <? echo (isset($errors['model'])) ? 'has-error' : ''; ?>">
		<? echo form::label('model','Model:','class="col-sm-2 control-label"'); ?>
		<div class="col-sm-6">
			<? echo form::input('model', $data['model'], 'class="form-control" placeholder="Genesis / Civic / FRS"'); ?>
		</div>
		<? if(isset($errors['model'])) : ?>
			<p class="col-sm-4 help-block"><? echo $errors['model']; ?></p>
		<? endif; ?>
	</div>

	<div class="clearfix sep"></div>

	<div class="form-group <? echo (isset($errors['color'])) ? 'has-error' : ''; ?>">
		<? echo form::label('color','Color:','class="col-sm-2 control-label"'); ?>
		<div class="col-sm-6">
			<? echo form::input('color', $data['color'], 'class="form-control"'); ?>
		</div>
		<? if(isset($errors['color'])) : ?>
			<p class="col-sm-4 help-block"><? echo $errors['color']; ?></p>
		<? endif; ?>
	</div>

	<div class="form-group <? echo (isset($errors['trim'])) ? 'has-error' : ''; ?>">
		<? echo form::label('trim','Trim:','class="col-sm-2 control-label"'); ?>
		<div class="col-sm-6">
			<? echo form::input('trim', $data['trim'], 'class="form-control"'); ?>
		</div>
		<? if(isset($errors['trim'])) : ?>
			<p class="col-sm-4 help-block"><? echo $errors['trim']; ?></p>
		<? endif; ?>
	</div>

	<div class="form-group <? echo (isset($errors['vin'])) ? 'has-error' : ''; ?>">
		<? echo form::label('vin','VIN:','class="col-sm-2 control-label"'); ?>
		<div class="col-sm-6">
			<? echo form::input('vin', $data['vin'], 'class="form-control"'); ?>
		</div>
		<? if(isset($errors['vin'])) : ?>
			<p class="col-sm-4 help-block"><? echo $errors['vin']; ?></p>
		<? endif; ?>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-6">
			<? echo form::submit('save', 'Save', 'class="btn"'); ?>
			<? echo form::submit('savereturn', 'Save & Return', 'class="btn btn-primary"'); ?>
			<a href="/car/delete/<? echo $data['id']; ?>" class="pull-right">Delete Car</a>
		</div>
	</div>

	<div class="clear sep"></div>

</div>
<? echo form::close(); ?>