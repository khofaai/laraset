<?php
/**
 * Author : Anas EL ALAMI [anaselalamikh@gmail.com]
 * github : khofaai
 */
namespace Khofaai\Laraset\core\Commands;

use File;
use Illuminate\Console\Command;
use Khofaai\Laraset\core\Facades\Laraset;

abstract class LarasetCommands extends Command
{
    const CORE_NAME = 'modules';
    /**
     * This Core name
     * 
     * @var string
     */
    protected $coreNamespace = "Laraset";

    /**
     * project base path 
     * 
     * @var string
     */
    protected $basePath;

    /**
     * [$modulePath description]
     * @var Strnig
     */
    protected $modulePath;

    /**
     * contain all command options
     * @var array
     */
    protected $commandOptions = [];

    /**
     * Module name
     * @var string
     */
    protected $moduleName;

    /**
     * Module name with first Letter uppercase
     * @var string
     */
    protected $moduleNameUpper;

    /**
     * modules folder base path
     * @var string
     */
    protected $baseSrc;

    /**
     * 
     */
    public function __construct()
    {
        $this->basePath = app_path($this->coreNamespace) . '/';
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    abstract function handle();

    /**
     * Init module name in case is allowed
     * 
     * @return boolean
     */
    protected function init()
    {
        $this->initName();
        if (in_array(strtolower($this->moduleName), $this->notAllowedNames())) {
            $this->info('<options=bold;fg=yellow>[' . strtolower($this->moduleName) . ']<bg=black;fg=yellow> name is reserved ! please choose another one');
            return false;
        }
        return true;
    }

    /**
     * Create File
     * 
     * @param  string $path
     * @param  string $content
     * @return void
     */
    protected function makeFile($path, $content)
    {
        File::put($path, $content);
    }

    /**
     * return not allowed names
     * 
     * @return array
     */
    protected function notAllowedNames()
    {
        return [
            'admin'
        ];
    }

    /**
     * Initial module name
     * 
     * @return void
     */
    protected function initName()
    {
        $this->moduleName = $this->formatName($this->argument('name'));
        $this->moduleNameUpper = ucfirst(camel_case($this->moduleName));

        $this->baseSrc = $this->basePath . self::CORE_NAME.'/';
        $this->modulePath = $this->baseSrc . $this->moduleName;
    }

    /**
     * set option name to $commandOptions
     * 
     * @param string $option
     * @return void
     */
    protected function setOption($option)
    {
        $optionValue = $this->option($option);
        $this->commandOptions[$option] = ($optionValue == 'default' ? false : (is_null($optionValue) ? true : $optionValue));
    }

    /**
     * get option value
     * 
     * @param  string $option option name
     * @return boolean|string string in case the option has value
     */
    protected function getOption($option)
    {
        return $this->commandOptions[$option];
    }

    /**
     * Set all command options to $commandOptions
     * 
     * @param array|string $option array in case multiple options
     */
    protected function setCommandOption($option)
    {
        if (is_array($option)) {
            foreach ($option as $opt) {
                $this->setOption($opt);
            }
        } else {
            $this->setOption($option);
        }
    }

    /**
     * Remplace - with _
     * 
     * @param string $name
     * @return string
     */
    protected function formatName($name)
    {
        return str_replace('-', '_', $name);
    }

    /**
     * Create Directory
     * 
     * @param  string $path
     * @return void
     */
    protected function makeDir($path)
    {
        File::makeDirectory($path, 0777, true, true);
    }

    /**
     * Create directories
     *
     * @param  array $directories
     * @return void
     */
    protected function makeDirectories($directories)
    {
        $this->makeDir($this->modulePath);
        foreach ($directories as $directory) {
            $this->makeDir($this->modulePath . '/' . $directory);
        }
    }

    /**
     * get Laraset Modules name
     * 
     * @return qrray
     */
    protected function modulesName()
    {
        return array_keys(Laraset::modules());
    }

    /**
     * get Instance Signature
     * 
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * Get instance description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get given stub file name
     *
     * @param  string $name
     * @return string
     */
    protected function getStubFileContent($name)
    {
        try {
            
            return File::get(Laraset::getStub($name));
        } catch (\Exception $e) {

            $this->error("stub name : ${$name} not exist");
        }
    }
}
