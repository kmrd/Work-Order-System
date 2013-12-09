<? echo form::open(); ?>

<div class="container container_16">

	<h2 class="grid_16">Your Profile</h2>

	<div class="grid_4">
		<? 
		$userimgs = $data['avatars']->as_array();
		$profileimg = end($userimgs);

		$img = img::display_filename($profileimg, 200, 200, Image::WIDTH);

		?>
		<div id="uploadercontent">
			<img src="<? echo $img; ?>" id="avatar" width="200" />
		</div>

		<div id="uploader_btn">Upload new image</div>
		<div id="uploader" title="Upload Image">
			<p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
		</div>

		<div class="clear sep"></div>

		<h3>Stats</h3>
		<p>Reviews :
			<? $reviewcount = 0; ?>
			<? foreach($user->reviews as $review): ?>
				<? if($review->completed == 1): ?>
					<? $reviewcount++; ?>
				<? endif; ?>
			<? endforeach; ?>
			<? echo $reviewcount; ?>
		</p>
		<p>Average Rating :
			<? $rating = 0; ?>
			<? foreach($user->reviews as $review): ?>
				<? $rating += $review->rating; ?>
			<? endforeach; ?>
			<? if(sizeof($user->reviews) > 0): ?>
				<? echo $rating / sizeof($user->reviews); ?>
			<? else: ?>
				0
			<? endif; ?>
		</p>

		<a href="/logout">Logout</a>
	</div>

	<div class="grid_12">
		<? if(isset($errors) AND (sizeof($errors) > 0)): ?>
			<div class="grid_8 prefix_2">
				<p class="announcebox error">
					All fields are required.
					<? // echo (isset($errors) AND (sizeof($errors) > 0))? '<br />There were errors with your entry.' : ''; ?>
				</p>
			</div>
			<div class="clear sep"></div>
		<? endif; ?>

		<div class="clear"></div>

		<? echo form::label('firstname','First Name:', 'class="grid_3"'); ?>
		<? echo form::input('firstname', $data['firstname'], (isset($errors['firstname']))? 'class="grid_4 errorfield"':'class="grid_4"'); ?>

		<div class="clear"></div>

		<? echo form::label('lastname','Last Name:', 'class="grid_3"'); ?>
		<? echo form::input('lastname', $data['lastname'], (isset($errors['lastname']))? 'class="grid_4 errorfield"':'class="grid_4"'); ?>

		<div class="clear sep"></div>

		<? echo form::label('email','Email:', 'class="grid_3"'); ?>
		<? echo form::input('email', $data['email'], (isset($errors['email']))? 'class="grid_5 errorfield"':'class="grid_5"'); ?>

		<div class="clear sep"></div>

		<? echo form::label('password','Password:', 'class="grid_3"'); ?>
		<? echo form::input('password', null, (isset($errors['password']))? 'class="grid_4 errorfield"':'class="grid_4"'); ?>
		<div class="grid_5 prefix_3"><small><em>Leave blank to keep current password</em></small></div>

		<div class="clear sep"></div>

		<div class="grid_4 prefix_3">
			<? echo form::submit('submit', 'Save Changes', 'class="button"'); ?>
		</div>

		<div class="clear sep"></div>

		<h3 class="grid_3">Your Stores</h3>
		<div class="grid_6">
			<? if(sizeof($user->stores) > 0): ?>
				<? foreach($user->stores as $store): ?>
					<li class="grid_3">
						<h4><a href="/store/view/<? echo security::scrambleint($store->id); ?>"><? echo $store->name; ?></a></h4>
					</li>
				<? endforeach; ?>
			<? else: ?>
					<em>No Stores found. <a href="/store/create">Open one</a> for free.</em>
			<? endif; ?>
		</div>

		<div class="clear sep"></div>

		<h3 class="grid_3">Your Purchases</h3>
		<div class="grid_6">
			<? if(sizeof($user->orders) > 0): ?>
				<? foreach($user->orders as $order): ?>
					<li class="grid_5">
						<? echo $order->id; ?> - <a href="/eats/<? echo security::scrambleint($order->eat->id); ?>"><? echo $order->eat->name; ?></a> - <? echo ($order->completed) ? ' Completed' : 'In progress'; ?>
					</li> 
				<? endforeach; ?>
			<? else: ?>
					<em>No Purchases found. Go buy something.</em>
			<? endif; ?>
		</div>

		<div class="clear sep"></div>

		<h3 class="grid_3">Your Orders <small>(ie. to fulfill)</small></h3>
		<div class="grid_6">
			<? if(sizeof($user->eats) > 0): ?>
				<? foreach($user->eats as $eat): ?>
					<? if(sizeof($eat->orders)) : ?>
						<? foreach($eat->orders as $order) : ?>
							<li class="grid_5">
								<? echo $order->id; ?> - <a href="/eats/<? echo security::scrambleint($eat->id); ?>"><? echo $eat->name; ?></a> - <? echo ($order->completed) ? ' Completed' : 'In progress'; ?>
							</li>
						<? endforeach; ?>
					<? endif; ?>
				<? endforeach; ?>
			<? else: ?>
					<em>No Stores found. <a href="/store/create">Open one</a> for free.</em>
			<? endif; ?>
		</div>

	</div>
</div>

<? echo form::close(); ?>