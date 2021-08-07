<?php

namespace App\Repositories;

use App\Models\Book;
use App\Repositories\Interfaces\BookRepositoryInterface;

class BookRepository extends Repository implements BookRepositoryInterface
{
    protected $model;

    public function __construct(Book $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function getSelectedColumns(array $columns = ['*'])
    {
        return $this->model->select($columns)->get();
    }
}
