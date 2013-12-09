<div class="container container_12">

	<div class="grid_12">
		<? if($store->user->id == Auth::instance()->get_user()->id): ?>
			<a href="/store/edit/<? echo security::scrambleint($store->id); ?>">Edit</a>
		<? endif; ?>
	</div>

	<h2 class="grid_10"><? echo $store->name; ?></h2>

	<div class="clear"></div>

	<div class="grid_16">
		<div id="uploadercontent">
			<? if(sizeof($store->images) > 0 ): ?>
				<? foreach($store->images as $img) : ?>
					<img src="<? echo img::display_filename($img, 800, false); ?>" width="800" />
				<? endforeach; ?>
			<? else : ?>
				<img src="/assets/imgs/default-store.jpg" width="800">
			<? endif; ?>
		</div>
	</div>

	<div class="clear"></div>

	<p><? echo nl2br($store->desc); ?></p>

	<h3>Eats</h3>
	<? if(sizeof($store->eats) > 0): ?>
		<div class="gridboxes">
			<? if(sizeof($store->eats) > 0): ?>
				<dl>
					<? foreach($store->eats as $eat): ?>
						<dd class="grid_3">
							<div class="thumb">
								<? if(sizeof($eat->images) > 0) : ?>
									<img src="<? echo img::display_filename($eat->images[0], 200, 200); ?>" />
								<? else : ?>
									<img src="/assets/imgs/default-eat.jpg" width="200" />
								<? endif; ?>
							</div>
							<h4><a href="/eat/view/<? echo security::scrambleint($eat->id); ?>"><? echo $eat->name; ?></a></h4>
							<p><? echo $eat->desc; ?></p>
						</dd>
					<? endforeach; ?>
				</dl>
			<? else: ?>
					<em>This store has no eats yet.</em>
			<? endif; ?>
		</div>

	<? else: ?>
		<p>No eats found. 
			<? if($store->user->id == Auth::instance()->get_user()->id): ?>
				<a href="/eat/post/">Add one now</a>.
			<? endif; ?>
		</p>
	<? endif; ?>


</div>