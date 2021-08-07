<?php

namespace App\Repositories\Interfaces;

interface BookRepositoryInterface extends RepositoryInterface
{
    public function getSelectedColumns(array $columns);
}
