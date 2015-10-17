ImageResize
===========

Image resizing library

Examples
--------

```php
use Alexantr\ImageResize\Image;

$src = Image::init('uploads/pic.jpg')->crop(200, 200);
$src = Image::init('uploads/pic.jpg')->silhouette()->quality(95)->fit(200, 200);
$src = Image::init('uploads/pic.jpg')->fitWidth(200);
$src = Image::init('uploads/pic.jpg')->fitHeight(200);
$src = Image::init('uploads/pic.jpg')->bgColor('6af')->place(200, 200);
```
For PHP >= 5.4:

```php
$src = (new Image('uploads/pic.jpg'))->crop(200, 200);
```

Creator example
---------------

.htacces file:

```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^resized/(.*)$ image.php?path=$1 [L]
```

image.php file:

```php
<?php
require '../vendor/autoload.php';

$webroot = __DIR__;
$path = isset($_GET['path']) ? $_GET['path'] : '';

Alexantr\ImageResize\Creator::create($webroot, $path);
```
