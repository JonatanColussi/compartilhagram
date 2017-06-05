<!DOCTYPE html>
<html>
<head>
	<title><?= $title ?></title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap/bootstrap.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/fontAwesome/font-awesome.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/compiled/style.min.css') ?>">
	<?php
		if(isset($styles) && is_array($styles))
			foreach($styles as $style)
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$style}\">\n";
	?>
</head>
<body>
	<?= $contents ?>
	<script type="text/javascript" src="<?= base_url('assets/js/jQuery/jquery-3.2.1.min.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/js/bootstrap/bootstrap.min.js') ?>"></script>
	<?php
		if(isset($scripts) && is_array($scripts))
			foreach($scripts as $script)
				echo "<script type=\"text/javascript\" src=\"{$script}\"></script>\n";
	?>
</body>
</html>