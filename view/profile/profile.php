<html>
	<head>
		<meta charset="utf-8" />
		<title>camagru</title>
		<link rel="stylesheet" href="/view/register/register.css" />	
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
		<center>
			<div class="block_title">
				<p class="title" >PROFILE</p>
			</div>
		<br />
		<form method="POST" action='?url=profile'>
			<div>
				<span class="champ">Login : </span><input placeholder="Login" class="block" type="text" name="login" value="" />
				<input class="button" type="submit" name= "TASK" value="CHANGE LOGIN" />
			</div>
			<br />
			<div>
				<span class="champ">Email : </span> <input placeholder="Email" class="block"type="text" name="mail" value="" />
				<input class="button" type="submit" name="TASK" value="CHANGE MAIL" />
			</div>
			<br />
			<div>
				<span class="champ">Password : </span> <input placeholder="Password" class="block" type="password" name="passwd" value="" />
				<input class="button" type="submit" name="TASK" value="CHANGE PASSWORD" />
			</div>
			<br />
			<div>
				<input class="button" type="submit" name="TASK" value="RETURN" />
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
