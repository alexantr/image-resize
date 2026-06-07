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
    protected string $imageUrl;
    /**
     * @var int default jpeg or webp quality
     */
    protected int $quality;
    /**
     * @var string background color
     */
    protected string $bgColor;
    /**
     * @var bool use silhouette placeholder for missing images
     */
    protected bool $silhouette = false;
    /**
     * @var bool place image 2/3 upper for portraits. Do not work with enabled noTopOffset, noBottomOffset
     */
    protected bool $placeUpper = false;
    /**
     * @var bool crop images w/o top offset
     */
    protected bool $noTopOffset = false;
    /**
     * @var bool crop images w/o bottom offset
     */
    protected bool $noBottomOffset = false;
    /**
     * @var bool do not resize images with smaller width and height (just copy)
     */
    protected bool $skipSmall = false;
    /**
     * @var bool disable copying images
     */
    protected bool $disableCopy = false;
    /**
     * @var bool force saving to jpeg
     */
    protected bool $asJpeg = false;
    /**
     * @var bool force saving to png
     */
    protected bool $asPng = false;
    /**
     * @var bool force saving to gif
     */
    protected bool $asGif = false;
    /**
     * @var bool force saving to webp
     */
    protected bool $asWebp = false;
    /**
     * @var bool disable autorotating based on EXIF data
     */
    protected bool $noExifRotate = false;
    /**
     * @var bool grayscale filter
     */
    protected bool $grayscale = false;
    /**
     * @var int[] absolute offset in pixels (x px, y px)
     */
    protected array $absOffset = [0, 0];

    /**
     * @param string $imageUrl
     * @return self
     */
    public static function init(string $imageUrl)
    {
        return new static($imageUrl);
    }

    /**
     * @param string $imageUrl
     */
    public function __construct(string $imageUrl)
    {
        $this->imageUrl = $imageUrl;
        $this->quality = Creator::$defaultQuality;
        $this->bgColor = Creator::$defaultBgColor;
    }

    /**
     * Set jpeg or webp quality
     * @param int|string $quality
     * @return $this
     */
    public function quality(int|string $quality)
    {
        $this->quality = Helper::processQuality($quality);
        return $this;
    }

    /**
     * Set background color
     * @param string $hex
     * @return $this
     */
    public function bgColor(string $hex)
    {
        $this->bgColor = Helper::normalizeHexColor($hex);
        return $this;
    }

    /**
     * Enable displaying silhouette for missing images
     * @param bool|true $value
     * @return $this
     */
    public function silhouette(bool $value = true)
    {
        $this->silhouette = $value;
        return $this;
    }

    /**
     * Place image 2/3 upper for portraits. Works with crop().
     * Don't working with enabled noTopOffset, noBottomOffset.
     * @param bool|true $value
     * @return $this
     */
    public function placeUpper(bool $value = true)
    {
        $this->placeUpper = $value;
        return $this;
    }

    /**
     * Disable top offset while cropping
     * @param bool|true $value
     * @return $this
     */
    public function noTopOffset(bool $value = true)
    {
        $this->noTopOffset = $value;
        return $this;
    }

    /**
     * Disable bottom offset while cropping
     * @param bool|true $value
     * @return $this
     */
    public function noBottomOffset(bool $value = true)
    {
        $this->noBottomOffset = $value;
        return $this;
    }

    /**
     * Disable resizing smaller images
     * @param bool|true $value
     * @return $this
     */
    public function skipSmall(bool $value = true)
    {
        $this->skipSmall = $value;
        return $this;
    }

    /**
     * Disable copying images with identical sizes
     * @param bool|true $value
     * @return $this
     */
    public function disableCopy(bool $value = true)
    {
        $this->disableCopy = $value;
        return $this;
    }

    /**
     * Force saving all to jpeg
     * @param bool|true $value
     * @return $this
     */
    public function asJpeg(bool $value = true)
    {
        $this->asJpeg = $value;
        return $this;
    }

    /**
     * Force saving all to png
     * @param bool|true $value
     * @return $this
     */
    public function asPng(bool $value = true)
    {
        $this->asPng = $value;
        return $this;
    }

    /**
     * Force saving all to gif
     * @param bool|true $value
     * @return $this
     */
    public function asGif(bool $value = true)
    {
        $this->asGif = $value;
        return $this;
    }

    /**
     * Force saving all to webp
     * @param bool|true $value
     * @return $this
     */
    public function asWebp(bool $value = true)
    {
        $this->asWebp = $value;
        return $this;
    }

    /**
     * Disable autorotating based on EXIF data
     * @param bool|true $value
     * @return $this
     */
    public function noExifRotate(bool $value = true)
    {
        $this->noExifRotate = $value;
        return $this;
    }

    /**
     * Add grayscale filter
     * @param bool|true $value
     * @return $this
     */
    public function grayscale(bool $value = true)
    {
        $this->grayscale = $value;
        return $this;
    }

    /**
     * Add absolute offset in pixels (x px, y px)
     * @param int $x
     * @param int $y
     * @return $this
     */
    public function absOffset(int $x = 0, int $y = 0)
    {
        $this->absOffset = [(int)$x, (int)$y];
        return $this;
    }

    /**
     * Crop
     * @param int $width
     * @param int $height
     * @return string
     */
    public function crop(int $width, int $height): string
    {
        return $this->resize(Creator::FIT_CROP, $width, $height);
    }

    /**
     * Fit contain
     * @param int $width
     * @param int $height
     * @return string
     */
    public function fit(int $width, int $height): string
    {
        return $this->resize(Creator::FIT_CONTAIN, $width, $height);
    }

    /**
     * Fit width
     * @param int $width
     * @return string
     */
    public function fitWidth(int $width): string
    {
        return $this->resize(Creator::FIT_WIDTH, $width, $width);
    }

    /**
     * Fit height
     * @param int $height
     * @return string
     */
    public function fitHeight(int $height): string
    {
        return $this->resize(Creator::FIT_HEIGHT, $height, $height);
    }

    /**
     * Fit fill
     * @param int $width
     * @param int $height
     * @return string
     */
    public function fill(int $width, int $height): string
    {
        return $this->resize(Creator::FIT_FILL, $width, $height);
    }

    /**
     * Fit max
     * @param int $width
     * @param int $height
     * @return string
     */
    public function max(int $width, int $height): string
    {
        return $this->resize(Creator::FIT_MAX, $width, $height);
    }

    /**
     * Fit stretch
     * @param int $width
     * @param int $height
     * @return string
     */
    public function stretch(int $width, int $height): string
    {
        return $this->resize(Creator::FIT_STRETCH, $width, $height);
    }

    /**
     * Place center
     * @param int $width
     * @param int $height
     * @return string
     */
    public function placeCenter(int $width, int $height): string
    {
        return $this->resize(Creator::PLACE_CENTER, $width, $height);
    }

    /**
     * Resize - base method
     * @param string $method
     * @param int $width
     * @param int $height
     * @return string
     */
    public function resize(string $method, int $width, int $height): string
    {
        $width = (int)$width;
        $height = (int)$height;

        // wrong params
        if (
            empty($this->imageUrl) ||
            $width < Creator::$minSize || $height < Creator::$minSize ||
            $width > Creator::$maxSize || $height > Creator::$maxSize ||
            !\in_array($method, Creator::$methods)
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
        if (empty($dest_ext) || !\in_array($dest_ext, ['jpeg', 'jpg', 'png', 'gif', 'webp'])) {
            return Helper::getBlankImageUrl();
        }

        // force format
        if ($this->asJpeg) {
            if (!\in_array($dest_ext, ['jpeg', 'jpg'])) {
                $image_url .= '.jpg';
            } else {
                $this->asJpeg = false;
            }
            $this->asPng = false;
            $this->asGif = false;
            $this->asWebp = false;
        } elseif ($this->asPng) {
            if ($dest_ext != 'png') {
                $image_url .= '.png';
            } else {
                $this->asPng = false;
            }
            $this->asJpeg = false;
            $this->asGif = false;
            $this->asWebp = false;
        } elseif ($this->asGif) {
            if ($dest_ext != 'gif') {
                $image_url .= '.gif';
            } else {
                $this->asGif = false;
            }
            $this->asJpeg = false;
            $this->asPng = false;
            $this->asWebp = false;
        } elseif ($this->asWebp) {
            if ($dest_ext != 'webp') {
                $image_url .= '.webp';
            } else {
                $this->asWebp = false;
            }
            $this->asJpeg = false;
            $this->asPng = false;
            $this->asGif = false;
        }

        $can_y_offset = $method == Creator::FIT_CROP || $method == Creator::FIT_FILL;

        // set dir name with all params
        $resized_dir = "{$width}-{$height}-{$method}";
        $resized_dir .= $this->quality !== Creator::$defaultQuality ? "-q{$this->quality}" : '';
        $resized_dir .= $this->bgColor !== Creator::$defaultBgColor ? "-{$this->bgColor}" : '';
        // additional params
        $params = $this->silhouette ? 's' : '';
        $params .= $this->asJpeg ? 'j' : ($this->asPng ? 'p' : ($this->asGif ? 'f' : ($this->asWebp ? 'w' : '')));
        $params .= $can_y_offset && !$this->noTopOffset && !$this->noBottomOffset && $this->placeUpper ? 'u' : '';
        $params .= $can_y_offset && $this->noTopOffset ? 'n' : '';
        $params .= $can_y_offset && !$this->noTopOffset && $this->noBottomOffset ? 'b' : '';
        $params .= $this->disableCopy ? 'c' : '';
        $params .= !$this->disableCopy && $this->skipSmall ? 't' : '';
        $params .= $this->noExifRotate ? 'r' : '';
        $params .= $this->grayscale ? 'g' : '';
        // offset
        if ($this->absOffset[0] !== 0 || $this->absOffset[1] !== 0) {
            $offset_params = 'o';
            if ($this->absOffset[0] > 0) {
                $offset_params .= \sprintf('l%d', $this->absOffset[0]);
            } elseif ($this->absOffset[0] < 0) {
                $offset_params .= \sprintf('r%d', abs($this->absOffset[0]));
            }
            if ($this->absOffset[1] > 0) {
                $offset_params .= \sprintf('t%d', $this->absOffset[1]);
            } elseif ($this->absOffset[1] < 0) {
                $offset_params .= \sprintf('b%d', abs($this->absOffset[1]));
            }
            $params .= (!empty($params) ? '-' : '') . $offset_params;
        }
        $resized_dir .= !empty($params) ? '-' . $params : '';

        return Helper::getBaseUrl() . Creator::$resizedBaseDir . '/' . $resized_dir . '/' . $image_url;
    }
}
