# ImageResize

Image resizing library. Creates images on demand using GD or Imagick if installed.

## Install

Install through [Composer](http://getcomposer.org/):

```
composer require alexantr/image-resize
```

## Examples

Generate URL to resized image:

```php
use Alexantr\ImageResize\Image;

$src1 = (new Image('uploads/pic.jpg'))->crop(200, 200);
$src2 = (new Image('uploads/pic.jpg'))->silhouette()->quality(95)->fit(200, 200);
$src3 = (new Image('uploads/pic.jpg'))->fitWidth(200);
$src4 = (new Image('uploads/pic.jpg'))->fitHeight(200);
$src5 = (new Image('/site/uploads/pic.jpg'))->bgColor('6af')->fill(200, 200);
```

Or with `init()` static method:

```
<img src="<?= Image::init('uploads/pic.jpg')->crop(200, 200) ?>" alt="">
```

More examples in `example` folder.

## Configure Creator

Apache `.htaccess` example:

```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^resized/(.+)$ image.php?path=$1 [L,QSA]
```

nginx config example:

```
location ~ ^/resized/(.+)$ {
    try_files $uri $uri/ /image.php?path=$1&$args;
}
```

Example of `image.php`:

```php
require '../vendor/autoload.php';

$webroot = __DIR__;
$path = $_GET['path'] ?? '';

// custom defaults
//Alexantr\ImageResize\Creator::$defaultQuality = 70;
//Alexantr\ImageResize\Creator::$enableProgressiveJpeg = true;
//Alexantr\ImageResize\Creator::$imagickDisabled = true;

Alexantr\ImageResize\Creator::create($webroot, $path);
```
