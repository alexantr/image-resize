<?php

use Alexantr\ImageResize\Helper;
use Alexantr\ImageResize\Image;

require '../vendor/autoload.php';

/**
 * img tag helper
 * @param $src
 */
function test_image($src, $title = '')
{
    $img = '<img src="' . htmlspecialchars($src, ENT_QUOTES, 'UTF-8') . '" alt="">';
    if ($title) {
        echo "<div class=\"img\">$img<br><small>$title</small></div>\n";
    } else {
        echo "<div class=\"img\">$img</div>\n";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>examples</title>
    <style>
        body { font: 100% sans-serif; margin: 0; padding: 1rem; }
        small { font: 80% monospace; color: gray; }
        img {
            border: 1px solid #999;
            background: url('data:image/gif;base64,R0lGODlhEAAQAIAAAP///+Li4iH5BAAAAAAALAAAAAAQABAAAAIfhG+hq4jM3IFLJhoswNly/XkcBpIiVaInlLJr9FZWAQA7') repeat 0 0;
        }
        table { border: 0; }
        table td { padding: 0 10px 0 0;}
        p { margin: 0 0 1rem; }
        .row {
            display: flex;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: .5em .2em;
            margin: 0 0 1.5rem;
        }
        .img img { vertical-align: top; }

    </style>
</head>
<body>

<p>crop(), fit(), fitWidth(), fitHeight(), fill()</p>

<div class="row">
<?php
$src = (new Image('uploads/folder/antelope_canyon.jpg'))->crop(150, 150);
test_image($src, 'crop(150, 150)');

$src = (new Image('uploads/Apple.png'))->bgColor('fff')->fit(200, 150);
test_image($src, "bgColor('fff')<br>-&gt;fit(200, 150)");

$src = (new Image('uploads/folder/floating_leaves.jpg'))->bgColor('fff')->fitWidth(200);
test_image($src, "bgColor('fff')<br>-&gt;fitWidth(200)");

$src = (new Image('uploads/Cat.jpeg'))->bgColor('fff')->fitHeight(150);
test_image($src, "bgColor('fff')<br>-&gt;fitHeight(150)");

$src = (new Image('uploads/Apple.png'))->bgColor('fff')->fill(200, 150);
test_image($src, "bgColor('fff')<br>-&gt;fill(200, 150)");
?>
</div>

<p>placeCenter()</p>

<div class="row">
<?php
$src = (new Image('uploads/parrot.gif'))->asWebp()->placeCenter(150, 150);
test_image($src, 'placeCenter(150, 150)');

$src = (new Image('uploads/petr.jpg'))->asWebp()->placeCenter(170, 150);
test_image($src, 'placeCenter(170, 150)');

$src = (new Image('uploads/Apple.png'))->asWebp()->bgColor('36f')->placeCenter(350, 150);
test_image($src, "bgColor('36f')<br>-&gt;placeCenter(350, 150)");
?>
</div>

<p>stretch()</p>

<div class="row">
<?php
$src = (new Image('uploads/Apple.png'))->stretch(200, 150);
test_image($src, 'stretch(200, 150)');

$src = (new Image('uploads/Apple.png'))->stretch(100, 150);
test_image($src, 'stretch(100, 150)');

$src = (new Image('uploads/petr.jpg'))->stretch(200, 150);
test_image($src, 'stretch(200, 150)');

$src = (new Image('uploads/folder/antelope_canyon.jpg'))->stretch(100, 150);
test_image($src, 'stretch(100, 150)');
?>
</div>

<p>max()</p>

<div class="row">
<?php
$src = (new Image('uploads/cs-137.gif'))->max(150, 150);
test_image($src, 'max(150, 150)');

$src = (new Image('uploads/Cat.jpeg'))->max(150, 150);
test_image($src, 'max(150, 150)');

$src = (new Image('uploads/Apple.png'))->max(150, 150);
test_image($src, 'max(150, 150)');

$src = (new Image('uploads/folder/antelope_canyon.jpg'))->max(150, 150);
test_image($src, 'max(150, 150)');
?>
</div>

<p>grayscale()<?= extension_loaded('imagick') ? ' with imagick' : '' ?></p>

<div class="row">
<?php
$src = (new Image('uploads/cs-137.gif'))->grayscale()->fit(150, 150);
test_image($src);

$src = (new Image('uploads/petr.jpg'))->grayscale()->fit(150, 150);
test_image($src);

$src = (new Image('uploads/Apple.png'))->grayscale()->fit(150, 150);
test_image($src);

$src = (new Image('uploads/folder/antelope_canyon.jpg'))->grayscale()->fit(150, 150);
test_image($src);

$src = (new Image('uploads/colorwheel.png'))->grayscale()->fit(150, 150);
test_image($src);
?>
</div>

<?php
if (extension_loaded('imagick')) {
    ?>
<p>grayscale() with gd</p>

<div class="row">
    <?php
    $src = (new Image('uploads/cs-137.gif'))->grayscale()->fit(150, 200);
    test_image($src . '?noimagick=1');

    $src = (new Image('uploads/petr.jpg'))->grayscale()->fit(200, 150);
    test_image($src . '?noimagick=1');

    $src = (new Image('uploads/Apple.png'))->grayscale()->fit(200, 150);
    test_image($src . '?noimagick=1');

    $src = (new Image('uploads/folder/antelope_canyon.jpg'))->grayscale()->fit(150, 200);
    test_image($src . '?noimagick=1');

    $src = (new Image('uploads/colorwheel.png'))->grayscale()->fit(200, 150);
    test_image($src . '?noimagick=1');
    ?>
</div>

    <?php
}
?>

<p>placeUpper(), noTopOffset(), noBottomOffset()</p>

<div class="row">
<?php
$src = (new Image('uploads/Cat.jpeg'))->crop(150, 150);
test_image($src);

$src = (new Image('uploads/Cat.jpeg'))->placeUpper()->crop(150, 150);
test_image($src, 'placeUpper()');

$src = (new Image('uploads/Cat.jpeg'))->noTopOffset()->crop(150, 150);
test_image($src, 'noTopOffset()');

$src = (new Image('uploads/Cat.jpeg'))->noBottomOffset()->crop(150, 150);
test_image($src, 'noBottomOffset()');

$src = (new Image('uploads/Apple.png'))->fill(100, 150);
test_image($src);

$src = (new Image('uploads/Apple.png'))->placeUpper()->fill(100, 150);
test_image($src, 'placeUpper()');

$src = (new Image('uploads/Apple.png'))->noTopOffset()->fill(100, 150);
test_image($src, 'noTopOffset()');

$src = (new Image('uploads/Apple.png'))->noBottomOffset()->fill(100, 150);
test_image($src, 'noBottomOffset()');
?>
</div>

<p>Jpeg quality</p>

<div class="row">
<?php
$src = (new Image('uploads/folder/antelope_canyon.jpg'))->quality(100)->crop(250, 200);
test_image($src, 'quality(100)');

$src = (new Image('uploads/folder/antelope_canyon.jpg'))->quality(50)->crop(250, 200);
test_image($src, 'quality(50)');

$src = (new Image('uploads/folder/antelope_canyon.jpg'))->quality(10)->crop(250, 200);
test_image($src, 'quality(10)');

$src = (new Image('uploads/folder/floating_leaves.jpg'))->quality(50)->fitHeight(200);
test_image($src, 'quality(50)');

$src = (new Image('uploads/folder/floating_leaves.jpg'))->quality(90)->fitHeight(200);
test_image($src, 'quality(90)');
?>
</div>

<p>Gif</p>

<div class="row">
<?php
$src = (new Image('uploads/parrot.gif'))->fill(150, 150);
test_image($src, 'animated transparent gif<br>must be transparent bg');

$src = (new Image('uploads/parrot.gif'))->bgColor('dce')->fill(150, 150);
test_image($src, "bgColor('dce')");

$src = (new Image('uploads/cs-137.gif'))->fill(150, 150);
test_image($src, 'opaque gif<br>must be transparent bg');

$src = (new Image('uploads/cs-137.gif'))->bgColor('fff')->fill(150, 150);
test_image($src, "bgColor('fff')");
?>
</div>

<p>Webp</p>

<div class="row">
<?php
$src = (new Image('uploads/webp/1_webp_a.webp'))->fitHeight(150);
test_image($src, 'transparent webp');

$src = (new Image('uploads/webp/1_webp_a.webp'))->quality(20)->fitHeight(150);
test_image($src, 'quality(20)');

$src = (new Image('uploads/webp/1_webp_a.webp'))->bgColor('69f')->quality(50)->fitHeight(150);
test_image($src, "bgColor('69f')<br>-&gt;quality(50)");

$src = (new Image('uploads/webp/yellow-rose-3.webp'))->fitHeight(150);
test_image($src, 'solid webp');

$src = (new Image('uploads/webp/yellow-rose-3.webp'))->quality(20)->fitHeight(150);
test_image($src, 'quality(20)');
?>
</div>

<p>Placeholder</p>

<div class="row">
<?php
$src = (new Image('uploads/not-found.jpeg'))->crop(180, 150);
test_image($src . '?custom=1', 'custom transparent placeholder');
test_image($src);

$src = (new Image('uploads/not-found.png'))->bgColor('69f')->fill(100, 150);
test_image($src, "bgColor('69f')<br>-&gt;fill(100, 150)");
test_image($src . '?custom=1', "bgColor('69f')<br>-&gt;fill(100, 150)");

$src = (new Image('uploads/not-found.png'))->placeCenter(200, 150);
test_image($src, 'placeCenter(200, 150)');

$src = (new Image('uploads/not-found.png'))->bgColor('777')->placeCenter(175, 150);
test_image($src . '?custom=1', "bgColor('777')<br>-&gt;placeCenter(175, 150)");

$src = (new Image('uploads/not-found.png'))->stretch(110, 150);
test_image($src, 'stretch(110, 150)');
?>
</div>

<p>silhouette()</p>

<div class="row">
<?php
$src = (new Image('uploads/not-found.gif'))->silhouette()->noTopOffset()->crop(220, 200);
test_image($src, 'silhouette()<br>-&gt;noTopOffset()<br>-&gt;crop(220, 200)');

$src = (new Image('uploads/not-found.png'))->silhouette()->crop(150, 200);
test_image($src, 'silhouette()<br>-&gt;crop(150, 200)');

$src = (new Image('uploads/not-found.png'))->silhouette()->stretch(150, 200);
test_image($src, 'silhouette()<br>-&gt;stretch(150, 200)');
?>
</div>

<p>bgColor()</p>

<div class="row">
<?php
$src = (new Image('uploads/Apple.png'))->bgColor('0000')->fit(180, 150);
test_image($src, "bgColor('0000')");

$src = (new Image('uploads/Apple.png'))->bgColor('0002')->fit(180, 150);
test_image($src, "bgColor('0002')");

$src = (new Image('uploads/Apple.png'))->bgColor('3366cc')->fill(150, 150);
test_image($src, "bgColor('3366cc')");

$src = (new Image('uploads/Apple.png'))->bgColor('356ecc59')->fill(180, 150);
test_image($src, "bgColor('356ecc59')");

$src = (new Image('uploads/Apple.png'))->bgColor('36cc')->fill(180, 150);
test_image($src, "bgColor('36cc')");

$src = (new Image('uploads/parrot.gif'))->bgColor('c365')->fill(180, 150);
test_image($src, "transparent gif<br>bgColor('c365')");

$src = (new Image('uploads/parrot.gif'))->bgColor('c36c')->fill(180, 150);
test_image($src, "transparent gif<br>bgColor('c36c')");
?>
</div>

<p>skipSmall(), disableCopy()</p>

<div class="row">
<?php
$src = (new Image('uploads/cat.gif'))->crop(100, 100);
test_image($src, 'image is 100x100<br>crop(100, 100)');

$src = (new Image('uploads/cat.gif'))->disableCopy()->crop(100, 100);
test_image($src, 'disableCopy()<br>-&gt;crop(100, 100)');

$src = (new Image('uploads/cat.gif'))->skipSmall()->crop(80, 80);
test_image($src, 'skipSmall()<br>-&gt;crop(80, 80)');

$src = (new Image('uploads/cat.gif'))->skipSmall()->crop(150, 150);
test_image($src, 'skipSmall()<br>-&gt;crop(150, 150)');

$src = (new Image('uploads/cat.gif'))->skipSmall()->disableCopy()->crop(150, 150);
test_image($src, 'skipSmall()<br>-&gt;disableCopy()<br>-&gt;crop(150, 150)');
?>
</div>

<p>absOffset()</p>

<div class="row">
<?php
$src = (new Image('uploads/Apple.png'))->absOffset(0, 0)->fill(150, 150);
test_image($src, 'absOffset(0, 0)');

$src = (new Image('uploads/Apple.png'))->absOffset(-20, 20)->fill(150, 150);
test_image($src, 'absOffset(-20, 20)');

$src = (new Image('uploads/Apple.png'))->absOffset(20, -20)->fill(150, 150);
test_image($src, 'absOffset(20, -20)');

$src = (new Image('uploads/Apple.png'))->bgColor('#fff')->asJpeg()->absOffset(0, 25)->fill(100, 150);
test_image($src, 'absOffset(0, 25)');

$src = (new Image('uploads/Apple.png'))->bgColor('#fff')->asJpeg()->absOffset(25, 0)->fill(200, 150);
test_image($src, 'absOffset(25, 0)');

$src = (new Image('uploads/not-found.png'))->absOffset(50, 50)->fill(150, 150);
test_image($src, 'absOffset(50, 50)');

$src = (new Image('uploads/not-found.png'))->silhouette()->absOffset(50, 50)->fill(150, 150);
test_image($src, 'absOffset(50, 50)');
?>
</div>

<p>Creator::$enableProgressiveJpeg = true</p>

<div class="row">
<?php
$src = (new Image('uploads/folder/antelope_canyon.jpg'))->quality(99)->crop(640, 480);
test_image($src . '?progressive=1');

$src = (new Image('uploads/folder/floating_leaves.jpg'))->quality(99)->crop(640, 480);
test_image($src . '?progressive=1');
?>
</div>

<p>asJpeg()</p>

<div class="row">
<?php
$src = (new Image('uploads/Apple.png'))->asJpeg()->quality(60)->fill(320, 240);
test_image($src);

$src = (new Image('uploads/cat.gif'))->asJpeg()->quality(80)->disableCopy()->fitWidth(100);
test_image($src);

$src = (new Image('uploads/parrot.gif'))->asJpeg()->quality(80)->bgColor('6c96')->fitWidth(150);
test_image($src);

$src = (new Image('uploads/Apple.png'))->asJpeg()->quality(95)->bgColor('63c')->fitWidth(150);
test_image($src);
?>
</div>

<p>asPng()</p>

<div class="row">
<?php
$src = (new Image('uploads/cat.gif'))->asPng()->bgColor('0005')->fill(200, 150);
test_image($src);

$src = (new Image('uploads/petr.jpg'))->asPng()->fitHeight(150);
test_image($src);

$src = (new Image('uploads/folder/floating_leaves.jpg'))->asPng()->fill(150, 150);
test_image($src);

$src = (new Image('uploads/cs-137.gif'))->asPng()->bgColor('63c')->fill(150, 150);
test_image($src);

$src = (new Image('uploads/webp/1_webp_a.webp'))->asPng()->fitHeight(150);
test_image($src);
?>
</div>

<p>asGif()</p>

<div class="row">
<?php
$src = (new Image('uploads/Apple.png'))->asGif()->fill(200, 150);
test_image($src);

$src = (new Image('uploads/petr.jpg'))->asGif()->bgColor('369c')->fill(200, 150);
test_image($src);

$src = (new Image('uploads/folder/antelope_canyon.jpg'))->asGif()->fitHeight(150);
test_image($src);

$src = (new Image('uploads/folder/floating_leaves.jpg'))->asGif()->fitHeight(150);
test_image($src);

$src = (new Image('uploads/colorwheel.png'))->asGif()->fitHeight(150);
test_image($src);
?>
</div>

<p>asWebp()</p>

<div class="row">
<?php
$src = (new Image('uploads/cat.gif'))->asWebp()->bgColor('0005')->quality(50)->fill(200, 150);
test_image($src);

$src = (new Image('uploads/petr.jpg'))->asWebp()->quality(50)->fitHeight(150);
test_image($src);

$src = (new Image('uploads/folder/floating_leaves.jpg'))->asWebp()->quality(50)->fill(150, 150);
test_image($src);

$src = (new Image('uploads/cs-137.gif'))->asWebp()->bgColor('f00')->fill(150, 150);
test_image($src);

$src = (new Image('uploads/colorwheel.png'))->asWebp()->quality(30)->fitHeight(150);
test_image($src);
?>
</div>

<p>Test crop()</p>

<div class="row">
<?php
$src = (new Image('uploads/petr.jpg'))->crop(82, 100);
test_image($src, 'crop(82, 100)');

$src = (new Image('uploads/petr.jpg'))->crop(83, 100);
test_image($src, 'crop(83, 100)');

$src = (new Image('uploads/petr.jpg'))->crop(84, 100);
test_image($src, 'crop(84, 100)');

$src = (new Image('uploads/petr.jpg'))->crop(85, 100);
test_image($src, 'crop(85, 100)');

$src = (new Image('uploads/petr.jpg'))->crop(86, 100);
test_image($src, 'crop(86, 100)');
?>
</div>

<p>Test fill()</p>

<div class="row">
<?php
$src = (new Image('uploads/petr.jpg'))->fill(81, 100);
test_image($src, 'fill(81, 100)');

$src = (new Image('uploads/petr.jpg'))->fill(82, 100);
test_image($src, 'fill(82, 100)');

$src = (new Image('uploads/petr.jpg'))->fill(83, 100);
test_image($src, 'fill(83, 100)');

$src = (new Image('uploads/petr.jpg'))->fill(84, 100);
test_image($src, 'fill(84, 100)');

$src = (new Image('uploads/petr.jpg'))->fill(85, 100);
test_image($src, 'fill(85, 100)');

$src = (new Image('uploads/petr.jpg'))->fill(86, 100);
test_image($src, 'fill(86, 100)');

$src = (new Image('uploads/petr.jpg'))->fill(87, 100);
test_image($src, 'fill(87, 100)');

$src = (new Image('uploads/petr.jpg'))->fill(88, 100);
test_image($src, 'fill(88, 100)');
?>
</div>

<p>Test exif rotate</p>

<div class="row">
<?php
$src = (new Image('uploads/exif/rlukeman_waterfall_1.jpg'))->fitHeight(125);
test_image($src);

$src = (new Image('uploads/exif/rlukeman_waterfall_2.jpg'))->fitHeight(125);
test_image($src);

$src = (new Image('uploads/exif/rlukeman_waterfall_3.jpg'))->fitHeight(125);
test_image($src);

$src = (new Image('uploads/exif/rlukeman_waterfall_4.jpg'))->fitHeight(125);
test_image($src);

$src = (new Image('uploads/exif/rlukeman_waterfall_5.jpg'))->fitHeight(125);
test_image($src);

$src = (new Image('uploads/exif/rlukeman_waterfall_6.jpg'))->fitHeight(125);
test_image($src);

$src = (new Image('uploads/exif/rlukeman_waterfall_7.jpg'))->fitHeight(125);
test_image($src);

$src = (new Image('uploads/exif/rlukeman_waterfall_8.jpg'))->fitHeight(125);
test_image($src);
?>
</div>

<p>noExifRotate()</p>

<div class="row">
<?php
$src = (new Image('uploads/exif/rlukeman_waterfall_1.jpg'))->noExifRotate()->fitHeight(125);
test_image($src);

$src = (new Image('uploads/exif/rlukeman_waterfall_2.jpg'))->noExifRotate()->fitHeight(125);
test_image($src);

$src = (new Image('uploads/exif/rlukeman_waterfall_3.jpg'))->noExifRotate()->fitHeight(125);
test_image($src);

$src = (new Image('uploads/exif/rlukeman_waterfall_4.jpg'))->noExifRotate()->fitHeight(125);
test_image($src);

$src = (new Image('uploads/exif/rlukeman_waterfall_5.jpg'))->noExifRotate()->fitHeight(125);
test_image($src);

$src = (new Image('uploads/exif/rlukeman_waterfall_6.jpg'))->noExifRotate()->fitHeight(125);
test_image($src);

$src = (new Image('uploads/exif/rlukeman_waterfall_7.jpg'))->noExifRotate()->fitHeight(125);
test_image($src);

$src = (new Image('uploads/exif/rlukeman_waterfall_8.jpg'))->noExifRotate()->fitHeight(125);
test_image($src);
?>
</div>

<p>Test URLs</p>

<?php
$urls = [
    // double "../"
    'uploads/folder/../../uploads/folder/floating_leaves.jpg',
    'uploads/./././folder/../Cat.jpeg',
    './uploads/cs-137.gif',
    'example/../uploads/petr.jpg',
    'uploads/parrot.gif?foo=bar',
    '../example/uploads/cat.gif#foobar',
    // variant with path relative to document root
    Helper::getBaseUrl() . '/uploads/Apple.png',
    // wrong url
    'folder/foo.bar',
    // wrong url - no extension
    'foobar',
];
?>

<table>
<?php foreach ($urls as $url): ?>
    <tr>
        <td>
            <?php
            $src = (new Image($url))->crop(99, 99);
            test_image($src);
            ?>
        </td>
        <td>
            Original: <code><?= $url ?></code><br>
            Filtered: <code><?= Helper::cleanImageUrl($url) ?></code>
        </td>
    </tr>
<?php endforeach; ?>
</table>

</body>
</html>
