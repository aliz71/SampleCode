<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Repository implements RepositoryInterface
{
    // model property on class instances
    protected $model;

    // Constructor to bind model to repo
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    // Get all instances of model
    public function all(): Collection
    {
        return $this->model->all();
    }

    // create a new record in the database
    public function create(array $data): Collection
    {
        return $this->model->create($data);
    }

    // update record in the database
    public function update(array $data, int $id): Collection
    {
        $record = $this->model->find($id);
        return $record->update($data);
    }

    // remove record from the database
    public function delete(int $id): Collection
    {
        return $this->model->destroy($id);
    }

    // show the record with the given id
    public function show(int $id): Collection
    {
        return $this->model->findOrFail($id);
    }
}
