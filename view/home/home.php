<?php
    $images_path = "/public/images";
    $imageController = new ImageController($db);
    $size = $imageController->getImageCount();
    $size = ceil($size / 5);
    if (!isset($_GET['page']) || !is_string($_GET['page']))
        $page = 1;
    else if (!(preg_match('/^[0-9]+$/', $_GET['page'])))
        $page = 1;
    else
    {
        $intval = intval($_GET['page'], 10);
        $page =  ($intval <= 0 || $intval > $size) ? 1 : $intval;
    }
    $images = $imageController->getImages(($page - 1) * 5, 5);
?>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>camagru</title>
    <link rel="stylesheet" href="/view/home/home.css" />
    <script src="./view/home/home.js"></script>
</head>

<body>
    <div class="header">
        <p1 class="title"><img class="logo" src="./icon1.png" />Camagru</p1>
        <div class="header-page">
            <a href="?url=home">Home</a>
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
    <div class="imagesList" id="imagesList">
        <?php
            foreach ((array) $images as $image):
            $count = $imageController->getLikeCount($image['filename']);
        ?>
        <?php if (isset($errors)): ?>
            <p class="Error"> <?= $errors["error_type"]?> </p>
        <?php $errors = null ; endif; ?>
        <div class="image">
            <img src=<?= "$images_path/$image[filename]"?> />
            <div class=info>
                <p><?php echo "Publisher : ".$image['user']?></p>
                <p><?php echo ", Published on : ".date("F j, Y, g:i a", $image['time'])?></p>
            </div>
            <button class="comment_button" onclick="showComment('<?php echo $image['filename'] ?>')">Comment</button>
            <form class="like_form" method="POST" action="?url=home">
                <button type="submit" class="like" name="like" value="like">
                    <?php if (!$imageController->alreadyLiked($image['filename'])): ?>
                        <span class="like_nonactive">&#x2661;</span>
                    <?php else: ?>
                        <span class="like_active">&#x2665;</span>
                    <?php endif; ?>
                    <span><?="$count"?><span>
                    <input type="hidden" name="action" value="like" />
                    <input type="hidden" name="image" value=<?= "$image[filename]"?> />
                </button>
            </form>
            <div class="hidden" id=<?= "$image[filename]" ?>>
                <div class="comments">
                    <?php
                       $comments = $imageController->getComments($image['filename']);
                       foreach ((array) $comments as $comment):
                       $commentaire = htmlspecialchars($comment['comment']);
                    ?>
                    <h5><?= "$comment[user] : $commentaire"
                        ?></h5>
                    <hr>
                    <?php endforeach; ?>
                </div>
                <div class="input">
                    <form method="POST" action='?url=home'>
                        <input type="text" placeholder="Enter a Comment" name="comment" required>
                        <button type="submit">OK</button>
                        <input type="hidden" name="action" value="comment" />
                        <input type="hidden" name="owner" value=<?= "$image[user]" ?> />
                        <input type="hidden" name="image" value=<?= "$image[filename]"?> />
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach;?>
        <div class="pagination">
            <?php
                for($i = 1; $i <= $size; $i++) {?>
                    <a href=<?= "?url=home&page=".$i ?>>&laquo;<?=$i?>&raquo;</a>
            <?php } ?>
        </div>
    </div>
    <footer>
        <p style="text-align:right;font-family:monospace;"><i>&#169; kdaou camagru</i></p>
    </footer>
</body>

</html>