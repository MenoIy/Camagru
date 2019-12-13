<html>
    <head>
        <meta charset="utf-8" />
        <title>camagru</title>
        <link rel="stylesheet" href="/view/home/home.css" />	
    </head>
    <body>
    <div>
        <form>
            <input class="block" type="submit" name="url" value="home">

            <?php if (!isset($_SESSION["loggued_on_user"])): ?>
                <input class="block" type="submit" name="url" value="login"/>
            <?php endif; ?>

            <?php if (!isset($_SESSION["loggued_on_user"])): ?>
                <input class="block" type="submit" name="url" value="register"/>
            <?php endif; ?>

            <?php if (isset($_SESSION["loggued_on_user"])): ?>
                <input class="block" type="submit" name="url" value="logout"/>
            <?php endif; ?>

            <?php if (!isset($_SESSION["loggued_on_user"])): ?>
                <input class="block" type="submit" name="url" value="reset_password"/>
            <?php endif; ?>

            <?php if (isset($_SESSION["loggued_on_user"])): ?>
                <input class="block" type="submit" name="url" value="profile"/>
            <?php endif; ?>
        
            <?php if (isset($_SESSION["loggued_on_user"])): ?>
                <input class="block" type="submit" name="url" value="camera"/>
            <?php endif; ?>
    
        </form>
    </div>
  
    <footer style="display: block;">
        <hr>
        <p style="text-align:right;font-family:monospace;"><i>&#169; kdaou camagru</i></p>
    </footer>

</body></html>