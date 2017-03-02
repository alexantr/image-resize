<?php

namespace Alexantr\ImageResize;

/**
 * Create URL for ImageCreator
 */
class Image
{
    /**
     * @var string image path relative to site base path
     */
    protected $imageUrl;

    /**
     * @var int default jpeg quality
     */
    protected $quality;

    /**
     * @var string background color
     */
    protected $bgColor;

    /**
     * @var bool use silhouette placeholder for missing images
     */
    protected $silhouette = false;

    /**
     * @var bool disable alpha channel for png and gif
     */
    protected $disableAlpha = false;

    /**
     * @var bool place image 2/3 upper for portraits. Do not work with enabled noTopOffset, noBottomOffset
     */
    protected $placeUpper = false;

    /**
     * @var bool crop images w/o top offset
     */
    protected $noTopOffset = false;

    /**
     * @var bool crop images w/o bottom offset
     */
    protected $noBottomOffset = false;

    /**
     * @var bool do not resize images with smaller width and height (just copy)
     */
    protected $skipSmall = false;

    /**
     * @var bool disable copying images
     */
    protected $disableCopy = false;

    /**
     * @var bool force saving to jpeg
     */
    protected $asJpeg = false;

    /**
     * @param string $imageUrl
     * @return self
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
     * @param int|string $quality
     * @return $this
     */
    public function quality($quality)
    {
        $this->quality = Helper::processQuality($quality);
        return $this;
    }

    /**
     * Set background color
     * @param string $hex
     * @return $this
     */
    public function bgColor($hex)
    {
        $this->bgColor = Helper::processColor($hex);
        return $this;
    }

    /**
     * Enable displaying silhouette for missing images
     * @param bool|true $value
     * @return $this
     */
    public function silhouette($value = true)
    {
        $this->silhouette = $value;
        return $this;
    }

    /**
     * Disable transparency for png
     * @param bool|true $value
     * @return $this
     */
    public function disableAlpha($value = true)
    {
        $this->disableAlpha = $value;
        return $this;
    }

    /**
     * Place image 2/3 upper for portraits. Works with crop().
     * Don't working with enabled noTopOffset, noBottomOffset.
     * @param bool|true $value
     * @return $this
     */
    public function placeUpper($value = true)
    {
        $this->placeUpper = $value;
        return $this;
    }

    /**
     * Disable top offset while cropping
     * @param bool|true $value
     * @return $this
     */
    public function noTopOffset($value = true)
    {
        $this->noTopOffset = $value;
        return $this;
    }

    /**
     * Disable bottom offset while cropping
     * @param bool|true $value
     * @return $this
     */
    public function noBottomOffset($value = true)
    {
        $this->noBottomOffset = $value;
        return $this;
    }

    /**
     * Disable resizing smaller images
     * @param bool|true $value
     * @return $this
     */
    public function skipSmall($value = true)
    {
        $this->skipSmall = $value;
        return $this;
    }

    /**
     * Disable copying images with identical sizes
     * @param bool|true $value
     * @return $this
     */
    public function disableCopy($value = true)
    {
        $this->disableCopy = $value;
        return $this;
    }

    /**
     * Force saving PNGs and GIFs to jpeg
     * @param bool|true $value
     * @return $this
     */
    public function asJpeg($value = true)
    {
        $this->asJpeg = $value;
        return $this;
    }

    /**
     * Crop
     * @param int $width
     * @param int $height
     * @return string
     */
    public function crop($width, $height)
    {
        return $this->resize('crop', $width, $height);
    }

    /**
     * Fit
     * @param int $width
     * @param int $height
     * @return string
     */
    public function fit($width, $height)
    {
        return $this->resize('fit', $width, $height);
    }

    /**
     * Fit width
     * @param int $width
     * @return string
     */
    public function fitWidth($width)
    {
        return $this->resize('fitw', $width, $width);
    }

    /**
     * Fit height
     * @param int $height
     * @return string
     */
    public function fitHeight($height)
    {
        return $this->resize('fith', $height, $height);
    }

    /**
     * Place
     * @param int $width
     * @param int $height
     * @return string
     */
    public function place($width, $height)
    {
        return $this->resize('place', $width, $height);
    }

    /**
     * Resize - base method
     * @param string $method
     * @param int $width
     * @param int $height
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
            return Helper::getBlankImageUrl();
        }

        // absolute link
        if (preg_match('{^(https?:)?//}', $this->imageUrl)) {
            return $this->imageUrl;
        }

        // clean url
        $image_url = Helper::cleanImageUrl($this->imageUrl);
        if (empty($image_url)) {
            Helper::getBlankImageUrl();
        }

        // check extension
        $dest_ext = pathinfo($image_url, PATHINFO_EXTENSION);
        $dest_ext = strtolower($dest_ext);
        if (empty($dest_ext) || !in_array($dest_ext, array('jpeg', 'jpg', 'png', 'gif'))) {
            return Helper::getBlankImageUrl();
        }

        // force jpeg
        if ($this->asJpeg) {
            if (!in_array($dest_ext, array('jpeg', 'jpg'))) {
                $image_url .= '.jpg';
            } else {
                $this->asJpeg = false;
            }
        }

        // set dir name with all params
        $resized_dir = "{$width}-{$height}-{$method}";
        $resized_dir .= ($this->quality != Creator::$defaultQuality ? "-q{$this->quality}" : '');
        $resized_dir .= (($this->disableAlpha || $method == 'place') && $this->bgColor != Creator::$defaultBgColor ? "-{$this->bgColor}" : '');
        // additional params
        $params = '';
        $params .= ($this->silhouette ? 's' : '');
        $params .= ($this->disableAlpha ? 'a' : '');
        $params .= ($this->asJpeg ? 'j' : '');
        $params .= ($method == 'crop' && !$this->noTopOffset && !$this->noBottomOffset && $this->placeUpper ? 'u' : '');
        $params .= ($method == 'crop' && $this->noTopOffset ? 'n' : '');
        $params .= ($method == 'crop' && !$this->noTopOffset && $this->noBottomOffset ? 'b' : '');
        $params .= ($this->disableCopy ? 'c' : '');
        $params .= (!$this->disableCopy && $this->skipSmall ? 't' : '');
        $resized_dir .= (!empty($params) ? '-' . $params : '');

        return Helper::getBaseUrl() . Creator::$resizedBaseDir . '/' . $resized_dir . '/' . $image_url;
    }
}
