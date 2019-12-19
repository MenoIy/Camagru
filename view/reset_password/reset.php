<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>camagru</title>
    <link rel="stylesheet" href="/view/login/login.css" />
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
        </div>
    </div>
    <div>
        <form method="POST" action='?url=reset'>
            <div class="container">
                <label for="password"><b>New Password</b></label>
                <input type="password" placeholder="Enter New Password" name="password" required>
                <button type="submit">RESET</button>
            </div>
            <?php if (isset($errors["error_type"])): ?>
            <p class="Error">
                <?= $errors["error_type"]?>
            </p>
            <?php endif; ?>
        </form>
    </div>
    <footer>
        <p style="text-align:right;font-family:monospace;"><i>&#169; kdaou camagru</i></p>
    </footer>
</body>

</html>