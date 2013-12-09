<? echo form::open(null, array('class' => 'form-horizontal')); ?>
<div class="container">

	<h2>Add Work Order <small><a href="/customer/view/<? echo $car->customer->id; ?>" class="btn btn-primary btn-xs">Back to Customer</a></small></h2>
	<dl>
		<dt class="col-xs-1">Customer</dt><dd><? echo $car->customer->fname.' '.$car->customer->lname; ?></dd>
		<dt class="col-xs-1">Car</dt><dd><? echo $car->year.' '.$car->make.' '.$car->model; ?></dd>
		<dt class="col-xs-1">Color</dt><dd><? echo (strlen($car->color) > 0) ? $car->color : '---'; ?></dd>
		<dt class="col-xs-1">Trim</dt><dd><? echo (strlen($car->trim) > 0) ? $car->trim : '---'; ?></dd>
		<dt class="col-xs-1">VIN</dt><dd><? echo (strlen($car->trim) > 0) ? $car->vin : '---'; ?></dd>
	</dl>

	<div class="clear"></div>

	<? if(isset($errors) AND (sizeof($errors) > 0)): ?>
		<p class="alert alert-danger">
			All fields are required.
		</p>
	<? endif; ?>

	<div class="form-group <? echo (isset($errors['servicedate'])) ? 'has-error' : ''; ?>">
		<? echo form::label('servicedate','Date:','class="col-sm-2 control-label"'); ?>

		<div class="col-sm-6">
			<div class="input-group datepicker input-append date" id="datetimepicker1">
				<input data-format="MM/dd/yyyy" type="text" name='servicedate' class="form-control" placeholder='mm/dd/yyyy'>
				<span class="input-group-addon add-on">
					<span class="glyphicon glyphicon-calendar" data-time-icon="icon-time" data-date-icon="icon-calendar"></span>
				</span>
			</div>
		</div>
		<? if(isset($errors['servicedate'])) : ?>
			<p class="col-sm-4 help-block"><? echo $errors['servicedate']; ?></p>
		<? endif; ?>
	</div>

	<div class="form-group <? echo (isset($errors['mileage'])) ? 'has-error' : ''; ?>">
		<? echo form::label('mileage','Mileage:','class="col-sm-2 control-label"'); ?>
		<div class="col-sm-6">
			<? echo form::input('mileage', $data['mileage'], 'class="form-control"'); ?>
		</div>
		<? if(isset($errors['mileage'])) : ?>
			<p class="col-sm-4 help-block"><? echo $errors['mileage']; ?></p>
		<? endif; ?>
	</div>

	<div class="form-group <? echo (isset($errors['worktype'])) ? 'has-error' : ''; ?>">
		<? echo form::label('worktype','Worktype:','class="col-sm-2 control-label"'); ?>
		<div class="col-sm-6">
			<? echo form::input('worktype', $data['worktype'], 'class="form-control" placeholder="Oil Change / FMIC / Exhaust"'); ?>
		</div>
		<? if(isset($errors['worktype'])) : ?>
			<p class="col-sm-4 help-block"><? echo $errors['worktype']; ?></p>
		<? endif; ?>
	</div>

	<div class="clearfix sep"></div>

	<div class="form-group <? echo (isset($errors['service'])) ? 'has-error' : ''; ?>">
		<? echo form::label('service','Service Performed:','class="col-sm-2 control-label"'); ?>
		<div class="col-sm-6">
			<? echo form::textarea('service', $data['service'], 'class="form-control" rows="5"'); ?>
		</div>
		<? if(isset($errors['service'])) : ?>
			<p class="col-sm-4 help-block"><? echo $errors['service']; ?></p>
		<? endif; ?>
	</div>

	<div class="form-group <? echo (isset($errors['parts'])) ? 'has-error' : ''; ?>">
		<? echo form::label('parts','Parts Used:','class="col-sm-2 control-label"'); ?>
		<div class="col-sm-6">
			<? echo form::textarea('parts', $data['parts'], 'class="form-control" rows="5"'); ?>
		</div>
		<? if(isset($errors['parts'])) : ?>
			<p class="col-sm-4 help-block"><? echo $errors['parts']; ?></p>
		<? endif; ?>
	</div>

	<div class="form-group <? echo (isset($errors['notes'])) ? 'has-error' : ''; ?>">
		<? echo form::label('notes','Notes:','class="col-sm-2 control-label"'); ?>
		<div class="col-sm-6">
			<? echo form::textarea('notes', $data['notes'], 'class="form-control" rows="5"'); ?>
		</div>
		<? if(isset($errors['notes'])) : ?>
			<p class="col-sm-4 help-block"><? echo $errors['notes']; ?></p>
		<? endif; ?>
	</div>

	
	<div class="clearfix sep"></div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<? echo form::submit('save', 'Save', 'class="btn"'); ?>
			<? echo form::submit('savegoback', 'Save & Go Back', 'class="btn btn-primary"'); ?>
		</div>
	</div>
</div>
<? echo form::close(); ?>