<?php

require '../vendor/autoload.php';

$webroot = __DIR__;
$path = isset($_GET['path']) ? $_GET['path'] : '';

Alexantr\ImageResize\Creator::create($webroot, $path);
