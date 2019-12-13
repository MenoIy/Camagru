<html>
	<head>
		<meta charset="utf-8" />
		<title>camagru</title>
		<link rel="stylesheet" href="/view/camera/camera.css" />
		<script async src="./core/camera.js"> </script>

	</head>
    <div>
			<form>
				<input class="home_block" type="submit" name="url" value="home">
				<input class="home_block" type="submit" name="url" value="logout"/>
				<input class="home_block" type="submit" name="url" value="profile"/>
				<input class="home_block" type="submit" name="url" value="camera"/>
			</form>
	</div>
	<body class="body">
		<form id="saveForm" method="POST" action="">
			<input type="hidden" id="data", name="data">
		</form>
		<div class="camera">
				<video class="video" id="video"></video>
				<div>   
			<button id="setImage1">
				<img src="./public/superposables/dumb.png" alt="Smiley face" height="42" width="42" id = "1">
			</button>

			<button id="setImage2">
			<img src="./public/superposables/dumb.png" alt="Smiley face" height="42" width="42" id = "2">
			</button>

			<button id="setImage3">
			<img src="./public/superposables/dumb.png" alt="Smiley face" height="42" width="42" id = "3">
			</button>
			<button id="noImage">Screen</button>
		<div>
			<canvas id= "canvas"  ></canvas>
		</div>
		<div>
			<button id="save">save picture</button>
		</div>

	</body>
	<footer style="display: block;">
        <hr>
        <p style="text-align:right;font-family:monospace;"><i>&#169; kdaou camagru</i></p>
    </footer>
</html>
