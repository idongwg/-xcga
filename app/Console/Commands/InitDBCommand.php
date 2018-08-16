<?php namespace App\Console\Commands;

use Illuminate\Database\Console\Migrations\RefreshCommand;

class InitDBCommand extends RefreshCommand {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'db:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh migrations and seed data.';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        //$this->call('dump-autoload');

        $this->call('migrate:reset');

        $this->call('migrate', ['--force' => true]);

        $this->call('db:seed', ['--force' => true]);

    }

}
