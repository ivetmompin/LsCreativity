<?php

use Ivet\Ac1\Objects\Image;
use Ivet\Ac1\Unsplash;

session_start();
require_once 'Unsplash.php';
require_once 'Objects/Image.php';

$images = [];
$keywordError="";
function getImagesProperties($data): array
{
    foreach ($data['results'] as $item) {
        $image =  new Image($item);
        $images[] = $image;
    }
    return $images;
}
if(isset($_SESSION['user_id'])) {
    if (!empty($_POST)) {
        $keyWord = $_POST['keyword'];
        if ($keyWord != null) {
            $unsplash = new Unsplash("nlFvHmqKjLEE6Cf4EkdUQZMpHb3XRCYcjTml5BhxVY4");
            $unsplash->registerSearchHistory($_SESSION['user_id'],$keyWord);
            $data = $unsplash->getDataByKeyWord($keyWord);
            if ($data != null) {
                $images = getImagesProperties($data);
            }
        } else {
            $keywordError = "you have to introduce something";
        }
    }
}else{
    header("Location: login.php");
    exit;
}
session_write_close();
?>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/forms.css"/>
    <link rel="stylesheet" href="css/searchGallery.css"/>
    <title>LsCreativity - Search</title>
</head>
<body>
    <div class="registration-form search-form">
        <h1>Search Form</h1>
        <form action="search.php" method="POST">
            <label class="label" for="keyword">Keyword: </label>
            <input type="text" name="keyword" placeholder="keyword">
            <p class="error"><?php echo $keywordError?></p>
            <button type="submit"> Search </button>
        </form>
    </div>
    <div class="grid-container">
        <?php foreach ($images as $image): ?>
            <!-- Insert the image URL into the src attribute of the img tag -->
            <div class="card" style="--row-height: var(--row-height);">
                <div class="card-img">
                    <img src="<?php echo $image->retrieveSrc(); ?>" alt="Unsplash Image">
                </div>
                <div class="card-content">
                    <div class="likes">
                        <i class="fas fa-heart"> <?php echo $image->retrieveLikes(); ?></i>
                    </div>
                    <div class="description">
                        <p class="description"><?php echo $image->retrieveDescription(); ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>