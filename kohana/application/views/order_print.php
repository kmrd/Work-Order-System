<? echo form::open(null, array('class' => 'form-horizontal')); ?>
<div class="container">

	<p class="hidden-print col-xs-10 col-sm-8">
		<a href="/customer/view/<? echo $car->customer->id; ?>" class="btn btn-primary btn-sm">Go to Customer</a>
		<a href="/order/printly/<? echo $order->id; ?>" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span> Edit</a>
		<a href="/order/printly/<? echo $order->id; ?>" class="btn btn-primary btn-sm pull-right" id="print"><span class="glyphicon glyphicon-print"></span> Print</a>
	</p>
	<div class="clearfix hidden-print"></div>

	<h2 class="col-xs-12">10fintec Work Order</h2>
	<h4 class="col-xs-12">Date: <? echo date('m/d/Y', strtotime($order->servicedate)); ?></h4>
	
	<hr class="col-xs-10 col-sm-8" />
	<div class="clearfix"></div>

	<dl>
		<dt class="col-xs-4 col-sm-2">Customer</dt><dd class="col-xs-8 col-sm-10"><? echo $car->customer->fname.' '.$car->customer->lname; ?></dd>
		<dt class="col-xs-4 col-sm-2">Car</dt><dd class="col-xs-8 col-sm-10"><? echo $car->year.' '.$car->make.' '.$car->model; ?></dd>
		<dt class="col-xs-4 col-sm-2">Color</dt><dd class="col-xs-8 col-sm-10"><? echo (strlen($car->color) > 0) ? $car->color : '---'; ?></dd>
		<dt class="col-xs-4 col-sm-2">Trim</dt><dd class="col-xs-8 col-sm-10"><? echo (strlen($car->trim) > 0) ? $car->trim : '---'; ?></dd>
		<dt class="col-xs-4 col-sm-2">VIN</dt><dd class="col-xs-8 col-sm-10"><? echo (strlen($car->vin) > 0) ? $car->vin : '---'; ?></dd>
		<dt class="col-xs-12 col-sm-2">Mileage</dt>
		<dd class="col-xs-12 col-sm-3 col-lg-2 input-group"><? echo $order->mileage; ?> km</dd>
	</dl>

	<div class="clearfix sep"></div>

	<hr class="col-xs-10 col-sm-8" />

	<div class="clearfix sep hidden-xs"></div>
	<div class="clearfix visible-xs"></div>

	<dl>
		<div class="clearfix sep"></div>
		<dt class="col-sm-2">Worktype</dt>
		<dd class="col-sm-6"><? echo $order->worktype; ?></dd>
		<div class="clearfix sep"></div>
		<dt class="col-sm-2">Parts Used</dt>
		<dd class="col-sm-6">
			<? if(sizeof($order->parts) > 0): ?>
				<? foreach($order->parts as $part): ?>
					<li><div class="col-sm-8"><? echo $part->name; ?></div><div class="col-sm-4 text-right">$ <? echo sprintf("%0.02f", $part->price / 100); ?></div></li>
				<? endforeach; ?>
			<? else: ?>
				<li><div class="col-sm-8"><em>No Parts Used</em></div><div class="col-sm-4 text-right">$ 0.00</div></li>
			<? endif; ?>
		</dd>
		<div class="clearfix sep"></div>
		<dt class="col-sm-2">Services</dt>
		<dd class="col-sm-6">
			<? if(sizeof($order->services) > 0): ?>
				<? foreach($order->services as $service): ?>
					<li><div class="col-sm-8"><? echo $service->name; ?></div><div class="col-sm-4 text-right">$ <? echo sprintf("%0.02f", $service->price / 100); ?></div></li>
				<? endforeach; ?>
			<? else: ?>
				<li><div class="col-sm-8"><em>No Services Completed</em></div><div class="col-sm-4 text-right">$ 0.00</div></li>
			<? endif; ?>
		</dd>
		<div class="clearfix sep"></div>
	</dl>

	<hr class="col-xs-10 col-sm-8" />

	<div class="clearfix"></div>

	<dl>
		<dt class="col-sm-2">Discount</dt>
		<dd class="col-sm-6 text-right"><div class="col-sm-12">- $ <? echo sprintf("%0.02f", $order->discount / 100); ?></div></dd>
		<div class="clearfix sep"></div>
		<dt class="col-sm-2">Tax (<? echo sprintf("%0.02f", $order->tax / 100); ?>%)</dt>
		<dd class="col-sm-6 text-right"><div class="col-sm-12">$ <? echo sprintf("%0.02f", $taxamt / 100); ?></div></dd>
		<div class="clearfix sep"></div>
		<dt class="col-sm-2">Total</dt>
		<dd class="col-sm-6 text-right"><div class="col-sm-12">$ <? echo sprintf("%0.02f", $order->total / 100); ?></div></dd>

	</dl>

	<hr class="col-xs-10 col-sm-8" />
	<div class="clearfix"></div>

	<div class="col-sm-2">Notes:</div>
	<div class="col-sm-6">
		<p><? echo $order->notes; ?></p>
	</div>

</div>
<? echo form::close(); ?>