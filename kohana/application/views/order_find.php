<? echo form::open(null, array('class' => 'form-horizontal')); ?>
	<div class="col-md-6">
		<h1 class="">Search Jobs</h1>
		<p>You can use any or all fields</p>
		<? echo form::input('job',	 $data['job'],  'class="form-control input-lg" placeholder="job (ie oil change)"'); ?>
		<br />
		<? echo form::input('year',	 $data['year'],  'class="form-control input-lg" placeholder="car year"'); ?>
		<? echo form::input('make',	 $data['make'],  'class="form-control input-lg" placeholder="car make (Hyundai / Honda / Toyota)"'); ?>
		<? echo form::input('model', $data['model'], 'class="form-control input-lg" placeholder="car model (Genesis / Civic / FRS)"'); ?>
		<br />
		<? echo form::submit('submit', 'Search','class="btn btn-lg btn-primary btn-block"'); ?>
	</div>
<? echo form::close(); ?>

<div class="clearfix sep"></div>

<? if($posted): ?>
	<hr />
	<div class="">
		<h1>Work Orders</h1>
		<? if(isset($orders) && (sizeof($orders) > 0)): ?>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Date</th>
						<th>Worktype</th>
						<th>Car</th>
						<th>Owner</th>
					</tr>
				</thead>
				<? foreach($orders as $order) : ?>
					<tr>
						<td><? echo date('M j, Y', strtotime($order->servicedate)); ?></td>
						<td><a href="/order/printly/<? echo $order->id; ?>"><? echo $order->worktype; ?></a></td>
						<td><? echo $order->car->year.' '. $order->car->make.' '.$order->car->model; ?></td>
						<td><? echo $order->car->customer->fname.' '.$order->car->customer->lname; ?></td>
					</tr>
				<? endforeach; ?>
			</table>
		<? else: ?>
			<p><em>No Work Orders found.</em></p>
		<? endif; ?>
	</div>
<? endif; ?>