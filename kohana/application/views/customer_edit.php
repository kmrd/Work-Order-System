<? echo form::open(null, array('class' => 'form-horizontal')); ?>
<div class="container container_12">

	<h2>Edit Customer</h2>
	<p><a href="/customer/view/<? echo $data['id']; ?>" class="btn btn-info">Go View Customer</a></p>

	<div class="clear"></div>

	<? if(isset($errors) AND (sizeof($errors) > 0)): ?>
		<p class="alert alert-danger">
			All fields are required.
			<? // echo (isset($errors) AND (sizeof($errors) > 0))? '<br />There were errors with your entry.' : ''; ?>
		</p>
	<? endif; ?>

	<div class="form-group <? echo (isset($errors['fname'])) ? 'has-error' : ''; ?>">
		<? echo form::label('fname','First Name:','class="col-sm-2 control-label"'); ?>
		<div class="col-sm-6">
			<? echo form::input('fname', $data['fname'], 'class="form-control"'); ?>
		</div>
		<? if(isset($errors['fname'])) : ?>
			<p class="col-sm-4 help-block"><? echo $errors['fname']; ?></p>
		<? endif; ?>
	</div>

	<div class="form-group <? echo (isset($errors['lname'])) ? 'has-error' : ''; ?>">
		<? echo form::label('lname','Last Name:','class="col-sm-2 control-label"'); ?>
		<div class="col-sm-6">
			<? echo form::input('lname', $data['lname'], 'class="form-control"'); ?>
		</div>
		<? if(isset($errors['lname'])) : ?>
			<p class="col-sm-4 help-block"><? echo $errors['lname']; ?></p>
		<? endif; ?>
	</div>

	<div class="clearfix sep"></div>

	<div class="form-group <? echo (isset($errors['phone'])) ? 'has-error' : ''; ?>">
		<? echo form::label('phone','Phone:','class="col-sm-2 control-label"'); ?>
		<div class="col-sm-6">
			<? echo form::input('phone', $data['phone'], 'class="form-control"'); ?>
		</div>
		<? if(isset($errors['phone'])) : ?>
			<p class="col-sm-4 help-block"><? echo $errors['phone']; ?></p>
		<? endif; ?>
	</div>

	<div class="form-group <? echo (isset($errors['email'])) ? 'has-error' : ''; ?>">
		<? echo form::label('email','Email:','class="col-sm-2 control-label"'); ?>
		<div class="col-sm-6">
			<? echo form::input('email', $data['email'], 'class="form-control"'); ?>
		</div>
		<? if(isset($errors['email'])) : ?>
			<p class="col-sm-4 help-block"><? echo $errors['email']; ?></p>
		<? endif; ?>
	</div>

	<div class="clearfix sep"></div>

	<div class="form-group <? echo (isset($errors['forumusername'])) ? 'has-error' : ''; ?>">
		<? echo form::label('forumusername','Forum Username:','class="col-sm-2 control-label"'); ?>
		<div class="col-sm-6">
			<? echo form::input('forumusername', $data['forumusername'], 'class="form-control"'); ?>
		</div>
		<? if(isset($errors['forumusername'])) : ?>
			<p class="col-sm-4 help-block"><? echo $errors['forumusername']; ?></p>
		<? endif; ?>
	</div>

	<div class="form-group <? echo (isset($errors['forum'])) ? 'has-error' : ''; ?>">
		<? echo form::label('forum','Forum:','class="col-sm-2 control-label"'); ?>
		<div class="col-sm-6">
			<? echo form::input('forum', $data['forum'], 'class="form-control"'); ?>
		</div>
		<? if(isset($errors['forum'])) : ?>
			<p class="col-sm-4 help-block"><? echo $errors['forum']; ?></p>
		<? endif; ?>
	</div>

	<div class="clearfix sep"></div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<? echo form::submit('save', 'Save', 'class="btn"'); ?>
			<? echo form::submit('savegoback', 'Save & View Customer', 'class="btn btn-primary"'); ?>
		</div>
	</div>

	<div class="clearfix sep"></div>

</div>
<? echo form::close(); ?>