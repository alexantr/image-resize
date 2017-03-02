<?php
require '../vendor/autoload.php';

use Alexantr\ImageResize\Helper;
use Alexantr\ImageResize\Image;

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

$src = Image::init('uploads/folder/antelope_canyon.jpg')->quality(80)->crop(640, 480);
test_image($src . '?progressive=1');

echo "<br>\n";

// force jpeg

$src = Image::init('uploads/Apple.png')->asJpeg()->quality(60)->place(320, 240);
test_image($src);

$src = Image::init('uploads/cat.gif')->asJpeg()->quality(80)->disableCopy()->fitWidth(100);
test_image($src);

/**
 * img tag helper
 * @param $src
 */
function test_image($src)
{
    echo '<img src="' . $src . '" alt="" style="border: 1px solid #000;">' . "\n";
}
