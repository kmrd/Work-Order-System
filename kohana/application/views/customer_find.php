<div class="row">
	<? echo form::open(null, array('class' => '')); ?>
		<div class="col-md-6">
			<h1 class="">Search Customers</h1>
			<p>You can use any or all fields</p>
			<? echo form::input('fname', $data['fname'], 'class="form-control input-lg" placeholder="first name" autofocus'); ?>
			<? echo form::input('lname', $data['lname'], 'class="form-control input-lg" placeholder="last name"'); ?>
			<? echo form::input('phone', $data['phone'], 'class="form-control input-lg" placeholder="phone number"'); ?>
			<br />
			<? echo form::input('year',	 $data['year'],  'class="form-control input-lg" placeholder="car year"'); ?>
			<? echo form::input('make',	 $data['make'],  'class="form-control input-lg" placeholder="car make (Hyundai / Honda / Toyota)"'); ?>
			<? echo form::input('model', $data['model'], 'class="form-control input-lg" placeholder="car model (Genesis / Civic / FRS)"'); ?>
			<br />
			<? echo form::submit('submit', 'Search','class="btn btn-lg btn-primary btn-block"'); ?>
		</div>
	<? echo form::close(); ?>
</div>

<? if($posted): ?>
	<div class="row">
		<div class="col-md-6">
			<h1>Customers</h1>
			<? if(isset($customers) && (sizeof($customers) > 0)): ?>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Phone</th>
							<th>Cars</th>
						</tr>
					</thead>
					<? foreach($customers as $customer) : ?>
						<tr>
							<td><a href="/customer/view/<? echo $customer->id; ?>"><? echo $customer->fname; ?></a></td>
							<td><a href="/customer/view/<? echo $customer->id; ?>"><? echo $customer->lname; ?></a></td>
							<td><a href="/customer/view/<? echo $customer->id; ?>"><? echo $customer->phone; ?></a></td>
							<td>
								<?
								// list their cars
								$carstrarray = array();
								foreach($customer->cars as $car):
									array_push($carstrarray, $car->year.' '.$car->make.' '.$car->model);
								endforeach;
								echo implode('<br />', $carstrarray);
								?>
							</td>
						</tr>
					<? endforeach; ?>
				</table>
			<? else: ?>
				<p><em>No Customers found.</em></p>
			<? endif; ?>
		</div>
	</div>
<? endif; ?>