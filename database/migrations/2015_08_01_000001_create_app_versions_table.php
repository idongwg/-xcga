<?php

class CreateAppVersionsTable extends TableMigration {

    protected $table = 'app_versions';

    public function create() {
        Schema::create($this->table, function ($table) {
            $table->increments('id');
            $table->string('uuid', 64)->unique();
            $table->string('version_name', 100)->default('');
            $table->string('version_code', 100)->default('');
            $table->string('platform', 100)->default('android');
            $table->string('upgrade_method', 100)->default('1');
            $table->string('upgrade_url', 200)->default('');
            $table->string('status', 16)->default('online');
            $table->string('description', 5000)->nullable();
            $table->timestamps();

            $table->index('platform');
            $table->index('version_code');
            $table->index('version_name');

//            $table->engine = 'InnoDB';
        });
    }

}