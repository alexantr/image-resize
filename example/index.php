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

<p>Basic (crop, fit, fit width, fit height, fill)</p>

<?php
$src = Image::init('uploads/folder/antelope_canyon.jpg')->crop(150, 150);
test_image($src);

$src = Image::init('uploads/Apple.png')->bgColor('fff')->fit(200, 150);
test_image($src);

$src = Image::init('uploads/folder/floating_leaves.jpg')->bgColor('fff')->fitWidth(150);
test_image($src);

$src = Image::init('uploads/Cat.jpeg')->bgColor('fff')->fitHeight(150);
test_image($src);

$src = Image::init('uploads/Apple.png')->bgColor('fff')->fill(200, 150);
test_image($src);
?>

<p>Place center</p>

<?php
$src = Image::init('uploads/cat.gif')->bgColor('96f')->placeCenter(150, 150);
test_image($src);

$src = Image::init('uploads/cat.gif')->placeCenter(80, 150);
test_image($src);

$src = Image::init('uploads/petr.jpg')->placeCenter(170, 150);
test_image($src);

$src = Image::init('uploads/folder/floating_leaves.jpg')->bgColor('36f')->placeCenter(320, 150);
test_image($src);
?>

<p>Stretch</p>

<?php
$src = Image::init('uploads/Apple.png')->stretch(200, 150);
test_image($src);

$src = Image::init('uploads/Apple.png')->stretch(100, 150);
test_image($src);

$src = Image::init('uploads/petr.jpg')->stretch(200, 150);
test_image($src);

$src = Image::init('uploads/folder/floating_leaves.jpg')->stretch(100, 150);
test_image($src);
?>

<p>Fit max (150x150)</p>

<?php
$src = Image::init('uploads/cs-137.gif')->max(150, 150);
test_image($src);

$src = Image::init('uploads/Cat.jpeg')->max(150, 150);
test_image($src);

$src = Image::init('uploads/Apple.png')->max(150, 150);
test_image($src);

$src = Image::init('uploads/folder/antelope_canyon.jpg')->max(150, 150);
test_image($src);
?>

<p>Grayscale</p>

<?php
$src = Image::init('uploads/cs-137.gif')->grayscale()->fit(150, 150);
test_image($src);

$src = Image::init('uploads/petr.jpg')->grayscale()->fit(150, 150);
test_image($src);

$src = Image::init('uploads/Apple.png')->grayscale()->fit(150, 150);
test_image($src);

$src = Image::init('uploads/folder/antelope_canyon.jpg')->grayscale()->fit(150, 150);
test_image($src);

$src = Image::init('uploads/colorwheel.png')->grayscale()->fit(150, 150);
test_image($src);
?>

<p>Check URL</p>

<?php
// double "../"
$url = 'uploads/folder/../../uploads/folder/floating_leaves.jpg';
echo '<!-- ' . Helper::cleanImageUrl($url) . ' -->' . "\n";
$src = Image::init($url)->fitHeight(150);
test_image($src);

$src = Image::init('uploads/./././folder/../Cat.jpeg')->crop(150, 150);
test_image($src);

$src = Image::init('./uploads/cs-137.gif')->crop(150, 150);
test_image($src);

$src = Image::init('example/../uploads/petr.jpg')->crop(120, 150);
test_image($src);

$src = Image::init('uploads/parrot.gif?foo=bar')->bgColor('fff')->crop(190, 150);
test_image($src);

$src = Image::init('../example/uploads/cat.gif#foobar')->fitWidth(150);
test_image($src);

// variant with path relative to document root
$url = Helper::getBaseUrl() . '/uploads/Apple.png';
echo '<!-- ' . $url . ' -->' . "\n";
$src = Image::init($url)->fill(120, 150);
test_image($src);

// wrong url
$src = Image::init('folder/foo.bar')->crop(150, 150);
test_image($src);

// wrong url - no extension
$src = Image::init('foobar')->crop(150, 150);
test_image($src);
?>

<p>Vertical position</p>

<?php
$src = Image::init('uploads/Cat.jpeg')->crop(150, 150);
test_image($src);

$src = Image::init('uploads/Cat.jpeg')->placeUpper()->crop(150, 150);
test_image($src);

$src = Image::init('uploads/Cat.jpeg')->noTopOffset()->crop(150, 150);
test_image($src);

$src = Image::init('uploads/Cat.jpeg')->noBottomOffset()->crop(150, 150);
test_image($src);

$src = Image::init('uploads/Apple.png')->fill(100, 150);
test_image($src);

$src = Image::init('uploads/Apple.png')->placeUpper()->fill(100, 150);
test_image($src);

$src = Image::init('uploads/Apple.png')->noTopOffset()->fill(100, 150);
test_image($src);

$src = Image::init('uploads/Apple.png')->noBottomOffset()->fill(100, 150);
test_image($src);
?>

<p>Jpeg quality</p>

<?php
$src = Image::init('uploads/folder/antelope_canyon.jpg')->quality(100)->crop(250, 200);
test_image($src);

$src = Image::init('uploads/folder/antelope_canyon.jpg')->quality(50)->crop(250, 200);
test_image($src);

$src = Image::init('uploads/folder/antelope_canyon.jpg')->quality(10)->crop(250, 200);
test_image($src);

$src = Image::init('uploads/folder/floating_leaves.jpg')->quality(50)->fitHeight(200);
test_image($src);

$src = Image::init('uploads/folder/floating_leaves.jpg')->quality(90)->fitHeight(200);
test_image($src);
?>

<p>Gif</p>

<?php
$src = Image::init('uploads/parrot.gif')->fill(150, 150);
test_image($src);

$src = Image::init('uploads/parrot.gif')->bgColor('ddd')->fill(150, 150);
test_image($src);

$src = Image::init('uploads/cs-137.gif')->fill(150, 150);
test_image($src);

$src = Image::init('uploads/cs-137.gif')->bgColor('fff')->fill(150, 150);
test_image($src);

$src = Image::init('uploads/cs-137.gif')->noBottomOffset()->crop(300, 150);
test_image($src);
?>

<p>Placeholder</p>

<?php
$src = Image::init('uploads/not-found.jpeg')->crop(170, 150);
test_image($src . '?custom=1');
test_image($src);

$src = Image::init('uploads/not-found.gif')->silhouette()->noTopOffset()->crop(170, 150);
test_image($src);

$src = Image::init('uploads/not-found.png')->silhouette()->crop(110, 150);
test_image($src);

$src = Image::init('uploads/not-found.png')->bgColor('69f')->fill(100, 150);
test_image($src);
test_image($src . '?custom=1');

$src = Image::init('uploads/not-found.png')->placeCenter(200, 150);
test_image($src);

$src = Image::init('uploads/not-found.png')->bgColor('777')->placeCenter(175, 150);
test_image($src . '?custom=1');

$src = Image::init('uploads/not-found.png')->stretch(110, 150);
test_image($src);

$src = Image::init('uploads/not-found.png')->silhouette()->stretch(110, 150);
test_image($src);
?>

<p>Background</p>

<?php
$src = Image::init('uploads/Apple.png')->bgColor('0000')->fit(180, 150);
test_image($src);

$src = Image::init('uploads/Apple.png')->bgColor('0002')->fit(180, 150);
test_image($src);

$src = Image::init('uploads/Apple.png')->bgColor('3366cc')->fill(150, 150);
test_image($src);

$src = Image::init('uploads/Apple.png')->bgColor('356ecc59')->fill(180, 150);
test_image($src);

$src = Image::init('uploads/Apple.png')->bgColor('36cc')->fill(180, 150);
test_image($src);

$src = Image::init('uploads/parrot.gif')->bgColor('c365')->fill(180, 150);
test_image($src);

$src = Image::init('uploads/parrot.gif')->bgColor('c36c')->fill(180, 150);
test_image($src);
?>

<p>Skip small</p>

<?php
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
?>

<p>Progressive jpeg</p>

<?php
$src = Image::init('uploads/folder/antelope_canyon.jpg')->quality(99)->crop(640, 480);
test_image($src . '?progressive=1');

$src = Image::init('uploads/folder/floating_leaves.jpg')->quality(99)->crop(640, 480);
test_image($src . '?progressive=1');
?>

<p>Force jpeg</p>

<?php
$src = Image::init('uploads/Apple.png')->asJpeg()->quality(60)->fill(320, 240);
test_image($src);

$src = Image::init('uploads/cat.gif')->asJpeg()->quality(80)->disableCopy()->fitWidth(100);
test_image($src);

$src = Image::init('uploads/parrot.gif')->asJpeg()->quality(80)->bgColor('6c96')->fitWidth(150);
test_image($src);

$src = Image::init('uploads/Apple.png')->asJpeg()->quality(95)->bgColor('63c')->fitWidth(150);
test_image($src);
?>

<p>Force png</p>

<?php
$src = Image::init('uploads/cat.gif')->asPng()->bgColor('0005')->fill(200, 150);
test_image($src);

$src = Image::init('uploads/petr.jpg')->asPng()->fitHeight(150);
test_image($src);

$src = Image::init('uploads/folder/floating_leaves.jpg')->asPng()->fill(150, 150);
test_image($src);

$src = Image::init('uploads/cs-137.gif')->asPng()->bgColor('63c')->fill(150, 150);
test_image($src);
?>

<p>Force gif</p>

<?php
$src = Image::init('uploads/Apple.png')->asGif()->fill(200, 150);
test_image($src);

$src = Image::init('uploads/petr.jpg')->asGif()->bgColor('369c')->fill(200, 150);
test_image($src);

$src = Image::init('uploads/folder/antelope_canyon.jpg')->asGif()->fitHeight(150);
test_image($src);

$src = Image::init('uploads/folder/floating_leaves.jpg')->asGif()->fitHeight(150);
test_image($src);

$src = Image::init('uploads/colorwheel.png')->asGif()->fitHeight(150);
test_image($src);
?>

<p>Check crop offset</p>

<?php
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
?>

<p>Check fill offset</p>

<?php
$src = Image::init('uploads/petr.jpg')->fill(81, 100);
test_image($src);

$src = Image::init('uploads/petr.jpg')->fill(82, 100);
test_image($src);

$src = Image::init('uploads/petr.jpg')->fill(83, 100);
test_image($src);

$src = Image::init('uploads/petr.jpg')->fill(84, 100);
test_image($src);

$src = Image::init('uploads/petr.jpg')->fill(85, 100);
test_image($src);

$src = Image::init('uploads/petr.jpg')->fill(86, 100);
test_image($src);

$src = Image::init('uploads/petr.jpg')->fill(87, 100);
test_image($src);

$src = Image::init('uploads/petr.jpg')->fill(88, 100);
test_image($src);
?>

<p>Exif rotate</p>

<?php
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
?>

<p>Exif rotate disabled</p>

<?php
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
