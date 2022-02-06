<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Repository implements RepositoryInterface
{
    const RANDOM = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    // model property on class instances
    /** @var Model */
    protected $model;

    // Constructor to bind model to repo
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $record = $this->find($id);
        return $record->update($data);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param $id
     * @return Model
     */
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @param $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function search($request)
    {
        return $this->model::query();
    }

    public function searchOtherTable($request)
    {
        return $this->model::query();
    }


    public function getMetaData(int $count, int $page, int $perPage)
    {
        return [
            'total' => $count,
            'page' => $page,
            'per_page' => $perPage
        ];
    }

    public function checkTableIfExist($connection, $tableName) {

        return Schema::connection($connection)->hasTable($tableName);

    }

}
