<?php
define("APP_DIR_NAME", 'Laraset');
define("MOD_DIR_NAME", 'modules');
define("VENDOR_PKG_PATH", 'khofaai/laraset');

/**
 * Path to laraset vendor package for given $path
 * 
 * @param  string $path
 * @return string
 */
if (!function_exists('laraset_path')) {

    function laraset_path($path = '')
    {
        return base_path("vendor/". VENDOR_PKG_PATH ."/src/${$path}");
    }
}

/**
 * List all created modules
 * 
 * @return string
 */
if (!function_exists(('laraset_modules'))) {

    function laraset_modules()
    {
        return json_decode(file_get_contents(app_path(APP_DIR_NAME) . '/core.json'), true)['modules'];
    }
}

/**
 * Path to Laraset directory inside app folder
 * 
 * @param  string $path
 * @return string
 */
if (!function_exists(('laraset_base'))) {

    function laraset_base($path = '')
    {
        return app_path( APP_DIR_NAME . ( $path != '' ? '/' . $path : '' ) );
    }
}

/**
 * Url to Laraset directory inside App folder
 * 
 * @param  string $path
 * @return string
 */
if (!function_exists(('laraset_asset'))) {

    function laraset_asset($path = '')
    {
        return url("app/". APP_DIR_NAME . ($path != '' ? '/' . $path : '' ) );
    }
}

/**
 * Check if given module name exist
 * 
 * @param  string $module_name
 * @return boolean
 */
if (!function_exists('module_exists')) {

    function module_exists($module_name)
    {
        $path = laraset_base( MOD_DIR_NAME . "/${$module_name}");
        return is_dir($path) ? $path : false;
    }
}

/**
 * Path to given module name
 * 
 * @param  string $module_name
 * @return boolean | null
 */
if (!function_exists('module_path')) {

    function module_path($module_name)
    {
        $path = module_exists($module_name);

        return $path ? $path : null;
    }
}

/**
 * construct directory architecture
 * 
 * @param  string $path
 * @param  string $subdir
 * @param  string $subpath
 * @return array | null
 */
if (!function_exists('dir_structure')) {

    function dir_structure($path = null, $subdir = '', $subpath = '')
    {
        $bt = debug_backtrace();
        $dirname = dirname($bt[0]['file']);
        if (!is_null($path)) {
            $dirname = $path;
        }

        if (is_dir($dirname)) {

            $dirname = str_finish($dirname, '/');
            $dirPath = str_finish(str_replace($subpath, '', $dirname), '/');

            $structure = [
                'path' => $subpath != '' ? $dirPath : $dirname,
                'directories' => [],
                'files' => []
            ];

            $directory = scandir($dirname);
            $directory = array_diff($directory, array('.', '..'));

            // fetch all files inside Helper Directory
            foreach ($directory as $filename) {
                // not including this file
                if (basename($dirname) != $filename) {
                    $baseFilePath = $filename;
                    if ($subdir != '') {
                        $baseFilePath .= '/' . $subdir;
                    }
                    // get each file location
                    $filePath = $dirname . $baseFilePath;
                    // check if this is a file or directory
                    if (is_file($filePath)) {
                        array_push($structure['files'], $baseFilePath);
                    } elseif (is_dir($filePath)) {
                        $structure['directories'][$filename] = dir_structure($filePath);
                    }
                }
            }
            return $structure;
        }
        return null;
    }
}

/**
 * Get classes in a Php file Content
 * 
 * @param  string $phpCode
 * @return array
 */
if (!function_exists('get_php_classes')) {

    function get_php_classes($phpCode)
    {
        $classes = array();
        $tokens = token_get_all($phpCode);
        $count = count($tokens);
        for ($i = 2; $i < $count; $i++) {
            if ($tokens[$i - 2][0] == T_CLASS && $tokens[$i - 1][0] == T_WHITESPACE && $tokens[$i][0] == T_STRING) {

                $className = $tokens[$i][1];
                $classes[] = $className;
            }
        }
        return $classes;
    }
}

/**
 * Get classes in a Php file
 * 
 * @param  string $filepath
 * @return array
 */
if (!function_exists('file_get_php_classes')) {

    function file_get_php_classes($filepath)
    {
        $phpCode = file_get_contents($filepath);
        $classes = get_php_classes($phpCode);
        return $classes;
    }
}

/**
 * Get stub file path
 * 
 * @param  string $name
 * @return string | null
 */
if (!function_exists('laraset_get_stub')) {

    function laraset_get_stub($name)
    {
        $stubPath = laraset_path('core/resource/' . $name . '.stub');
        return file_exists($stubPath) ? $stubPath : null;
    }
}

/**
 * Check if a given class name exist in given path directory
 * 
 * @param  string $path
 * @param  string $className
 * @return boolean
 */
if (!function_exists('class_exists_in_directory')) {
    
    function class_exists_in_directory($path,$className) {
        $dir = dir_structure($path);
        $classExists = false;
        if (isset($dir['files'])) {
            # code...
            foreach ($dir['files'] as $file) {
            
                $path = $dir['path'].$file;
                $classNames = get_php_classes(file_get_contents($path));

                if (in_array($className, $classNames)) {
                    $classExists = true;
                    break;
                }
            }
        }
        return $classExists;
    }
}