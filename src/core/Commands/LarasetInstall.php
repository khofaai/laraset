<?php
/**
 * Author : Anas EL ALAMI [anaselalamikh@gmail.com]
 * github : khofaai
 */
namespace Khofaai\Laraset\core\Commands;

use File;
use Khofaai\Laraset\core\Commands\LarasetCommands;
use Khofaai\Laraset\core\Facades\Laraset;

class LarasetInstall extends LarasetCommands
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laraset:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'install laraset logic';

    /**
     * hold success and warning console messages
     * 
     * @var array
     */
    protected $messages = [
        'success' => '<options=bold;fg=cyan>[Laraset]<bg=black;fg=cyan> installed successfully',
        'warning' => '<options=bold,reverse>~Laraset~<fg=yellow> already installed.'
    ];

    /**
     * Hold Laraset file structure
     * 
     * @var array
     */
    protected $files = [
        '/' => [
            'bootstrap.js' => 'js/bootstrap.js',
            'core.js' => 'js/core.js',
            'core.json' => 'js/core.json',
            'routes.js' => 'js/route.js',
            'routes.php' => 'route.php',
            'webpack.mix.js' => 'js/webpack.mix.js'
        ],
        'helpers' => [
            'helpers.js' => 'js/helpers.js',
            'helpers.php' => 'helpers.php'
        ],
        'modules' => [
            'Core.vue' => 'js/vuejs/core.vue',
            'menu.vue' => 'js/vuejs/menu.vue',
            'topbar.vue' => 'js/vuejs/topbar.vue'
        ]
    ];

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $this->updateInstallStatus();
    }

    /**
     * Update core.json instalation status
     *
     * @return void
     */
    protected function updateInstallStatus()
    {
        $path = Laraset::path('core.json');

        if (File::exists($path)) {

            $modules = json_decode(File::get($path), true);

            if (!$modules['installed']["status"] || !isset($modules['installed']["status"])) {

                $this->generateArchitecture();
                $this->generateFiles();
                $this->updateWebpackMixJs();

                $modules['installed']["status"] = true;
                $modules['installed']["installed_at"] = date('Y-m-d H:i:s');
                File::put($path, json_encode((Object) $modules));

                $this->info($this->messages['success']);
            } else {

                $this->info($this->messages['warning']);
                $this->info('//installed at : ' . $modules['installed']['installed_at'] . '');
            }
        } else {

            $this->error('core.json not found');
        }
    }

    /**
     * Generate architecture
     */
    protected function generateArchitecture()
    {
        $architecture = array(
            'assets' => '',
            'dist' => ['js' => ''],
            'helpers' => '',
            'modules' => ''
        );

        $path = app_path($this->coreNamespace);
        $this->createFolder($path);

        $this->createArchitectureFolders($architecture, $path);

        $this->info('* [Folders] Generated Successfully !');
    }

    /**
     * Create architecture folders
     *
     * @param type $architecture
     * @param type $path
     */
    protected function createArchitectureFolders($architecture, $path)
    {
        foreach ($architecture as $key => $value) {
            $dir_path = $path . '/' . $key;
            $this->createFolder($dir_path);

            if (gettype($value) !== 'string') {

                $this->createArchitectureFolders($value, $dir_path);
            }
        }
    }

    /**
     * Create folder
     *
     * @param boolean
     */
    protected function createFolder($path)
    {
        if (!is_dir($path)) {
            return File::makeDirectory($path);
        }
    }

    /**
     * Generate Files
     */
    protected function generateFiles()
    {
        $path = app_path($this->coreNamespace);
        foreach ($this->files as $key => $value) {
            foreach ($value as $filename => $stub) {
                $dir_path = $key != '/' ? $path . '/' . $key . '/' : $path . $key;
                $this->makeFile($dir_path . $filename, $this->getStubFileContent($stub));
            }
        }
        $laraset_path = resource_path('views/' . $this->coreNamespace . '.blade.php');
        if (!File::exists($laraset_path)) {
            $this->makeFile($laraset_path, $this->getStubFileContent('template.blade'));
        }
        $this->info('* [File] Generated Successfully !');
    }

    /**
     * Update Webpack Mix Js
     */
    protected function updateWebpackMixJs()
    {
        $path = base_path('webpack.mix.js');
        if (File::exists($path)) {
            $content = File::get($path);
            $this->makeFile(base_path('webpack-old.mix.js'), $content);
            File::delete($path);
        }
        $this->makeFile($path, $this->getStubFileContent('js/webpack.base.mix.js'));
    }
}
