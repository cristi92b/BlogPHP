<?php require '../blog/library.php'; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<script type="text/javascript" src="js/jquery-2.1.1.js"></script>
		<script src="https://cdn.socket.io/socket.io-1.1.0.js"></script>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>
	<body>
		<h1>Blog</h1>
		<hr>
		<div id="posts">
			<?php fetch_latest7(); ?>
		</div>
	</body>
</html>
