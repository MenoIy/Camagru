<html>
	<head>
		<meta charset="utf-8" />
		<title>camagru</title>
		<link rel="stylesheet" href="/view/login/login.css" />	
	</head>

	<body class="body">
		<center>
			<div class="block_title">
				<p class="title" >NEW PASSWORD</p>
			</div>
		<br />
		<form method="POST" action='?url=reset'>
			<input type="hidden" name="token" value="<?= $_GET["token"] ?>">
			<div>
				New Password: <input placeholder="Password" class="block" type="password" name="passwd" value="" />
			</div>
			</br>
			<div>
				<input class="button" type="submit" name="submit" value="RESET" />
			</div>
			<?php if (isset($errors["error_type"])): ?>
					<p class="message error">
						<?= $errors["error_type"]?>
					</p>
			<?php endif; ?>
		</form>
		</center>
	</body>
	<footer style="display: block;">
        <hr>
        <p style="text-align:right;font-family:monospace;"><i>&#169; kdaou camagru</i></p>
    </footer>
</html>