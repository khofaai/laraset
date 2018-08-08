<?php
/**
 * Author : Anas EL ALAMI [anaselalamikh@gmail.com]
 * github : khofaai
 */
namespace Khofaai\Laraset\core\Commands;

use File;
use Khofaai\Laraset\core\Facades\Laraset;

class LarasetMigrate extends LarasetCommands
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laraset:migrate
    {--no-sync=default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'migrate from Core modules';

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $this->setCommandOption('no-sync');
        $this->loadMigrationPaths();

        if (!$this->getOption('no-sync')) {
            $this->mappingMigrationDirectories();
        }
        $this->call('migrate');
    }

    /**
     * get migration paths
     * 
     * @return void
     */
    protected function loadMigrationPaths()
    {
        $corePath = Laraset::base('modules');
        $migration_structure = Laraset::dirStructure($corePath, 'Database/Migrations');
        foreach ($migration_structure['directories'] as $migration) {
            $this->fetchMigrationFiles($migration);
        }
    }

    /**
     * fetch migration files 
     * 
     * @param  array $files
     * @return void
     */
    protected function fetchMigrationFiles($files)
    {
        foreach ($files['files'] as $file) {
            $this->copyFileToMigrationDir($files['path'], $file);
        }
    }

    /**
     * copy migration file
     * 
     * @param  string $path
     * @param  string $file
     * @return void
     */
    protected function copyFileToMigrationDir($path, $file)
    {
        File::copy($path . $file, $this->migrationDirectory() . '/' . $file);
    }

    /**
     * create migration directory
     * 
     * @return string
     */
    protected function migrationDirectory()
    {
        $migrationDir = database_path('migrations');
        if (!is_dir($migrationDir)) {
            File::createDirectory($migrationDir);
        }
        return $migrationDir;
    }

    /**
     * Synchroniz migration files from Laraset to Laravel
     * 
     * @return void
     */
    protected function mappingMigrationDirectories()
    {
        $tree = dir_structure(Laraset::base('modules'), 'Database');

        foreach ($tree['directories'] as $element) {
            $path = $element['directories']['Migrations']['path'];
            unset($element['directories']['Migrations']['path'], $element['directories']['Migrations']['directories']);
            if (!empty($element['directories']['Migrations']['files'])) {
                $files[$path] = array_values($element['directories']['Migrations']['files']);
            }
        }

        $migration_tree = dir_structure(database_path('migrations'));

        foreach ($migration_tree['files'] as $file) {
            foreach ($files as $path => $local_files) {
                foreach ($local_files as $key => $old_file) {
                    $this->synchFile($path, $old_file);
                }
            }
        }
    }

    /**
     * copy migration from Laraset to Laravel
     * 
     * @param  string $path
     * @param  string $filename
     * @return void
     */
    protected function synchFile($path, $filename)
    {
        $migrationPath = database_path('migrations') . '/' . $filename;
        $moduleMigrationPath = $path . $filename;
        if (!File::exists($migrationPath) && File::exists($moduleMigrationPath)) {
            File::copy($moduleMigrationPath, $migrationPath);
            $this->info('   Migration file [ ' . $filename . ' ] synchronized successfully !');
        } elseif (md5(File::get($moduleMigrationPath)) != md5(File::get($migrationPath))) {
            if (File::exists($migrationPath)) {
                File::delete($migrationPath);
            }
            File::copy($moduleMigrationPath, $migrationPath);
            $this->info('   Migration file [ ' . $filename . ' ] synchronized successfully !');
        }
        
    }
}
