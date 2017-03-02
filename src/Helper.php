<?php

namespace Alexantr\ImageResize;

class Helper
{
    /**
     * @return string
     */
    public static function getBlankImageUrl()
    {
        return self::getBaseUrl() . Creator::$resizedBaseDir . '/' . Creator::BLANK_IMAGE_NAME;
    }

    /**
     * @param int|string $quality
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
     * @param string $image_url
     * @return string
     */
    public static function cleanImageUrl($image_url)
    {
        $image_url = str_replace('\\', '/', $image_url);
        $image_url = preg_replace('{^\./}', '', $image_url);
        while (strpos($image_url, '/./') !== false) {
            $image_url = str_replace('/./', '/', $image_url); // remove "/./"
        }
        while (preg_match('{(^|/)[^/]+/\.\./}', $image_url)) {
            $image_url = preg_replace('{(^|/)[^/]+/\.\./}', '$1', $image_url); // remove "folder/../"
        }
        $image_url = preg_replace('{^\.\./[^/]+/}', '', $image_url); // remove "../folder/" from beginning
        $image_url_exploded = explode('#', $image_url);
        $image_url_exploded = explode('?', $image_url_exploded[0]);
        $image_url = $image_url_exploded[0];
        if (strpos($image_url, '/') === 0) {
            $baseUrl = self::getBaseUrl();
            if (!empty($baseUrl) && strpos($image_url, $baseUrl) === 0) {
                $image_url = mb_substr($image_url, mb_strlen($baseUrl));
            }
        }
        $image_url = ltrim($image_url, '/');
        return $image_url;
    }

    /**
     * Convert hex string to rgb array
     * @param string $hex
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

    /**
     * @var string base relative URL
     */
    private static $baseUrl;

    /**
     * Returns the relative URL for the application.
     * @return string Path without ending slash
     * @throws \Exception
     */
    public static function getBaseUrl()
    {
        if (self::$baseUrl === null) {
            $scriptFile = $_SERVER['SCRIPT_FILENAME'];
            $scriptName = basename($scriptFile);
            if (basename($_SERVER['SCRIPT_NAME']) === $scriptName) {
                $scriptUrl = $_SERVER['SCRIPT_NAME'];
            } elseif (basename($_SERVER['PHP_SELF']) === $scriptName) {
                $scriptUrl = $_SERVER['PHP_SELF'];
            } elseif (isset($_SERVER['ORIG_SCRIPT_NAME']) && basename($_SERVER['ORIG_SCRIPT_NAME']) === $scriptName) {
                $scriptUrl = $_SERVER['ORIG_SCRIPT_NAME'];
            } elseif (($pos = strpos($_SERVER['PHP_SELF'], '/' . $scriptName)) !== false) {
                $scriptUrl = substr($_SERVER['SCRIPT_NAME'], 0, $pos) . '/' . $scriptName;
            } elseif (!empty($_SERVER['DOCUMENT_ROOT']) && strpos($scriptFile, $_SERVER['DOCUMENT_ROOT']) === 0) {
                $scriptUrl = str_replace('\\', '/', str_replace($_SERVER['DOCUMENT_ROOT'], '', $scriptFile));
            } else {
                throw new \Exception('Unable to determine the entry script URL.');
            }
            self::$baseUrl = rtrim(dirname($scriptUrl), '\\/');
        }
        return self::$baseUrl;
    }
}
