<html>
	<head>
		<meta charset="utf-8" />
		<title>camagru</title>
		<link rel="stylesheet" href="/view/register/register.css" />	
	</head>
    <div>
			<form>
				<input class="home_block" type="submit" name="url" value="home">
				<input class="home_block" type="submit" name="url" value="login"/>
				<input class="home_block" type="submit" name="url" value="register"/>
				<input class="home_block" type="submit" name="url" value="reset_password"/>

			</form>
	</div>
	<body class="body">
		<center>
			<div class="block_title">
				<p class="title" >REGISTER</p>
			</div>
		<br />
		<form method="POST" action='?url=register'>
			<div>
				<span class="champ">Login : </span><input placeholder="Login" class="block" type="text" name="login" value="" />
			</div>
			<br />
			<div>
				<span class="champ">Email : </span> <input placeholder="Email" class="block"type="text" name="mail" value="" />
			</div>
			<br />
			<div>
				<span class="champ">Password : </span> <input placeholder="Password" class="block" type="password" name="passwd" value="" />
			</div>
			<br />
			<div>
				<input class="button" type="submit" name="submit" value="REGISTER" />
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
