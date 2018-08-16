<?php namespace App\Repositories;

class BaseRepositoryService implements BaseContract {

    protected $model_class;
    protected $model_instance;

    public function __construct($model_class = null) {
        $this->model_class = $model_class;
    }

    public function model() {
        return $this->modelInstance();
    }

    public function save($data) {
        $model = $this->newModel($data);
        if (! $model->save()) {
            return false;
        }
        return $model;
    }

    public function update($uuid, $data) {
        if (! $uuid) {
            return false;
        }
        $model = $this->findByUuid($uuid);
        if (! $model) {
            return false;
        }
        if (! $model->update($data)) {
            return false;
        }
        return $model;
    }

    public function updateById($id, $data) {
        if (! $id) {
            return false;
        }
        $model = $this->findById($id);
        if (! $model) {
            return false;
        }
        if (! $model->update($data)) {
            return false;
        }
        return $model;
    }

    public function updateStatus($uuid, $status = 'online') {
        if (! $uuid) {
            return false;
        }
        $model = $this->findByUuid($uuid);
        if (! $model) {
            return false;
        }
        $model->status = $status;
        $model->save();

        return $model;
    }
    
    public function delete($uuid) {
        if (! $uuid) {
            return false;
        }
        $model = $this->findByUuid($uuid);
        if (! $model) {
            return false;
        }
        return $model->delete();
    }

    public function deleteById($id) {
        if (! $id) {
            return false;
        }
        $model = $this->findById($id);
        if (! $model) {
            return false;
        }
        return $model->delete();
    }

    public function find($uuid, $columns = ['*']) {
        if (is_numeric($uuid)) {
            return $this->findById($uuid, $columns = ['*']);
        } else {
            return $this->findByUuid($uuid, $columns = ['*']);
        }
    }

    public function findById($id, $columns = ['*']) {
        $query = $this->newQuery();
        return $query->find($id, $columns = ['*']);
    }


    public function findByUuid($uuid, $columns = ['*']) {
        return $this->findBy('uuid', $uuid, $columns);
        //$model = $this->modelInstance();
        //return $model->findByUuid($uuid, $columns = ['*']);
    }

    public function findBy($attribute, $value, $columns = ['*']) {
        $query = $this->newQuery();
        return $query->where($attribute, $value)->first($columns);
    }

    public function get($uuid = null) {
        if ($uuid) {
            return $this->findByUuid($uuid);
        } else {
            return $this->all();
        }
    }

    public function all($columns = ['*']) {
        $query = $this->newQuery();
        return $query->get($columns);
    }

    public function newQuery() {

        return $this->model()->newQuery();
    }

    public function getTable() {
        return $this->model()->getTable();
    }

    public function getModelName() {
        return $this->model()->getModelName();
    }

    protected function modelInstance() {
        if ($this->model_instance) {
            return $this->model_instance;
        }
        return $this->newModel();
    }

    protected function newModel($attributes = array()) {
        if ($this->model_class) {
            $this->model_instance = new $this->model_class($attributes);
        }
        return $this->model_instance;
    }

    public function __call($method, $parameters) {
        $model = $this->modelInstance();
        if (in_array($method, ['select', 'where', 'whereNull', 'whereNotNull', 'whereIn', 'whereNotIn', 'count', 'min', 'max', 'sum', 'avg', 'distinct'])) {
            return $model->newQuery()->$method(...$parameters);
        } else {
            return $model->$method(...$parameters);
        }
    }

    public function __clone() {
        $this->model_instance = clone $this->model_instance;
    }

}