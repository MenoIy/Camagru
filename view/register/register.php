<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>camagru</title>
    <link rel="stylesheet" href="/view/register/register.css" />
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
        <form method="POST" action='?url=register'>
            <div class="container">
                <label for="username"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="user" required>
                <label for="email"><b>Address email</b></label>
                <input type="text" placeholder="Enter Address Email" name="mail" required>
                <label for="password"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" required>
                <button type="submit">Register</button>
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