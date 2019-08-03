<?php
require '../vendor/autoload.php';

use Alexantr\ImageResize\Helper;
use Alexantr\ImageResize\Image;

/**
 * img tag helper
 * @param $src
 */
function test_image($src)
{
    echo '<img src="' . $src . '" alt="">' . "\n";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>examples</title>
    <style>
        img {
            border: 1px solid #999;
            background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAIAAACQkWg2AAAAKklEQVR42mL5//8/Azbw+PFjrOJMDCSCUQ3EABZc4S0rKzsaSvTTABBgAMyfCMsY4B9iAAAAAElFTkSuQmCC') repeat 0 0;
        }
    </style>
</head>
<body>
<?php

// base examples

$src = Image::init('uploads/folder/antelope_canyon.jpg')->crop(150, 150);
test_image($src);

// double "../"
$url = 'uploads/folder/../../uploads/folder/floating_leaves.jpg';
echo '<!-- ' . Helper::cleanImageUrl($url) . ' -->' . "\n";
$src = Image::init($url)->fitHeight(150);
test_image($src);

$src = Image::init('uploads/./././folder/../Cat.jpeg')->crop(150, 150);
test_image($src);

$src = Image::init('./uploads/Cat.jpeg')->placeUpper()->crop(150, 150);
test_image($src);

$src = Image::init('example/../uploads/Cat.jpeg')->noTopOffset()->crop(150, 150);
test_image($src);

$src = Image::init('uploads/Cat.jpeg?foo=bar')->noBottomOffset()->crop(150, 150);
test_image($src);

$src = Image::init('../example/uploads/cat.gif#foobar')->fitWidth(150);
test_image($src);

// variant with path relative to document root
$url = Helper::getBaseUrl() . '/uploads/Apple.png';
echo '<!-- ' . $url . ' -->' . "\n";
$src = Image::init($url)->place(120, 150);
test_image($src);

// wrong url
$src = Image::init('folder/foo.bar')->crop(150, 150);
test_image($src);

// wrong url - no extension
$src = Image::init('foobar')->crop(150, 150);
test_image($src);

echo "<br>\n";

// quality examples

$src = Image::init('uploads/folder/antelope_canyon.jpg')->quality(100)->crop(250, 200);
test_image($src);

$src = Image::init('uploads/folder/antelope_canyon.jpg')->quality(50)->crop(250, 200);
test_image($src);

$src = Image::init('uploads/folder/antelope_canyon.jpg')->quality(10)->crop(250, 200);
test_image($src);

$src = Image::init('uploads/folder/floating_leaves.jpg')->quality(60)->fitHeight(200);
test_image($src);

echo "<br>\n";

// placeholder examples

$src = Image::init('uploads/not-found.jpeg')->crop(170, 150);
test_image($src . '?custom=1');
test_image($src);

$src = Image::init('uploads/not-found.gif')->silhouette()->noTopOffset()->crop(170, 150);
test_image($src);

$src = Image::init('uploads/not-found.png')->silhouette()->crop(110, 150);
test_image($src);

$src = Image::init('uploads/not-found.png')->disableAlpha()->bgColor('69f')->place(200, 150);
test_image($src);
test_image($src . '?custom=1');

echo "<br>\n";

// background examples

$src = Image::init('uploads/Apple.png')->fit(180, 150);
test_image($src);

$src = Image::init('uploads/Apple.png')->disableAlpha()->bgColor('3366cc')->place(150, 150);
test_image($src);

$src = Image::init('uploads/Apple.png')->disableAlpha()->bgColor('c36')->place(180, 150);
test_image($src);

echo "<br>\n";

// original size

$src = Image::init('uploads/cat.gif')->crop(100, 100);
test_image($src);

$src = Image::init('uploads/cat.gif')->disableCopy()->crop(100, 100);
test_image($src);

$src = Image::init('uploads/cat.gif')->skipSmall()->crop(50, 50);
test_image($src);

$src = Image::init('uploads/cat.gif')->skipSmall()->crop(150, 150);
test_image($src);

$src = Image::init('uploads/cat.gif')->skipSmall()->disableCopy()->crop(150, 150);
test_image($src);

echo "<br>\n";

// progressive jpeg

$src = Image::init('uploads/folder/antelope_canyon.jpg')->quality(99)->crop(640, 480);
test_image($src . '?progressive=1');

echo "<br>\n";

// force jpeg

$src = Image::init('uploads/Apple.png')->asJpeg()->quality(60)->place(320, 240);
test_image($src);

$src = Image::init('uploads/cat.gif')->asJpeg()->quality(80)->disableCopy()->fitWidth(100);
test_image($src);

$src = Image::init('uploads/Apple.png')->asJpeg()->quality(80)->fitWidth(100);
test_image($src);

$src = Image::init('uploads/Apple.png')->asJpeg()->quality(95)->bgColor('63c')->fitWidth(150);
test_image($src);

echo "<br>\n";

// check crop offset

$src = Image::init('uploads/petr.jpg')->crop(82, 100);
test_image($src);

$src = Image::init('uploads/petr.jpg')->crop(83, 100);
test_image($src);

$src = Image::init('uploads/petr.jpg')->crop(84, 100);
test_image($src);

$src = Image::init('uploads/petr.jpg')->crop(85, 100);
test_image($src);

$src = Image::init('uploads/petr.jpg')->crop(86, 100);
test_image($src);

echo "<br>\n";

// check place offset

$src = Image::init('uploads/petr.jpg')->place(81, 100);
test_image($src);

$src = Image::init('uploads/petr.jpg')->place(82, 100);
test_image($src);

$src = Image::init('uploads/petr.jpg')->place(83, 100);
test_image($src);

$src = Image::init('uploads/petr.jpg')->place(84, 100);
test_image($src);

$src = Image::init('uploads/petr.jpg')->place(85, 100);
test_image($src);

$src = Image::init('uploads/petr.jpg')->place(86, 100);
test_image($src);

$src = Image::init('uploads/petr.jpg')->place(87, 100);
test_image($src);

$src = Image::init('uploads/petr.jpg')->place(88, 100);
test_image($src);

echo "<br>\n";

// gifs

$src = Image::init('uploads/parrot.gif')->place(150, 150);
test_image($src);

$src = Image::init('uploads/parrot.gif')->disableAlpha()->bgColor('ddd')->place(150, 150);
test_image($src);

$src = Image::init('uploads/cs-137.gif')->place(150, 150);
test_image($src);

$src = Image::init('uploads/cs-137.gif')->disableAlpha()->place(150, 150);
test_image($src);

$src = Image::init('uploads/cs-137.gif')->noBottomOffset()->crop(300, 150);
test_image($src);

echo "<br>\n";

// exif rotate

$src = Image::init('uploads/exif/rlukeman_waterfall_1.jpg')->fitHeight(125);
test_image($src);

$src = Image::init('uploads/exif/rlukeman_waterfall_2.jpg')->fitHeight(125);
test_image($src);

$src = Image::init('uploads/exif/rlukeman_waterfall_3.jpg')->fitHeight(125);
test_image($src);

$src = Image::init('uploads/exif/rlukeman_waterfall_4.jpg')->fitHeight(125);
test_image($src);

$src = Image::init('uploads/exif/rlukeman_waterfall_5.jpg')->fitHeight(125);
test_image($src);

$src = Image::init('uploads/exif/rlukeman_waterfall_6.jpg')->fitHeight(125);
test_image($src);

$src = Image::init('uploads/exif/rlukeman_waterfall_7.jpg')->fitHeight(125);
test_image($src);

$src = Image::init('uploads/exif/rlukeman_waterfall_8.jpg')->fitHeight(125);
test_image($src);

echo "<br>\n";

// exif rotate disabled

$src = Image::init('uploads/exif/rlukeman_waterfall_1.jpg')->noExifRotate()->fitHeight(125);
test_image($src);

$src = Image::init('uploads/exif/rlukeman_waterfall_2.jpg')->noExifRotate()->fitHeight(125);
test_image($src);

$src = Image::init('uploads/exif/rlukeman_waterfall_3.jpg')->noExifRotate()->fitHeight(125);
test_image($src);

$src = Image::init('uploads/exif/rlukeman_waterfall_4.jpg')->noExifRotate()->fitHeight(125);
test_image($src);

$src = Image::init('uploads/exif/rlukeman_waterfall_5.jpg')->noExifRotate()->fitHeight(125);
test_image($src);

$src = Image::init('uploads/exif/rlukeman_waterfall_6.jpg')->noExifRotate()->fitHeight(125);
test_image($src);

$src = Image::init('uploads/exif/rlukeman_waterfall_7.jpg')->noExifRotate()->fitHeight(125);
test_image($src);

$src = Image::init('uploads/exif/rlukeman_waterfall_8.jpg')->noExifRotate()->fitHeight(125);
test_image($src);

?>
</body>
</html>
