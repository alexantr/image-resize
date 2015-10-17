<?php

namespace Alexantr\ImageResize;

use Alexantr\ImageResize\Helpers\ImageHelper;
use Alexantr\ImageResize\Helpers\UrlHelper;

/**
 * Create URL for ImageCreator
 */
class Image
{
    /**
     * @var string image path relative to site base path
     */
    private $imageUrl;

    /**
     * @var int default jpeg quality
     */
    private $quality;

    /**
     * @var string background color
     */
    private $bgColor;

    /**
     * @var bool use silhouette placeholder for missing images
     */
    private $silhouette = false;

    /**
     * @var bool disable alpha channel for png and gif
     */
    private $disableAlpha = false;

    /**
     * @var bool crop images w/o top offset
     */
    private $noTopOffset = false;

    /**
     * @param string $imageUrl
     *
     * @return Image
     */
    public static function init($imageUrl)
    {
        return new static($imageUrl);
    }

    /**
     * @param string $imageUrl
     */
    public function __construct($imageUrl)
    {
        $this->imageUrl = $imageUrl;
        $this->quality = Creator::$defaultQuality;
        $this->bgColor = Creator::$defaultBgColor;
    }

    /**
     * Set jpeg quality
     *
     * @param int|string $quality
     *
     * @return $this
     */
    public function quality($quality)
    {
        $this->quality = ImageHelper::processQuality($quality);
        return $this;
    }

    /**
     * Set background color
     *
     * @param string $hex
     *
     * @return $this
     */
    public function bgColor($hex)
    {
        $this->bgColor = ImageHelper::processColor($hex);
        return $this;
    }

    /**
     * Enable displaying silhouette for missing images
     *
     * @param bool $value
     *
     * @return $this
     */
    public function silhouette($value = true)
    {
        $this->silhouette = $value;
        return $this;
    }

    /**
     * Disable transparency for png
     *
     * @param bool $value
     *
     * @return $this
     */
    public function disableAlpha($value = true)
    {
        $this->disableAlpha = $value;
        return $this;
    }

    /**
     * Disable top offset while cropping
     *
     * @param bool $value
     *
     * @return $this
     */
    public function noTopOffset($value = true)
    {
        $this->noTopOffset = $value;
        return $this;
    }

    /**
     * Crop
     *
     * @param int $width
     * @param int $height
     *
     * @return string
     */
    public function crop($width, $height)
    {
        return $this->resize('crop', $width, $height);
    }

    /**
     * Fit
     *
     * @param int $width
     * @param int $height
     *
     * @return string
     */
    public function fit($width, $height)
    {
        return $this->resize('fit', $width, $height);
    }

    /**
     * Fit width
     *
     * @param int $width
     *
     * @return string
     */
    public function fitWidth($width)
    {
        return $this->resize('fitw', $width, $width);
    }

    /**
     * Fit height
     *
     * @param int $height
     *
     * @return string
     */
    public function fitHeight($height)
    {
        return $this->resize('fith', $height, $height);
    }

    /**
     * Place
     *
     * @param int $width
     * @param int $height
     *
     * @return string
     */
    public function place($width, $height)
    {
        return $this->resize('place', $width, $height);
    }

    /**
     * Resize - base method
     *
     * @param string $method
     * @param int $width
     * @param int $height
     *
     * @return string
     */
    public function resize($method, $width, $height)
    {
        $width = (int)$width;
        $height = (int)$height;

        // wrong params
        if (
            empty($this->imageUrl) ||
            $width < Creator::$minSize || $height < Creator::$minSize ||
            $width > Creator::$maxSize || $height > Creator::$maxSize ||
            !in_array($method, Creator::$methods)
        ) {
            return ImageHelper::getBlankImageUrl();
        }

        // absolute link
        if (preg_match('{^(https?:)?//}', $this->imageUrl)) {
            return $this->imageUrl;
        }

        // clean url
        $image_url = ImageHelper::cleanImageUrl($this->imageUrl);
        if (empty($image_url)) {
            ImageHelper::getBlankImageUrl();
        }

        // get pathinfo
        $destPathInfo = pathinfo($image_url);

        // check extension
        $destExt = strtolower($destPathInfo['extension']);
        if (empty($destExt) || !in_array($destExt, array('jpeg', 'jpg', 'png', 'gif'))) {
            return ImageHelper::getBlankImageUrl();
        }

        // set dir name with all params
        $resizedDir = "{$width}-{$height}-{$method}";
        $resizedDir .= ($this->quality != Creator::$defaultQuality ? "-q{$this->quality}" : '');
        $resizedDir .= (($this->disableAlpha || $method == 'place') && $this->bgColor != Creator::$defaultBgColor ? "-{$this->bgColor}" : '');
        // additional params
        $params = '';
        $params .= $this->silhouette ? 's' : '';
        $params .= $this->disableAlpha ? 'a' : '';
        $params .= $this->noTopOffset ? 'n' : '';
        $resizedDir .= (!empty($params) ? '-' . $params : '');

        return UrlHelper::getBaseUrl() . Creator::$resizedBaseDir. '/' . $resizedDir . '/' . $image_url;
    }
}