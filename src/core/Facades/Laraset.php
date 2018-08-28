<?php
/**
 * Author : Anas EL ALAMI [anaselalamikh@gmail.com]
 * github : khofaai
 */
namespace Khofaai\Laraset\core\Facades;

use Illuminate\Support\Facades\Facade;

class Laraset extends Facade
{
    /**
     * Get facade accessor
     *
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'laraset';
    }

    /**
     * Check Str Pos
     *
     * @param string $el
     * @param string $str
     * @return boolean
     */
    public static function checkStrPos($el, $str)
    {
        return $el != '' && strpos($el, $str) !== false;
    }

    /**
     * Get the path
     *
     * @param string $path
     * @return string
     */
    public static function path($path = '')
    {
        return laraset_path($path);
    }

    /**
     * Get the modules
     *
     * @return string
     */
    public static function modules()
    {
        return laraset_modules();
    }

    /**
     * Get the base
     *
     * @param string $path
     * @return string
     */
    public static function base($path = '')
    {
        return laraset_base($path);
    }

    /**
     * Get the asset
     *
     * @param string $path
     * @return string
     */
    public static function asset($path = '')
    {
        return laraset_asset($path);
    }

    /**
     * Get the stub
     *
     * @param string $name
     * @return string
     */
    public static function getStub($name)
    {
        return laraset_get_stub($name);
    }

    /**
     * Check if module exist
     *
     * @param string $moduleName
     * @return boolean
     */
    public static function moduleExists($moduleName)
    {
        return module_exists($moduleName);
    }

    /**
     * Get the module path
     *
     * @param string $moduleName
     * @return string
     */
    public static function modulePath($moduleName)
    {
        return module_path($moduleName);
    }

    /**
     * Get the directory structure
     *
     * @param string $path
     * @param string $subdir
     * @param string $subpath
     * @return array
     */
    public static function dirStructure($path = null, $subdir = '', $subpath = '')
    {
        return dir_structure($path, $subdir, $subpath);
    }

    /**
     * Get file php classes
     *
     * @param string $filepath
     * @return string
     */
    public static function getFilePhpClasses($filepath)
    {
        return file_get_php_classes($filepath);
    }
}
