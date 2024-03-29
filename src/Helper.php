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
     * @return string 3, 4, 6 or 8 signs
     */
    public static function normalizeHexColor($hex)
    {
        $hex = str_replace('#', '', $hex);
        if (empty($hex) || !preg_match('/^([0-9a-f]{3}|[0-9a-f]{4}|[0-9a-f]{6}|[0-9a-f]{8})$/i', $hex)) {
            return Creator::$defaultBgColor;
        }
        if (preg_match('/^([0-9a-f])\1([0-9a-f])\2([0-9a-f])\3([0-9a-f])\4$/i', $hex, $m)) {
            return strtolower($m[1] . $m[2] . $m[3] . $m[4]);
        }
        if (preg_match('/^([0-9a-f])\1([0-9a-f])\2([0-9a-f])\3$/i', $hex, $m)) {
            return strtolower($m[1] . $m[2] . $m[3]);
        }
        return strtolower($hex);
    }

    /**
     * Get params from path
     * @param string $path
     * @return array|bool
     */
    public static function parsePath($path)
    {
        $methods = implode('|', Creator::$methods);
        if (preg_match('{^(([0-9]{1,4})-([0-9]{1,4})-(' . $methods . ')(?:-q([0-9]{1,2}|100))?(?:-([a-f0-9]{3}|[a-f0-9]{4}|[a-f0-9]{6}|[a-f0-9]{8}))?(?:-([a-z]+))?(?:-o([lr][0-9]+)?([tb][0-9]+)?)?)/(.+)}', $path, $m)) {
            $params = $m[7];
            $params = str_split($params);
            // abs offset
            $abs_offset = array(0, 0);
            $offset_x_param = isset($m[8]) ? $m[8] : '';
            $offset_y_param = isset($m[9]) ? $m[9] : '';
            if ($offset_x_param !== '') {
                $offset_x_param_dir = substr($offset_x_param, 0, 1);
                $offset_x_param_value = (int)substr($offset_x_param, 1);
                $abs_offset[0] = $offset_x_param_dir == 'r' ? -$offset_x_param_value : $offset_x_param_value;
            }
            if ($offset_y_param !== '') {
                $offset_y_param_dir = substr($offset_y_param, 0, 1);
                $offset_y_param_value = (int)substr($offset_y_param, 1);
                $abs_offset[1] = $offset_y_param_dir == 'b' ? -$offset_y_param_value : $offset_y_param_value;
            }
            return array(
                'dir_name' => $m[1],
                'width' => (int)$m[2],
                'height' => (int)$m[3],
                'method' => $m[4],
                'quality' => ($m[5] !== '' ? Helper::processQuality($m[5]) : Creator::$defaultQuality),
                'bg_color' => Helper::normalizeHexColor($m[6]),
                'silhouette' => in_array('s', $params),
                'as_jpeg' => in_array('j', $params),
                'as_png' => in_array('p', $params),
                'as_gif' => in_array('f', $params),
                'as_webp' => in_array('w', $params),
                'place_upper' => in_array('u', $params),
                'no_top_offset' => in_array('n', $params),
                'no_bottom_offset' => in_array('b', $params),
                'disable_copy' => in_array('c', $params),
                'skip_small' => in_array('t', $params),
                'no_exif_rotate' => in_array('r', $params),
                'grayscale' => in_array('g', $params),
                'abs_offset' => $abs_offset,
                'image_url' => trim($m[10]),
            );
        } else {
            return false;
        }
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
        $hex = self::normalizeHexColor($hex);
        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
            $a = 255;
        } elseif (strlen($hex) == 4) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
            $a = hexdec(substr($hex, 3, 1) . substr($hex, 3, 1));
        } elseif (strlen($hex) == 8) {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
            $a = hexdec(substr($hex, 6, 2));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
            $a = 255;
        }
        return array('r' => $r, 'g' => $g, 'b' => $b, 'a' => $a);
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

    /**
     * @param resource $image
     */
    public static function flopImage($image)
    {
        if (function_exists('imageflip') && defined('IMG_FLIP_HORIZONTAL')) {
            imageflip($image, IMG_FLIP_HORIZONTAL);
        } else {
            $max_x = imagesx($image) - 1;
            $half_x = $max_x / 2;
            $sy = imagesy($image);
            $temp_image = imageistruecolor($image) ? imagecreatetruecolor(1, $sy) : imagecreate(1, $sy);
            for ($x = 0; $x < $half_x; ++$x) {
                imagecopy($temp_image, $image, 0, 0, $x, 0, 1, $sy);
                imagecopy($image, $image, $x, 0, $max_x - $x, 0, 1, $sy);
                imagecopy($image, $temp_image, $max_x - $x, 0, 0, 0, 1, $sy);
            }
        }
    }

    /**
     * @param resource $src
     * @param array $rect
     * @return resource|bool
     */
    public static function cropImage($src, array $rect)
    {
        if (!function_exists('imagecrop')) {
            $im = imagecreatetruecolor($rect['width'], $rect['height']);
            imagealphablending($im, false);
            imagesavealpha($im, true);
            $color = imagecolorallocatealpha($im, 255, 255, 255, 127);
            imagefilledrectangle($im, 0, 0, $rect['width'], $rect['height'], $color);
            imagecopy($im, $src, 0, 0, $rect['x'], $rect['y'], $rect['width'], $rect['height']);
        } else {
            $im = imagecrop($src, array(
                'x' => $rect['x'],
                'y' => $rect['y'],
                'width' => $rect['width'],
                'height' => $rect['height'],
            ));
        }

        return $im;
    }
}
