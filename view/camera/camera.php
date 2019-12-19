<?php
    $images_path = "/public/images";
    $imageController = new ImageController($db);
    $images = $imageController->getUserImages();
?>
<html>

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>camagru</title>
	<link rel="stylesheet" href="/view/camera/camera.css" />
	<script async src="./view/camera/camera.js"> </script>
</head>

<body>
	<div class="header">
		<p1 class="title"><img class="logo" src="./icon1.png" />Camagru</p1>
		<div class="header-page">
			<a class="active" href="?url=home">Home</a>
			<?php if (!isset($_SESSION["loggued_on_user"])): ?>
			<a href="?url=login" />Login</a>
			<?php endif; ?>
			<?php if (!isset($_SESSION["loggued_on_user"])): ?>
			<a href="?url=register" />Register</a>
			<?php endif; ?>
			<?php if (isset($_SESSION["loggued_on_user"])): ?>
			<a href="?url=profile" />profile</a>
			<?php endif; ?>
			<?php if (isset($_SESSION["loggued_on_user"])): ?>
			<a href="?url=camera" />Camera</a>
			<?php endif; ?>
			<?php if (isset($_SESSION["loggued_on_user"])): ?>
			<a href="?url=logout" />Logout</a>
			<?php endif; ?>
		</div>
	</div>
	<div class="fullbody">
		<div class="camera">
			<div class="video">
				<video id="video"></video>
				<button class="superposable" id="setImage1">
					<img src="./public/superposables/dumb.png" alt="Smiley face" height="42" width="42" id="1">
				</button>
			</div>
			<div class="canvas">
				<canvas id="canvas"></canvas>
				<div>
					<form id="saveForm" method="POST" action="?url=camera">
						<input type="hidden" id="data" , name="data">
						<input type="hidden" id="superpos" , name="superpose">
						<input type="hidden" name="action" value="save" />
						<button class="button" id="save">Save Image</button>
					</form>
				</div>
			</div>
		</div>
		<div class="preview">
			<?php foreach ((array) $images as $image):?>
			<form id="deleteForm" method="POST" action="?url=camera">
				<div class="image">
					<img src=<?= "$images_path/$image[filename]"?> />
				</div>
				<input type="hidden" name="action" value="delete" />
				<input type="hidden" name="image" value=<?="$image[filename]" ?> />
				<button class="button">Delete Image</button>
				<form>
					<?php endforeach; ?>
		</div>
	</div>
	<footer>
		<p style="text-align:right;font-family:monospace;"><i>&#169; kdaou camagru</i></p>
	</footer>

</body>

</html>