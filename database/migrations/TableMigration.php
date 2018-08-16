<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableMigration extends Migration {

    protected $table;

    public function create() {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid', 64)->unique();
            $table->timestamps();

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        if ($this->table) {
            $this->down();
            $this->create();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists($this->table);
        Schema::enableForeignKeyConstraints();
        //DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

}
