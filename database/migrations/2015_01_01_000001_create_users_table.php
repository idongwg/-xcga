<?php

class CreateUsersTable extends TableMigration {

    protected $table = 'users';

    public function create() {
        Schema::create($this->table, function ($table) {
            $table->increments('id');
            $table->string('token', 64)->unique();
            $table->string('uuid', 64)->unique();
            $table->string('username', 64)->unique();
            $table->string('password', 200)->nullable();
            $table->string('realname', 200)->nullable()->default('');
            $table->string('title', 200)->nullable()->default('');
            $table->string('rfid', 64)->nullable()->default('');
            $table->string('phone', 200)->nullable()->default('');
            $table->string('mobile', 200)->nullable()->default('');
            $table->string('email', 200)->nullable()->default('');
            $table->string('department_uuid', 64)->nullable()->default(config('app.dept'));
            $table->string('team_uuid', 64)->nullable()->default('');
            $table->string('role_uuid', 64)->nullable()->default('');
            $table->string('avatar', 200)->nullable();
            $table->string('status', 32)->default('new');   //new, online, offline
            $table->string('latitude', 100)->nullable();
            $table->string('longitude', 100)->nullable();
            $table->string('channel_id', 100)->nullable();
            $table->string('app_version', 100)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->index('department_uuid');
            $table->index('role_uuid');
            $table->index('status');

//            $table->engine = 'InnoDB';
        });
    }

}

