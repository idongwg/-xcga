<?php namespace App\Repositories;

interface BaseContract {

    public function model();

    public function save($data);

    public function update($uuid, $data);

    public function updateById($id, $data);

    public function updateStatus($uuid, $status = 'online');

    public function delete($uuid);

    public function deleteById($id);

    public function find($uuid, $columns = ['*']);

    public function findById($id, $columns = ['*']);

    public function findByUuid($uuid, $columns = ['*']);

    public function findBy($attribute, $value, $columns = ['*']);
    
    public function all($columns = ['*']);

    public function get($uuid = null);

    public function newQuery();


}