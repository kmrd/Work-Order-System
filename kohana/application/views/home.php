<? //echo (isset($errors) AND (sizeof($errors) > 0))? '<br />There were errors with your entry.' : ''; ?>
<? echo form::open(null,array('class'=>"form-signin")); ?>
	
	<img src="/assets/imgs/logo.png" class="img-responsive" alt="Responsive image">

	<h2 class="form-signin-heading text-center">WOS Login</h2>
	<? echo form::input('username', $data['username'] , 'class="form-control input-lg" placeholder="username" autofocus'); ?>
	<? echo form::password('password', '' , 'class="form-control input-lg" placeholder="password"'); ?>	
	<? if (isset($errors)): ?>
		<div class="alert alert-danger">
			<? foreach($errors as $error): ?>
				<? echo $error; ?><br />
			<? endforeach; ?>
		</div>
	<? endif; ?>
	<? echo form::submit('submit', 'Login', 'class="btn btn-lg btn-primary btn-block"'); ?>
<? echo form::close(); ?>