<?php
require '../vendor/autoload.php';

$webroot = __DIR__;
$path = isset($_GET['path']) ? $_GET['path'] : '';

if (isset($_GET['custom'])) {
    Alexantr\ImageResize\Creator::$defaultImagePath = __DIR__ . '/no-photo.png';
}

if (isset($_GET['progressive'])) {
    Alexantr\ImageResize\Creator::$enableProgressiveJpeg = true;
}

Alexantr\ImageResize\Creator::create($webroot, $path);
