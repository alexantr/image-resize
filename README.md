# ImageResize

Image resizing library. Creates images on demand using GD.

## Install

Install through [Composer](http://getcomposer.org/):

```
composer require alexantr/image-resize "~1.0"
```

## Examples

See full list of examples in `example` folder.

Creating URLs:

```php
use Alexantr\ImageResize\Image;

$src1 = Image::init('uploads/pic.jpg')->crop(200, 200);
$src2 = Image::init('uploads/pic.jpg')->silhouette()->quality(95)->fit(200, 200);
$src3 = Image::init('uploads/pic.jpg')->fitWidth(200);
$src4 = Image::init('uploads/pic.jpg')->fitHeight(200);
$src5 = Image::init('/site/uploads/pic.jpg')->bgColor('6af')->place(200, 200);
```

Can use class member access on instantiation in PHP 5.4 or higher:

```
<img src="<?= (new Image('uploads/pic.jpg'))->crop(200, 200) ?>" alt="">
```

## Creator example

Apache `.htacces` file:

```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^resized/(.*)$ image.php?path=$1 [L]
```

`image.php` in web root folder:

```php
require '../vendor/autoload.php';

$webroot = __DIR__;
$path = isset($_GET['path']) ? $_GET['path'] : '';

Alexantr\ImageResize\Creator::create($webroot, $path);
```
