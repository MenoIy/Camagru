<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>camagru</title>
		<link rel="stylesheet" href="/view/home/home.css"/>
    </head>
    <body>
            <div class="header">
                <p1 class="title"><img class="logo" src="./icon1.png"/>Camagru</p1>
                <div class="header-page">
                    <a href="?url=home">Home</a>
                    <?php if (!isset($_SESSION["loggued_on_user"])): ?>
                        <a href="?url=login"/>Login</a>
                    <?php endif; ?>
                    <?php if (!isset($_SESSION["loggued_on_user"])): ?>
                        <a href="?url=register"/>Register</a>
                    <?php endif; ?>
                    <?php if (isset($_SESSION["loggued_on_user"])): ?>
                        <a href="?url=profile"/>profile</a>
                    <?php endif; ?>
                    <?php if (isset($_SESSION["loggued_on_user"])): ?>
                        <a href="?url=camera"/>Camera</a>
                    <?php endif; ?>
                </div>
            </div>
            <footer>
                <p style="text-align:right;font-family:monospace;"><i>&#169; kdaou camagru</i></p>
            </footer>
    </body>
</html>