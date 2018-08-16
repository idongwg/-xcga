<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class InitClassCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'class:init {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create model, migration and seeder.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->composer = app()['composer'];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $name = $this->input->getArgument('name');
        $table = snake_case(str_plural($name));

        $this->createModel($name, $table);
        $this->createMigration($table);
        $this->createSeeder($name);
        //$this->createController($name);


        // Dump autoload.
        $this->composer->dumpAutoloads();

        //$this->call('dump-autoload');

    }

    protected function createModel($name, $table) {
        $class = $name;
        $path = $this->getModelPath();
        $patterns = array(
            '/{{namespace}}/s' => 'App\Models',
            '/{{class}}/s' => $class,
            '/{{table}}/s' => $table
        );

        return $this->writeFile($path, $class, 'model', $patterns);
    }

    protected function createMigration($table) {
        $path = $this->getMigrationPath();
        $filename = 'create_' . $table . '_table';
        $class = studly_case($filename);
        $patterns = array(
            '/{{class}}/s' => $class,
            '/{{table}}/s' => $table
        );
        $filename = date('Y_m_d_His') . '_' . $filename;

        return $this->writeFile($path, $filename, 'migration', $patterns);
    }

    protected function createSeeder($model) {
        $path = $this->getSeedPath();
        $filename = $model . 'TableSeeder';
        $uuid = str_random(24);
        $patterns = array(
            '/{{model}}/s' => $model,
            '/{{uuid}}/s' => $uuid
        );

        return $this->writeFile($path, $filename, 'seed', $patterns);
    }

    protected function createController($name) {
        $path = $this->getControllerPath();
        $this->createApiController($path, $name);
        $this->createAdminController($path, $name);
    }

    protected function createApiController($path, $name) {
        $model = $name;
        $class = $name . 'ApiController';
        $path = $path . '/api';
        $patterns = array(
            '/{{namespace}}/s' => ' namespace api;',
            '/{{class}}/s' => $class,
            '/{{model}}/s' => $model
        );

        return $this->writeFile($path, $class, 'api_controller', $patterns);
    }

    protected function createAdminController($path, $name) {
        $model = $name;
        $class = $name . 'AdminController';
        $path = $path . '/admin';
        $patterns = array(
            '/{{namespace}}/s' => ' namespace admin;',
            '/{{class}}/s' => $class,
            '/{{model}}/s' => $model
        );

        return $this->writeFile($path, $class, 'admin_controller', $patterns);
    }

    protected function writeFile($path, $filename, $template, $patterns = array()) {
        $file = new Filesystem();

        $file_path = $path . "/{$filename}.php";

        $template = $file->get(__DIR__ . "/templates/{$template}.stub");
        $template = preg_replace(array_keys($patterns), array_values($patterns), $template);
        //$template = str_replace('{{class}}', $class, $template);

        if (!$file->exists($file_path)) {
            $file->put($file_path, $template);
            $this->line("<info>Created File:</info> $file_path");
        }
        return true;
    }

    protected function getDatabasePath() {
        return base_path('/database');
    }

    protected function getModelPath() {
        return $this->getDatabasePath() . '/models';
    }

    protected function getMigrationPath() {
        return $this->getDatabasePath() . '/migrations';
    }

    protected function getSeedPath() {
        return $this->getDatabasePath() . '/seeds';
    }

    protected function getControllerPath() {
        return base_path('/controllers');
    }

    protected function getPath() {
        $path = $this->input->getOption('path');
        if (!is_null($path)) {
            return $this->laravel['path.base'] . '/' . $path;
        }
        return $this->laravel['path'];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments() {
        return array(
            array('name', InputArgument::REQUIRED, 'The name of the model'),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions() {
        return array(
            array('table', null, InputOption::VALUE_OPTIONAL, 'The table to model.'),
            array('path', null, InputOption::VALUE_OPTIONAL, 'Where to store the file.', null)
        );
    }

}
