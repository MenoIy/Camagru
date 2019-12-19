<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>camagru</title>
    <link rel="stylesheet" href="/view/profile/profile.css" />
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
    <div>
        <form method="POST" action='?url=profile'>
            <div class="container">
                <label for="username"><b>Username</b></label>
                <div class="block">
                    <input type="text" placeholder="Enter Username" name="user" value="">
                    <button type="submit" name="TASK" value="CHANGE LOGIN">Change Username</button>
                </div>
                <label for="email"><b>Address email</b></label>
                <div class="block">
                    <input type="text" placeholder="Enter Address Email" name="mail" value ="">
                    <button type="submit" name="TASK" value="CHANGE MAIL">Change Mail</button>
                </div>
                <label for="password"><b>Password</b></label>
                <div class="block">
                    <input type="password" placeholder="Enter Password" name="password" value="">
                    <button type="submit" name="TASK" value="CHANGE PASSWORD">Change Password</button>
                </div>
                <label for="Notification"><b>Notification</b></label>
                </br>
                    <button class="Notif" type="submit" name="TASK" value="CHANGE NOTIFICATION">
                        <?php 
                            $userController = new UserController($db);
                            $status = $userController->getStatus($_SESSION['loggued_on_user']);
                            echo $status;
                        ?>
                    </button>
                <button type="submit">Return</button>
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