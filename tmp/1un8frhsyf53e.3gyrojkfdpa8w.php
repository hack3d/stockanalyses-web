<!DOCTYPE html>
<html lang="en">
	<head>
		<base href="<?= $BASE.'/'.$UI ?>" />
		<title><?= $site ?></title>
		<!-- Bootstrap -->
		<link href="../css/bootstrap.css" rel="stylesheet" media="screen" />
                
                <!-- bootstrap-datetimepicker -->
                <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen" />

		
		<script src="../js/jquery.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
                
                <!-- bootstrap-datetimepicker -->
                <script src="../js/moment-with-locales.min.js"></script>
                <script src="../js/bootstrap-datetimepicker.min.js"></script>
                
                <!-- fontaawesome -->
                <link href="../css/font-awesome.min.css" rel="stylesheet" media="screen" />
                
                
                
	</head>

	<body>
		<div class="container">

			<div class="jumbotron">
                            <div class="container">
                                <h1 class="col-xs-10"><?= $page_head ?></h1>
                            </div>
			</div>
		<?php echo $this->render('nav.htm',NULL,get_defined_vars(),0); ?>

		<?php if ($message): ?>
            	<div class="alert alert-success">
                	<button type="button" class="close" data-dismiss="alert">&times;</button>
                	<strong><?= $message ?></strong>
            	</div>
            	<?php endif; ?>

		<?php if ($message_warning): ?>
		 <div class="alert alert-warning">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <strong><?= $message_warning ?></strong>
		 </div>
		<?php endif; ?>

		<?php if ($message_failed): ?>
		 <div class="alert alert-danger">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <strong><?= $message_failed ?></strong>
		 </div>
		<?php endif; ?>
