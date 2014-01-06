<? echo form::open(null, array('class' => 'form-horizontal')); ?>
<div class="container">

	<h2>Add Work Order</h2>
	<p><a href="/customer/view/<? echo $car->customer->id; ?>" class="btn btn-primary btn-xs">Back to Customer</a></p>
	<dl>
		<dt class="col-xs-4 col-sm-2">Customer</dt><dd class="col-xs-8 col-sm-10"><? echo $car->customer->fname.' '.$car->customer->lname; ?></dd>
		<dt class="col-xs-4 col-sm-2">Car</dt><dd class="col-xs-8 col-sm-10"><? echo $car->year.' '.$car->make.' '.$car->model; ?></dd>
		<dt class="col-xs-4 col-sm-2">Color</dt><dd class="col-xs-8 col-sm-10"><? echo (strlen($car->color) > 0) ? $car->color : '---'; ?></dd>
		<dt class="col-xs-4 col-sm-2">Trim</dt><dd class="col-xs-8 col-sm-10"><? echo (strlen($car->trim) > 0) ? $car->trim : '---'; ?></dd>
		<dt class="col-xs-4 col-sm-2">VIN</dt><dd class="col-xs-8 col-sm-10"><? echo (strlen($car->trim) > 0) ? $car->vin : '---'; ?></dd>
	</dl>

	<div class="clearfix sep"></div>

	<hr class="col-xs-10 col-sm-8" />

	<div class="clearfix sep hidden-xs"></div>
	<div class="clearfix visible-xs"></div>



	<? if(isset($errors) AND (sizeof($errors) > 0)): ?>
		<p class="alert alert-danger">
			All fields are required.
		</p>
	<? endif; ?>



	<div class="form-group <? echo (isset($errors['servicedate'])) ? 'has-error' : ''; ?>">
		<? echo form::label('servicedate','Date:','class="col-xs-12 col-sm-2 control-label"'); ?>

		<div class="col-xs-12 col-sm-3 col-lg-2">
			<div class="input-group datepicker input-append date" id="datetimepicker1">
				<input data-format="MM/dd/yyyy" type="text" name='servicedate' class="form-control" placeholder='mm/dd/yyyy' data-default-start-date='<? echo date('m/d/Y', strtotime($order->servicedate)); ?>'>
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
		<? echo form::label('mileage','Mileage:','class="col-xs-12 col-sm-2 control-label"'); ?>
		<div class="col-xs-12 col-sm-3 col-lg-2 input-group">
			<? echo form::input('mileage', $data['mileage'], 'class="form-control" placeholder="200000"'); ?>
  			<span class="input-group-addon">km</span>
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




	<div class="form-group">

		<? echo form::label('parts','Parts Used:','class="col-xs-12 col-sm-2 control-label"'); ?>

		<div class="col-xs-6 col-sm-3 col-md-4">
			<? echo form::input('parts[]', null, 'class="form-control name" placeholder=""'); ?>
		</div>

		<div class="col-xs-6 col-sm-3 col-md-2">
			<div class="input-group">
				<span class="input-group-addon">$</span>
				<? echo form::input('partsprice[]', null, 'class="form-control price text-right" placeholder=""'); ?>
				<span class="input-group-btn">
					<button class="btn btn-primary addrow" type="button"><span class="glyphicon glyphicon-plus-sign"></span></button>
				</span>
			</div>
		</div>

		<? /* if(isset($errors['service'])) : ?>
			<p class="col-xs-4 help-block"><? echo $errors['service']; ?></p>
		<? endif; */ ?>
	</div>

	<? foreach($order->parts as $part): ?>
		<div class="form-group">
			<div class="col-xs-6 col-sm-3 col-md-4 col-sm-offset-2">
				<? echo form::input('parts[]', $part->name, 'class="form-control name" placeholder=""'); ?>
			</div>

			<div class="col-xs-6 col-sm-3 col-md-2">
				<div class="input-group">
					<span class="input-group-addon">$</span>
					<? echo form::input('partsprice[]', sprintf('%0.02f', $part->price / 100), 'class="form-control price text-right" placeholder=""'); ?>
					<span class="input-group-btn">
						<button class="btn btn-info removerow" type="button"><span class="glyphicon glyphicon-minus-sign"></span></button>
					</span>
				</div>
			</div>
		</div>
	<? endforeach; ?>



	<div class="clearfix sep"></div>



	<div class="form-group">
		<? echo form::label('service','Services:','class="col-xs-12 col-sm-2 control-label"'); ?>

		<div class="col-xs-6 col-sm-3 col-md-4">
			<? echo form::input('services[]', null, 'class="form-control name" placeholder=""'); ?>
		</div>

		<div class="col-xs-6 col-sm-3 col-md-2">
			<div class="input-group">
				<span class="input-group-addon">$</span>
				<? echo form::input('serviceprice[]', null, 'class="form-control price text-right" placeholder=""'); ?>
				<span class="input-group-btn">
					<button class="btn btn-primary addrow" type="button"><span class="glyphicon glyphicon-plus-sign"></span></button>
				</span>
			</div>
		</div>
	</div>

	<? foreach($order->services as $service): ?>
		<div class="form-group">
			<div class="col-xs-6 col-sm-3 col-md-4 col-sm-offset-2">
				<? echo form::input('services[]', $service->name, 'class="form-control name" placeholder=""'); ?>
			</div>

			<div class="col-xs-6 col-sm-3 col-md-2">
				<div class="input-group">
					<span class="input-group-addon">$</span>
					<? echo form::input('serviceprice[]', sprintf('%0.02f', $service->price / 100), 'class="form-control price text-right" placeholder=""'); ?>
					<span class="input-group-btn">
						<button class="btn btn-info removerow" type="button"><span class="glyphicon glyphicon-minus-sign"></span></button>
					</span>
				</div>
			</div>
		</div>
	<? endforeach; ?>




	<div class="clearfix sep"></div>

	<hr class="col-sm-7 col-sm-offset-1" />

	<div class="clearfix sep"></div>


	<div class="form-group">
		<? echo form::label('discount','Discount:','class="col-xs-6 col-sm-2 control-label"'); ?>
		
		<div class="col-xs-6 col-sm-3 col-md-2 col-sm-offset-3 col-md-offset-4">
			<div class="input-group">
				<span class="input-group-addon">$ -</span>
				<? echo form::input('discount', sprintf('%0.02f', $data['discount'] / 100), 'class="form-control price text-right" placeholder=""'); ?>
			</div>
		</div>
	</div>

	<div class="form-group">
		<? echo form::label('tax','Tax:','class="col-xs-6 col-sm-2 control-label"'); ?>
		
		<div class="col-xs-6 col-sm-3 col-md-2 col-sm-offset-3 col-md-offset-4">
			<div class="input-group">
				<? echo form::input('tax', $data['tax'], 'class="form-control price text-right" placeholder=""'); ?>
				<span class="input-group-addon">%</span>
			</div>
		</div>
	</div>

	<div class="form-group">
		<? echo form::label('total','Total:','class="col-xs-6 col-sm-2 control-label"'); ?>
		
		<div class="col-xs-6 col-sm-3 col-md-2 col-sm-offset-3 col-md-offset-4">
			<div class="input-group">
				<span class="input-group-addon">$</span>
				<? echo form::input('total', sprintf('%0.02f', $order->total / 100), 'class="form-control price text-right" placeholder="" readonly="readonly"'); ?>
			</div>
		</div>
	</div>




	<div class="clearfix sep"></div>

	<hr class="col-sm-7 col-sm-offset-1" />

	<div class="clearfix sep"></div>




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
		<div class="col-sm-offset-2 col-sm-4">
			<? echo form::submit('save', 'Save', 'class="btn"'); ?>
			<? echo form::submit('savegoback', 'Save & Go Back', 'class="btn btn-primary"'); ?>
		</div>
		<div class="col-sm-2 text-right">
			<a href="/order/delete/<? echo $order->id; ?>" class="btn btn-danger btn-xs confirm">Delete work order</a>
		</div>
	</div>

	<div class="clearfix sep"></div>
	<div class="clearfix sep"></div>
	<div class="clearfix sep"></div>
	<div class="clearfix sep"></div>

</div>
<? echo form::close(); ?>