<?php

namespace Alexantr\ImageResize\Helpers;

use Alexantr\ImageResize\Creator;

class ImageHelper
{
    /**
     * @return string
     */
    public static function getBlankImageUrl()
    {
        return UrlHelper::getBaseUrl() . Creator::$resizedBaseDir . '/' . Creator::BLANK_IMAGE_NAME;
    }

    /**
     * @param int|string $quality
     *
     * @return int
     */
    public static function processQuality($quality)
    {
        $quality = (int)$quality;
        if ($quality > Creator::$maxQuality) {
            $quality = Creator::$maxQuality;
        }
        if ($quality < Creator::$minQuality) {
            $quality = Creator::$minQuality;
        }
        return $quality;
    }

    /**
     * @param string $hex
     *
     * @return string 3 or 6 signs
     */
    public static function processColor($hex)
    {
        $hex = str_replace('#', '', $hex);
        if (empty($hex) || !preg_match('/^([0-9a-f]{3}|[0-9a-f]{6})$/i', $hex)) {
            return Creator::$defaultBgColor;
        }
        if (preg_match('/^([0-9a-f])\1([0-9a-f])\2([0-9a-f])\3$/i', $hex, $m)) {
            return strtolower($m[1] . $m[2] . $m[3]);
        }
        return $hex;
    }

    /**
     * Clean url
     *
     * @param string $image_url
     *
     * @return string
     */
    public static function cleanImageUrl($image_url)
    {
        $image_url = str_replace('\\', '/', $image_url);
        $image_url = str_replace(array('../', '/./'), array('', '/'), $image_url);
        $image_url = preg_replace('{^\./}', '', $image_url);
        $image_url_exploded = explode('#', $image_url);
        $image_url_exploded = explode('?', $image_url_exploded[0]);
        $image_url = $image_url_exploded[0];
        if (strpos($image_url, '/') === 0) {
            $baseUrl = UrlHelper::getBaseUrl();
            if (!empty($baseUrl) && strpos($image_url, $baseUrl) === 0) {
                $image_url = mb_substr($image_url, mb_strlen($baseUrl));
            }
        }
        $image_url = ltrim($image_url, '/');
        return $image_url;
    }

    /**
     * Convert hex string to rgb array
     *
     * @param string $hex
     *
     * @return array
     */
    public static function hex2rgb($hex)
    {
        $hex = self::processColor($hex);
        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        return array('r' => $r, 'g' => $g, 'b' => $b);
    }

}
