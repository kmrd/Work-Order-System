<?php defined('SYSPATH') OR die('No direct access allowed.');


?><!DOCTYPE html>
<html>
<head>
    <title><?
		if(isset($title))
			echo $title . ' | 10fintec';
		else
			echo '10fintec';
	?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!-- Bootstrap -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <? // <link href="/assets/css/bootstrap-theme.min.css" rel="stylesheet"> <? // use this if you want fancier look & feeling (ie 3D effects on buttons, etc) ?>


	<? // <link rel="shortcut icon" href="/favicon.ico"> ?>
	<? // <link rel="apple-touch-icon" href="/favicon.png"> ?>


	<? if(isset($css)):
		foreach($css as $sheet):
			echo '<link rel="stylesheet" type="text/css" href="/assets/css/'.$sheet.'.css" />';
		endforeach;
	endif ?>

	<link rel="stylesheet/less" href="/assets/less/layout.less" />
	<? if(isset($less)):
		foreach($less as $sheet):
			echo '<link rel="stylesheet/less" href="/assets/less/'.$sheet.'.less" />';
		endforeach;
	endif ?>

	<? /*	// -------------- Taking this out because we don't care about IE compatibility in an internal application ------------//
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    */ ?>

</head>
<body class="<? echo isset($bodyclass) ? $bodyclass : ''; ?>">
<div class="header">
	<? if (isset($header)): ?>
		<div class="container">
			<? echo $header; ?>
		</div>
	<? else: ?>
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <a class="navbar-brand" href="/dashboard"><img src="/assets/imgs/logo.png" class="img-responsive"></a>
	        </div>
	        <div class="collapse navbar-collapse">
	          <ul class="nav navbar-nav">
	            <li><a href="/customer/add">Add Customer</a></li>
	            <li><a href="/customer/find">Find Customer</a></li>
	            <li><a href="/order/find">Find Job</a></li>
	          </ul>
	          <ul class="nav navbar-nav navbar-right">
	          	<li class="navbar-right"><a href="/logout">Logout</a></li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
		</div>
	<? endif; ?>
	<?

	?>
</div>

<div class="contents">
	<?php if(Session::get('successstate')): ?>
		<div class="container">
			<div class="alert alert-success"><?php echo Session::get('successstate'); ?></div>
		</div>
	<?php endif; ?>
	<?php if(Session::get('warningstate')): ?>
		<div class="container">
			<div class="alert alert-warning"><?php echo Session::get('warningstate'); ?></div>
		</div>
	<?php endif; ?>

	<?php if(isset($content)): ?>
		<div class="container">
			<? echo $content; ?>
		</div>
	<? endif; ?>
</div>

<?
//$this->profiler = new Profiler;
//$this->profiler->render(TRUE);
?>

<script src="/assets/js/jquery-1.10.2.min.js"></script>
<? // <script src="/assets/js/jquery-1.9.1.min.js"></script> ?>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/less-1.5.0.min.js"></script>
<script src="/assets/js/bootstrap-datetimepicker.min.js"></script>

<? if(isset($js)):
	foreach($js as $script):
		echo '<script src="/assets/js/'.$script.'.js"></script>'."\n";
	endforeach;
endif; ?>
</body>
</html>