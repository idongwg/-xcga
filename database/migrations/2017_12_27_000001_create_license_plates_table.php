<?php

class CreateLicensePlatesTable extends TableMigration {

    protected $table = 'license_plates';

    public function create() {
        Schema::create($this->table, function ($table) {
            $table->increments('id');
            //$table->string('uuid', 64)->unique();
            $table->string('sweepers_title', 200)->nullable()->default('');
            $table->string('title', 200)->nullable()->default('');
            $table->string('device_uuid', 64)->index();
            $table->string('latitude', 100)->nullable();
            $table->string('longitude', 100)->nullable();
            $table->string('location', 200)->nullable()->default('');
            $table->string('image', 200)->nullable()->default('');
            $table->string('road_uuid', 64)->nullable()->default('');
            $table->string('road_title', 200)->nullable()->default('');
            $table->integer('year')->unsigned()->default(2017);
            $table->tinyInteger('month')->unsigned()->default(0);
            $table->string('day', 32)->default('');
            $table->string('status', 16)->default('new');
            $table->binary('description')->nullable();

            $table->timestamps();

            $table->index('road_uuid');
            $table->index('year');
            $table->index('month');
            $table->index('day');
            $table->index('status');

//            $table->engine = 'InnoDB';
        });
    }

}