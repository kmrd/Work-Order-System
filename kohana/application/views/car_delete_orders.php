<? echo form::open(null, array('class' => 'form-horizontal')); ?>
<div class="container container_12">

	<h2>Can Not Delete Car</h2>
	<p><a href="/customer/view/<? echo $car->customer->id; ?>" class="btn btn-primary">Back to Customer</a></p>

	<div class="clear"></div>

	<div class="alert alert-danger">
		<p>You are about to delete this car:</p>
		<h2><? echo $car->year.' '.$car->model.' '.$car->make; ?></h2>
	</div>

	<a href="/customer/view/<? echo $car->customer->id; ?>" class="btn btn-primary pull-left">Go back to Customer</a>
	<a href="/car/deleteconfirm/<? echo $car->id; ?>" class="btn btn-danger pull-right">Delete this car</a>

</div>
<? echo form::close(); ?>