<? echo form::open(); ?>

<div class="container container_12">

	<h2 class=""><? echo $customer->fname.' '.$customer->lname; ?></h2>

	<div class="clear"></div>

	<div class="panel panel-default">
		<div class="panel-heading">
			Customer Information <a href="/customer/edit/<? echo $customer->id; ?>" class="btn btn-info btn-xs pull-right"><span class="glyphicon glyphicon-edit"></span> Edit</a>
		</div>
		<div class="panel-body">
			<dl class="">
			  <dt class="col-xs-3 col-sm-2 col-md-1">Name: </dt><dd class=""><? echo (strlen($customer->fname) > 0) ? $customer->fname : '---'; ?> <? echo (strlen($customer->lname) > 0) ? $customer->lname : '---'; ?></dd>
			  <dt class="col-xs-3 col-sm-2 col-md-1">Phone:</dt><dd class=""><? echo (strlen($customer->phone) > 0) ? '<a href="tel:'.$customer->phone.'">'.$customer->phone.'</a>' : '---'; ?></dd>
			  <dt class="col-xs-3 col-sm-2 col-md-1">Email:</dt><dd class=""><? echo (strlen($customer->email) > 0) ? '<a href="mailto:'.$customer->email.'">'.$customer->email.'</a>' : '---'; ?></dd>
			  <dt class="col-xs-3 col-sm-2 col-md-1">Forum:</dt><dd class=""><? echo (strlen($customer->forumusername) > 0) ? $customer->forumusername : '---'; ?> (<? echo (strlen($customer->forum) >0) ? $customer->forum : '---'; ?>)</dd>
			</dl>
		</div>
	</div>


	<div class="panel panel-default">
		<div class="panel-heading">
			Cars <a href="/car/add/<? echo $customer->id; ?>" class="btn btn-info btn-xs pull-right"><span class="glyphicon glyphicon-plus"></span> Add Car</a>
		</div>
		<div class="panel-body">
			<? if(sizeof($customer->cars) > 0): ?>

				<ul class="nav nav-tabs">
					<? $first = true; ?>
					<? foreach($customer->cars as $car) :?>
						<li class="<? echo $first ? 'active' : ''; ?>">
							<a href="#car-<? echo $car->id; ?>" data-toggle="tab">
								<? echo '\''.substr($car->year, -2); ?>
								<? echo $car->model; ?>
							</a>
						</li>
						<? $first = false; ?>
					<? endforeach; ?>
				</ul>

				<div class="tab-content">
					<? $first = true; ?>
					<? foreach($customer->cars as $carindex => $car): ?>
						<div class="tab-pane <? echo $first ? 'active' : ''; ?>" id="car-<? echo $car->id; ?>">
							<div class="col-md-3">
								<h3>
									<a href="/car/edit/<? echo $car->id; ?>"><? echo $car->year.' '.$car->make.' '.$car->model; ?></a>
									<? /* <a href="/car/edit/<? echo $car->id; ?>" class="btn btn-info btn-xs pull-right visible-xs visible-sm">Edit</a> */ ?>
								</h3>
								<div>
									<dl>
										<dt class="col-xs-4">Color</dt><dd><? echo (strlen($car->color) > 0) ? $car->color : '---'; ?></dd>
										<dt class="col-xs-4">Trim</dt><dd><? echo (strlen($car->trim) > 0) ? $car->trim : '---'; ?></dd>
										<dt class="col-xs-4">VIN</dt><dd><? echo (strlen($car->vin) > 0) ? $car->vin : '---'; ?></dd>
										<dt class="col-xs-4">Mileage</dt><dd><?
											// get the last work order for this car
											$orders = $car->orders;
											if(sizeof($orders) > 0):
												$order = $orders[0];
												echo $order->mileage;
											else:
												echo '---';
											endif;
										?></dd>
									</dl>
								</div>
							</div>
							<div class="col-md-9">
								<div class="clearfix sep"></div>

								<a href="/order/add/<? echo $car->id; ?>" class="btn btn-primary btn-block sep"><span class="glyphicon glyphicon-plus-sign"></span> New Work Order</a>

								<? if(sizeof($car->orders) > 0): ?>
									<div class="panel-group" id="accordion-<? echo $carindex; ?>">
										<? foreach($car->orders as $index => $order): ?>
											<div class="panel panel-default">
												<div class="panel-heading">
													<a href="/order/edit/<? echo $order->id; ?>" class="pull-right btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"></span> Edit</a>
													<h4 class="panel-title">
														<a data-toggle="collapse" data-parent="#accordion" href="#collapse-<? echo $carindex; ?>-<? echo $index;?>"><? echo $order->worktype; ?></a>
														<small><? echo (strlen($order->mileage) > 0) ? $order->mileage : '---'; ?>km | <? echo date('D, M d, Y', strtotime($order->servicedate)); ?></small>
													</h4>
												</div>
												<div id="collapse-<? echo $carindex; ?>-<? echo $index;?>" class="panel-collapse collapse">
													<div class="panel-body">
														<div class="col-md-4">
															<h4>Service</h4>
															<dl>
																<? foreach($order->services as $service): ?>
																	<dd><? echo $service->name; ?></dd>
																<? endforeach; ?>
															</dl>
														</div>
														<div class="col-md-4">
															<h4>Parts</h4>
															<dl>
																<? foreach($order->parts as $part): ?>
																	<dd><? echo $part->name; ?></dd>
																<? endforeach; ?>
															</dl>
														</div>
														<div class="col-md-4">
															<h4>Notes</h4>
															<? echo $order->notes; ?>
														</div>
													</div>
												</div>
											</div>
										<? endforeach; ?>
									</div>
								<? else: ?>
									<div class="panel panel-default">
										<div class="panel-body">
											<em>No work orders found. <a href="/order/add/<? echo $car->id; ?>">Add order</a>.</em>
										</div>
									</div>
								<? endif;?>
							</div>
						</div>
						<? $first = false; ?>
					<? endforeach; ?>
				</div>
			<? else : ?>
				<p><em>No cars found. <a href="/car/add/<? echo $customer->id; ?>">Add a car</a>.</em></p>
			<? endif; ?>
		</div>
	</div>
</div>

<? echo form::close(); ?>