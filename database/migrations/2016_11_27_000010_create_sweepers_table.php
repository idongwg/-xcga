<?php

class CreateSweepersTable extends TableMigration {

    protected $table = 'sweepers';

    public function create() {
        Schema::create($this->table, function ($table) {
            $table->increments('id');
            $table->string('uuid', 64)->unique();
            $table->string('code', 64)->index();
            $table->string('title', 64)->unique()->default('');
            $table->string('rfid', 64)->default('')->nullable();
            $table->string('device_uuid', 64)->default('')->nullable();
            $table->string('department_uuid', 64)->default('')->nullable();  //使用单位
            $table->string('sweeper_type', 64)->default('normal')->nullable();
            $table->string('engine_number', 100)->nullable();
            $table->string('chassis_number', 100)->nullable();
            $table->string('model_number', 100)->nullable();
            $table->string('manufacturer', 200)->nullable();
            $table->string('image', 200)->nullable();
            $table->string('status', 16)->default('new')->nullable(); //new, online, onstart, offline
            $table->string('description', 200)->nullable();
            $table->timestamps();

            $table->index('device_uuid');
            $table->index('department_uuid');
            $table->index('sweeper_type');
            $table->index('rfid');
            $table->index('status');

//            $table->engine = 'InnoDB';
        });
    }

}