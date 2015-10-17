<?php

namespace Alexantr\ImageResize\Helpers;

class FileHelper
{
    /**
     * Determines the MIME type of the specified file.
     * This method will first try to determine the MIME type based on
     * [finfo_open](http://php.net/manual/en/function.finfo-open.php). If the `fileinfo` extension is not installed,
     * it will fall back to [[getMimeTypeByExtension()]] when `$checkExtension` is true.
     *
     * @param string $file the file name.
     * @param boolean $checkExtension whether to use the file extension to determine the MIME type in case
     * `finfo_open()` cannot determine it.
     *
     * @return string the MIME type (e.g. `text/plain`). Null is returned if the MIME type cannot be determined.
     * @throws \Exception when the `fileinfo` PHP extension is not installed and `$checkExtension` is `false`.
     */
    public static function getMimeType($file, $checkExtension = true)
    {
        if (!extension_loaded('fileinfo')) {
            if ($checkExtension) {
                return static::getMimeTypeByExtension($file);
            } else {
                throw new \Exception('The fileinfo PHP extension is not installed.');
            }
        }
        $info = finfo_open(FILEINFO_MIME_TYPE);
        if ($info) {
            $result = finfo_file($info, $file);
            finfo_close($info);

            if ($result !== false) {
                return $result;
            }
        }
        return $checkExtension ? static::getMimeTypeByExtension($file) : null;
    }

    /**
     * Determines the MIME type based on the extension name of the specified file.
     * This method will use a local map between extension names and MIME types.
     *
     * @param string $file the file name.
     *
     * @return string the MIME type. Null is returned if the MIME type cannot be determined.
     */
    public static function getMimeTypeByExtension($file)
    {
        $mimeTypes = static::loadMimeTypes();
        if (($ext = pathinfo($file, PATHINFO_EXTENSION)) !== '') {
            $ext = strtolower($ext);
            if (isset($mimeTypes[$ext])) {
                return $mimeTypes[$ext];
            }
        }
        return null;
    }

    private static $_mimeTypes = array();

    /**
     * Loads MIME types from the specified file.
     * @return array the mapping from file extensions to MIME types
     */
    protected static function loadMimeTypes()
    {
        $magicFile = __DIR__ . '/mimeTypes.php';
        if (!isset(self::$_mimeTypes[$magicFile])) {
            self::$_mimeTypes[$magicFile] = require($magicFile);
        }
        return self::$_mimeTypes[$magicFile];
    }

    /**
     * Creates a new directory.
     *
     * This method is similar to the PHP `mkdir()` function except that
     * it uses `chmod()` to set the permission of the created directory
     * in order to avoid the impact of the `umask` setting.
     *
     * @param string $path path of the directory to be created.
     * @param integer $mode the permission to be set for the created directory.
     * @param boolean $recursive whether to create parent directories if they do not exist.
     *
     * @return boolean whether the directory is created successfully
     * @throws \Exception if the directory could not be created.
     */
    public static function createDirectory($path, $mode = 0775, $recursive = true)
    {
        if (is_dir($path)) {
            return true;
        }
        $parentDir = dirname($path);
        if ($recursive && !is_dir($parentDir)) {
            static::createDirectory($parentDir, $mode, true);
        }
        try {
            $result = mkdir($path, $mode);
            chmod($path, $mode);
        } catch (\Exception $e) {
            throw new \Exception("Failed to create directory '$path': " . $e->getMessage(), $e->getCode(), $e);
        }
        return $result;
    }
}
