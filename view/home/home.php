<?php
    $images_path = "/public/images";
    $imageModel = new ImageModel($db);
    $images = $imageModel->getImages();
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
            foreach ($images as $image):
            $count = $imageModel->getLikeCount($image['filename']);
        ?>
        <div class="image">
            <img src=<?= "$images_path/$image[filename]"?> />
            <button class="comment_button" onclick="showComment('<?php echo $image['filename'] ?>')">Comment</button>
            <form class="like_form" method="POST" action="?url=home">
                <button type="submit" class="like" name="like" value="like">
                    <?php if ($imageModel->AlreadyLiked($_SESSION['loggued_on_user'], $image['filename']) == 0): ?>
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
                       $comments = $imageModel->getComments($image['filename']);
                       foreach ($comments as $comment):
                       $commentaire = htmlspecialchars($comment['comment']);
                    ?>
                    <h5><?= "$comment[user] : $commentaire"
                        ?></h5>
                    <?php endforeach; ?>
                </div>
                <div class="input">
                    <form method="POST" action='?url=home'>
                        <input type="text" placeholder="Enter a Comment" name="comment" required>
                        <button type="submit">OK</button>
                        <input type="hidden" name="action" value="comment" />
                        <input type="hidden" name="image" value=<?= "$image[filename]"?> />
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
    <footer>
        <p style="text-align:right;font-family:monospace;"><i>&#169; kdaou camagru</i></p>
    </footer>
</body>

</html>